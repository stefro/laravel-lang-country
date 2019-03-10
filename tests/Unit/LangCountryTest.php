<?php

namespace InvolvedGroup\LaravelLangCountry\Tests\Unit;

use App;
use Carbon\Carbon;
use Jenssegers\Date\Date;
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
        Date::setLocale('nl');

        $this->assertEquals('nl', \LangCountry::lang());
        $this->assertEquals('NL', \LangCountry::country());
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

        $expected = [
            'current' => [
                'lang' => 'nl',
                'country' => 'NL',
                'name' => 'Nederlands',
                'lang_country' => 'nl-NL',
                'emoji_flag' => '🇳🇱',
            ],
            'available' => [
                [
                    'lang' => 'nl',
                    'country' => 'BE',
                    'name' => 'België - Vlaams',
                    'lang_country' => 'nl-BE',
                    'emoji_flag' => '🇧🇪',
                ],
                [
                    'lang' => 'en',
                    'country' => 'GB',
                    'name' => 'English',
                    'lang_country' => 'en-GB',
                    'emoji_flag' => '🇬🇧',
                ],
                [
                    'lang' => 'en',
                    'country' => 'US',
                    'name' => 'English',
                    'lang_country' => 'en-US',
                    'emoji_flag' => '🇺🇸',
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
        Date::setLocale('en');

        $this->assertEquals('en', \LangCountry::lang());
        $this->assertEquals('US', \LangCountry::country());
        $this->assertEquals('English', \LangCountry::name());
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

        $expected = [
            'current' => [
                'lang' => 'en',
                'country' => 'US',
                'name' => 'English',
                'lang_country' => 'en-US',
                'emoji_flag' => '🇺🇸',
            ],
            'available' => [
                [
                    'lang' => 'nl',
                    'country' => 'NL',
                    'name' => 'Nederlands',
                    'lang_country' => 'nl-NL',
                    'emoji_flag' => '🇳🇱',
                ],
                [
                    'lang' => 'nl',
                    'country' => 'BE',
                    'name' => 'België - Vlaams',
                    'lang_country' => 'nl-BE',
                    'emoji_flag' => '🇧🇪',
                ],
                [
                    'lang' => 'en',
                    'country' => 'GB',
                    'name' => 'English',
                    'lang_country' => 'en-GB',
                    'emoji_flag' => '🇬🇧',
                ],
            ],
        ];
        $this->assertEquals($expected, \LangCountry::langSelectorHelper());
    }

    /** @test */
    public function it_uses_the_override_when_available()
    {
        session(['lang_country' => 'nl-NL']);
        App::setLocale('nl');
        Date::setLocale('nl');

        $file = __DIR__.'/../Support/Files/lang-country-overrides/nl-NL.json';

        mkdir(resource_path('lang/lang-country-overrides/'));
        $dest = resource_path('lang/lang-country-overrides/').'nl-NL.json';
        copy($file, $dest);

        $this->assertEquals('nl', \LangCountry::lang());
        $this->assertEquals('NL', \LangCountry::country());
        $this->assertEquals('Nederlands override!', \LangCountry::name());

        // Remove test files from testbench
        unlink(resource_path('lang/lang-country-overrides/').'nl-NL.json');
        rmdir(resource_path('lang/lang-country-overrides/'));
    }
}
