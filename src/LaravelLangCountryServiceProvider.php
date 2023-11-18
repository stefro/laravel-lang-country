<?php

namespace Stefro\LaravelLangCountry;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Stefro\LaravelLangCountry\Listeners\UserAuthenticated;
use Stefro\LaravelLangCountry\Middleware\LangCountrySession;

class LaravelLangCountryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lang-country.php' => config_path('lang-country.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app['router']->aliasMiddleware('lang_country', LangCountrySession::class);

        $this->app['router']
            ->middleware(config('lang-country.lang_switcher_middleware'))
            ->get('/' . config('lang-country.lang_switcher_uri','change_lang_country') . '/{lang_country}', 'Stefro\LaravelLangCountry\Controllers\LangCountrySwitchController@switch')
            ->name('lang_country.switch');

        \Event::listen(Login::class, UserAuthenticated::class);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
    }
}
