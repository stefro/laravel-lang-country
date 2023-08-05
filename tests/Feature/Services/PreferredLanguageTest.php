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
    ]);
});

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
