<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use DB;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if we're running in console (artisan command)
        if ($this->app->runningInConsole()) {
            return;
        }

        Paginator::useBootstrap();

        // Default Settings
        $general_setting = (object)[
            'site_name' => 'PVBI Shop',
            'site_layout' => 'LTR',
            'contact_email' => 'contact@pvbi.org',
            'timezone' => 'Asia/Manila',
            'currency_name' => 'PHP',
            'currency_icon' => '₱',
            'contact_phone' => '+639193582208',
            'contact_address' => 'No. 78 Mountain Rock, Heaven\'s Gate Street, Baguio City 2600, Cordillera Administrative Region, Philippines',
            'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.36019131022!2d120.60093529999997!3d16.4065233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a143efaa737b%3A0x6adcb81297e4a5aa!2sUpper%20Session%20Rd%2C%20Baguio%2C%20Benguet!5e0!3m2!1sen!2sph!4v1726199937709!5m2!1sen!2sph',
        ];

        $logo_setting = (object)[
            'logo' => 'default-logo.png',
            'favicon' => 'default-favicon.png',
        ];

        $mailSetting = (object)[
            'email' => 'pvbi.org@gmail.com',
            'host' => 'smtp.gmail.com',
            'port' => '587',
            'username' => 'pvbi.org@gmail.com',
            'password' => 'vwgy pogs rcfl uebe',
            'encryption' => 'tls',
        ];

        $pusherSetting = (object)[
            'pusher_app_id' => '1791095',
            'pusher_key' => 'bc17b66f451cd0eab1f5',
            'pusher_secret' => '801dce42885a52b82c17',
            'pusher_cluster' => 'ap1',
        ];

        $useDefaults = true;

        try {
            // First check if we can connect to the database
            DB::connection()->getPdo();

            // Then check if tables exist and get settings from database
            if ($this->checkIfTablesExist()) {
                $dbGeneralSetting = GeneralSetting::first();
                $dbLogoSetting = LogoSetting::first();
                $dbMailSetting = EmailConfiguration::first();
                $dbPusherSetting = PusherSetting::first();

                // Only use database settings if all required settings exist
                if ($dbGeneralSetting && $dbLogoSetting && $dbMailSetting && $dbPusherSetting) {
                    $general_setting = $dbGeneralSetting;
                    $logo_setting = $dbLogoSetting;
                    $mailSetting = $dbMailSetting;
                    $pusherSetting = $dbPusherSetting;
                    $useDefaults = false;
                }
            }
        } catch (Exception) {
            // Log error if needed but continue with defaults
            // \Log::error($e->getMessage());
        }

        // Configure application settings
        Config::set('app.timezone', $general_setting->timezone);

        // Set mail configuration
        Config::set('mail.mailers.smtp.host', $mailSetting->host);
        Config::set('mail.mailers.smtp.port', $mailSetting->port);
        Config::set('mail.mailers.smtp.encryption', $mailSetting->encryption);
        Config::set('mail.mailers.smtp.username', $mailSetting->username);
        Config::set('mail.mailers.smtp.password', $mailSetting->password);

        // Set broadcasting configuration
        Config::set('broadcasting.connections.pusher.key', $pusherSetting->pusher_key);
        Config::set('broadcasting.connections.pusher.secret', $pusherSetting->pusher_secret);
        Config::set('broadcasting.connections.pusher.app_id', $pusherSetting->pusher_app_id);
        Config::set(
            'broadcasting.connections.pusher.options.host',
            "api-" . $pusherSetting->pusher_cluster . ".pusher.com"
        );

        // Share settings with all views
        View::composer('*', static function ($view) use ($general_setting, $logo_setting, $pusherSetting, $useDefaults) {
            $view->with([
                'settings' => $general_setting,
                'logo_setting' => $logo_setting,
                'pusherSetting' => $pusherSetting,
                'using_default_settings' => $useDefaults // Optional: lets views know if we're using defaults
            ]);
        });
    }

    /**
     * Check if all required tables exist
     */
    private function checkIfTablesExist(): bool
    {
        return Schema::hasTable('general_settings')
            && Schema::hasTable('logo_settings')
            && Schema::hasTable('email_configurations')
            && Schema::hasTable('pusher_settings');
    }
}
