<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('distinctProgrammePages')]
    public function test_programme_page_explains_the_offering_with_unique_copy_and_media(string $path, string $copy, string $media): void
    {
        $this->seed();

        $response = $this->get($path);

        $response->assertOk();
        $response->assertSee($copy);
        $response->assertSee($media, false);
        $response->assertDontSee('aria-label="Breadcrumb"', false);
        $response->assertDontSee('The programme in four screens');
        $response->assertDontSee('11 countries');
        $response->assertDontSee('Singapore and United States');
    }

    public function test_hospital_at_home_uses_wordpress_copy_and_media(): void
    {
        $this->seed();

        $response = $this->get('/hospital-at-home');

        $response->assertSee('Hospital Care in the Comfort of Your Home');
        $response->assertSee('Keep your Patients in connection');
        $response->assertSee('/brand/wp/new-assets/images/Hospital-at-Home.mp4', false);
        $response->assertSee('/brand/wp/new-assets/images/solution-1.png', false);
        $response->assertDontSee('FAQPage', false);
    }

    public function test_blog_index_is_canonical_and_legacy_newsletter_paths_redirect(): void
    {
        $this->seed();

        $this->get('/blog')->assertOk()->assertSee('News and Insights')->assertSee('Subscribe')->assertDontSee('aria-label="Breadcrumb"', false);
        $this->get('/newsletter')->assertRedirect('/blog');

        $post = Post::query()->published()->first();

        $this->assertNotNull($post);
        $this->get('/newsletter/'.$post->slug)->assertRedirect('/blog/'.$post->slug);
    }

    public function test_legacy_emergency_kit_url_redirects_to_emergency_care(): void
    {
        $this->seed();

        $this->get('/emergency-kit')->assertRedirect('/emergency-care');
    }

    public function test_legacy_in_clinic_url_redirects_to_facility_care(): void
    {
        $this->seed();

        $this->get('/solution-in-clinic')->assertRedirect('/facility-care');
        $this->get('/resident-tracking-solution')->assertRedirect('/facility-care');
    }

    public function test_solutions_view_all_page_lists_the_four_programmes(): void
    {
        $this->seed();

        $response = $this->get('/solutions');

        $response->assertOk();
        $response->assertSee('White-Label Platform for Remote Patient Monitoring');
        $response->assertSee('The Right Solution');
        $response->assertSee('How We Do It');
        $response->assertSee('Hospital at Home Solution');
        $response->assertSee('Cellular Remote Patient Monitoring');
        $response->assertSee('Resident Tracking Solution');
        $response->assertSee('Emergency Response Kit');
        $response->assertSee('Wellness Kit');
        $response->assertSee('/hospital-at-home', false);
        $response->assertSee('/emergency-care', false);
        $response->assertSee('/facility-care', false);
        $response->assertSee('/cellular-platform', false);
        $response->assertDontSee('aria-label="Breadcrumb"', false);
        $response->assertDontSee('/brand/sf/solutions-hero.jpg', false);
        $response->assertDontSee('Digital Care Solutions');
    }

    public function test_emergency_care_uses_wordpress_copy_and_media(): void
    {
        $this->seed();

        $html = $this->get('/emergency-care')->getContent();

        $this->assertStringContainsString('Faster, Smarter Emergency Response', $html);
        $this->assertStringContainsString('AR Glasses Integration', $html);
        $this->assertStringContainsString('/brand/wp/new-assets/images/Emergency-Response-Kit.mp4', $html);
        $this->assertStringContainsString('/brand/wp/new-assets/images/AR.png', $html);
        $this->assertStringContainsString('Maritime', $html);
        $this->assertStringNotContainsString('/brand/sf/', $html);
    }

    public function test_hospital_at_home_uses_wordpress_departments_and_devices(): void
    {
        $this->seed();

        $html = $this->get('/hospital-at-home')->getContent();

        $this->assertStringContainsString('Cardiology Department', $html);
        $this->assertStringContainsString('Leading Wireless Medical Devices', $html);
        $this->assertStringContainsString('/brand/wp/new-assets/dev-img/Cardiology-Department.jpg', $html);
        $this->assertStringContainsString('/brand/wp/new-assets/images/pa-img-2.png', $html);
        $this->assertStringNotContainsString('/brand/sf/', $html);
    }

    public function test_chronic_care_uses_wordpress_bluetooth_copy(): void
    {
        $this->seed();

        $html = $this->get('/chronic-care')->getContent();

        $this->assertStringContainsString('Bluetooth Medical Devices for Chronic Care Management', $html);
        $this->assertStringContainsString('/brand/wp/uploads/2021/09/blood-glucose-app.jpg', $html);
        $this->assertStringNotContainsString('/brand/sf/', $html);
    }

    public function test_facility_care_uses_wordpress_resident_tracking_copy(): void
    {
        $this->seed();

        $html = $this->get('/facility-care')->getContent();

        $this->assertStringContainsString('Comprehensive Solution to Track Residents in Residential Facilities', $html);
        $this->assertStringContainsString('Industrial Grade Bluetooth Hub', $html);
        $this->assertStringContainsString('/brand/wp/uploads/2024/07/Health-monitoring-platform-for-residential.mp4', $html);
        $this->assertStringNotContainsString('/brand/sf/', $html);
    }

    public function test_contact_us_and_demo_entry_points_are_reachable(): void
    {
        $this->seed();

        foreach ([
            '/',
            '/hospital-at-home',
            '/emergency-care',
            '/chronic-care',
            '/facility-care',
            '/solutions',
            '/blog',
            '/contact-us',
            '/admin/login',
        ] as $path) {
            $this->get($path)->assertOk();
        }

        $this->get('/contact-us')
            ->assertSee('id="contact"', false)
            ->assertSee('Contact Us')
            ->assertSee('First Name')
            ->assertSee('Write Here');

        $this->get('/')
            ->assertSee('id="solutions"', false)
            ->assertSee('href="'.url('/contact-us').'"', false);

        $this->get('/emergency-care')
            ->assertSee('Emergency-Response-Kit.mp4', false)
            ->assertSee('href="'.url('/contact-us').'"', false);

        $this->get('/blog')
            ->assertSee('Work email')
            ->assertDontSee('bg-navy', false)
            ->assertDontSee('aria-label="Search"', false)
            ->assertDontSee('href="'.url('/search').'"', false);
    }

    public function test_privacy_policy_and_terms_of_use_publish_the_uploaded_legal_copy(): void
    {
        $this->seed();

        $this->get('/privacy-policy')
            ->assertOk()
            ->assertSee('Last updated: 17 September 2026')
            ->assertSee('Personal Data Protection Act 2012')
            ->assertSee('dpo@byphealthtek.com')
            ->assertSee('mailto:dpo@byphealthtek.com', false)
            ->assertDontSee('We collect contact details you submit through forms');

        $this->get('/tnc')
            ->assertOk()
            ->assertSee('Last updated: 17 September 2026')
            ->assertSee('does not constitute medical advice')
            ->assertSee('governed by the laws of Singapore')
            ->assertSee('href="/privacy-policy"', false)
            ->assertDontSee('Clinical programmes, device orders, and software licences are governed by separate agreements.');
    }

    public function test_homepage_logo_rows_and_talk_band_use_the_contained_layout(): void
    {
        $this->seed();

        $this->get('/')
            ->assertSee('logo-wall', false)
            ->assertSee('logo-heading', false)
            ->assertSee('logo-grid', false)
            ->assertSee('logo-cell', false)
            ->assertSee('/brand/byp/clients/client-1.png', false)
            ->assertSee('Clients')
            ->assertSee('Partners')
            ->assertSee('Awards')
            ->assertSee('Acceleration');
    }

    public function test_homepage_platform_pillars_fill_the_content_width(): void
    {
        $this->seed();

        $this->get('/')
            ->assertSee('Medical Devices')
            ->assertSee('Oximeter')
            ->assertSee('Blood Pressure Monitor')
            ->assertSee('EHR / EMR Integration')
            ->assertSee('ehr-band', false)
            ->assertSee('Epic')
            ->assertSee('athenahealth');
    }

    public function test_solutions_dropdown_renders_programme_thumbnails(): void
    {
        $this->seed();

        $this->get('/')
            ->assertSee('/brand/byp/solutions/hospital-at-home.jpg', false)
            ->assertSee('/brand/byp/solutions/emergency.jpg', false)
            ->assertSee('/brand/byp/solutions/cellular.jpg', false)
            ->assertSee('/brand/byp/solutions/resident-tracking.jpg', false)
            ->assertSee('Hospital at Home Solution')
            ->assertSee('Resident Tracking Solution');
    }

    #[DataProvider('pagesWithSharedChrome')]
    public function test_public_pages_share_the_same_header_and_footer(string $path): void
    {
        $this->seed();

        $response = $this->get($path);

        $response->assertOk();
        $response->assertSee('id="site-header"', false);
        $response->assertSee('id="footer"', false);
        $response->assertSee('aria-label="Primary"', false);
        $response->assertSee('Book a call');
        $response->assertSee('Home');
        $response->assertSee('Solutions');
        $response->assertDontSee('aria-label="Search"', false);
        $response->assertDontSee('href="'.url('/search').'"', false);
        $response->assertSee('Privacy Policy');
        $response->assertSee('Terms and Conditions');
        $response->assertSee('href="'.url('/tnc').'"', false);
        $response->assertSee('href="'.url('/privacy-policy').'"', false);
        $response->assertSee('Customized tech solutions to help providers seamlessly connect with their patients.');
        $response->assertSee('id="cookie-banner"', false);
        $response->assertDontSee('SG HQ');
        $response->assertDontSee('US office');
        $response->assertDontSee('Singapore HQ');
        $response->assertDontSee('United States office');
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function pagesWithSharedChrome(): array
    {
        return [
            'home' => ['/'],
            'emergency kit' => ['/emergency-care'],
            'hospital at home' => ['/hospital-at-home'],
            'solutions' => ['/solutions'],
            'blog' => ['/blog'],
        ];
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function distinctProgrammePages(): array
    {
        return [
            'hospital at home' => ['/hospital-at-home', 'always on and permanently charging', 'Hospital-at-Home.mp4'],
            'chronic care' => ['/chronic-care', 'Bluetooth Medical Devices for Chronic Care Management', 'blood-glucose-app.jpg'],
            'cellular rpm' => ['/cellular-platform', 'No-app, customized remote patient monitoring', 'Cellular-Platform-at-Home.mp4'],
            'facility care' => ['/facility-care', 'Industrial Grade Bluetooth Hub', 'Health-monitoring-platform-for-residential.mp4'],
            'emergency kit' => ['/emergency-care', 'Faster, Smarter Emergency Response', 'Emergency-Response-Kit.mp4'],
            'wellness kit' => ['/wellness-kit', 'Instant Health Check Up in Your Site', 'wellness-kit.mp4'],
            'corporate wellness' => ['/corporate-wellness-kit', 'On-site employee health checks', 'Customisable-Portable.jpg'],
            'rpm platform' => ['/rpm-platform', 'White-Label Platform for Remote Patient Monitoring', '/brand/wp/new-assets/images/h-1.png'],
            'about' => ['/about-us', 'Bringing Healthcare Closer To You', '/brand/wp/logo.png'],
            'contact' => ['/contact-us', "We'd love to hear from you!", '/brand/wp/logo.png'],
        ];
    }
}
