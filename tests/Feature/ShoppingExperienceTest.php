<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShoppingExperienceTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogSeeder::class);
        $this->product = Product::first();

        $this->user = User::create([
            'name' => 'Yassine Customer',
            'email' => 'yassine.customer@souqly.ma',
            'phone' => '0661234567',
            'password' => Hash::make('password123'),
            'role' => UserRole::CUSTOMER,
            'status' => 'active',
        ]);
    }

    public function test_cart_page_renders_cleanly(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Panier');
    }

    public function test_user_can_add_item_to_cart(): void
    {
        $response = $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect(route('cart.index'));

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);
    }

    public function test_user_can_update_cart_quantity(): void
    {
        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $cartItem = CartItem::first();

        $response = $this->actingAs($this->user)->patch("/cart/{$cartItem->id}", [
            'quantity' => 4,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('cart_items', [
            'id' => $cartItem->id,
            'quantity' => 4,
        ]);
    }

    public function test_user_can_remove_item_from_cart(): void
    {
        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $cartItem = CartItem::first();

        $response = $this->actingAs($this->user)->delete("/cart/{$cartItem->id}");
        $response->assertStatus(302);

        $this->assertDatabaseMissing('cart_items', [
            'id' => $cartItem->id,
        ]);
    }

    public function test_checkout_page_redirects_if_cart_is_empty(): void
    {
        $response = $this->actingAs($this->user)->get('/checkout');
        $response->assertRedirect(route('cart.index'));
    }

    public function test_checkout_places_cod_order_and_deducts_stock(): void
    {
        $initialStock = $this->product->stock;

        // Add to cart as user
        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Place COD order
        $response = $this->actingAs($this->user)->post('/checkout/process', [
            'name' => 'Mohamed Tazi',
            'email' => 'tazi@example.com',
            'phone' => '0661234567',
            'city' => 'Casablanca',
            'address' => 'Boulevard Zerktouni, Immeuble 22',
            'notes' => 'Livraison l\'après-midi',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Mohamed Tazi',
            'customer_phone' => '0661234567',
            'shipping_city' => 'Casablanca',
            'payment_method' => 'cod',
            'status' => 'pending',
        ]);

        $order = Order::first();
        $response->assertRedirect(route('checkout.success', $order->order_number));

        // Check stock was decremented
        $this->assertEquals($initialStock - 2, $this->product->fresh()->stock);

        // Check cart is emptied
        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_order_success_page_renders(): void
    {
        $this->actingAs($this->user)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $this->actingAs($this->user)->post('/checkout/process', [
            'name' => 'Fatima Zahra',
            'email' => 'fatima@example.com',
            'phone' => '0661998877',
            'city' => 'Marrakech',
            'address' => 'Guéliz, Rue de la Liberté',
        ]);

        $order = Order::first();

        $response = $this->get("/checkout/success/{$order->order_number}");
        $response->assertStatus(200);
        $response->assertSee($order->order_number);
        $response->assertSee('Fatima Zahra');
        $response->assertSee('Marrakech');
    }
}
