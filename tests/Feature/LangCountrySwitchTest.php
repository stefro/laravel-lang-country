<?php

namespace InvolvedGroup\LaravelLangCountry\Tests\Unit;

use Illuminate\Foundation\Auth\User;
use InvolvedGroup\LaravelLangCountry\Tests\TestCase;

class LangCountrySwitchTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Set config variables
        $this->app['config']->set('lang-country.fallback', 'en-GB');
        $this->app['config']->set('lang-country.allowed', [
            'nl-NL',
            'nl-BE',
            'en-GB',
            'en-US',
        ]);

        User::unguard();
        $this->user = User::create([
            'name' => 'Orchestra',
            'email' => 'hello@orchestraplatform.com',
            'password' => \Hash::make('456'),
            'lang_country' => null,
        ]);
        User::reguard();
    }

    /** @test */
    public function switch_for_non_logged_in_user()
    {
        // make first visit and verify fallback values are set
        $this->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
            ->assertStatus(200);
        $this->assertEquals('en-GB', session('lang_country'));
        $this->assertEquals('en', session('locale'));

        // visit switch route
        $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
            ->assertRedirect(route('test_route'));
        $this->assertEquals('nl-BE', session('lang_country'));
        $this->assertEquals('nl', session('locale'));
    }

    /** @test */
    public function switch_for_logged_in_user_without_lang_country_setting()
    {
        // make first visit and verify fallback values are set
        $this->actingAs($this->user)->get('test_route', ['HTTP_ACCEPT_LANGUAGE' => 'gr,zh-CH'])
            ->assertStatus(200);
        $this->assertEquals('en-GB', session('lang_country'));
        $this->assertEquals('en', session('locale'));

        // visit switch route
        $this->get(route('lang_country.switch', ['lang_country' => 'nl-BE']), ['HTTP_REFERER' => 'test_route'])
            ->assertRedirect(route('test_route'));
        $this->assertEquals('nl-BE', session('lang_country'));
        $this->assertEquals('nl', session('locale'));

        $this->assertEquals('nl-BE', $this->user->lang_country);
    }
}
