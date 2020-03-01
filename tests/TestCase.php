<?php

namespace InvolvedGroup\LaravelLangCountry\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
        $this->artisan('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [
            \InvolvedGroup\LaravelLangCountry\LaravelLangCountryServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LangCountry' => \InvolvedGroup\LaravelLangCountry\LangCountryFacade::class,
            'Auth' => \Illuminate\Support\Facades\Auth::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['config']->set('app.key', 'base64:f9kzW7cVoE96+f+00BKmlvFujZGy5Pf5GHG6/51mbns=');
        $app['config']->set('lang-country.lang_switcher_middleware', ['web', 'lang_country']);

        $app['config']->set('app.debug', true);

        // Set the test routes
        $app['router']
            ->middleware(['web', 'lang_country'])
            ->get('test_route', 'InvolvedGroup\LaravelLangCountry\Tests\Support\Controllers\TestRoutesController@testRoute')
            ->name('test_route');
    }
}
