<?php


use Carbon\Carbon;
use Illuminate\Support\Facades\App;

beforeEach(function () {
    $this->test_date = Carbon::create(2018, 03, 10, 13, 05);

    // Set config variables
    $this->app['config']->set('lang-country.fallback', 'en-GB');
    $this->app['config']->set('lang-country.allowed', [
        'nl-NL',
        'nl-BE',
        'en-GB',
        'en-US',
    ]);
});

it(
    'should get lang_country based on app locale, lang_country session and fallback_based_on_current_locale setting',
    function ($fallbackBasedOnCurrentLocale, $langCountrySession, $appLocale, $expected) {
        $this->app['config']->set('lang-country.fallback_based_on_current_locale', $fallbackBasedOnCurrentLocale);

        if ($langCountrySession === null) {
            session()->forget('lang_country');
        } else {
            session(['lang_country' => $langCountrySession]);
        }

        App::setLocale($appLocale);

        expect(\LangCountry::currentLangCountry())->toEqual($expected);

    }
)->with([
    [true, null, 'en', 'en-GB'],
    [true, null, 'nl', 'nl-NL'],
    [false, 'en-US', 'en', 'en-US'],
    [false, null, 'nl', 'en-GB'],
]);

it('should return the right values for nl-nl', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::country())->toEqual('NL')
        ->and(\LangCountry::countryName())->toEqual('The Netherlands')
        ->and(\LangCountry::countryNameLocal())->toEqual('Nederland')
        ->and(\LangCountry::lang())->toEqual('nl')
        ->and(\LangCountry::name())->toEqual('Nederlands')
        ->and(\LangCountry::dateNumbersFormat())->toEqual('d-m-Y')
        ->and(\LangCountry::dateNumbers($this->test_date))->toEqual('10-03-2018')
        ->and($this->test_date->langCountryDateNumbers())->toEqual('10-03-2018')
        ->and(\LangCountry::dateNumbersFullCapitalsFormat())->toEqual('DD-MM-YYYY')
        ->and(\LangCountry::dateWordsWithoutDayFormat())->toEqual('j F Y')
        ->and(\LangCountry::dateWordsWithoutDay($this->test_date))->toEqual('10 maart 2018')
        ->and($this->test_date->langCountryDateWordsWithoutDay())->toEqual('10 maart 2018')
        ->and(\LangCountry::dateWordsWithDayFormat())->toEqual('l j F Y')
        ->and(\LangCountry::dateWordsWithDay($this->test_date))->toEqual('zaterdag 10 maart 2018')
        ->and($this->test_date->langCountryDateWordsWithDay())->toEqual('zaterdag 10 maart 2018')
        ->and(\LangCountry::dateBirthdayFormat())->toEqual('j F')
        ->and(\LangCountry::dateBirthday($this->test_date))->toEqual('10 maart')
        ->and($this->test_date->langCountryDateBirthday())->toEqual('10 maart')
        ->and(\LangCountry::timeFormat())->toEqual('H:i')
        ->and(\LangCountry::time($this->test_date))->toEqual('13:05')
        ->and($this->test_date->langCountryTime())->toEqual('13:05')
        ->and(\LangCountry::emojiFlag())->toEqual('🇳🇱')
        ->and(\LangCountry::currencyCode())->toEqual('EUR')
        ->and(\LangCountry::currencySymbol())->toEqual('€')
        ->and(\LangCountry::currencySymbolLocal())->toEqual('€')
        ->and(\LangCountry::currencyName())->toEqual('Euro')
        ->and(\LangCountry::currencyNameLocal())->toEqual('Euro');

    $expected = [
        'current' => [
            'country' => 'NL',
            'country_name' => 'The Netherlands',
            'country_name_local' => 'Nederland',
            'lang' => 'nl',
            'name' => 'Nederlands',
            'lang_country' => 'nl-NL',
            'emoji_flag' => '🇳🇱',
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'currency_symbol_local' => '€',
            'currency_name' => 'Euro',
            'currency_name_local' => 'Euro',
        ],
        'available' => [
            [
                'country' => 'BE',
                'country_name' => 'Belgium',
                'country_name_local' => 'België',
                'lang' => 'nl',
                'name' => 'België - Vlaams',
                'lang_country' => 'nl-BE',
                'emoji_flag' => '🇧🇪',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'currency_symbol_local' => '€',
                'currency_name' => 'Euro',
                'currency_name_local' => 'Euro',
            ],
            [
                'country' => 'GB',
                'country_name' => 'United Kingdom',
                'country_name_local' => 'United Kingdom',
                'lang' => 'en',
                'name' => 'English',
                'lang_country' => 'en-GB',
                'emoji_flag' => '🇬🇧',
                'currency_code' => 'GBP',
                'currency_symbol' => '£',
                'currency_symbol_local' => '£',
                'currency_name' => 'Pound Stirling',
                'currency_name_local' => 'Pound',
            ],
            [
                'country' => 'US',
                'country_name' => 'United States of America',
                'country_name_local' => 'America',
                'lang' => 'en',
                'name' => 'American English',
                'lang_country' => 'en-US',
                'emoji_flag' => '🇺🇸',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'currency_symbol_local' => 'US$',
                'currency_name' => 'Dollar',
                'currency_name_local' => 'US Dollar',
            ],
        ],
    ];
    expect(\LangCountry::langSelectorHelper())->toEqual($expected);
});

it('returns the right values for en-US', function () {
    session(['lang_country' => 'en-US']);
    App::setLocale('en');

    expect(\LangCountry::country())->toEqual('US')
        ->and(\LangCountry::countryName())->toEqual('United States of America')
        ->and(\LangCountry::countryNameLocal())->toEqual('America')
        ->and(\LangCountry::lang())->toEqual('en')
        ->and(\LangCountry::name())->toEqual('American English')
        ->and(\LangCountry::dateNumbersFormat())->toEqual('m/d/Y')
        ->and(\LangCountry::dateNumbers($this->test_date))->toEqual('03/10/2018')
        ->and($this->test_date->langCountryDateNumbers())->toEqual('03/10/2018')
        ->and(\LangCountry::dateNumbersFullCapitalsFormat())->toEqual('MM/DD/YYYY')
        ->and(\LangCountry::dateWordsWithoutDayFormat())->toEqual('F jS Y')
        ->and(\LangCountry::dateWordsWithoutDay($this->test_date))->toEqual('March 10th 2018')
        ->and($this->test_date->langCountryDateWordsWithoutDay())->toEqual('March 10th 2018')
        ->and(\LangCountry::dateWordsWithDayFormat())->toEqual('l F jS Y')
        ->and(\LangCountry::dateWordsWithDay($this->test_date))->toEqual('Saturday March 10th 2018')
        ->and($this->test_date->langCountryDateWordsWithDay())->toEqual('Saturday March 10th 2018')
        ->and(\LangCountry::dateBirthdayFormat())->toEqual('F jS')
        ->and(\LangCountry::dateBirthday($this->test_date))->toEqual('March 10th')
        ->and($this->test_date->langCountryDateBirthday())->toEqual('March 10th')
        ->and(\LangCountry::timeFormat())->toEqual('h:i a')
        ->and(\LangCountry::time($this->test_date))->toEqual('01:05 pm')
        ->and($this->test_date->langCountryTime())->toEqual('01:05 pm')
        ->and(\LangCountry::emojiFlag())->toEqual('🇺🇸')
        ->and(\LangCountry::currencyCode())->toEqual('USD')
        ->and(\LangCountry::currencySymbol())->toEqual('$')
        ->and(\LangCountry::currencySymbolLocal())->toEqual('US$')
        ->and(\LangCountry::currencyName())->toEqual('Dollar')
        ->and(\LangCountry::currencyNameLocal())->toEqual('US Dollar');

    $expected = [
        'current' => [
            'country' => 'US',
            'country_name' => 'United States of America',
            'country_name_local' => 'America',
            'lang' => 'en',
            'name' => 'American English',
            'lang_country' => 'en-US',
            'emoji_flag' => '🇺🇸',
            'currency_code' => 'USD',
            'currency_symbol' => '$',
            'currency_symbol_local' => 'US$',
            'currency_name' => 'Dollar',
            'currency_name_local' => 'US Dollar',
        ],
        'available' => [
            [
                'country' => 'NL',
                'country_name' => 'The Netherlands',
                'country_name_local' => 'Nederland',
                'lang' => 'nl',
                'name' => 'Nederlands',
                'lang_country' => 'nl-NL',
                'emoji_flag' => '🇳🇱',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'currency_symbol_local' => '€',
                'currency_name' => 'Euro',
                'currency_name_local' => 'Euro',
            ],
            [
                'country' => 'BE',
                'country_name' => 'Belgium',
                'country_name_local' => 'België',
                'lang' => 'nl',
                'name' => 'België - Vlaams',
                'lang_country' => 'nl-BE',
                'emoji_flag' => '🇧🇪',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'currency_symbol_local' => '€',
                'currency_name' => 'Euro',
                'currency_name_local' => 'Euro',
            ],
            [
                'country' => 'GB',
                'country_name' => 'United Kingdom',
                'country_name_local' => 'United Kingdom',
                'lang' => 'en',
                'name' => 'English',
                'lang_country' => 'en-GB',
                'emoji_flag' => '🇬🇧',
                'currency_code' => 'GBP',
                'currency_symbol' => '£',
                'currency_symbol_local' => '£',
                'currency_name' => 'Pound Stirling',
                'currency_name_local' => 'Pound',
            ],
        ],
    ];
    expect(\LangCountry::langSelectorHelper())->toEqual($expected);
});

it('should return the right values for enUS while session is nl-NL but is overruled', function ($method, $override, $expectation) {
    // We need to run this test in a loop with a dateset, to prevent a sticky override when testing in a chain
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::$method($this->test_date, $override))->toEqual($expectation);
})->with([
    ['dateNumbers', 'en-US', '03/10/2018'],
    ['dateWordsWithoutDay', 'en-US', 'March 10th 2018'],
    ['dateWordsWithDay', 'en-US', 'Saturday March 10th 2018'],
    ['dateBirthday', 'en-US', 'March 10th'],
    ['time', 'en-US', '01:05 pm'],
]);

it('should return the right values for enUS while session is nl-NL but is overruled when using the Carbon Macro', function ($method, $override, $expectation) {
    // We need to run this test in a loop with a dateset, to prevent a sticky override when testing in a chain
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect($this->test_date->$method($override))->toEqual($expectation);
})->with([
    ['langCountryDateNumbers', 'en-US', '03/10/2018'],
    ['langCountryDateWordsWithoutDay', 'en-US', 'March 10th 2018'],
    ['langCountryDateWordsWithDay', 'en-US', 'Saturday March 10th 2018'],
    ['langCountryDateBirthday', 'en-US', 'March 10th'],
    ['langCountryTime', 'en-US', '01:05 pm'],
]);

it('should return all the available languages', function () {

    $expected = [
        [
            'country' => 'NL',
            'country_name' => 'The Netherlands',
            'country_name_local' => 'Nederland',
            'lang' => 'nl',
            'name' => 'Nederlands',
            'lang_country' => 'nl-NL',
            'emoji_flag' => '🇳🇱',
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'currency_symbol_local' => '€',
            'currency_name' => 'Euro',
            'currency_name_local' => 'Euro',
        ],
        [
            'country' => 'BE',
            'country_name' => 'Belgium',
            'country_name_local' => 'België',
            'lang' => 'nl',
            'name' => 'België - Vlaams',
            'lang_country' => 'nl-BE',
            'emoji_flag' => '🇧🇪',
            'currency_code' => 'EUR',
            'currency_symbol' => '€',
            'currency_symbol_local' => '€',
            'currency_name' => 'Euro',
            'currency_name_local' => 'Euro',
        ],
        [
            'country' => 'GB',
            'country_name' => 'United Kingdom',
            'country_name_local' => 'United Kingdom',
            'lang' => 'en',
            'name' => 'English',
            'lang_country' => 'en-GB',
            'emoji_flag' => '🇬🇧',
            'currency_code' => 'GBP',
            'currency_symbol' => '£',
            'currency_symbol_local' => '£',
            'currency_name' => 'Pound Stirling',
            'currency_name_local' => 'Pound',
        ],
        [
            'country' => 'US',
            'country_name' => 'United States of America',
            'country_name_local' => 'America',
            'lang' => 'en',
            'name' => 'American English',
            'lang_country' => 'en-US',
            'emoji_flag' => '🇺🇸',
            'currency_code' => 'USD',
            'currency_symbol' => '$',
            'currency_symbol_local' => 'US$',
            'currency_name' => 'Dollar',
            'currency_name_local' => 'US Dollar',
        ],
    ];
    expect(\LangCountry::allLanguages())->toEqual(collect($expected));
});

it('should use the override when available', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    $file = __DIR__ . '/../../Support/Files/lang-country-overrides/nl-NL.json';
    $dir = lang_path('lang-country-overrides');
    $filename = 'nl-NL.json';

    if (! is_dir($dir)) {
        mkdir($dir);
    }
    if (! is_file($dir)) {
        $dest = lang_path('lang-country-overrides/' . $filename);
    }

    copy($file, $dest);

    expect(\LangCountry::lang())->toEqual('nl')
        ->and(\LangCountry::country())->toEqual('NL')
        ->and(\LangCountry::name())->toEqual('Nederlands override!');

    // Remove test files from testbench
    unlink(lang_path('lang-country-overrides/' . $filename));
    rmdir(lang_path('lang-country-overrides'));
});

it('should return the language for an override lang country code', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::lang('en-US'))->toEqual('en');
});

it('should accept the withTime method', function () {
    session(['lang_country' => 'en-US']);
    App::setLocale('en');

    expect(\LangCountry::dateNumbersFormat())->toEqual('m/d/Y')
        ->and(\LangCountry::withTime()->dateNumbersFormat())->toEqual('m/d/Y h:i a')
        ->and(\LangCountry::dateNumbers($this->test_date))->toEqual('03/10/2018')
        ->and($this->test_date->langCountryDateNumbers())->toEqual('03/10/2018')
        ->and(\LangCountry::withTime()->dateNumbers($this->test_date))->toEqual('03/10/2018 01:05 pm')
        ->and($this->test_date->langCountryDateNumbers(false, true))->toEqual('03/10/2018 01:05 pm')
        ->and(\LangCountry::dateWordsWithoutDayFormat())->toEqual('F jS Y')
        ->and(\LangCountry::withTime()->dateWordsWithoutDayFormat())->toEqual('F jS Y h:i a')
        ->and(\LangCountry::dateWordsWithoutDay($this->test_date))->toEqual('March 10th 2018')
        ->and($this->test_date->langCountryDateWordsWithoutDay())->toEqual('March 10th 2018')
        ->and(\LangCountry::withTime()->dateWordsWithoutDay($this->test_date))->toEqual('March 10th 2018 01:05 pm')
        ->and($this->test_date->langCountryDateWordsWithoutDay(false, true))->toEqual('March 10th 2018 01:05 pm')
        ->and(\LangCountry::dateWordsWithDayFormat())->toEqual('l F jS Y')
        ->and(\LangCountry::withTime()->dateWordsWithDayFormat())->toEqual('l F jS Y h:i a')
        ->and(\LangCountry::dateWordsWithDay($this->test_date))->toEqual('Saturday March 10th 2018')
        ->and($this->test_date->langCountryDateWordsWithDay())->toEqual('Saturday March 10th 2018')
        ->and(\LangCountry::withTime()->dateWordsWithDay($this->test_date))->toEqual('Saturday March 10th 2018 01:05 pm')
        ->and($this->test_date->langCountryDateWordsWithDay(false, true))->toEqual('Saturday March 10th 2018 01:05 pm')
        ->and(\LangCountry::dateNumbersFullCapitalsFormat())->toEqual('MM/DD/YYYY')
        ->and(\LangCountry::withTime()->dateNumbersFullCapitalsFormat())->toEqual('MM/DD/YYYY h:i a');
});
