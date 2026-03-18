<?php

namespace App\Providers;

use Cookie;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\ServiceProvider;

class CustomCookieConsentServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cookieConsent');

        $this->mergeConfigFrom(__DIR__.'/../../config/cookie-consent.php', 'cookie-consent');

        $this->loadViewsFrom(__DIR__.'/../../resources/views/custom', 'cookieConsent');
        
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('cookie-consent.cookie_name'));
        });
        
        $this->app['view']->composer('custom.cookieConsent.index', function (View $view) {

            $cookieConsentConfig = config('cookie-consent');

            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });
        
    }
}
