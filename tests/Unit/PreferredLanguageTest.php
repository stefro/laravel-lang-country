<?php

namespace Stefro\LaravelLangCountry\Tests\Unit;

use Stefro\LaravelLangCountry\Services\PreferedLanguage;
use Stefro\LaravelLangCountry\Tests\TestCase;

class PreferredLanguageTest extends TestCase
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
        ]);
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function get_prefered_languages_in_right_order()
    {
        $lang = new PreferedLanguage('nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4,de;q=0.5');

        $expected = collect([
            'nl-NL' => 1.0,
            'nl'    => 0.8,
            'en-US' => 0.6,
            'de'    => 0.5,
            'en'    => 0.4,
        ]);

        $this->assertEquals($expected, $lang->clientPreferedLanguages());
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function prioritize_more_specific_values()
    {
        $lang = new PreferedLanguage('nl-NL,nl,en-US,en,de');
        $expected = collect([
            'nl-NL' => 1.0,
            'en-US' => 1.0,
            'nl'    => 1.0,
            'de'    => 1.0,
            'en'    => 1.0,
        ]);

        $this->assertEquals($expected, $lang->clientPreferedLanguages());
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function exact_match_with_allowed_lang_country()
    {
        $lang = new PreferedLanguage('gr,nl,de-DE,en');

        $this->assertEquals('de-DE', $lang->lang_country);
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function match_based_on_lang()
    {
        $lang = new PreferedLanguage('gr,nl,zh-CH,en');

        $this->assertEquals('nl-NL', $lang->lang_country);
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function no_match_return_fallback()
    {
        $lang = new PreferedLanguage('gr,zh-CH');

        $this->assertEquals('en-GB', $lang->lang_country);
    }

    /**
     * @group prefered_lang_test
     * @test
     */
    public function country_in_lowecase()
    {
        $lang = new PreferedLanguage('nl-nl,nl-be,gr');

        $this->assertEquals('nl-NL', $lang->lang_country);
    }
}
