<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Logo;
use App\Models\MedicalDevice;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Redirect;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\Concerns\SeedsWordPressPages;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use SeedsWordPressPages;

    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin');
        Role::findOrCreate('editor');

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@byphealthtek.com'],
            [
                'name' => 'BYP Health Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $admin->assignRole($adminRole);

        SiteSetting::query()->updateOrCreate(['id' => 1], [
            'data' => [
                'site_name' => 'BYP Health',
                'tagline' => 'Remote Care Solutions for Healthcare',
                'logo' => '/brand/wp/logo.png',
                'favicon' => '/favicon.png',
                'about_blurb' => '',
                'footer_cta' => 'Customized tech solutions to help providers seamlessly connect with their patients.',
                'email' => 'sales@byphealthtek.com',
                'topbar_line' => '',
                'coverage_line' => 'We deploy with hospitals, clinics, and care teams in any country. The UAE, Singapore and the United States are our offices — not the limit of where we work.',
                'phone_sg' => '+65 8836 0984',
                'phone_us' => '+1 (512) 717-6408',
                'phone_ae' => '+971 55 735 6736',
                'whatsapp_url' => 'https://wa.me/971557356736',
                'address_sg' => '246 Macpherson Road, #03-01 Betime Building, Singapore 348578',
                'address_us' => '651 N Broad St, Suite 201, Middletown, Delaware 19709',
                'address_ae' => 'United Arab Emirates',
                'twitter_url' => '',
                'linkedin_url' => '',
                'header_cta_label' => 'Book a call',
                'header_cta_url' => '/contact-us',
                'newsletter_headline' => '',
                'newsletter_body' => '',
                'default_meta_title' => 'Remote Patient Monitoring & Remote Care Solutions | BYP Health',
                'default_meta_description' => 'BYP Health connects care teams and patients with digital solutions for hospital at home, emergency response, chronic disease and facility-based care.',
                'cookie_banner_enabled' => true,
                'cookie_banner_title' => 'Cookies',
                'cookie_banner_body' => 'We use cookies to understand how visitors use this website. Analytics load only after you accept. See our Privacy Policy for details.',
                'google_analytics_id' => 'G-5MWJ5HDFMZ',
                'google_tag_manager_id' => 'GTM-KCDG6B9B',
                'google_ads_id' => '',
            ],
        ]);

        $this->menus();
        $this->taxonomies();
        $this->library();
        $this->pages();
        $this->blog();
        $this->redirects();
    }

    protected function menus(): void
    {
        Menu::query()->updateOrCreate(['location' => 'header'], [
            'name' => 'Header',
            'items' => [
                [
                    'label' => 'Solutions',
                    'url' => '/solutions',
                    'children' => [
                        ['label' => 'Hospital at Home Solution', 'url' => '/hospital-at-home'],
                        ['label' => 'Cellular Remote Patient Monitoring', 'url' => '/cellular-platform'],
                        ['label' => 'Resident Tracking Solution', 'url' => '/facility-care'],
                        ['label' => 'Emergency Response Kit', 'url' => '/emergency-care'],
                        ['label' => 'Wellness Kit', 'url' => '/wellness-kit'],
                    ],
                ],
            ],
        ]);

        Menu::query()->updateOrCreate(['location' => 'footer'], [
            'name' => 'Footer',
            'items' => [
                ['label' => 'Hospital at Home', 'url' => '/hospital-at-home'],
                ['label' => 'Cellular RPM', 'url' => '/cellular-platform'],
                ['label' => 'Resident Tracking', 'url' => '/facility-care'],
                ['label' => 'Emergency Response Kit', 'url' => '/emergency-care'],
                ['label' => 'Wellness Kit', 'url' => '/wellness-kit'],
                ['label' => 'Blog', 'url' => '/blog'],
                ['label' => 'Contact Us', 'url' => '/contact-us'],
            ],
        ]);

        Menu::query()->updateOrCreate(['location' => 'legal'], [
            'name' => 'Legal',
            'items' => [
                ['label' => 'Terms and Conditions', 'url' => '/tnc'],
                ['label' => 'Privacy Policy', 'url' => '/privacy-policy'],
            ],
        ]);
    }

    protected function taxonomies(): void
    {
        foreach (['General' => 'general', 'Health' => 'health', 'Blog' => 'blog'] as $name => $slug) {
            Category::query()->updateOrCreate(['type' => 'post', 'slug' => $slug], ['name' => $name]);
        }
    }

    protected function library(): void
    {
        Logo::query()->delete();

        $logos = [
            ['client', 'Client 1', '/brand/byp/clients/client-1.png', null, 1, true],
            ['client', 'Client 2', '/brand/byp/clients/client-2.png', null, 2, true],
            ['client', 'Client 3', '/brand/byp/clients/sm2.png', null, 3, true],
            ['client', 'Client 4', '/brand/byp/clients/client-4.png', null, 4, true],
            ['client', 'Client 5', '/brand/byp/clients/sm1.png', null, 5, true],
            ['client', 'Client 6', '/brand/byp/clients/sm4.png', null, 6, true],
            ['client', 'Client 7', '/brand/byp/clients/sm6.png', null, 7, true],
            ['partner', 'Partner', '/brand/byp/clients/sm5.png', null, 1, true],
            ['partner', 'Partner 2', '/brand/byp/clients/partner-2.png', null, 2, true],
            ['partner', 'AWS Partner', '/brand/byp/clients/aws-partner.png', 'https://aws.amazon.com', 3, true],
            ['acceleration', 'Acceleration 1', '/brand/byp/clients/program-1.png', null, 1, true],
            ['acceleration', 'Acceleration 2', '/brand/byp/clients/program-2.png', null, 2, true],
            ['acceleration', 'Acceleration 3', '/brand/byp/clients/sm3.png', null, 3, true],
            ['award', 'Award 1', '/brand/byp/clients/award-1.png', null, 1, true],
            ['award', 'Award 2', '/brand/byp/clients/award-2.png', null, 2, true],
            ['award', 'Award 3', '/brand/byp/clients/award-3.png', null, 3, true],
        ];

        foreach ($logos as $logo) {
            Logo::query()->create([
                'type' => $logo[0],
                'name' => $logo[1],
                'image' => $logo[2],
                'url' => $logo[3],
                'sort_order' => $logo[4],
                'is_published' => $logo[5],
            ]);
        }

        $devices = [
            ['Blood Pressure Monitor', '/brand/sf/hah-devices/blood-pressure.png'],
            ['Thermometer', '/brand/sf/hah-devices/thermometer.png'],
            ['Blood Glucose Monitor', '/brand/sf/hah-devices/glucose.png'],
            ['Ultrasound', '/brand/sf/ek-devices/ultrasound.png'],
            ['ECG Monitor', '/brand/sf/hah-devices/ecg.png'],
            ['Oximeter', '/brand/sf/hah-devices/pulse-oximeter.png'],
            ['Dermatoscope', '/brand/sf/ek-devices/dermatoscope.png'],
            ['Spirometer', '/brand/sf/cdm-devices/spirometer.png'],
            ['Digital Stethoscope', '/brand/sf/hah-devices/stethoscope.png'],
        ];
        foreach ($devices as $i => $device) {
            MedicalDevice::query()->updateOrCreate(['name' => $device[0]], [
                'image' => $device[1],
                'sort_order' => $i,
            ]);
        }

        MedicalDevice::query()->whereNotIn('name', array_column($devices, 0))->delete();

        Testimonial::query()->delete();
        Testimonial::query()->create([
            'name' => 'Amelia Joseph',
            'organization' => 'NUHS',
            'quote' => 'The kit stays on in the home, so the care team sees vitals without asking patients to open another app. That is what makes this usable as a programme, not a pilot.',
            'sort_order' => 1,
            'is_published' => true,
        ]);
        Testimonial::query()->create([
            'name' => 'Jacob Joshua',
            'organization' => 'SingHealth',
            'quote' => 'One clinician portal for thresholds, video, chat, and escalation. We did not want a second system sitting beside the EHR.',
            'sort_order' => 2,
            'is_published' => true,
        ]);
        Testimonial::query()->create([
            'name' => 'Jacob Joshua',
            'organization' => 'International SOS',
            'quote' => 'For remote sites, cellular devices and live video matter more than a consumer wellness app. This is built for that setting.',
            'sort_order' => 3,
            'is_published' => true,
        ]);

        $faqs = [
            ['How is BYP Health different from other RPM vendors?', 'We deliver a fully white-labeled remote patient monitoring platform hosted on your infrastructure. Devices, the patient experience, the clinician portal, alerting, and EHR integrations sit in one programme — in your brand, not ours.'],
            ['Who is this for?', 'Hospitals, clinics, nursing homes, insurers, and occupational-health teams in any country. Typical buyers are clinical operations, digital-health, and population-health leads. Offices in Singapore and the United States support calls and visits — they are not a limit on where we deploy.'],
            ['Do you only work in Singapore and the United States?', 'No. Those are our offices for calls and visits. Kits, white-label hosting, and clinician programmes are set up for the country you operate in. Tell us the site of care on the contact form.'],
            ['What does a patient actually receive?', 'A kit with an always-on companion device (often an iPad) plus wireless medical devices for blood pressure, temperature, glucose, ECG, SpO2 and other vitals. Readings transmit automatically. Video and chat keep the care team in reach.'],
            ['What does a clinician see?', 'A web portal with cohort views, trends, threshold alerts, and messaging. Teams can register patients, configure devices, generate reports, and escalate without jumping between systems.'],
            ['Can you integrate with our EHR or EMR?', 'Yes. We sync remote monitoring data with hospital records so the clinical view stays complete across ward, clinic, and home. We already work with 110+ EHR/EMR systems.'],
            ['Do you support cellular connectivity?', 'Yes. Cellular kits send data from the device without a patient app or home Wi-Fi — used for nursing homes, kiosks, and households without reliable broadband.'],
            ['Can we white-label the apps and portal?', 'Yes. Mobile app, web portal, SMS, and hosting run in your brand and on your environment. You keep data ownership and compliance.'],
            ['How do we start a hospital-at-home programme?', 'Book a 30-minute demo. We map your pathway, devices, alerts, and a first ward or clinic, then configure a pilot before you scale.'],
            ['What is in the emergency kit?', 'A modular kit of wireless diagnostics, video support (including AR glasses where needed), and data flow for maritime, aviation, mining, oil-rig, military, and other remote sites.'],
            ['Can we use this for workplace wellness rather than clinical RPM?', 'Yes. The Wellness Kit is a portable station for on-site checks at offices, schools, gyms, hotels, ageing centres, residences, and ships — with the same connected device stack.'],
        ];
        foreach ($faqs as $i => $faq) {
            Faq::query()->updateOrCreate(['question' => $faq[0]], [
                'answer' => '<p>'.$faq[1].'</p>',
                'group' => 'General',
                'sort_order' => $i,
            ]);
        }
    }

    protected function pages(): void
    {
        $this->upsertPage('Home', 'home', true, [
            $this->block('hero_slider', [
                'slides' => [
                    [
                        'overlay' => false,
                        'headline' => 'Hospital at Home',
                        'image' => '/brand/byp/slides/hospital-at-home.jpeg',
                        'image_alt' => 'Empowering hospitals with technology to monitor their patients at home',
                        'cta_url' => '/hospital-at-home',
                    ],
                    [
                        'overlay' => false,
                        'headline' => 'Cellular Remote Patient Monitoring',
                        'image' => '/brand/byp/slides/cellular.jpeg',
                        'image_alt' => 'Cellular remote patient monitoring',
                        'cta_url' => '/cellular-platform',
                    ],
                    [
                        'overlay' => false,
                        'headline' => 'Resident Tracking Solution',
                        'image' => '/brand/byp/slides/resident-tracking.jpeg',
                        'image_alt' => 'Resident tracking solution',
                        'cta_url' => '/facility-care',
                    ],
                    [
                        'overlay' => false,
                        'headline' => 'Emergency Response Kit',
                        'image' => '/brand/byp/slides/emergency.jpeg',
                        'image_alt' => 'Emergency response kit',
                        'cta_url' => '/emergency-care',
                    ],
                ],
            ]),
            $this->block('cards', [
                'anchor' => 'solutions',
                'variant' => 'photo',
                'columns' => '2',
                'tone' => 'white',
                'headline' => 'Solutions',
                'intro' => 'Learn more about the solutions we offer.',
                'items' => [
                    ['image' => '/brand/byp/solutions/hospital-at-home.jpg', 'title' => 'Hospital at Home Solution', 'body' => 'Enable healthcare providers to extend their care to patients\' homes, providing seamless monitoring and continuous health management.', 'url' => '/hospital-at-home'],
                    ['image' => '/brand/byp/solutions/cellular.jpg', 'title' => 'Cellular Remote Patient Monitoring', 'body' => 'Ensure patients stay connected and monitored in real-time, regardless of their location, with our robust cellular-based solutions.', 'url' => '/cellular-platform'],
                    ['image' => '/brand/byp/solutions/resident-tracking.jpg', 'title' => 'Resident Tracking Solution', 'body' => 'Improve resident safety and oversight in assisted living environments with our advanced tracking and health monitoring technology.', 'url' => '/facility-care'],
                    ['image' => '/brand/byp/solutions/emergency.jpg', 'title' => 'Emergency Response Kit', 'body' => 'Equip first responders with essential tools for swift and informed decision-making in emergency situations.', 'url' => '/emergency-care'],
                ],
            ]),
            $this->block('devices', [
                'headline' => 'Medical Devices',
                'eyebrow' => 'Configured for your programme',
                'intro' => 'Choose from a wide range of medical devices for your solution.',
                'from_library' => false,
                'show_pills' => false,
                'variant' => 'photo',
                'items' => [
                    ['name' => 'Oximeter', 'image' => '/brand/byp/devices/device-1.jpeg'],
                    ['name' => 'Blood Glucose Monitor', 'image' => '/brand/byp/devices/device-2.jpeg'],
                    ['name' => 'Blood Pressure Monitor', 'image' => '/brand/byp/devices/device-3.jpeg'],
                    ['name' => 'Spirometer', 'image' => '/brand/byp/devices/device-4.jpeg'],
                    ['name' => 'Ultrasound', 'image' => '/brand/byp/devices/device-5.jpeg'],
                    ['name' => 'Home Sleep Test', 'image' => '/brand/byp/devices/device-6.jpeg'],
                    ['name' => 'ECG Monitor', 'image' => '/brand/byp/devices/device-7.jpeg'],
                    ['name' => 'Dermathoscope', 'image' => '/brand/byp/devices/device-8.webp'],
                    ['name' => '32 + Vitals'],
                ],
            ]),
            $this->block('split', [
                'layout' => 'integrations',
                'headline' => 'EHR / EMR Integration',
                'body' => '<p>Integrate with your EHR and other systems for optimized workflow.</p>',
                'image' => '/brand/wp/assets/img/billing-image.png',
                'image_alt' => 'EHR and billing integrations for remote care programmes',
                'fit' => 'contain',
                'systems' => [
                    ['label' => 'Epic'],
                    ['label' => 'Cerner'],
                    ['label' => 'MEDITECH'],
                    ['label' => 'athenahealth'],
                    ['label' => 'eClinicalWorks'],
                    ['label' => 'Allscripts'],
                    ['label' => 'NextGen'],
                ],
            ]),
            $this->block('trust_wall', [
                'sources' => ['client', 'partner', 'acceleration', 'award'],
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
                'show_details' => false,
            ]),
        ], 'Remote Patient Monitoring & Remote Care Solutions | BYP Health', 'BYP Health connects care teams and patients with digital solutions for hospital at home, emergency response, chronic disease and facility-based care.');

        $this->seedWordPressPages();

        $this->upsertPage('Privacy Policy', 'privacy-policy', false, [
            $this->block('rich_text', [
                'headline' => 'Privacy Policy',
                'body' => $this->legalBody('privacy-policy.html'),
            ]),
        ], 'Privacy Policy | BYP Health', 'This Privacy Policy explains how BYP Health may collect, use, disclose, process, store and protect personal data in connection with our websites, healthcare technology solutions and related services.');

        $this->upsertPage('Terms and Conditions', 'tnc', false, [
            $this->block('rich_text', [
                'headline' => 'Terms and Conditions',
                'body' => $this->legalBody('terms-of-use.html'),
            ]),
        ], 'Terms and Conditions | BYP Health', 'These Terms and Conditions govern your access to and use of the BYP Health website.');
    }

    protected function blog(): void
    {
        $author = User::query()->where('email', 'admin@byphealthtek.com')->first();
        $general = Category::query()->where('type', 'post')->where('slug', 'general')->first();
        $health = Category::query()->where('type', 'post')->where('slug', 'health')->first();

        $posts = [
            [
                'Why Connected Healthcare Devices Matter Today',
                'why-connected-healthcare-devices-matter-today',
                'In many modern hospitals, nurses still spend time manually recording patient vital signs. Connected devices change that workflow.',
                '/brand/images/blog1.png',
                $general,
                '<p>Clinicians often need to open multiple systems to understand a patient’s status. Connected healthcare devices stream vitals into a single remote monitoring layer so teams can spot deterioration earlier and spend less time on transcription.</p><p>BYP Health helps hospitals, clinics, and home-care programmes deploy those devices with white-labeled software and EHR integration.</p>',
            ],
            [
                '5 Reasons People Are Choosing BYP Health MediKit',
                '5-reasons-people-are-choosing-smartfuture-medikit',
                'As healthcare systems evolve, people want solutions that are connected, portable, and simple to operate on site.',
                '/brand/images/blog2.png',
                $health,
                '<p>The MediKit and Wellness Kit family brings screening into workplaces, schools, hotels, and community sites. Programmes get devices, a connected workflow, and measurable outcomes without standing up a full clinic.</p>',
            ],
            [
                'How AI in Healthcare Changes Patient Care',
                'how-ai-in-healthcare-changes-patient-care',
                'AI in healthcare is becoming essential as providers face growing and complex challenges.',
                '/brand/images/blog3.png',
                $health,
                '<p>When remote monitoring data is structured, care teams can apply intelligence to risk, workload, and follow-up. BYP Health adds an intelligent layer so programmes work faster and reduce manual effort.</p>',
            ],
            [
                'Using RPM to Improve Athlete Performance',
                'using-rpm-to-improve-athlete-performance',
                'Remote patient monitoring is not only for chronic disease. Sports programmes use the same connected vitals stack for recovery and readiness.',
                '/brand/images/blog4.png',
                $general,
                '<p>RPM platforms designed for clinical care also help performance teams track recovery, sleep, and cardiac load with medical-grade devices and a shared dashboard.</p>',
            ],
        ];

        foreach ($posts as $i => $post) {
            Post::query()->updateOrCreate(['slug' => $post[1]], [
                'user_id' => $author?->id,
                'category_id' => $post[4]?->id,
                'title' => $post[0],
                'status' => 'published',
                'excerpt' => $post[2],
                'featured_image' => $post[3],
                'author_name' => 'BYP Health',
                'published_at' => now()->subDays(($i + 1) * 7),
                'body' => $post[5],
                'seo_title' => $post[0].' | BYP Health',
                'seo_description' => $post[2],
            ]);
        }

        $dump = database_path('seeders/data/posts.json');
        if (File::exists($dump)) {
            foreach (json_decode(File::get($dump), true) ?: [] as $row) {
                if (blank($row['slug'] ?? null) || blank($row['title'] ?? null)) {
                    continue;
                }

                Post::query()->updateOrCreate(['slug' => $row['slug']], [
                    'user_id' => $author?->id,
                    'category_id' => $health?->id ?? $general?->id,
                    'title' => $row['title'],
                    'status' => 'published',
                    'excerpt' => $row['excerpt'] ?? null,
                    'featured_image' => $row['featured'] ?? null,
                    'author_name' => 'BYP Health',
                    'published_at' => filled($row['date'] ?? null) ? $row['date'] : now(),
                    'body' => $row['content'] ?? '',
                    'seo_title' => $row['yoast_title'] ?: ($row['title'].' | BYP Health'),
                    'seo_description' => $row['yoast_desc'] ?: ($row['excerpt'] ?? null),
                ]);
            }
        }
    }

    protected function redirects(): void
    {
        Redirect::query()->where('from_path', '/blog')->delete();

        $map = [
            '/cellular-remote-patient-monitoring' => '/cellular-platform',
            '/solutions/cellular-remote-patient-monitoring' => '/cellular-platform',
            '/resident-tracking-solution' => '/facility-care',
            '/solutions/resident-tracking-solution' => '/facility-care',
            '/solution-in-clinic' => '/facility-care',
            '/solutions/hospital-at-home' => '/hospital-at-home',
            '/solutions/emergency-response' => '/emergency-care',
            '/emergency-response' => '/emergency-care',
            '/emergency-kit' => '/emergency-care',
            '/home-2023' => '/',
            '/contact' => '/contact-us',
            '/product' => '/solutions',
            '/store' => '/solutions',
            '/chronic-disease-management' => '/chronic-care',
            '/shop' => '/solutions',
            '/cart' => '/',
            '/checkout' => '/contact-us',
        ];

        foreach ($map as $from => $to) {
            Redirect::query()->updateOrCreate(['from_path' => $from], [
                'to_path' => $to,
                'status_code' => 301,
                'is_active' => true,
            ]);
        }
    }

    /**
     * @param  array<int, array{label: string, body: string}>  $choose
     * @param  array<int, array{label: string, body: string}>  $receives
     * @return array<string, mixed>
     */
    protected function audience(string $headline, string $intro, array $choose, array $receives): array
    {
        return $this->block('detail_list', [
            'headline' => $headline,
            'intro' => $intro,
            'tone' => 'white',
            'columns' => [
                ['title' => 'Choose this if', 'items' => $choose],
                ['title' => 'What they receive', 'items' => $receives],
            ],
        ]);
    }

    /**
     * @return array<int, array{src: string, alt: string}>
     */
    protected function imageSet(string $pattern, int $from, int $to, string $altPrefix): array
    {
        $images = [];

        for ($i = $from; $i <= $to; $i++) {
            $images[] = [
                'src' => sprintf($pattern, $i),
                'alt' => $altPrefix.' '.$i,
            ];
        }

        return $images;
    }

    /**
     * @param  array{
     *     title: string,
     *     eyebrow: string,
     *     headline: string,
     *     body: string,
     *     hero_image: string,
     *     highlight_eyebrow: string,
     *     highlight_headline: string,
     *     highlight_body: string,
     *     highlight_image: string,
     *     extras?: array<int, array<string, mixed>>
     * }  $kit
     */
    protected function wellnessKitPage(string $slug, array $kit): void
    {
        $blocks = [
            $this->block('hero', [
                'layout' => 'home',
                'eyebrow' => $kit['eyebrow'],
                'headline' => $kit['headline'],
                'body' => $kit['body'],
                'image' => $kit['hero_image'],
                'image_alt' => $kit['title'],
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
                'secondary_label' => 'All wellness kits',
                'secondary_url' => '/wellness-kit',
            ]),
            $this->block('split', [
                'eyebrow' => $kit['highlight_eyebrow'],
                'headline' => $kit['highlight_headline'],
                'body' => $kit['highlight_body'],
                'image' => $kit['highlight_image'],
                'image_alt' => $kit['title'],
                'image_right' => true,
            ]),
            $this->block('split', [
                'headline' => 'Customisable and Portable',
                'body' => '<p>The BYP Health Wellness Kit comes complete with medical devices and an iPad, packed in a carry-on case for easy transport and setup.</p>',
                'image' => '/brand/wp/new-assets/dev-img/Customisable-Portable.jpg',
                'image_alt' => 'BYP Health wellness kit',
                'image_right' => false,
            ]),
            $this->block('gallery', [
                'headline' => 'Leading Wireless Medical Devices',
                'variant' => 'product',
                'images' => $this->imageSet('/brand/wp/new-assets/dev-img/wmd-%02d.png', 1, 7, 'Wellness medical device'),
            ]),
        ];

        foreach ($kit['extras'] ?? [] as $extra) {
            $blocks[] = $this->block('split', [
                'eyebrow' => $extra['eyebrow'] ?? null,
                'headline' => $extra['headline'],
                'body' => $extra['body'],
                'image' => $extra['image'],
                'image_alt' => $extra['headline'],
                'fit' => $extra['fit'] ?? 'cover',
                'image_right' => $extra['image_right'] ?? true,
            ]);
        }

        $blocks[] = $this->block('form', [
            'headline' => 'Plan a '.$kit['title'].' deployment',
            'intro' => 'Tell us the venue, headcount, and whether you need white-label reports. We will spec the case.',
            'type' => 'demo',
            'button_label' => 'Request a kit brief',
        ]);

        $this->upsertPage(
            $kit['title'],
            $slug,
            false,
            $blocks,
            $kit['title'].' | BYP Health',
            $kit['body'],
            'MedicalWebPage',
        );
    }

    /**
     * @param  array<int, array{0: string, 1: string}>  $items
     * @return array<string, mixed>
     */
    protected function faqBlock(string $headline, array $items): array
    {
        return $this->block('faq', [
            'headline' => $headline,
            'from_library' => false,
            'items' => array_map(fn (array $item): array => [
                'question' => $item[0],
                'answer' => '<p>'.$item[1].'</p>',
            ], $items),
        ]);
    }

    /**
     * @param  list<string>  $labels
     * @return list<array{label: string, tone: string}>
     */
    protected function devicePills(array $labels): array
    {
        $tones = ['red', 'blue', 'amber', 'pink', 'purple', 'green', 'blue', 'gray'];
        $pills = [];

        foreach ($labels as $index => $label) {
            $pills[] = [
                'label' => $label,
                'tone' => $tones[$index % count($tones)],
            ];
        }

        return $pills;
    }

    /**
     * @return array<string, string>
     */
    protected function photos(): array
    {
        return [
            'telemedicine' => '/uploads/2024/07/man-using-telemedicine-service-2024-04-08-15-09-10-utc-2048x1365.jpg',
            'team' => '/uploads/2024/07/medicine-doctor-team-2023-11-27-04-53-21-utc-2048x1365.jpg',
            'doctor' => '/uploads/2024/07/female-doctor-of-the-medical-health-system-putting-2023-11-27-04-50-53-utc-2048x1365.jpg',
            'elderly' => '/uploads/2023/05/happiness-cheerful-elderly-woman-men-talking-with-female-caregiver-nurse-doctor-having-health-checking-consult-living-areacaretakers-with-senior-couple-sitting-living-room-nursing-home-2048x1366.jpg',
            'paramedic' => '/uploads/2023/06/medium-shot-paramedic-holding-tablet-scaled.jpg',
            'ambulance' => '/uploads/2023/06/ems-paramedics-provide-medical-help-injured-patient-way-healthcare-hospital-emergency-care-assistants-putting-noninvasive-ventilation-mask-ambulance-scaled.jpg',
            'bp' => '/uploads/2024/07/woman-measuring-blood-pressure-with-an-electric-di-2023-11-27-05-34-26-utc-2048x1366.jpg',
            'ward' => '/uploads/2024/08/monitor-hospital-ward-showing-bmp-from-patient-scaled.jpg',
            'nursing' => '/uploads/2023/09/Nursing-Home-1024x576.png',
            'bed' => '/uploads/2023/07/medium-shot-sick-woman-bed-scaled.jpg',
            'laptop' => '/uploads/2023/05/close-up-man-with-laptop-2048x1365.jpg',
            'sport' => '/uploads/2023/05/retired-person-doing-sports-home-watching-online-workout-2048x1396.jpg',
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $blocks
     */
    protected function upsertPage(string $title, string $slug, bool $home, array $blocks, ?string $seoTitle = null, ?string $seoDescription = null, string $schema = 'WebPage'): void
    {
        Page::query()->updateOrCreate(['slug' => $slug], [
            'title' => $title,
            'status' => 'published',
            'is_homepage' => $home,
            'published_at' => now(),
            'blocks' => $blocks,
            'seo_title' => $seoTitle,
            'seo_description' => $seoDescription,
            'schema_type' => $schema,
            'robots' => 'index,follow',
        ]);
    }

    protected function renamePageSlug(string $from, string $to): void
    {
        if (Page::query()->where('slug', $to)->exists()) {
            Page::query()->where('slug', $from)->delete();

            return;
        }

        Page::query()->where('slug', $from)->update(['slug' => $to]);
    }

    protected function legalBody(string $filename): string
    {
        return File::get(database_path('seeders/legal/'.$filename));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function block(string $type, array $data): array
    {
        return [
            'type' => $type,
            'data' => $data,
        ];
    }
}
