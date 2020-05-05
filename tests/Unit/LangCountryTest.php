<?php

namespace InvolvedGroup\LaravelLangCountry\Tests\Unit;

use App;
use Carbon\Carbon;
use InvolvedGroup\LaravelLangCountry\Tests\TestCase;

class LangCountryTest extends TestCase
{
    protected $test_date;

    protected function setUp(): void
    {
        parent::setUp();

        $this->test_date = Carbon::create(2018, 03, 10, 13, 05);

        // Set config variables
        $this->app['config']->set('lang-country.fallback', 'en-GB');
        $this->app['config']->set('lang-country.allowed', [
            'nl-NL',
            'nl-BE',
            'en-GB',
            'en-US',
        ]);
    }

    /**
     * @group lang_country_test
     * @test
     */
    public function it_returns_the_right_values_for_nl_NL()
    {
        session(['lang_country' => 'nl-NL']);
        App::setLocale('nl');

        $this->assertEquals('NL', \LangCountry::country());
        $this->assertEquals('The Netherlands', \LangCountry::countryName());
        $this->assertEquals('Nederland', \LangCountry::countryNameLocal());
        $this->assertEquals('nl', \LangCountry::lang());
        $this->assertEquals('Nederlands', \LangCountry::name());
        $this->assertEquals('d-m-Y', \LangCountry::dateNumbersFormat());
        $this->assertEquals('10-03-2018', \LangCountry::dateNumbers($this->test_date));
        $this->assertEquals('DD-MM-YYYY', \LangCountry::dateNumbersFullCapitalsFormat());
        $this->assertEquals('j F Y', \LangCountry::dateWordsWithoutDayFormat());
        $this->assertEquals('10 maart 2018', \LangCountry::dateWordsWithoutDay($this->test_date));
        $this->assertEquals('l j F Y', \LangCountry::dateWordsWithDayFormat());
        $this->assertEquals('zaterdag 10 maart 2018', \LangCountry::dateWordsWithDay($this->test_date));
        $this->assertEquals('j F', \LangCountry::dateBirthdayFormat());
        $this->assertEquals('10 maart', \LangCountry::dateBirthday($this->test_date));
        $this->assertEquals('H:i', \LangCountry::timeFormat());
        $this->assertEquals('13:05', \LangCountry::time($this->test_date));
        $this->assertEquals('🇳🇱', \LangCountry::emojiFlag());
        $this->assertEquals('EUR', \LangCountry::currencyCode());
        $this->assertEquals('€', \LangCountry::currencySymbol());
        $this->assertEquals('€', \LangCountry::currencySymbolLocal());
        $this->assertEquals('Euro', \LangCountry::currencyName());
        $this->assertEquals('Euro', \LangCountry::currencyNameLocal());

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
                    'currency_name' =>'Pound Stirling',
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
        $this->assertEquals($expected, \LangCountry::langSelectorHelper());
    }

    /**
     * @group lang_country_test
     * @test
     */
    public function it_returns_the_right_values_for_en_US()
    {
        session(['lang_country' => 'en-US']);
        App::setLocale('en');

        $this->assertEquals('US', \LangCountry::country());
        $this->assertEquals('United States of America', \LangCountry::countryName());
        $this->assertEquals('America', \LangCountry::countryNameLocal());
        $this->assertEquals('en', \LangCountry::lang());
        $this->assertEquals('American English', \LangCountry::name());
        $this->assertEquals('m/d/Y', \LangCountry::dateNumbersFormat());
        $this->assertEquals('03/10/2018', \LangCountry::dateNumbers($this->test_date));
        $this->assertEquals('MM/DD/YYYY', \LangCountry::dateNumbersFullCapitalsFormat());
        $this->assertEquals('F jS Y', \LangCountry::dateWordsWithoutDayFormat());
        $this->assertEquals('March 10th 2018', \LangCountry::dateWordsWithoutDay($this->test_date));
        $this->assertEquals('l F jS Y', \LangCountry::dateWordsWithDayFormat());
        $this->assertEquals('Saturday March 10th 2018', \LangCountry::dateWordsWithDay($this->test_date));
        $this->assertEquals('F jS', \LangCountry::dateBirthdayFormat());
        $this->assertEquals('March 10th', \LangCountry::dateBirthday($this->test_date));
        $this->assertEquals('h:i a', \LangCountry::timeFormat());
        $this->assertEquals('01:05 pm', \LangCountry::time($this->test_date));
        $this->assertEquals('🇺🇸', \LangCountry::emojiFlag());
        $this->assertEquals('USD', \LangCountry::currencyCode());
        $this->assertEquals('$', \LangCountry::currencySymbol());
        $this->assertEquals('US$', \LangCountry::currencySymbolLocal());
        $this->assertEquals('Dollar', \LangCountry::currencyName());
        $this->assertEquals('US Dollar', \LangCountry::currencyNameLocal());

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
        $this->assertEquals($expected, \LangCountry::langSelectorHelper());
    }

    /**
     * @group lang_country_test
     * @test
     */
    public function it_returns_the_right_values_for_en_US_while_session_is_nl_NL_but_is_overruled()
    {
        session(['lang_country' => 'nl-NL']);
        App::setLocale('nl');

        $this->assertEquals('03/10/2018', \LangCountry::dateNumbers($this->test_date, 'en-US'));
        $this->assertEquals('March 10th 2018', \LangCountry::dateWordsWithoutDay($this->test_date, 'en-US'));
        $this->assertEquals('Saturday March 10th 2018', \LangCountry::dateWordsWithDay($this->test_date, 'en-US'));
        $this->assertEquals('March 10th', \LangCountry::dateBirthday($this->test_date, 'en-US'));
        $this->assertEquals('01:05 pm', \LangCountry::time($this->test_date, 'en-US'));
    }

    /**
     * @group lang_country_test
     * @test
     */
    public function it_returns_all_the_availeble_languages()
    {
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
        $this->assertEquals(collect($expected), \LangCountry::allLanguages());
    }

    /** @test */
    public function it_uses_the_override_when_available()
    {
        session(['lang_country' => 'nl-NL']);
        App::setLocale('nl');

        $file = __DIR__.'/../Support/Files/lang-country-overrides/nl-NL.json';
        $dir = resource_path('lang/lang-country-overrides/');

        if (!is_dir($dir)) {
            mkdir($dir);
        }
        if (!is_file($dir)) {
            $dest = $dir.'nl-NL.json';
        }

        copy($file, $dest);

        $this->assertEquals('nl', \LangCountry::lang());
        $this->assertEquals('NL', \LangCountry::country());
        $this->assertEquals('Nederlands override!', \LangCountry::name());

        // Remove test files from testbench
        unlink(resource_path('lang/lang-country-overrides/').'nl-NL.json');
        rmdir(resource_path('lang/lang-country-overrides/'));
    }

    /**
     * @test
     */
    public function get_the_language_for_an_overrided_lang_country_code()
    {
        session(['lang_country' => 'nl-NL']);
        App::setLocale('nl');

        $this->assertEquals('en', \LangCountry::lang('en-US'));
    }
}
