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

it('should switch for non logged in user', function () {
    $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));

    expect(session('lang_country'))->toEqual('nl-BE')
        ->and(session('locale'))->toEqual('nl');
});

it('should switch for logged in user without lang country setting', function () {
    $this->actingAs($this->user);

    $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));
    expect(session('lang_country'))->toEqual('nl-BE')
        ->and(session('locale'))->toEqual('nl')
        ->and($this->user->lang_country)->toEqual('nl-BE');

});

it('should switch for logged in user with lang country setting', function () {
    $this->user->update([
        'lang-country' => 'en-US',
    ]);

    $this->actingAs($this->user);

    $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));
    expect(session('lang_country'))->toEqual('nl-BE')
        ->and(session('locale'))->toEqual('nl')
        ->and($this->user->lang_country)->toEqual('nl-BE');

});

it('should redirect back without changes if a lang country is not allowed', function () {
    session(['lang_country' => 'nl-BE', 'locale' => 'nl']);

    $this->get(route('lang_country.switch', ['lang_country' => 'xx-YY']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));

    expect(session('lang_country'))->toEqual('nl-BE')
        ->and(session('locale'))->toEqual('nl');
});
