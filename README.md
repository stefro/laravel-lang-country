# LaravelLangCountry

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

# Important!

This package is Laravel 7+!
For use with earlier versions please use version 1.

## TL;DR

Setting the locale is not enough most of the time, some countries use more than one languages. Also, different countries
use different date notation formats. This package is here to help you with that!
In a nutshell:

* You can set all supported lang_country of your choice in the settings.
* It will make smart fallback.
* You can now show dates not only translated, but also in the right format! (example: jan 1st 2018; 1 jan 2018. Both the
  same date, both translated, but every country has a different order).
* It will help you to show the right flag in your language switcher (because you now also have a country value, not only
  a language value).
* We'll assume you're using Translation Strings As
  Keys ([Using Translation Strings As Keys](https://laravel.com/docs/5.6/localization#using-translation-strings-as-keys))

I've also written an article about
it [here](https://stefrouschop.nl/why-a-locale-is-sometimes-not-enough-in-laravel-28b1e82029cc).

## Install

You can install this package via composer using this command:

``` bash
$ composer require involved-group/laravel-lang-country
```

The package will automatically register itself.

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="Stefro\LaravelLangCountry\LaravelLangCountryServiceProvider" --tag="config"
```

Set the middleware. Add this in your `app\Http\Kernel.php` file to the $middlewareGroups web property:

``` php
protected $middlewareGroups = [
    'web' => [
        ....
        'lang_country'
    ],
```

As soon as you run the migration, a `lang_country` column will be set for your User table. The migration will be load
through the service provider of the package, so you don't need to publish it first.

``` php
php artisan migrate
```

Make sure your `lang_country` on your User model can be stored by adding it to the $fillable property. Example:

``` php
protected $fillable = [
    'firstname', 'lastname', 'email', 'password', 'lang_country'
];
```

To make sure this will be loaded and stored in the session add this to method to
your `app\Http\Controllers\Auth\LoginController.php`:

```
public function authenticated(Request $request, $user)
{
    // Set the right sessions
    if (null != $user->lang_country) {
        \LangCountry::setAllSessions($user->lang_country);
    }

    return redirect()->intended($this->redirectPath());
}
```

**That's all folks!**

## What will it do?

For each user or guest it will create a four character `lang_country` code. For guests it will try to make a perfect
match based on the browser settings. For users, it will load the last used `lang_country`, because we will store it in
the DB.

**There will ALWAYS be two sessions set:**

- `lang_country` (example: `nl-BE`)
- `locale` (examples: `nl`, `es-CO`)

When a user will log in to your app, it will load the last `lang_country` and set the sessions accordingly.

## How to switch lang_country

There is a named route you can use that takes the new lang_country as a parameter:

``` php
route('lang_country.switch', ['lang_country' => 'nl-BE'])
```

It will first check if the requested `lang_country` is in your `allowed` list of your config file. When so, it will
change all the sessions accordingly. When it detects there is a logged in User, it will also set the `lang_country` to
the database.

It's really easy to create a language selector! You can use `LangCountry::langSelectorHelper()`.
This will output for example:

``` php
Array
(
    [available] => Array
        (
            [0] => Array
                (
                    [country] => NL
                    [country_name] => The Netherlands
                    [country_name_local] => Nederlands
                    [lang] => nl
                    [name] => Nederlands
                    [lang_country] => nl-NL
                    [emoji_flag] => 🇳🇱
                    [currency_code] => EUR
                    [currency_symbol] => €
                    [currency_symbol_local] => €
                    [currency_name] => Euro
                    [currency_name_local] => Euro
                )

            [1] => Array
                (
                    [country] => BE
                    [country_name] => The Netherlands
                    [country_name_local] => Nederlands
                    [lang] => nl
                    [name] => België - Vlaams
                    [lang_country] => nl-BE
                    [emoji_flag] => 🇧🇪
                    [currency_code] => EUR
                    [currency_symbol] => €
                    [currency_symbol_local] => €
                    [currency_name] => Euro
                    [currency_name_local] => Euro
                )

            [2] => Array
                (
                    [country] => GB
                    [country_name] => United Kingdom
                    [country_name_local] => United Kingdom
                    [lang] => en
                    [name] => English
                    [lang_country] => en-GB
                    [emoji_flag] => 🇬🇧
                    [currency_code] => GBP
                    [currency_symbol] => £
                    [currency_symbol_local] => £
                    [currency_name] => Pound Stirling
                    [currency_name_local] => Pound
                )

            [3] => Array
                ( 
                    [country] => CA
                    [country_name] => Canada
                    [country_name_local] => Canada
                    [lang] => en
                    [name] => Canadian English
                    [lang_country] => en-CA
                    [emoji_flag] => 🇨🇦
                    [currency_code] => CAD
                    [currency_symbol] => $
                    [currency_symbol_local] => CA$
                    [currency_name] => Dollar
                    [currency_name_local] => Canadian Dollar
                )

        )

    [current] => Array
        (
            [country] => US
            [country_name] => United States of America
            [country_name_local] => America
            [lang] => en
            [name] => Amreican English
            [lang_country] => en-US
            [emoji_flag] => 🇺🇸
            [currency_code] => USD
            [currency_symbol] => $
            [currency_symbol_local] => US$
            [currency_name] => Dollar
            [currency_name_local] => US Dollar
        )

)
```

With this array you're able to create a simple language/country switcher like this in your own frontend framework of
choice:

<p align="center">
  <img width="350" src="https://Stefro.github.io/laravel-lang-country/lang_switcher.png">
</p>

## Usage

### Available methods

``` php
use Stefro\LaravelLangCountry\LangCountry

LangCountry::allLanguages();
/*
 * It will return a collection with all the available languages with all propperties of that language.
 */
 
LangCountry::langSelectorHelper();
/*
 * It will return an array with the current language, country and name
 * and also the other available language, country and name.
 */

LangCountry::currencyCode();
/*
 * This will return the ISO-4217 of the country in this file .
 * Example: "EUR" when lang_country = "nl-NL"
 * Example: "COP" when lang_country = "es-CO"
 */

LangCountry::currencySymbol();
/*
 * This will return the symbol of the officially regognised (primary) currency of the country in this file .
 * Example: "€" when lang_country = "nl-NL"
 * Example: "$" when lang_country = "es-CO"
 */

LangCountry::currencySymbolLocal();
/*
 * This will return the `localized` symbol of the officially regognised (primary) currency of the country in this file .
 * Example: "AU$" when lang_country = "en-AU"
 * Example: "COP$" when lang_country = "es-CO"
 */

LangCountry::currencyName();
/*
 * This will return the `localized` name of the officially regognised (primary) currency of the country in this file .
 * Example: "Dollar" when lang_country = "en-AU"
 * Example: "Dollar" when lang_country = "en-Au"
 */

LangCountry::currencyNameLocal();
/*
 * This will return the `localized` name of the officially regognised (primary) currency of the country in this file .
 * Example: "Australian Dollar" when lang_country = "en-AU"
 * Example: "US Dollar" when lang_country = "en-US"
 */
```

## What does the middleware do?

The middleware is optional. Of course you can create your own middleware with a different approach. But this is what our
“out of the box” middleware does:

* It will check the users browser language preferences. Then it will try to make the most perfect match to the `allowed`
  lang_country’s in your settings file.
* When no perfect match (language AND country) it will try to make a match on language only.
* When still no match, it will return to your fallback setting.
* It will ALWAYS store a `lang_country` session.
* When a lang_country is already set, it will not run any unnecessary scripts.
* Based on the `lang_country` it will check your `resources/lang/` folder for an exact match in your json translation
  files (example es_CO). If an exact match is found it will set the Laravel Locale to this value. This way you’re able
  to create different translation files for each country if you need it.
* When no exact match, it will set the Laravel Locale to the language only.

## Override lang-country properties

Don't like the default settings for a lang-country? Create a `lang-country-overrides` directory in your laravel '
resources/lang' directory.
Place a new .json file (example: nl-NL.json) in this directory with your preferred properties. This file will override
the package .json file.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ phpunit
```

## How can I help?

Glad your asking! We can always use some more country info in this package. Copy the `_template.json` file in
the `src/LangCountryData` direcory and fill in the blanks. You can then make a PR.
Some good resources:

* [http://www.localeplanet.com/icu/index.html](http://www.localeplanet.com/icu/index.html)
* [https://gist.github.com/mlconnor/1887156](https://gist.github.com/mlconnor/1887156)
* [http://www.lingoes.net/en/translator/langcode.htm](http://www.lingoes.net/en/translator/langcode.htm)
* [https://emojipedia.org/flags/](https://emojipedia.org/flags/)

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## ToDo

* Caching to reduce file lookups.

## Security

If you discover any security related issues, please email github@rouschop.com instead of using the issue tracker.

## Credits

- [Stef Rouschop](https://github.com/stefro)
- [Jayenne Montana](https://github.com/jayenne): For adding local country names and currency.
- Ronald Huijgen: Background vocals, choreography and funny business.
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/involved-group/laravel-lang-country.svg?style=flat-square

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[ico-travis]: https://img.shields.io/travis/Stefro/laravel-lang-country/master.svg?style=flat-square

[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Stefro/laravel-lang-country.svg?style=flat-square

[ico-code-quality]: https://img.shields.io/scrutinizer/g/Stefro/laravel-lang-country.svg?style=flat-square

[ico-downloads]: https://img.shields.io/packagist/dt/involved-group/laravel-lang-country.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/involved-group/laravel-lang-country

[link-travis]: https://travis-ci.org/Stefro/laravel-lang-country

[link-scrutinizer]: https://scrutinizer-ci.com/g/Stefro/laravel-lang-country/code-structure

[link-code-quality]: https://scrutinizer-ci.com/g/Stefro/laravel-lang-country

[link-downloads]: https://packagist.org/packages/involved-group/laravel-lang-country

[link-author]: https://github.com/stefro

[link-contributors]: ../../contributors
