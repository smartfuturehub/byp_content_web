<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ShopFlowRemovedTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_shop_urls_redirect_to_programme_pages(): void
    {
        $this->seed();

        $this->get('/shop')->assertRedirect('/solutions');
        $this->get('/product')->assertRedirect('/solutions');
        $this->get('/store')->assertRedirect('/solutions');
        $this->get('/cart')->assertRedirect('/');
        $this->get('/checkout')->assertRedirect('/contact-us');
    }

    public function test_admin_product_and_order_screens_are_gone(): void
    {
        $this->seed();

        $user = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($user);

        $this->get('/admin/products')->assertNotFound();
        $this->get('/admin/orders')->assertNotFound();
    }

    public function test_search_and_sitemap_do_not_include_the_shop(): void
    {
        $this->seed();

        $this->get('/search?q=hospital')
            ->assertOk()
            ->assertSee('Pages')
            ->assertSee('Newsletter')
            ->assertDontSee('>Shop</h2>', false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertDontSee('/shop');

        $this->get('/robots.txt')
            ->assertOk()
            ->assertDontSee('/cart')
            ->assertDontSee('/checkout');
    }

    public function test_shop_tables_are_dropped(): void
    {
        $this->assertFalse(Schema::hasTable('products'));
        $this->assertFalse(Schema::hasTable('product_variants'));
        $this->assertFalse(Schema::hasTable('orders'));
        $this->assertFalse(Schema::hasTable('order_items'));
    }
}
