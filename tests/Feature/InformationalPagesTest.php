<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InformationalPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_faq_page_can_be_rendered(): void
    {
        $response = $this->get('/faq');

        $response->assertStatus(200);
        $response->assertSee(__('common.faq'));
        $response->assertSee('Amana');
        $response->assertSee('Cash on Delivery');
    }

    public function test_shipping_policy_page_can_be_rendered(): void
    {
        $response = $this->get('/shipping-policy');

        $response->assertStatus(200);
        $response->assertSee(__('common.shipping_policy'));
        $response->assertSee('Cathedis');
        $response->assertSee('30,00 MAD');
    }

    public function test_return_policy_page_can_be_rendered(): void
    {
        $response = $this->get('/return-policy');

        $response->assertStatus(200);
        $response->assertSee(__('common.return_policy'));
        $response->assertSee('7');
    }

    public function test_terms_page_can_be_rendered(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
        $response->assertSee(__('common.terms'));
        $response->assertSee('Loi N° 31-08');
    }

    public function test_privacy_page_can_be_rendered(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);
        $response->assertSee(__('common.privacy'));
        $response->assertSee('CNDP');
    }

    public function test_sitemap_includes_informational_pages(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('/faq');
        $response->assertSee('/shipping-policy');
        $response->assertSee('/return-policy');
        $response->assertSee('/terms');
        $response->assertSee('/privacy');
    }

    public function test_checkout_success_page_renders_with_luxury_styling_and_details(): void
    {
        $category = Category::create([
            'slug' => 'test-luxury-watches',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'SQL-TEST-001',
            'slug' => 'royal-chrono',
            'price' => 1200.00,
            'stock' => 10,
            'is_featured' => true,
            'status' => 'published',
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'SQL-TEST-001-GOLD',
            'price' => 1200.00,
            'stock_quantity' => 10,
            'attributes' => ['color' => 'Gold'],
        ]);

        $order = Order::create([
            'order_number' => 'SQL-202611-TEST01',
            'status' => \App\Enums\OrderStatus::PENDING,
            'shipping_city' => 'Casablanca',
            'shipping_address' => 'Boulevard d\'Anfa, N° 12',
            'customer_name' => 'Amine Tazi',
            'customer_phone' => '0661123456',
            'customer_email' => 'amine@example.ma',
            'subtotal' => 1200.00,
            'shipping_cost' => 0.00,
            'discount' => 0.00,
            'total' => 1200.00,
            'currency' => 'MAD',
            'payment_method' => \App\Enums\PaymentMethod::COD,
            'payment_status' => \App\Enums\PaymentStatus::PENDING,
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_name' => 'Royal Chrono Gold',
            'sku' => $variant->sku,
            'unit_price' => 1200.00,
            'quantity' => 1,
            'total' => 1200.00,
        ]);

        $response = $this->get(route('checkout.success', $order->order_number));

        $response->assertStatus(200);
        $response->assertSee('SQL-202611-TEST01');
        $response->assertSee('Amine Tazi');
        $response->assertSee('Casablanca');
        $response->assertSee('1,200.00');
        $response->assertSee('WhatsApp');
    }
}
