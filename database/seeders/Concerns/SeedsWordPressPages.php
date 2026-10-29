<?php

namespace Database\Seeders\Concerns;

trait SeedsWordPressPages
{
    protected function wp(string $path): string
    {
        return '/brand/wp/'.ltrim($path, '/');
    }

    protected function seedWordPressPages(): void
    {
        $this->seedSolutionsPage();
        $this->seedHospitalAtHomePage();
        $this->seedCellularPage();
        $this->seedResidentTrackingPage();
        $this->seedEmergencyPage();
        $this->seedWellnessPages();
        $this->seedChronicCarePage();
        $this->seedRpmPlatformPage();
        $this->seedAboutPage();
        $this->seedContactPage();
    }

    protected function seedSolutionsPage(): void
    {
        $icon = fn (string $file): string => $this->wp('uploads/2021/10/'.$file);

        $this->upsertPage('Solutions', 'solutions', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'White-Label Platform for Remote Patient Monitoring',
                'body' => 'A tech solution for healthcare providers in their own brand, so they can capture vitals of their patients and provide counselling remotely.',
                'show_form' => false,
                'cta_label' => 'Get in touch',
                'cta_url' => '/contact-us',
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '3',
                'headline' => 'The Right Solution',
                'intro' => 'RPM platform that comes with a mobile app, web portal, wireless medical devices, and integrations with EHR/EMR.',
                'items' => [
                    ['image' => $icon('bluetooth.png'), 'title' => 'Bluetooth Devices'],
                    ['image' => $icon('smartphone-1.png'), 'title' => 'Mobile App'],
                    ['image' => $icon('device-2-1.png'), 'title' => 'Cellular Devices'],
                    ['image' => $icon('website-1.png'), 'title' => 'Web Portal'],
                    ['image' => $icon('medical-record.png'), 'title' => 'EHR/EMR Integration'],
                    ['image' => $icon('bill-1.png'), 'title' => 'Billing Integration'],
                ],
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '2',
                'headline' => 'How We Do It',
                'intro' => 'Remote Patient Monitoring made easy and convenient, for both physicians and patients.',
                'items' => [
                    ['image' => $this->wp('uploads/2023/03/Web-Portal-e1678297683714.jpg'), 'title' => 'Mobile App & Web Portal', 'body' => 'We build white-label, HIPAA-compliant RPM platforms for clinics and hospitals that include a mobile app for their patients and a web portal for themselves. Using the platform, patients can check their vitals regularly, and physicians and nurses can monitor the vitals and get alerts in real time.'],
                    ['image' => $this->wp('uploads/2021/09/blood-glucose-app.jpg'), 'title' => 'Bluetooth Devices', 'body' => 'We provide bluetooth devices such as glucometer, blood pressure meter, pulse oximeter and weighing scale. These bluetooth devices sync seamlessly to the white-label mobile app of the client. The measurements are transferred to client\'s cloud and EMR in real time.'],
                    ['image' => $this->wp('uploads/2021/10/20200701114250963.jpg'), 'title' => 'Cellular Devices', 'body' => 'We provide cellular devices such as glucometer, blood pressure meter, pulse oximeter and weighing scale. The devices have 4G sim card inside which send the readings in real time to client\'s cloud and EMR in real time. There is no need for a phone or tablet when using cellular devices.'],
                    ['image' => $this->wp('uploads/2021/10/Picture3.png'), 'title' => 'EMR & Billing Integration', 'body' => 'The RPM platform will be integrated to most of the popular EHR and Billing systems including Meditech, Cerner, AthenaHealth, eClinicalWorks, Kareo and Epic. Clients also have 24x7 access to our Billing Experts to help them submit their claims easily and on time.'],
                    ['image' => $this->wp('uploads/2021/10/Untitled.png'), 'title' => 'Chat & Call', 'body' => 'Physicians and nurses will be able to chat and call patients from the web portal and from some of the EHR systems directly. Chats and calls can be recorded and stored for as long as they are needed for audit purpose.'],
                    ['image' => $this->wp('uploads/2021/10/Untitled2.png'), 'title' => 'SMS Alerts', 'body' => 'Physicians and nurses get SMS alerts when patients do not check their vitals on time or when a reading is out of range. The Alerts will direct them to the web portal or to selected EHR systems directly, from where they can chat or call the patient or escalate them.'],
                ],
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '2',
                'tone' => 'white',
                'headline' => 'Explore Our Solutions',
                'items' => [
                    ['image' => '/brand/byp/solutions/hospital-at-home.jpg', 'title' => 'Hospital at Home Solution', 'body' => 'Enable healthcare providers to extend their care to patients\' homes, providing seamless monitoring and continuous health management.', 'url' => '/hospital-at-home'],
                    ['image' => '/brand/byp/solutions/cellular.jpg', 'title' => 'Cellular Remote Patient Monitoring', 'body' => 'Ensure patients stay connected and monitored in real-time, regardless of their location, with our robust cellular-based solutions.', 'url' => '/cellular-platform'],
                    ['image' => '/brand/byp/solutions/resident-tracking.jpg', 'title' => 'Resident Tracking Solution', 'body' => 'Improve resident safety and oversight in assisted living environments with our advanced tracking and health monitoring technology.', 'url' => '/facility-care'],
                    ['image' => '/brand/byp/solutions/emergency.jpg', 'title' => 'Emergency Response Kit', 'body' => 'Equip first responders with essential tools for swift and informed decision-making in emergency situations.', 'url' => '/emergency-care'],
                    ['image' => $this->wp('new-assets/dev-img/wk-01.jpg'), 'title' => 'Wellness Kit', 'body' => 'Instant health check-up in your site with a portable kit of medical devices and an iPad.', 'url' => '/wellness-kit'],
                ],
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
                'show_details' => false,
            ]),
        ], 'Solutions | BYP Health', 'White-label remote patient monitoring platform with mobile app, web portal, wireless medical devices, and EHR/EMR integrations.');
    }

    protected function seedHospitalAtHomePage(): void
    {
        $img = fn (string $file): string => $this->wp('new-assets/images/'.$file);
        $dev = fn (string $file): string => $this->wp('new-assets/dev-img/'.$file);

        $this->upsertPage('Hospital At Home', 'hospital-at-home', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Hospital Care in the Comfort of Your Home',
                'subhead' => 'Remote Care Kit and Digital Healthcare Platform',
                'body' => 'Extend hospital-grade care into the home with real-time devices, alerts and digital tools that simplify post-discharge care.',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('gallery', [
                'variant' => 'scene',
                'images' => $this->imageSet($this->wp('new-assets/images/solution-%d.png'), 1, 6, 'Hospital at Home kit'),
            ]),
            $this->block('video', [
                'src' => $img('Hospital-Care-in-the.mp4'),
                'poster' => $img('solution-1.png'),
                'autoplay' => true,
            ]),
            $this->block('split', [
                'headline' => 'Keep your Patients in connection',
                'body' => '<p>Our solution keeps patients seamlessly connected with continuous, real-time data transmission.</p><p>The iPad remains always on and permanently charging, so no readings are ever lost. There\'s no need for manual uploads; supporting timely interventions and better health management. Built-in video call and chat features also enable direct communication, making remote care more personal, responsive, and effective.</p>',
                'image' => $img('patient.png'),
                'image_alt' => 'Patient connected through Hospital at Home',
                'image_right' => true,
            ]),
            $this->block('devices', [
                'headline' => 'Leading Wireless Medical Devices',
                'intro' => 'Comprehensive Home Care Services All in One Place',
                'from_library' => false,
                'show_pills' => false,
                'variant' => 'photo',
                'items' => [
                    ['name' => 'Blood Pressure', 'image' => $img('pa-img-2.png')],
                    ['name' => 'Thermometer', 'image' => $img('pa-img-3.png')],
                    ['name' => 'Pulse Oximeter', 'image' => $img('pa-img-4.png')],
                    ['name' => 'Glucometer', 'image' => $img('pa-img-5.png')],
                    ['name' => 'ECG', 'image' => $img('pa-img-6.png')],
                    ['name' => 'Weight Scale', 'image' => $img('pa-img-7.png')],
                    ['name' => 'Spirometer', 'image' => $img('pa-img-8.png')],
                ],
            ]),
            $this->block('rich_text', [
                'headline' => 'Designed to support diverse clinical needs',
                'body' => '<p>We collaborate with trusted manufacturers to provide access to advanced wireless medical devices that support accurate monitoring of vital signs across different care settings. Designed to integrate into a unified care model, these devices enable hospital-at-home programs to operate consistently and safely. Built for home-based use and deployed directly by healthcare organizations, the system allows providers to deliver reliable monitoring without relying on fragmented tools.</p><p>Full Customisation, Total Flexibility. Our integrated monitoring solutions extend beyond general care. Our platform empowers different hospital divisions to deliver safer, more connected, and more efficient care.</p>',
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '3',
                'headline' => 'Hospital divisions',
                'items' => [
                    ['image' => $dev('Cardiology-Department.jpg'), 'title' => 'Cardiology Department'],
                    ['image' => $dev('Pulmonology-Department.jpg'), 'title' => 'Pulmonology Department'],
                    ['image' => $dev('Maternity-Department.jpg'), 'title' => 'Maternity Department'],
                    ['image' => $dev('Rehabilitation-Department.jpg'), 'title' => 'Rehabilitation Department'],
                    ['image' => $dev('Gastroenterology-Department.jpg'), 'title' => 'Gastroenterology Department'],
                    ['image' => $dev('Nephrology-Department.jpg'), 'title' => 'Nephrology Department'],
                    ['image' => $dev('Neurology-Department.jpg'), 'title' => 'Neurology Department'],
                    ['image' => $dev('Oncology-Department.jpg'), 'title' => 'Oncology Department'],
                    ['image' => $dev('Primary-Care-Department.jpg'), 'title' => 'Primary Care Department'],
                    ['image' => $dev('Geriatrics-Department.jpg'), 'title' => 'Geriatrics Department'],
                    ['image' => $dev('Endocrinology-Department.jpg'), 'title' => 'Endocrinology Department'],
                    ['image' => $dev('Post-Surgery-Department.jpg'), 'title' => 'Post Surgery Department'],
                ],
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '3',
                'items' => [
                    ['title' => 'Post-Discharge Continuity', 'body' => 'Extend care beyond hospital walls. Maintain consistent patient records and ongoing monitoring as patients recover at home.', 'image' => $img('screen-content.png')],
                    ['title' => 'EHR/EMR Integration Streamlined Operations', 'body' => 'Sync all collected data with hospital records to ensure a complete, up-to-date clinical view across care settings.', 'image' => $img('h-9.png')],
                    ['title' => 'Seamless Patient Management and Communication', 'body' => 'Register new Patients, set up profiles, generate reports, communicate, and configure their monitoring devices effortlessly.', 'image' => $img('Seamless-Patient-Management-and-Communication.jpeg')],
                ],
            ]),
            $this->block('gallery', [
                'variant' => 'product',
                'headline' => 'Clinician portal',
                'images' => $this->imageSet($this->wp('new-assets/images/h-%d.png'), 1, 12, 'Hospital at Home portal'),
            ]),
            $this->block('video', [
                'src' => $img('Hospital-at-Home.mp4'),
                'poster' => $img('solution-2.png'),
                'autoplay' => true,
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Hospital At Home - BYP Health', 'Hospital Care in the Comfort of Your Home. Remote Care Kit and Digital Healthcare Platform for post-discharge care.', 'MedicalWebPage');
    }

    protected function seedCellularPage(): void
    {
        $img = fn (string $file): string => $this->wp('new-assets/images/'.$file);

        $this->upsertPage('Cellular Platform', 'cellular-platform', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Cellular Platform at Home',
                'body' => "No-app, customized remote patient monitoring designed for organizations deploying medical kiosks across care settings.\n\nConnect with patients through cellular medical devices that support comprehensive health kiosks workflows with real-time vital monitoring.",
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('gallery', [
                'images' => $this->imageSet($this->wp('new-assets/images/cell-%d.png'), 1, 6, 'Cellular RPM kit'),
            ]),
            $this->block('video', [
                'src' => $img('Cellular-Platform-at-Home.mp4'),
                'poster' => $img('cell-1.png'),
                'autoplay' => true,
            ]),
            $this->block('gallery', [
                'headline' => 'Wearable Cellular Wireless Medical Devices',
                'variant' => 'product',
                'intro' => 'Capture a full spectrum of patient vitals without a gateway, best supporting use cases such as nursing home monitors and long-term care oversight. We provide essential tools for monitoring multiple chronic conditions through integrated medical tracking solutions, enabling complete and connected care without requiring additional applications. In collaboration with trusted manufacturers, we deliver reliable wearable wireless medical technology for institutional use.',
                'images' => $this->imageSet($this->wp('new-assets/images/m-%d.png'), 1, 8, 'Cellular medical device'),
            ]),
            $this->block('split', [
                'headline' => 'No-App Solution',
                'body' => '<p>Ensure compliance by sending data directly from patient’s medical device to you, without installing any apps.</p>',
                'image' => $img('4g.png'),
                'image_alt' => 'Cellular 4G device connectivity',
                'fit' => 'contain',
                'image_right' => true,
            ]),
            $this->block('split', [
                'headline' => 'Tailored Reports & Integration',
                'body' => '<p>Automated data submission streamlines billing processes and delivers comprehensive, customizable reports for better decision-making.</p>',
                'image' => $img('tailered-r-int.png'),
                'image_alt' => 'Tailored RPM reports',
                'fit' => 'contain',
            ]),
            $this->block('split', [
                'headline' => 'SMS/Call Communication',
                'body' => '<p>Stay connected by ensuring timely communication and improved patient engagement.</p>',
                'image' => $img('communication.png'),
                'image_alt' => 'Patient communication workflow',
                'fit' => 'contain',
                'image_right' => true,
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Cellular Platform - BYP Health', 'No-app, customized remote patient monitoring designed for organizations deploying medical kiosks across care settings.', 'MedicalWebPage');
    }

    protected function seedResidentTrackingPage(): void
    {
        $this->renamePageSlug('solution-in-clinic', 'facility-care');

        $this->upsertPage('Resident Tracking Solution', 'facility-care', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Comprehensive Solution to Track Residents in Residential Facilities',
                'body' => 'Enhancing Care in Nursing Homes, Old Age Homes and Behavioral Health Centers',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('video', [
                'src' => $this->wp('uploads/2024/07/Health-monitoring-platform-for-residential.mp4'),
                'poster' => $this->wp('uploads/2024/06/residential.jpg'),
                'autoplay' => true,
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '3',
                'items' => [
                    ['image' => $this->wp('uploads/2024/06/blood-pressure-glyph-circle-icon-vector-e1718299781234.jpg'), 'title' => 'Variety of Medical Devices', 'body' => 'Wearable Devices for Continuous Health Monitoring of Residents'],
                    ['image' => $this->wp('uploads/2024/06/images-3-e1718535399177.png'), 'title' => 'Industrial Grade Bluetooth Hub', 'body' => 'Reliable Facility-wide Connectivity for Seamless Data Transmission'],
                    ['image' => $this->wp('uploads/2024/06/visual-communication-flat-circle-icon-vector-e1718535390135.jpg'), 'title' => 'Multi-Platform Access', 'body' => 'View Multiple Health Graphs via Webpage, iPad App, and Android TV App'],
                    ['image' => $this->wp('uploads/2024/06/images-4-e1718535379546.png'), 'title' => 'Proactive Alerts System', 'body' => 'Receive Alerts for Abnormal Readings and Unauthorized Exits'],
                    ['image' => $this->wp('uploads/2024/06/7237507-e1718523360998.png'), 'title' => 'Web Portal for Clinical Staff', 'body' => 'Onboard Residents and Create Customized Alert Protocols'],
                    ['image' => $this->wp('uploads/2024/06/2397655-e1718525497768.png'), 'title' => 'Tailored Reports and Integration', 'body' => 'Automated Data Submission for Billing and Comprehensive Reporting'],
                ],
            ]),
            $this->block('split', [
                'headline' => 'Widest Range of Medical Devices Connected to Bluetooth Hub',
                'body' => '<p>Choose Wearables Based on Patient Conditions, All Connected to Bluetooth Hubs.</p><p>We collaborate with all major brands and manufacturers of wireless medical devices to ensure that you have access to the best technology available. Our range of continuous medical wearables includes Oximeters, Heart Rate Monitors, Respiration Rate Monitors, ECG machines, Blood Pressure Monitors, Glucose Monitors, and Thermometers patches. Our commitment to quality means we offer devices that are reliable, accurate, and easy to use.</p><p>These devices, worn by residents, wirelessly transmit vital health data to the industrial-grade Bluetooth hub installed within the facility. The hub ensures reliable and seamless data collection, providing real-time health metrics to caregivers and clinical staff.</p>',
                'image' => $this->wp('uploads/2024/06/residential.jpg'),
                'image_alt' => 'Resident tracking in a residential facility',
                'image_right' => true,
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '2',
                'headline' => 'Real-Time Data Access Across Multiple Platforms',
                'intro' => 'Monitor Vitals via Webpage, iPad App, and Android TV App',
                'items' => [
                    ['image' => $this->wp('uploads/2024/06/SS01.jpg'), 'title' => 'Comprehensive Multi-Patient View', 'body' => 'View Hundreds of Patient Graphs on a Single Page, Whether Accessed Through the Webpage or Android TV App, Providing Consolidated and Efficient Way to Monitor Numerous Residents Simultaneously'],
                    ['image' => $this->wp('uploads/2024/06/SS02.jpg'), 'title' => 'Real-Time Alerts for Immediate Attention', 'body' => 'Real-time Alerts Displayed Prominently on Top Together with Audio Alarms when Readings are Abnormal, Wearables are Removed, or Residents Leave the Facility, Ensuring Staff can Identify and Attend to Residents who Require Immediate Attention'],
                    ['image' => $this->wp('uploads/2024/07/nSS03.jpg'), 'title' => 'Multi-Functional iPad Integration', 'body' => 'Capture Residents\' Vital Signs Accurately at Entrance, Send Readings to Existing Systems, Streamline Check-in and Check-out Process for Residents at the Entrance, and Automate Reminders and Nudges to Staff to Perform their Daily Rounds'],
                ],
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Resident Tracking Solution - BYP Health', 'Comprehensive solution to track residents in nursing homes, old age homes and behavioral health centers.', 'MedicalWebPage');
    }

    protected function seedEmergencyPage(): void
    {
        $this->renamePageSlug('emergency-kit', 'emergency-care');
        $img = fn (string $file): string => $this->wp('new-assets/images/'.$file);
        $dev = fn (string $file): string => $this->wp('new-assets/dev-img/'.$file);

        $this->upsertPage('Emergency Response Kit', 'emergency-care', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Emergency kit',
                'subhead' => 'Faster, Smarter Emergency Response',
                'body' => 'Empower field responders with instant diagnostics, expert video support, and seamless data flow—no matter where the emergency happens.',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('gallery', [
                'images' => $this->imageSet($this->wp('new-assets/images/ee-%d.png'), 1, 6, 'Emergency response kit'),
            ]),
            $this->block('video', [
                'src' => $img('Emergency-Response-Kit.mp4'),
                'poster' => $img('ee-1.png'),
                'autoplay' => true,
            ]),
            $this->block('devices', [
                'headline' => 'Widest Array of Medical Devices',
                'intro' => 'High customisation to suit any case. We partner with leading brands and manufacturers of wireless medical devices to bring you the most advanced and reliable technology available. All devices are chosen for their accuracy, ease of use, and durability—ensuring healthcare professionals are equipped to respond swiftly and effectively in any emergency.',
                'from_library' => false,
                'show_pills' => false,
                'items' => [
                    ['name' => 'Ultrasound', 'image' => $img('e-1.png')],
                    ['name' => 'ECG', 'image' => $img('e-2.png')],
                    ['name' => 'Otoscope', 'image' => $img('e-3.png')],
                    ['name' => 'Dermatoscope', 'image' => $img('e-4.png')],
                    ['name' => 'Blood Pressure', 'image' => $img('e-5.png')],
                    ['name' => 'Oximeter', 'image' => $img('e-6.png')],
                    ['name' => 'Thermometer', 'image' => $img('e-7.png')],
                ],
            ]),
            $this->block('split', [
                'headline' => 'AR Glasses Integration',
                'body' => '<p>Re-imagine first aid communication. Stream live video from First Responders to the Control Room.</p>',
                'image' => $img('AR.png'),
                'image_alt' => 'AR glasses for emergency response',
                'fit' => 'contain',
                'image_right' => true,
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '3',
                'headline' => 'Supporting Every Terrain, Every Case',
                'intro' => 'Rapid Deployment. Mission-Ready Emergency Kits. Emergency response kits are designed for fast deployment across diverse terrains and high-risk environments. Each kit is modular, customisable, and built to support critical care delivery when time, connectivity, and resources are limited.',
                'items' => [
                    ['image' => $dev('Maritime.jpg'), 'title' => 'Maritime'],
                    ['image' => $dev('Aviation.jpg'), 'title' => 'Aviation'],
                    ['image' => $dev('Oil-Rig.jpg'), 'title' => 'Oil-Rig'],
                    ['image' => $dev('Mining.jpg'), 'title' => 'Mining'],
                    ['image' => $dev('Renewable.jpg'), 'title' => 'Renewable'],
                    ['image' => $dev('Off-shore.jpg'), 'title' => 'Off-shore'],
                    ['image' => $dev('Yacht-04.jpg'), 'title' => 'Yacht'],
                    ['image' => $dev('School.jpg'), 'title' => 'School'],
                    ['image' => $dev('Military.jpg'), 'title' => 'Military'],
                ],
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '2',
                'headline' => 'Always Connected',
                'intro' => 'Ensuring Preparedness for Any Emergency Situation',
                'items' => [
                    ['image' => $img('connected.png'), 'title' => 'Always on iPad', 'body' => 'The iPad, always on and permanently charging, ensures data is instantly transmitted to the Control Room'],
                    ['image' => $img('control-room.png'), 'title' => 'Dashboard for Control Room', 'body' => 'Complete overview of all ongoing and recent emergency situations. Monitor effectively with a centralised Support Platform'],
                    ['image' => $img('real-time-monitoring.png'), 'title' => 'Real-time Monitoring and Communication Hub', 'body' => 'Live video calls and real-time data sharing allow remote medical teams to guide every step of the emergency care process.'],
                    ['image' => $img('comprehensive-db.png'), 'title' => 'Comprehensive Archive of Database', 'body' => 'Detailed archive including any notes added, video recordings, and captured readings'],
                ],
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Emergency Kit - BYP Health', 'Faster, smarter emergency response. Empower field responders with instant diagnostics, expert video support, and seamless data flow.', 'MedicalWebPage');
    }

    protected function seedWellnessPages(): void
    {
        $dev = fn (string $file): string => $this->wp('new-assets/dev-img/'.$file);

        $this->upsertPage('Wellness Kit', 'wellness-kit', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Wellness Kit',
                'subhead' => 'Instant Health Check Up in Your Site',
                'body' => 'Redefining wellness through intelligent kit that make health monitoring convenient, transparent, and measurable — for employees and employers alike',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('gallery', [
                'images' => $this->imageSet($this->wp('new-assets/dev-img/wk-%02d.jpg'), 1, 6, 'Wellness kit in use'),
            ]),
            $this->block('video', [
                'src' => $this->wp('new-assets/images/wellness-kit.mp4'),
                'poster' => $dev('wk-01.jpg'),
                'autoplay' => true,
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '3',
                'headline' => 'Customisable and Portable',
                'items' => [
                    ['image' => $dev('vp-01.jpg'), 'title' => 'Corporate', 'url' => '/corporate-wellness-kit'],
                    ['image' => $dev('vp-02.jpg'), 'title' => 'Gym', 'url' => '/gym-wellness-kit'],
                    ['image' => $dev('vp-03.jpg'), 'title' => 'Residential Building', 'url' => '/residential-building-kit'],
                    ['image' => $dev('vp-04.jpg'), 'title' => 'Yacht', 'url' => '/yachi-kit'],
                    ['image' => $dev('vp-05.jpg'), 'title' => 'Old Age Center', 'url' => '/old-age-center-kit'],
                    ['image' => $dev('vp-06.jpg'), 'title' => 'School', 'url' => '/school-kit'],
                ],
            ]),
            $this->block('split', [
                'headline' => 'Customisable and Portable',
                'body' => '<p>Comes complete with all medical devices and an iPad — Neatly packed in a carry-on case for easy transport and setup.</p>',
                'image' => $dev('Customisable-Portable.jpg'),
                'image_alt' => 'Portable wellness kit',
                'image_right' => true,
            ]),
            $this->block('gallery', [
                'headline' => 'Leading Wireless Medical Devices All in One Place',
                'variant' => 'product',
                'intro' => 'We collaborate with top brands and trusted manufacturers to give you access to the most advanced wireless medical technology on the market. Designed for modern healthcare, our devices are reliable, precise, and simple to use—so you can focus on what matters most: delivering quality care.',
                'images' => $this->imageSet($this->wp('new-assets/dev-img/wmd-%02d.png'), 1, 7, 'Wellness medical device'),
            ]),
            $this->block('cards', [
                'variant' => 'photo',
                'columns' => '3',
                'items' => [
                    ['image' => $dev('Dashboard-Reporting-Portal.png'), 'title' => 'Dashboard & Reporting Portal', 'body' => 'Centralised dashboard providing access to aggregated employee health data and reports.'],
                    ['image' => $dev('Mobile-Application-Integration.png'), 'title' => 'Mobile Application Integration', 'body' => 'Track your health stats, view progress, and stay informed about your well-being anytime.'],
                    ['image' => $dev('Full-Customisation.png'), 'title' => 'Full Customisation', 'body' => 'Add any programs, packages, or extras you’d like to promote within the tablet or the mobile-app.'],
                ],
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Wellness Kit | BYP Health', 'Instant health check-up in your site. A portable kit of medical devices and an iPad for workplaces, gyms, schools, and more.');

        $this->wellnessKitPage('corporate-wellness-kit', [
            'title' => 'Corporate Wellness Kit',
            'eyebrow' => 'Workplace health',
            'headline' => 'Corporate Wellness Kit',
            'body' => 'Instant health check-up in the office. A portable kit with medical devices and an iPad, neatly packed in a carry-on case.',
            'hero_image' => $dev('vp-01.jpg'),
            'highlight_eyebrow' => 'Customisable and Portable',
            'highlight_headline' => 'On-site employee health checks',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('school-kit', [
            'title' => 'School Kit',
            'eyebrow' => 'Campus health',
            'headline' => 'School Kit',
            'body' => 'Simple on-site health checks for students, packed in a portable wellness kit.',
            'hero_image' => $dev('vp-06.jpg'),
            'highlight_eyebrow' => 'Campus',
            'highlight_headline' => 'Health monitoring at school',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('gym-wellness-kit', [
            'title' => 'Gym Wellness Kit',
            'eyebrow' => 'Fitness',
            'headline' => 'Gym Wellness Kit',
            'body' => 'On-site vital checks for members, before and after training.',
            'hero_image' => $dev('vp-02.jpg'),
            'highlight_eyebrow' => 'Gym',
            'highlight_headline' => 'Health checks on the gym floor',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('hotal-and-resort-kit', [
            'title' => 'Hotel And Resort Kit',
            'eyebrow' => 'Hospitality',
            'headline' => 'Hotel And Resort Kit',
            'body' => 'A portable wellness station for guests in a lounge or spa room.',
            'hero_image' => $dev('wk-05.jpg'),
            'highlight_eyebrow' => 'Hospitality',
            'highlight_headline' => 'Guest wellness on site',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('old-age-center-kit', [
            'title' => 'Old Age Center Kit',
            'eyebrow' => 'Senior living',
            'headline' => 'Old Age Center Kit',
            'body' => 'A lounge-ready kit for residents to check vitals with a simple tablet interface.',
            'hero_image' => $dev('vp-05.jpg'),
            'highlight_eyebrow' => 'Ageing centre',
            'highlight_headline' => 'Simple checks for residents',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('residential-building-kit', [
            'title' => 'Residential Building Kit',
            'eyebrow' => 'Property amenity',
            'headline' => 'Residential Building Kit',
            'body' => 'A 24/7 health amenity for residents, packed in a portable case.',
            'hero_image' => $dev('vp-03.jpg'),
            'highlight_eyebrow' => 'Residential',
            'highlight_headline' => 'Wellness at the doorstep',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
        $this->wellnessKitPage('yachi-kit', [
            'title' => 'Yachi Kit',
            'eyebrow' => 'Onboard care',
            'headline' => 'Yacht Kit',
            'body' => 'Clinical-grade feedback onboard with a compact wellness station.',
            'hero_image' => $dev('vp-04.jpg'),
            'highlight_eyebrow' => 'Yacht',
            'highlight_headline' => 'Health checks on the water',
            'highlight_body' => '<p>Comes complete with all medical devices and an iPad — neatly packed in a carry-on case for easy transport and setup.</p>',
            'highlight_image' => $dev('Customisable-Portable.jpg'),
        ]);
    }

    protected function seedChronicCarePage(): void
    {
        $this->upsertPage('Chronic Care', 'chronic-care', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Bluetooth Medical Devices for Chronic Care Management',
                'body' => 'Bluetooth medical device remote patient monitoring is cost-effective in terms of both device cost and data transmission charges. Patients use connected devices at home, and readings sync to a white-label mobile app and clinician portal.',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('split', [
                'headline' => 'Bluetooth Devices',
                'body' => '<p>We provide bluetooth devices such as glucometer, blood pressure meter, pulse oximeter and weighing scale. These bluetooth devices sync seamlessly to the white-label mobile app of the client. The measurements are transferred to client\'s cloud and EMR in real time.</p>',
                'image' => $this->wp('uploads/2021/09/blood-glucose-app.jpg'),
                'image_alt' => 'Bluetooth glucose monitoring app',
                'image_right' => true,
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'Chronic Care | BYP Health', 'Bluetooth medical device remote patient monitoring for ongoing chronic care between visits.');
    }

    protected function seedRpmPlatformPage(): void
    {
        $this->upsertPage('RPM Platform', 'rpm-platform', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'White-Label Platform for Remote Patient Monitoring',
                'body' => 'A tech solution for healthcare providers in their own brand, so they can capture vitals of their patients and provide counselling remotely.',
                'show_form' => false,
                'cta_label' => 'Get in touch',
                'cta_url' => '/contact-us',
            ]),
            $this->block('gallery', [
                'headline' => 'Clinician and EHR screens',
                'variant' => 'product',
                'images' => $this->imageSet($this->wp('new-assets/images/h-%d.png'), 1, 12, 'Platform screen'),
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'RPM platform | BYP Health', 'White-label remote patient monitoring: mobile app, web portal, wireless medical devices, and EHR/EMR integrations.');
    }

    protected function seedAboutPage(): void
    {
        $this->upsertPage('About Us', 'about-us', false, [
            $this->block('hero', [
                'layout' => 'home',
                'headline' => 'Bringing Healthcare Closer To You',
                'body' => 'BYP Health, headquartered in Singapore with a global presence, specializes in delivering customized, plug and play remote patient monitoring solutions. With a focus on clinics, hospitals, and nursing homes across North America and Asia Pacific, we strive to connect healthcare providers, patients, insurers and employers.',
                'show_form' => false,
                'cta_label' => 'Request Demo',
                'cta_url' => '/contact-us',
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'headline' => 'What We Do',
                'intro' => 'We provide proprietary, end-to-end, white-label, customizable Remote Patient Monitoring Platform to healthcare providers across the world so they can engage with patients remotely.',
                'items' => [
                    ['title' => 'White Label', 'body' => 'The platforms are always white-label, in the brand of our clients. Whether it is Mobile App, Web Portal, Payment gateway or SMS gateway, the owner is always the healthcare provider.'],
                    ['title' => 'Integration with Medical Devices', 'body' => 'The platforms integrate with a wide variety of Cellular, Bluetooth and Wi-Fi devices to capture more than 45 vital signs, ensuring comprehensive health monitoring.'],
                    ['title' => 'Population Screening', 'body' => 'The platforms can have population screening tools such as kiosks, pods and kits for healthcare providers to offer option of community testing to corporate clients.'],
                    ['title' => 'Data Analytics', 'body' => 'The platforms do analytics on medical data collected to provide accurate insights on patients\' health to their providers, and for predictive analytics, diet recommendations and more.'],
                    ['title' => 'Teleconsultation', 'body' => 'The platforms enable physicians and nurses to assist and follow up with patients, to better manage and stabilize their chronic healthcare conditions.'],
                    ['title' => 'Integration with EHR/EMR', 'body' => 'We seamlessly integrate with major EHR/EMR systems, enabling real-time data synchronization and enhancing clinical workflows for improved patient care and management.'],
                ],
            ]),
            $this->block('rich_text', [
                'headline' => 'Statistics',
                'body' => '<p>BYP Health has been part of multiple acceleration programs and won numerous awards:</p><ul><li>Aichi Smart Sustainable City Co-Creation Program</li><li>Singapore Biodesign BOLT Initiative</li><li>Leave a Nest Japan Program</li><li>Google for Startups South East Asia</li><li>Impact Collective Program</li><li>Philips APAC Acceleration Program</li><li>HIMSS APAC Digital Innovation Winner</li></ul>',
                'align' => 'left',
            ]),
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
            ]),
        ], 'About Us | BYP Health', 'BYP Health specializes in customized, plug and play remote patient monitoring for clinics, hospitals, and nursing homes.', 'AboutPage');
    }

    protected function seedContactPage(): void
    {
        $this->upsertPage('Contact Us', 'contact-us', false, [
            $this->block('contact', [
                'headline' => 'Contact Us',
                'intro' => "Have questions or interested in our solutions?\nWe'd love to hear from you!",
                'show_form' => true,
                'show_details' => false,
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '3',
                'items' => [
                    ['title' => 'Email', 'body' => 'sales@byphealthtek.com. All emails will be replied to in working days.'],
                    ['title' => 'Phone', 'body' => '+971 55 735 6736. We are open from Monday to Friday, 10 am to 6 pm.'],
                    ['title' => 'WhatsApp Us', 'body' => 'Clients are strongly encouraged to drop us a WhatsApp for swifter reply.'],
                ],
            ]),
            $this->block('cards', [
                'variant' => 'feature',
                'columns' => '3',
                'headline' => 'Offices',
                'items' => [
                    ['image' => $this->wp('assets/img/liberty.png'), 'title' => 'USA', 'body' => '651 N Broad St, Suite 201, Middletown, Delaware 19709. +1 (512) 717-6408'],
                    ['image' => $this->wp('assets/img/merlion.png'), 'title' => 'Singapore', 'body' => '246 Macpherson Road, #03-01 Betime Building, Singapore 348578. +65 8836 0984'],
                    ['image' => $this->wp('assets/img/map.png'), 'title' => 'United Arab Emirates', 'body' => '+971 55 735 6736'],
                ],
            ]),
        ], 'Contact Us | BYP Health', 'Have questions or interested in our solutions? Contact BYP Health.');
    }
}
