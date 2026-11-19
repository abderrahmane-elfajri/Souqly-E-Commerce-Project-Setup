<?php

namespace Tests\Feature;

use App\Enums\InventoryMovementType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShipmentStatus;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\InventoryService;
use App\Services\OrderService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $customer;
    protected User $otherCustomer;
    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create([
            'email' => 'client@souqly.ma',
            'phone' => '0612345678',
        ]);

        $this->otherCustomer = User::factory()->create([
            'email' => 'other@souqly.ma',
            'phone' => '0698765432',
        ]);

        $category = Category::create([
            'slug' => 'test-cat',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'sku' => 'SQL-TEST-001',
            'slug' => 'test-product',
            'price' => 350.00,
            'stock' => 10,
            'is_featured' => true,
            'status' => 'published',
        ]);
    }

    public function test_customer_can_view_orders_index(): void
    {
        Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-TEST1',
            'status' => OrderStatus::PENDING,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Casablanca',
            'shipping_address' => 'Boulevard d\'Anfa',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->customer)->get(route('account.orders.index'));

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-TEST1');
        $response->assertSee('Casablanca');
    }

    public function test_customer_can_view_own_order_detail(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-TEST2',
            'status' => OrderStatus::CONFIRMED,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Rabat',
            'shipping_address' => 'Agdal Avenue de France',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'product_name' => 'Montre Royale Maroc',
            'sku' => $this->product->sku,
            'unit_price' => 350.00,
            'quantity' => 1,
            'total' => 350.00,
        ]);

        $response = $this->actingAs($this->customer)->get(route('account.orders.show', $order->order_number));

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-TEST2');
        $response->assertSee('Montre Royale Maroc');
        $response->assertSee('Rabat');
    }

    public function test_customer_cannot_view_another_customer_order(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-PRIVATE',
            'status' => OrderStatus::PENDING,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Casablanca',
            'shipping_address' => 'Maarif',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->otherCustomer)->get(route('account.orders.show', $order->order_number));

        $response->assertStatus(403);
    }

    public function test_checkout_records_inventory_sale_movement(): void
    {
        $cart = Cart::create(['user_id' => $this->customer->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $initialStock = $this->product->stock; // 10

        $checkoutService = app(CheckoutService::class);
        $order = $checkoutService->placeCodOrder($cart, [
            'name' => 'Abdelkrim',
            'email' => 'abdel@test.ma',
            'phone' => '0612345678',
            'city' => 'Tanger',
            'address' => 'Malabata',
        ], $this->customer);

        // Check stock decremented
        $this->assertEquals($initialStock - 2, $this->product->fresh()->stock);

        // Check inventory movement record
        $movement = InventoryMovement::where('product_id', $this->product->id)
            ->where('reference', $order->order_number)
            ->first();

        $this->assertNotNull($movement);
        $this->assertEquals(InventoryMovementType::SALE, $movement->type);
        $this->assertEquals(-2, $movement->quantity);
        $this->assertEquals(10, $movement->stock_before);
        $this->assertEquals(8, $movement->stock_after);
    }

    public function test_customer_can_cancel_pending_order_and_restores_stock(): void
    {
        // Place order first
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-CANCELME',
            'status' => OrderStatus::PENDING,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Marrakech',
            'shipping_address' => 'Gueliz',
            'subtotal' => 700.00,
            'shipping_cost' => 0.00,
            'total' => 700.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product->id,
            'product_name' => 'Montre Royale Maroc',
            'sku' => $this->product->sku,
            'unit_price' => 350.00,
            'quantity' => 2,
            'total' => 700.00,
        ]);

        // Simulated stock at 8 after order was placed
        $this->product->update(['stock' => 8]);

        // Cancel order
        $response = $this->actingAs($this->customer)
            ->post(route('account.orders.cancel', $order->order_number));

        $response->assertRedirect();
        $this->assertEquals(OrderStatus::CANCELLED, $order->fresh()->status);

        // Verify stock is restored back to 10
        $this->assertEquals(10, $this->product->fresh()->stock);

        // Verify cancellation movement was logged
        $movement = InventoryMovement::where('product_id', $this->product->id)
            ->where('reference', $order->order_number)
            ->where('type', InventoryMovementType::CANCELLATION_RETURN)
            ->first();

        $this->assertNotNull($movement);
        $this->assertEquals(2, $movement->quantity);
        $this->assertEquals(8, $movement->stock_before);
        $this->assertEquals(10, $movement->stock_after);
    }

    public function test_customer_cannot_cancel_shipped_order(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-SHIPPED',
            'status' => OrderStatus::SHIPPED,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Fès',
            'shipping_address' => 'Ville Nouvelle',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $this->assertFalse($order->canBeCancelled());

        $orderService = app(OrderService::class);
        $this->expectException(Exception::class);
        $orderService->cancelByCustomer($order);
    }

    public function test_order_status_transitions_rules(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-TRANS',
            'status' => OrderStatus::PENDING,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Agadir',
            'shipping_address' => 'Talborjt',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $orderService = app(OrderService::class);

        // Step 1: PENDING -> CONFIRMED (Allowed)
        $orderService->updateStatus($order, OrderStatus::CONFIRMED);
        $this->assertEquals(OrderStatus::CONFIRMED, $order->fresh()->status);

        // Step 2: CONFIRMED -> PROCESSING (Allowed)
        $orderService->updateStatus($order, OrderStatus::PROCESSING);
        $this->assertEquals(OrderStatus::PROCESSING, $order->fresh()->status);

        // Step 3: Direct PROCESSING -> DELIVERED (Invalid transition, must be SHIPPED first)
        $this->expectException(Exception::class);
        $orderService->updateStatus($order, OrderStatus::DELIVERED);
    }

    public function test_delivery_marks_cod_as_paid(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-CODPAID',
            'status' => OrderStatus::SHIPPED,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Salé',
            'shipping_address' => 'Bettana',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $orderService = app(OrderService::class);
        $orderService->updateStatus($order, OrderStatus::DELIVERED);

        $this->assertEquals(OrderStatus::DELIVERED, $order->fresh()->status);
        $this->assertEquals(PaymentStatus::PAID, $order->fresh()->payment_status);
    }

    public function test_create_shipment_assigns_tracking_and_transitions_order(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-SHIP1',
            'status' => OrderStatus::PROCESSING,
            'customer_name' => $this->customer->name,
            'customer_email' => $this->customer->email,
            'customer_phone' => '0612345678',
            'shipping_city' => 'Meknès',
            'shipping_address' => 'Hamria',
            'subtotal' => 350.00,
            'shipping_cost' => 30.00,
            'total' => 380.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $orderService = app(OrderService::class);
        $shipment = $orderService->createShipment($order, 'Cathedis Express', 'CAT-9928374', 'Expédié en express');

        $this->assertInstanceOf(Shipment::class, $shipment);
        $this->assertEquals('Cathedis Express', $shipment->carrier);
        $this->assertEquals('CAT-9928374', $shipment->tracking_number);
        $this->assertEquals(ShipmentStatus::PICKED_UP, $shipment->status);
        // Order transitioned to SHIPPED
        $this->assertEquals(OrderStatus::SHIPPED, $order->fresh()->status);
    }

    public function test_public_tracking_succeeds_with_order_number_and_phone(): void
    {
        $order = Order::create([
            'order_number' => 'SQL-202611-PUBLIC1',
            'status' => OrderStatus::SHIPPED,
            'customer_name' => 'Youssef El Amrani',
            'customer_email' => 'youssef@example.ma',
            'customer_phone' => '+212661001122',
            'shipping_city' => 'Casablanca',
            'shipping_address' => 'Ain Diab',
            'subtotal' => 500.00,
            'shipping_cost' => 0.00,
            'total' => 500.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        // Test with 06... local format matching +2126... in DB
        $response = $this->post(route('track.search'), [
            'order_number' => 'SQL-202611-PUBLIC1',
            'phone' => '0661001122',
        ]);

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-PUBLIC1');
        $response->assertSee('Casablanca');
    }

    public function test_public_tracking_fails_when_phone_does_not_match(): void
    {
        Order::create([
            'order_number' => 'SQL-202611-PUBLIC2',
            'status' => OrderStatus::SHIPPED,
            'customer_name' => 'Fatima Zahra',
            'customer_email' => 'fatima@example.ma',
            'customer_phone' => '0655443322',
            'shipping_city' => 'Rabat',
            'shipping_address' => 'Hay Riad',
            'subtotal' => 450.00,
            'shipping_cost' => 30.00,
            'total' => 480.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->post(route('track.search'), [
            'order_number' => 'SQL-202611-PUBLIC2',
            'phone' => '0600000000', // Wrong phone
        ]);

        $response->assertStatus(200);
        $response->assertDontSee('Hay Riad');
        $response->assertSee('Aucune commande trouvée');
    }
}
