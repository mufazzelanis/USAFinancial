<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'general' => [
                'company_name' => 'FirstServe Accounting',
                'company_badge' => 'UK CA FIRM',
                'phone' => '+44 20 1234 5678',
                'email' => 'info@firstserveaccounting.co.uk',
                'website' => 'www.firstserveaccounting.co.uk',
                'address' => '128 City Road, London, EC1V 2NX, United Kingdom',
            ],
            'hero' => [
                'hero_line_1' => 'Smart Accounting.',
                'hero_line_2' => 'Stronger Business.',
                'hero_line_3' => 'Global Expertise.',
                'hero_subtitle' => 'Reliable accounting, bookkeeping and payroll solutions to help your business grow with accuracy, compliance and confidence.',
            ],
            'package' => [
                'dedicated_hours' => '160',
                'dedicated_currency' => 'GBP',
            ],
            'footer' => [
                'footer_cta_title' => "Let's Work Together!",
                'footer_cta_subtitle' => 'Get a dedicated expert, save time & reduce cost.',
                'footer_tagline' => 'UK Chartered Accounting Firm',
                'footer_copyright' => '',
                'social_facebook' => '',
                'social_twitter' => '',
                'social_linkedin' => '',
                'social_instagram' => '',
            ],
            'whatsapp' => [
                'whatsapp_enabled' => '1',
                'whatsapp_country' => 'GB',
                'whatsapp_number' => '2012345678',
                'whatsapp_message' => "Hi FirstServe Accounting, I'd like to know more about your services.",
            ],
            'branding' => [
                'site_logo' => '',
                'site_favicon' => '',
            ],
            'tracking' => [
                'fb_pixel_enabled' => '0',
                'fb_pixel_id' => '',
                'ga_enabled' => '0',
                'ga_measurement_id' => '',
            ],
        ];

        foreach ($settings as $group => $items) {
            foreach ($items as $key => $value) {
                SiteSetting::updateOrCreate(['key' => $key], ['group' => $group, 'value' => $value]);
            }
        }
    }
}
