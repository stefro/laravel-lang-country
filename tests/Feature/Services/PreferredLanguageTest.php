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
    ]);
});

it('get preferred languages in right order', function () {
    $lang = new PreferredLanguage('nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4,de;q=0.5');

    $expected = collect([
        'nl-NL' => 1.0,
        'nl' => 0.8,
        'en-US' => 0.6,
        'de' => 0.5,
        'en' => 0.4,
    ]);

    expect($lang->clientPreferedLanguages())->toEqual($expected);
})->group('preferred_lang_test');

it('prioritize more specific values', function () {
    $lang = new PreferredLanguage('nl-NL,nl,en-US,en,de');
    $expected = collect([
        'nl-NL' => 1.0,
        'en-US' => 1.0,
        'nl' => 1.0,
        'de' => 1.0,
        'en' => 1.0,
    ]);

    expect($lang->clientPreferedLanguages())->toEqual($expected);
})->group('preferred_lang_test');

it('exact match with allowed lang country', function () {
    $lang = new PreferredLanguage('gr,nl,de-DE,en');

    expect($lang->lang_country)->toEqual('de-DE');
})->group('preferred_lang_test');

it('match based on lang', function () {
    $lang = new PreferredLanguage('gr,nl,zh-CH,en');

    expect($lang->lang_country)->toEqual('nl-NL');
})->group('preferred_lang_test');

it('no match return fallback', function () {
    $lang = new PreferredLanguage('gr,zh-CH');

    expect($lang->lang_country)->toEqual('en-GB');
})->group('preferred_lang_test');

it('country in lowecase', function () {
    $lang = new PreferredLanguage('nl-nl,nl-be,gr');

    expect($lang->lang_country)->toEqual('nl-NL');
})->group('preferred_lang_test');

it('will override the default allowed languages from the config', function () {
    $override_allowed_languages = collect([
        'es-ES', 'es-CO', 'no-NO', 'cn-CN',
    ]);
    $override_fallback = 'cn-CN';

    $lang = new PreferredLanguage('es', $override_allowed_languages, $override_fallback);
    expect($lang->lang_country)->toEqual('es-ES');
    expect($lang->locale)->toEqual('es');

    $lang = new PreferredLanguage('nl', $override_allowed_languages, $override_fallback);
    expect($lang->lang_country)->toEqual('cn-CN');
    expect($lang->locale)->toEqual('cn');
});
