<?php


use Stefro\LaravelLangCountry\Services\PreferredLanguage;

beforeEach(function () {
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

it('should get preferred languages in right order', function () {
    $lang = new PreferredLanguage('nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4,de;q=0.5');

    $expected = collect([
        'nl-NL' => 1.0,
        'nl' => 0.8,
        'en-US' => 0.6,
        'de' => 0.5,
        'en' => 0.4,
    ]);

    expect($lang->clientPreferredLanguages())->toEqual($expected);
});

it('prioritize more specific values', function () {
    $lang = new PreferredLanguage('nl-NL,nl,en-US,en,de');
    $expected = collect([
        'nl-NL' => 1.0,
        'en-US' => 1.0,
        'nl' => 1.0,
        'de' => 1.0,
        'en' => 1.0,
    ]);

    expect($lang->clientPreferredLanguages())->toEqual($expected);
});

it('should return exact match with allowed lang country', function () {
    $lang = new PreferredLanguage('gr,nl,de-DE,en');

    expect($lang->lang_country)->toEqual('de-DE');
});

it('should match based on lang', function () {
    $lang = new PreferredLanguage('gr,nl,zh-CH,en');

    expect($lang->lang_country)->toEqual('nl-NL');
});

it('should return fallback when there is no match', function () {
    $lang = new PreferredLanguage('gr,zh-CH');

    expect($lang->lang_country)->toEqual('en-GB');
});

it('should return country in lowercase', function () {
    $lang = new PreferredLanguage('nl-nl,nl-be,gr');

    expect($lang->lang_country)->toEqual('nl-NL');
});

it('should override the default allowed languages from the config', function () {
    $override_allowed_languages = collect([
        'es-ES', 'es-CO', 'no-NO', 'cn-CN',
    ]);
    $override_fallback = 'cn-CN';

    $lang = new PreferredLanguage('es', $override_allowed_languages, $override_fallback);
    expect($lang->lang_country)->toEqual('es-ES')
        ->and($lang->locale)->toEqual('es');

    $lang = new PreferredLanguage('nl', $override_allowed_languages, $override_fallback);
    expect($lang->lang_country)->toEqual('cn-CN')
        ->and($lang->locale)->toEqual('cn');
});

it('should fall back to only country two char if four char json not available', function () {
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
        'en-CA',
        'en-AU',
        'es-CO',
    ]);

    $lang = new PreferredLanguage('es-CO,en');

    expect($lang->locale)->toEqual('es');
});

it('should use four char json when available', function () {
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
        'en-CA',
        'en-AU',
        'es-CO',
    ]);

    $file = __DIR__ . '/../../Support/Files/es-CO.json';
    $dest = lang_path() . 'es-CO.json';
    copy($file, $dest);

    $lang = new PreferredLanguage('es-CO,en');

    expect($lang->locale)->toEqual('es-CO');
    @unlink($dest);
});

it('should should be able to override the lang_country session', function () {
    session()->put('lang_country', 'nl-NL');
    $langCountry = new \Stefro\LaravelLangCountry\LangCountry();

    expect($langCountry->currentLangCountry())->toEqual('nl-NL');

    $langCountry->overrideSession('en-GB');

    expect($langCountry->currentLangCountry())->toEqual('en-GB');
});

it('should throw an error when the lang_country session is null', function () {
    session()->put('lang_country', null);
    $langCountry = new \Stefro\LaravelLangCountry\LangCountry();
})->throws(\Exception::class, 'The lang_country session is not set');
