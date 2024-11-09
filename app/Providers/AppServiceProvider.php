<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
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

        try {
            // First check if we can connect to the database
            \DB::connection()->getPdo();

            // Then check if tables exist
            if ($this->checkIfTablesExist()) {
                $general_setting = GeneralSetting::first();
                $logo_setting = LogoSetting::first();
                $mailSetting = EmailConfiguration::first();
                $pusherSetting = PusherSetting::first();
            }
        } catch (\Exception $e) {
            // Log error if needed but don't throw exception
            // \Log::error($e->getMessage());
        }

        if ($general_setting && $logo_setting && $mailSetting && $pusherSetting) {
            /**
             * Set Timezone
             */
            Config::set('app.timezone', $general_setting->timezone);

            /** Set Mail Config */
            Config::set('mail.mailers.smtp.host', $mailSetting->host);
            Config::set('mail.mailers.smtp.port', $mailSetting->port);
            Config::set('mail.mailers.smtp.encryption', $mailSetting->encryption);
            Config::set('mail.mailers.smtp.username', $mailSetting->username);
            Config::set('mail.mailers.smtp.password', $mailSetting->password);

            /** Set Broadcasting Config */
            Config::set('broadcasting.connections.pusher.key', $pusherSetting->pusher_key);
            Config::set('broadcasting.connections.pusher.secret', $pusherSetting->pusher_secret);
            Config::set('broadcasting.connections.pusher.app_id', $pusherSetting->pusher_app_id);
            Config::set(
                'broadcasting.connections.pusher.options.host',
                "api-" . $pusherSetting->pusher_cluster . ".pusher.com"
            );

            /**
             * Access settings at all views
             */
            View::composer('*', static function ($view) use ($general_setting, $logo_setting, $pusherSetting) {
                $view->with([
                    'settings' => $general_setting,
                    'logo_setting' => $logo_setting,
                    'pusherSetting' => $pusherSetting
                ]);
            });
        }
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
