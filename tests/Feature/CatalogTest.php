<?php

namespace Tests\Feature;

use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogSeeder::class);
    }

    public function test_catalog_page_renders_successfully(): void
    {
        $response = $this->get('/shop');
        $response->assertStatus(200);
        $response->assertSee('Souqly Royal Chronographe');
        $response->assertSee('MAD');
    }

    public function test_catalog_can_be_filtered_by_category(): void
    {
        $response = $this->get('/shop?category=luxury-watches');
        $response->assertStatus(200);
        $response->assertSee('Souqly Royal Chronographe');
        $response->assertDontSee('Écouteurs Sans Fil Souqly Air Pro');
    }

    public function test_catalog_can_be_filtered_by_price_range(): void
    {
        $response = $this->get('/shop?min_price=1500&max_price=2000');
        $response->assertStatus(200);
        $response->assertSee('Souqly Royal Chronographe'); // 1,890 MAD
        $response->assertDontSee('Écouteurs Sans Fil Souqly Air Pro'); // 499 MAD
    }

    public function test_catalog_search_filters_results(): void
    {
        $response = $this->get('/shop?q=Earbuds');
        $response->assertStatus(200);
        $response->assertSee('Souqly Air Pro');
        $response->assertDontSee('Souqly Royal Chronographe');
    }

    public function test_single_product_page_can_be_rendered(): void
    {
        $response = $this->get('/product/souqly-royal-chrono-41mm');
        $response->assertStatus(200);
        $response->assertSee('Souqly Royal Chronographe Automatique 41mm');
        $response->assertSee('1,890.00');
        $response->assertSee('Acier Argenté');
    }

    public function test_non_existent_product_returns_404(): void
    {
        $response = $this->get('/product/unknown-item-12345');
        $response->assertStatus(404);
    }

    public function test_product_renders_arabic_translation_in_rtl(): void
    {
        session(['locale' => 'ar']);
        $response = $this->get('/product/souqly-royal-chrono-41mm');
        $response->assertStatus(200);
        $response->assertSee('ساعة سوقلي رويال كرونوغراف أوتوماتيك');
        $response->assertSee('dir="rtl"', false);
    }

    public function test_xml_sitemap_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $response->assertSee('/product/souqly-royal-chrono-41mm');
    }
}
