<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'site_name' => 'Curl AFhair',
            'site_email' => 'info@curlafhair.com',
            'contact_number' => '+1234567890',
            'logo_path' => 'logos/logo.png',
            'favicon_path' => 'logos/favicon.ico',
            'about_us' => 'Curl AFhair, you go to store.',
            'footer_text' => 'Contact us now.',
        ]);
    }
}
