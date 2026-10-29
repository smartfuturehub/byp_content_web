<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Solutions');
        $response->assertSee('Learn more about the solutions we offer.');
        $response->assertSee('Hospital at Home Solution');
        $response->assertSee('Cellular Remote Patient Monitoring');
        $response->assertSee('Resident Tracking Solution');
        $response->assertSee('Emergency Response Kit');
        $response->assertSee('Medical Devices');
        $response->assertSee('EHR / EMR Integration');
        $response->assertSee('Clients');
        $response->assertSee('Partners');
        $response->assertSee('Awards');
        $response->assertSee('Contact Us');
        $response->assertSee('Book a call');
        $response->assertSee('Terms and Conditions');
        $response->assertSee('Privacy Policy');
        $response->assertSee('id="hero-slider"', false);
        $response->assertSee('aspect-ratio: 1349 / 516', false);
        $response->assertSee('/brand/byp/slides/hospital-at-home.jpeg', false);
        $response->assertSee('/brand/byp/slides/cellular.jpeg', false);
        $response->assertSee('/brand/byp/slides/resident-tracking.jpeg', false);
        $response->assertSee('/brand/byp/slides/emergency.jpeg', false);
        $response->assertSee('/brand/byp/solutions/hospital-at-home.jpg', false);
        $response->assertSee('id="cookie-banner"', false);
        $response->assertSee('G-5MWJ5HDFMZ', false);
        $response->assertSee('GTM-KCDG6B9B', false);
        $response->assertDontSee('aria-label="Cart"', false);
        $response->assertDontSee('href="'.url('/shop').'"', false);
    }

    public function test_admin_login_page_is_available(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertSee('Sign in to the CMS');
        $response->assertSee('admin@byphealthtek.com');
        $response->assertSee('Powering connected healthcare');
        $response->assertSee('Back to the website');
        $response->assertSee('brand/images/logo.png', false);
        $response->assertSee('favicon.png', false);
    }

    public function test_admin_can_open_cms_pages(): void
    {
        $this->seed();

        $user = User::query()->where('email', 'admin@byphealthtek.com')->first();
        $page = Page::query()->where('is_homepage', true)->first();

        $this->actingAs($user);

        $this->get('/admin/pages')->assertOk();
        $this->get('/admin/pages/'.$page->getKey().'/edit')->assertOk();
        $this->get('/admin/pages/'.Page::query()->where('slug', 'solutions')->value('id').'/edit')->assertOk();
        $this->get('/admin/menus')->assertOk();
        $this->get('/admin/manage-site-settings')->assertOk();
    }
}
