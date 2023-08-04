<?php

namespace Stefro\LaravelLangCountry;

use Illuminate\Support\ServiceProvider;

class LaravelLangCountryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/lang-country.php' => config_path('lang-country.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->app['router']->aliasMiddleware('lang_country', \Stefro\LaravelLangCountry\Middleware\LangCountrySession::class);

        $this->app['router']
            ->middleware(config('lang-country.lang_switcher_middleware'))
            ->get('/change_lang_country/{lang_country}', 'Stefro\LaravelLangCountry\Controllers\LangCountrySwitchController@switch')
            ->name('lang_country.switch');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
    }
}
