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

    $this->user = User::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
        'password' => \Hash::make('456'),
        'lang_country' => null,
    ]);
});


it('should call the setAllSessions method when there is no lang_country session and no logged in user', function () {
    \LangCountry::shouldReceive('setAllSessions')->once()->with('nl,de')->andReturnUsing(function () {
        session()->put([
            'lang_country' => 'nl-NL',
            'locale' => 'nl',
        ]);
    });

    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'nl,de'])
        ->assertStatus(200);

    expect(session('locale'))->toBe('nl')->and(session('lang_country'))->toBe('nl-NL');
});

it('should not call the setAllSessions method when there is a lang_country session but no logged in user', function () {
    session()->put([
        'lang_country' => 'nl-NL',
        'locale' => 'nl',
    ]);

    \LangCountry::shouldReceive('setAllSessions')->never();

    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'de'])
        ->assertStatus(200);

    expect(session('locale'))->toBe('nl')->and(session('lang_country'))->toBe('nl-NL');
});

it('should call the setAllSessions method with the browser locale when there is a lang_country session but there is a user without a lang_country value in the database', function () {
    \LangCountry::shouldReceive('setAllSessions')->once()->with('nl,de')->andReturnUsing(function () {
        session()->put([
            'lang_country' => 'nl-NL',
            'locale' => 'nl',
        ]);
    });

    $this->user->update([
        'lang_country' => null,
    ]);

    $this->actingAs($this->user);

    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'nl,de'])
        ->assertStatus(200);

    expect(session('locale'))->toBe('nl')
        ->and(session('lang_country'))->toBe('nl-NL')
        ->and($this->user->refresh()->lang_country)->toBe('nl-NL');

});

it('should call the setAllSessions method with the user lang_country value when there is a lang_country session but there is a user with a lang_country value in the database', function () {
    \LangCountry::shouldReceive('setAllSessions')->once()->with('nl-NL')->andReturnUsing(function () {
        session()->put([
            'lang_country' => 'nl-NL',
            'locale' => 'nl',
        ]);
    });

    $this->user->update([
        'lang_country' => 'nl-NL',
    ]);

    $this->actingAs($this->user);

    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'nl,de'])
        ->assertStatus(200);

    expect(session('locale'))->toBe('nl')
        ->and(session('lang_country'))->toBe('nl-NL');
});
