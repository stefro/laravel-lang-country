<?php

namespace Stefro\LaravelLangCountry\Tests\Unit;

use Stefro\LaravelLangCountry\Services\PreferredLanguage;
use Stefro\LaravelLangCountry\Tests\TestCase;

class LocaleForDateTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

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
    }

    /**
     * @group locale_for_date_test
     * @test
     */
    public function no_four_char_json_available_in_date_package_fallback_to_just_lang()
    {
        $lang = new PreferredLanguage('nl-NL');

        $this->assertEquals('nl', $lang->locale);
    }

    /**
     * @group locale_for_date_test
     * @test
     */
    public function no_match_fallback_to_date_package_fallback()
    {
        $lang = new PreferredLanguage('xx-XX');

        $this->assertEquals('en', $lang->locale);
    }
}
