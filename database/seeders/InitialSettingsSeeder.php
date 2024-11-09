<?php

namespace Database\Seeders;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use Illuminate\Database\Seeder;

class InitialSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // General Settings
        GeneralSetting::create([
            'site_name' => 'PV Bishop',
            'site_layout' => 'LTR',
            'contact_email' => 'contact@pvbi.org',
            'timezone' => 'Asia/Manila',
            'currency_name' => 'PHP',
            'currency_icon' => '₱',
            'contact_phone' => '+639193582208',
            'contact_address' => 'No. 78 Mountain Rock, Heaven\'s Gate Street, Baguio City 2600, Cordillera Administrative Region, Philippines',
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.36019131022!2d120.60093529999997!3d16.4065233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a143efaa737b%3A0x6adcb81297e4a5aa!2sUpper%20Session%20Rd%2C%20Baguio%2C%20Benguet!5e0!3m2!1sen!2sph!4v1726199937709!5m2!1sen!2sph',
        ]);

        // Logo Settings
        LogoSetting::create([
            'logo' => 'default-logo.png',
            'favicon' => 'default-favicon.png',
        ]);

        // Email Configuration
        EmailConfiguration::create([
            'email' => 'pvbi.org@gmail.com',
            'host' => 'smtp.gmail.com',
            'port' => '587',
            'username' => 'pvbi.org@gmail.com',
            'password' => 'vwgy pogs rcfl uebe',
            'encryption' => 'tls',
        ]);

        // Pusher Settings
        PusherSetting::create([
            'pusher_app_id' => '1791095',
            'pusher_key' => 'bc17b66f451cd0eab1f5',
            'pusher_secret' => '801dce42885a52b82c17',
            'pusher_cluster' => 'ap1',
        ]);
    }
}
