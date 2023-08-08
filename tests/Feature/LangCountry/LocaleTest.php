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
        'es-CO',
    ]);
});

it('four char json available', function () {
    $file = __DIR__ . '/../../Support/Files/es-CO.json';
    $dest = lang_path() . 'es-CO.json';
    copy($file, $dest);

    $lang = new PreferredLanguage('es-CO,en');

    expect($lang->locale)->toEqual('es-CO');

    @unlink($dest);
})->group('locale_test');

it('four char json not available', function () {
    $lang = new PreferredLanguage('es-CO,en');

    expect($lang->locale)->toEqual('es');
})->group('locale_test');
