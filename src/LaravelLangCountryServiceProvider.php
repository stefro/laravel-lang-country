<?php

namespace Stefro\LaravelLangCountry;

use Carbon\Carbon;
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
            ->get('/' . config('lang-country.lang_switcher_uri', 'change_lang_country') . '/{lang_country}', 'Stefro\LaravelLangCountry\Controllers\LangCountrySwitchController@switch')
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
        Carbon::macro('langCountryDateNumbers', function (bool|string $override = false, bool $withTime = false) {
            if ($withTime) {
                return \LangCountry::withTime()->dateNumbers($this, $override);
            }

            return \LangCountry::dateNumbers($this, $override);
        });

        Carbon::macro('langCountryDateWordsWithoutDay', function (bool|string $override = false, bool $withTime = false) {
            if ($withTime) {
                return \LangCountry::withTime()->dateWordsWithoutDay($this, $override);
            }

            return \LangCountry::dateWordsWithoutDay($this, $override);
        });

        Carbon::macro('langCountryDateWordsWithDay', function (bool|string $override = false, bool $withTime = false) {
            if ($withTime) {
                return \LangCountry::withTime()->dateWordsWithDay($this, $override);
            }

            return \LangCountry::dateWordsWithDay($this, $override);
        });

        Carbon::macro('langCountryDateBirthday', function (bool|string $override = false) {
            return \LangCountry::dateBirthday($this, $override);
        });

        Carbon::macro('langCountryTime', function (bool|string $override = false) {
            return \LangCountry::time($this, $override);
        });

    }
}
