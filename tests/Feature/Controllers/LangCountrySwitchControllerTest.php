<?php


use Illuminate\Foundation\Auth\User;

beforeEach(function () {
    // Set config variables
    $this->app['config']->set('lang-country.fallback', 'en-GB');
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
    ]);

    User::unguard();
    $this->user = User::create([
        'name' => 'Orchestra',
        'email' => 'hello@orchestraplatform.com',
        'password' => \Hash::make('456'),
        'lang_country' => null,
    ]);
    User::reguard();
});

test('switch for non logged in user', function () {
    // make first visit and verify fallback values are set
    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
        ->assertStatus(200);
    expect(session('lang_country'))->toEqual('en-GB');
    expect(session('locale'))->toEqual('en');

    // visit switch route
    $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));
    expect(session('lang_country'))->toEqual('nl-BE');
    expect(session('locale'))->toEqual('nl');
});

test('switch for logged in user without lang country setting', function () {
    // make first visit and verify fallback values are set
    $this->actingAs($this->user)->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
        ->assertStatus(200);
    expect(session('lang_country'))->toEqual('en-GB');
    expect(session('locale'))->toEqual('en');

    // visit switch route
    $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
        ->assertRedirect(route('test_route'));
    expect(session('lang_country'))->toEqual('nl-BE');
    expect(session('locale'))->toEqual('nl');

    expect($this->user->lang_country)->toEqual('nl-BE');
});
