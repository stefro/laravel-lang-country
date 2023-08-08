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

it('sessions will be set on first visit with fallback', function () {
    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
        ->assertStatus(200);

    expect(session('lang_country'))->toEqual('en-GB');
    expect(session('locale'))->toEqual('en');
});

it('sessions will be set on first visit according to browser', function () {
    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'nl-BE'])
        ->assertStatus(200);

    expect(session('lang_country'))->toEqual('nl-BE');
    expect(session('locale'))->toEqual('nl');
});

it('uses fallback for logged in user without lang country setting', function () {
    $this->actingAs($this->user)->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
        ->assertStatus(200);
    expect(session('lang_country'))->toEqual('en-GB')
        ->and(session('locale'))->toEqual('en');
});
