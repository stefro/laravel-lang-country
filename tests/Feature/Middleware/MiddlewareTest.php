<?php


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

test('sessions will be set on first visit with fallback', function () {
    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
        ->assertStatus(200);

    expect(session('lang_country'))->toEqual('en-GB');
    expect(session('locale'))->toEqual('en');
});

test('sessions will be set on first visit according to browser', function () {
    $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'nl-BE'])
        ->assertStatus(200);

    expect(session('lang_country'))->toEqual('nl-BE');
    expect(session('locale'))->toEqual('nl');
});
