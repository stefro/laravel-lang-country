<?php

use Stefro\LaravelLangCountry\Tests\Support\Models\User;

beforeEach(function () {
    // Set config variables
    $this->app['config']->set('lang-country.fallback', 'en-GB');
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
    ]);
});

it('should set all sessions when the user is logged in by listening to the Login event', function () {
    $user = User::create([
        'name' => 'Stef Rouschop',
        'email' => 'hello@hello.com',
        'password' => \Hash::make('password'),
        'lang_country' => 'nl_NL',
    ]);

    Auth::login($user);

    expect(session('locale'))->toBe('nl')->and(session('lang_country'))->toBe('nl-NL');
});
