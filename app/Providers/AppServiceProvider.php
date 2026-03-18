<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Force use Https to production website
         *
         * 
         */
        if (app()->environment('production')) {
             \URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.erenge');
        
        /**
         * Custom cookie consent service
         *
         * 
         */
        $this->app->bind(CustomCookieConsentServiceProvider::class, Spatie\CokieConsent\CookieCOnsentServiceProvider::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Paginator::defaultView('vendor.pagination.erenge');
    }
}
