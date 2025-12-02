<?php

declare(strict_types=1);

namespace Stefro\LaravelLangCountry\Tests;

use Spatie\LaravelRay\RayServiceProvider;
use Stefro\LaravelLangCountry\LaravelLangCountryServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // Ensure the static exists so orchestra/testbench-core can set it
    public static $latestResponse = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->artisan('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelLangCountryServiceProvider::class,
            RayServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LangCountry' => \Stefro\LaravelLangCountry\LangCountryFacade::class,
            'Auth' => \Illuminate\Support\Facades\Auth::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set('app.key', 'base64:f9kzW7cVoE96+f+00BKmlvFujZGy5Pf5GHG6/51mbns=');
        $app['config']->set('lang-country.lang_switcher_middleware', ['web', 'lang_country']);

        $app['config']->set('app.debug', true);

        // Set the test routes
        $app['router']
            ->middleware(['web', 'lang_country'])
            ->get('test_route', 'Stefro\LaravelLangCountry\Tests\Support\Controllers\TestRoutesController@testRoute')
            ->name('test_route');
    }
}
