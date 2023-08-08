<?php


use Stefro\LaravelLangCountry\Services\PreferredLanguage;

beforeEach(function () {
    // Set config variables
    $this->app['config']->set('lang-country.fallback', 'en-GB');
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
        'en-CA',
        'en-AU',
        'de-DE',
        'zh-CN',
    ]);
});

it('no four char json available in date package fallback to just lang', function () {
    $lang = new PreferredLanguage('nl-NL');

    expect($lang->locale)->toEqual('nl');
})->group('locale_for_date_test');

it('no match fallback to date package fallback', function () {
    $lang = new PreferredLanguage('xx-XX');

    expect($lang->locale)->toEqual('en');
})->group('locale_for_date_test');
