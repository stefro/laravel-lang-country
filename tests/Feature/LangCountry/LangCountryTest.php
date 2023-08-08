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

it('returns the right values for nl  n l', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::country())->toEqual('NL');
    expect(\LangCountry::countryName())->toEqual('The Netherlands');
    expect(\LangCountry::countryNameLocal())->toEqual('Nederland');
    expect(\LangCountry::lang())->toEqual('nl');
    expect(\LangCountry::name())->toEqual('Nederlands');
    expect(\LangCountry::dateNumbersFormat())->toEqual('d-m-Y');
    expect(\LangCountry::dateNumbers($this->test_date))->toEqual('10-03-2018');
    expect(\LangCountry::dateNumbersFullCapitalsFormat())->toEqual('DD-MM-YYYY');
    expect(\LangCountry::dateWordsWithoutDayFormat())->toEqual('j F Y');
    expect(\LangCountry::dateWordsWithoutDay($this->test_date))->toEqual('10 maart 2018');
    expect(\LangCountry::dateWordsWithDayFormat())->toEqual('l j F Y');
    expect(\LangCountry::dateWordsWithDay($this->test_date))->toEqual('zaterdag 10 maart 2018');
    expect(\LangCountry::dateBirthdayFormat())->toEqual('j F');
    expect(\LangCountry::dateBirthday($this->test_date))->toEqual('10 maart');
    expect(\LangCountry::timeFormat())->toEqual('H:i');
    expect(\LangCountry::time($this->test_date))->toEqual('13:05');
    expect(\LangCountry::emojiFlag())->toEqual('🇳🇱');
    expect(\LangCountry::currencyCode())->toEqual('EUR');
    expect(\LangCountry::currencySymbol())->toEqual('€');
    expect(\LangCountry::currencySymbolLocal())->toEqual('€');
    expect(\LangCountry::currencyName())->toEqual('Euro');
    expect(\LangCountry::currencyNameLocal())->toEqual('Euro');

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
})->group('lang_country_test');

it('returns the right values for en  u s', function () {
    session(['lang_country' => 'en-US']);
    App::setLocale('en');

    expect(\LangCountry::country())->toEqual('US');
    expect(\LangCountry::countryName())->toEqual('United States of America');
    expect(\LangCountry::countryNameLocal())->toEqual('America');
    expect(\LangCountry::lang())->toEqual('en');
    expect(\LangCountry::name())->toEqual('American English');
    expect(\LangCountry::dateNumbersFormat())->toEqual('m/d/Y');
    expect(\LangCountry::dateNumbers($this->test_date))->toEqual('03/10/2018');
    expect(\LangCountry::dateNumbersFullCapitalsFormat())->toEqual('MM/DD/YYYY');
    expect(\LangCountry::dateWordsWithoutDayFormat())->toEqual('F jS Y');
    expect(\LangCountry::dateWordsWithoutDay($this->test_date))->toEqual('March 10th 2018');
    expect(\LangCountry::dateWordsWithDayFormat())->toEqual('l F jS Y');
    expect(\LangCountry::dateWordsWithDay($this->test_date))->toEqual('Saturday March 10th 2018');
    expect(\LangCountry::dateBirthdayFormat())->toEqual('F jS');
    expect(\LangCountry::dateBirthday($this->test_date))->toEqual('March 10th');
    expect(\LangCountry::timeFormat())->toEqual('h:i a');
    expect(\LangCountry::time($this->test_date))->toEqual('01:05 pm');
    expect(\LangCountry::emojiFlag())->toEqual('🇺🇸');
    expect(\LangCountry::currencyCode())->toEqual('USD');
    expect(\LangCountry::currencySymbol())->toEqual('$');
    expect(\LangCountry::currencySymbolLocal())->toEqual('US$');
    expect(\LangCountry::currencyName())->toEqual('Dollar');
    expect(\LangCountry::currencyNameLocal())->toEqual('US Dollar');

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
})->group('lang_country_test');

it('returns the right values for en  u s while session is nl  n l but is overruled', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::dateNumbers($this->test_date, 'en-US'))->toEqual('03/10/2018');
    expect(\LangCountry::dateWordsWithoutDay($this->test_date, 'en-US'))->toEqual('March 10th 2018');
    expect(\LangCountry::dateWordsWithDay($this->test_date, 'en-US'))->toEqual('Saturday March 10th 2018');
    expect(\LangCountry::dateBirthday($this->test_date, 'en-US'))->toEqual('March 10th');
    expect(\LangCountry::time($this->test_date, 'en-US'))->toEqual('01:05 pm');
})->group('lang_country_test');

it('returns all the availeble languages', function () {
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
})->group('lang_country_test');

it('uses the override when available', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    $file = __DIR__ . '/../../Support/Files/lang-country-overrides/nl-NL.json';
    $dir = lang_path('lang-country-overrides');

    if (! is_dir($dir)) {
        mkdir($dir);
    }
    if (! is_file($dir)) {
        $dest = $dir . 'nl-NL.json';
    }

    copy($file, $dest);

    expect(\LangCountry::lang())->toEqual('nl');
    expect(\LangCountry::country())->toEqual('NL');
    expect(\LangCountry::name())->toEqual('Nederlands override!');

    // Remove test files from testbench
    unlink(lang_path('lang-country-overrides') . 'nl-NL.json');
    rmdir(lang_path('lang-country-overrides'));
});

it('get the language for an override lang country code', function () {
    session(['lang_country' => 'nl-NL']);
    App::setLocale('nl');

    expect(\LangCountry::lang('en-US'))->toEqual('en');
});
