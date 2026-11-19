<?php

namespace Tests\Feature;

use App\Enums\InventoryMovementType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShipmentStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@souqly.ma',
            'role' => UserRole::ADMIN,
        ]);

        $this->customer = User::factory()->create([
            'email' => 'customer@souqly.ma',
            'role' => UserRole::CUSTOMER,
        ]);

        $this->category = Category::create([
            'slug' => 'maroc-luxury',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_customer_receives_forbidden_403(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Tableau de Bord Administratif');
        $response->assertSee('Commandes Totales');
    }

    public function test_admin_can_list_orders(): void
    {
        Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-ADM01',
            'status' => OrderStatus::PENDING,
            'customer_name' => 'Driss Basri',
            'customer_email' => 'driss@test.ma',
            'customer_phone' => '0661122334',
            'shipping_city' => 'Casablanca',
            'shipping_address' => 'Gauthier',
            'subtotal' => 1200.00,
            'shipping_cost' => 0.00,
            'total' => 1200.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-ADM01');
        $response->assertSee('Driss Basri');
    }

    public function test_admin_can_view_order_details(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-ADM02',
            'status' => OrderStatus::PENDING,
            'customer_name' => 'Laila Benjelloun',
            'customer_email' => 'laila@test.ma',
            'customer_phone' => '0662233445',
            'shipping_city' => 'Rabat',
            'shipping_address' => 'Souissi',
            'subtotal' => 850.00,
            'shipping_cost' => 0.00,
            'total' => 850.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.orders.show', $order->id));

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-ADM02');
        $response->assertSee('Laila Benjelloun');
        $response->assertSee('Souissi');
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-CONFIRM',
            'status' => OrderStatus::PENDING,
            'customer_name' => 'Mehdi Chraibi',
            'customer_email' => 'mehdi@test.ma',
            'customer_phone' => '0663344556',
            'shipping_city' => 'Tanger',
            'shipping_address' => 'Iberia',
            'subtotal' => 500.00,
            'shipping_cost' => 0.00,
            'total' => 500.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.orders.update-status', $order->id), [
            'status' => 'confirmed',
            'note' => 'Client confirmé par appel téléphonique',
        ]);

        $response->assertRedirect();
        $this->assertEquals(OrderStatus::CONFIRMED, $order->fresh()->status);
    }

    public function test_admin_can_ship_order_with_courier_tracking(): void
    {
        $order = Order::create([
            'user_id' => $this->customer->id,
            'order_number' => 'SQL-202611-SHIPME',
            'status' => OrderStatus::PROCESSING,
            'customer_name' => 'Karim Alami',
            'customer_email' => 'karim@test.ma',
            'customer_phone' => '0664455667',
            'shipping_city' => 'Marrakech',
            'shipping_address' => 'Hivernage',
            'subtotal' => 450.00,
            'shipping_cost' => 30.00,
            'total' => 480.00,
            'currency' => 'MAD',
            'payment_method' => PaymentMethod::COD,
            'payment_status' => PaymentStatus::PENDING,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.ship', $order->id), [
            'carrier' => 'Amana Express',
            'tracking_number' => 'AMN-998877-MA',
            'notes' => 'Remis au chauffeur Amana à Casablanca Oasis',
        ]);

        $response->assertRedirect();
        $this->assertEquals(OrderStatus::SHIPPED, $order->fresh()->status);
        $this->assertDatabaseHas('shipments', [
            'order_id' => $order->id,
            'tracking_number' => 'AMN-998877-MA',
            'carrier' => 'Amana Express',
            'status' => ShipmentStatus::PICKED_UP->value,
        ]);
    }

    public function test_admin_can_create_product_with_trilingual_content(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'category_id' => $this->category->id,
            'sku' => 'SQL-NEW-WATCH',
            'price' => 1499.00,
            'compare_at_price' => 1999.00,
            'stock' => 15,
            'is_featured' => 1,
            'name_fr' => 'Montre Saphir Casablanca',
            'short_description_fr' => 'Édition limitée Casablanca',
            'description_fr' => 'Verre saphir inrayable, mouvement automatique suisse.',
            'name_ar' => 'ساعة ياقوتية كازابلانكا',
            'short_description_ar' => 'إصدار محدود للدار البيضاء',
            'description_ar' => 'زجاج ياقوتي مقاوم للخدش وحركة أوتوماتيكية.',
            'name_en' => 'Casablanca Sapphire Watch',
            'short_description_en' => 'Limited Casablanca edition',
            'description_en' => 'Scratch-resistant sapphire glass, Swiss automatic movement.',
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('sku', 'SQL-NEW-WATCH')->first();
        $this->assertNotNull($product);
        $this->assertEquals('1499.00', $product->price);
        $this->assertEquals(15, $product->stock);

        // Verify trilingual translations created
        $this->assertDatabaseHas('product_translations', [
            'product_id' => $product->id,
            'locale' => 'fr',
            'name' => 'Montre Saphir Casablanca',
        ]);
        $this->assertDatabaseHas('product_translations', [
            'product_id' => $product->id,
            'locale' => 'ar',
            'name' => 'ساعة ياقوتية كازابلانكا',
        ]);

        // Verify initial inventory audit movement recorded
        $movement = InventoryMovement::where('product_id', $product->id)
            ->where('reference', 'INITIAL_CREATION')
            ->first();
        $this->assertNotNull($movement);
        $this->assertEquals(InventoryMovementType::RESTOCK, $movement->type);
        $this->assertEquals(15, $movement->quantity);
    }

    public function test_admin_can_adjust_inventory_stock(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'SQL-STOCK-ADJ',
            'slug' => 'test-stock-adj',
            'price' => 200.00,
            'stock' => 20,
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.inventory.adjust'), [
            'product_id' => $product->id,
            'new_stock' => 25,
            'reason' => 'Comptage physique trimestriel',
        ]);

        $response->assertRedirect();
        $this->assertEquals(25, $product->fresh()->stock);

        $movement = InventoryMovement::where('product_id', $product->id)
            ->where('type', InventoryMovementType::ADJUSTMENT)
            ->first();
        $this->assertNotNull($movement);
        $this->assertEquals(5, $movement->quantity);
        $this->assertEquals(20, $movement->stock_before);
        $this->assertEquals(25, $movement->stock_after);
    }

    public function test_admin_can_restock_product(): void
    {
        $product = Product::create([
            'category_id' => $this->category->id,
            'sku' => 'SQL-RESTOCK-ME',
            'slug' => 'test-restock-me',
            'price' => 300.00,
            'stock' => 5,
            'status' => 'published',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.inventory.restock'), [
            'product_id' => $product->id,
            'quantity' => 15,
            'reference' => 'BL-FOURNISSEUR-2026',
            'notes' => 'Livraison fournisseur Agadir',
        ]);

        $response->assertRedirect();
        $this->assertEquals(20, $product->fresh()->stock);

        $movement = InventoryMovement::where('product_id', $product->id)
            ->where('reference', 'BL-FOURNISSEUR-2026')
            ->first();
        $this->assertNotNull($movement);
        $this->assertEquals(15, $movement->quantity);
        $this->assertEquals(5, $movement->stock_before);
        $this->assertEquals(20, $movement->stock_after);
    }

    public function test_admin_can_create_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'slug' => 'maroc-artisanat',
            'name_fr' => 'Artisanat Marocain',
            'name_ar' => 'صناعة تقليدية مغربية',
            'name_en' => 'Moroccan Handicrafts',
            'sort_order' => 5,
        ]);

        $response->assertRedirect();
        $category = Category::where('slug', 'maroc-artisanat')->first();
        $this->assertNotNull($category);

        $this->assertDatabaseHas('category_translations', [
            'category_id' => $category->id,
            'locale' => 'ar',
            'name' => 'صناعة تقليدية مغربية',
        ]);
    }

    public function test_admin_can_view_customers_list_and_details(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.customers.index'));
        $response->assertStatus(200);
        $response->assertSee($this->customer->name);

        $showResponse = $this->actingAs($this->admin)->get(route('admin.customers.show', $this->customer->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($this->customer->name);
        $showResponse->assertSee($this->customer->email);
    }
}
