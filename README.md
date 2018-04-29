# LaravelLangCountry

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## TL;DR
Setting the locale is not enough most of the time, some countries use more than one langages. Also, different countries use different date notation formats. This package is here to help you with that!
In a nutshell:

* You can set all supported lang/country of your choice in the settings.
* It will make smart fallbacks.
* It will help you set the right locale for the awesome [Date](https://github.com/jenssegers/date) package.
* You can now show dates not only translated, but also in the right format! (example: jan 1th 2018; 1 jan 2018. Both the same date, both translated, but every country has a different order).
* It will help you to show the right flag in your language switcher (because you now also have a country value, not only a language value).
* We'll assume you're using Translation Strings As Keys ([Using Translation Strings As Keys](https://laravel.com/docs/5.6/localization#using-translation-strings-as-keys))


## Install

You can install this package via composer using this command:

``` bash
$ composer require involved-group/laravel-lang-country
```
The package will automatically register itself.

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="InvolvedGroup\LaravelLangCountry\LaravelLangCountryServiceProvider" --tag="config"
```

Set the middleware. Add this in your `app\Http\Kernel.php` file to the $middlewareGroups web property:

``` php
protected $middlewareGroups = [
    'web' => [
        ....
        'lang_country'
    ],
```

As soon as you run the migration, a `lang_country` column will be set for your User table. The migration will be load through the service provider of the package, so you don't need to publish it first.

``` php
php artisan migrate
```
Make sure your `lang_country` on your User model can be stored by adding it to the $fillable property. Example:

``` php
protected $fillable = [
    'firstname', 'lastname', 'email', 'password', 'lang_country'
];
```

To make sure this will be loaded and stored in the session add this to method to your `app\Http\Controllers\Auth\LoginController.php`:

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

**Thats all!**

## Usage


### Available methods

``` php
use InvolvedGroup\LaravelLangCountry\LangCountry

LangCountry::lang();
/* 
 * The path where to store temporary files while performing image conversions.
 * If set to null, storage_path('medialibrary/temp') will be used.
 * This will return the right language. This can be a two char representation 
 * (example: "nl", dutch) or a four char representation (example: es_CO; Spanish-colombian)
 */ 

LangCountry::country();
/*
 * This will return the two character code representation of the country.
 * Example: "NL" when lang_country = "nl-NL"
 * Example: "BE" when lang_country = "nl-BE"
 */

LangCountry::name();
/*
 * This will return the name of the language TRANSLATED IN THE LANGUAGE IN QUESTION.
 * You can use this for nice country-selectors in your app.
 * Example: "English" when lang_country = "en-US"
 * Example: 'België - Vlaams' when lang_country = "nl-BE"
 */

LangCountry::dateNumbersFormat();
/*
 * Returns string representation of the dateformat with only numbers.
 * Example: "m/d/Y" when lang_country = "en-US"
 * Example: "d/m/Y" when lang_country = "nl-NL"
 */

LangCountry::dateNumbers($blog->post->created_at);
/*
 * You should provide the date as a Carbon instance;
 * It will return the date as a string in the format for this country.
 * Example: "04/24/2018" when lang_country = "en-US"
 * Example: "24/04/2018" when lang_country = "nl-NL"
 */

LangCountry::dateNumbersFullCapitalsFormat();
/*
 * Returns string representation of the dateformat with only capitals, some javascript dateselectors use this.
 * Example: "MM/DD/YYYY" when lang_country = "en-US"
 * Example: "DD-MM-YYYY" when lang_country = "nl-NL"
 */
     
LangCountry::dateWordsWithoutDayFormat();
/*
 * Returns string representation of the dateformat with words but without the day.
 * Example: "F jS Y" when lang_country = "en-US"
 * Example: "j F Y" when lang_country = "nl-NL"
 */

LangCountry::dateWordsWithoutDay($blog->post->created_at);
/*
 * You should provide the date as a Carbon instance;
 * It will return the date in words but without the day.
 * Example: "April 24th 2018" when lang_country = "en-US"
 * Example: "24 april 2018" when lang_country = "nl-NL"
 */

LangCountry::dateWordsWithDayFormat();
/*
 * String representation of the dateformat with words including the day.
 * Example: "l F jS Y" when lang_country = "en-US"
 * Example: "l j F Y" when lang_country = "nl-NL"
 */

LangCountry::dateWordsWithDay($blog->post->created_at);
/*
 * You should provide the date as a Carbon instance;
 * It will return the date in words including the day.
 * Example: "Tuesday April 24th 2018" when lang_country = "en-US"
 * Example: "dinsdag 24 april 2018" when lang_country = "nl-NL"
 */

LangCountry::dateBirthdayFormat();
/*
 * String representation of the dateformat for a birthday.
 * Example: "F jS" when lang_country = "en-US"
 * Example: "j F" when lang_country = "nl-NL"
 */

LangCountry::dateBirthday($user->birthday);
/*
 * You should provide the date as a Carbon instance;
 * It will return the a birthday date.
 * Example: "April 24th" when lang_country = "en-US"
 * Example: "24 april" when lang_country = "nl-NL"
 */

LangCountry::timeFormat();
/*
 * Returns string representation of the timeformat.
 * Example: "h:i a" when lang_country = "en-US"
 * Example: "H:i" when lang_country = "nl-NL"
 */

LangCountry::time($whatever->time);
/*
 * You should provide the time as a Carbon instance;
 * It will return the formatted time.
 * Example: "1:00 pm" when lang_country = "en-US"
 * Example: "13:00" when lang_country = "nl-NL"
 */

LangCountry::langSelectorHelper();
/*
 * It will return a collection with the current language, country and name
 * and also the other available language, country and name.
 */
```

## What does the middleware do?
The middleware is optional. Of course you can create your own middleware with a different approach. But this is what our “out of the box” middleware does:

* It will check the users browser language preferences. Then it will try to make the most perfect match to the `allowed` lang_country’s in your settings file. 
* When no perfect match (language AND country) it will try to make a match on language only. 
* When still no match, it will return to your fallback setting.
* It will ALWAYS store a `lang_country` session.
* When a lang_country is already set, it will not run any unnecessary scripts.
* Based on the `lang_country` it will check your `resources/lang/` folder for an exact match in your json translation files (example es_CO). If an exact match is found it will set the Laravel Locale to this value. This way you’re able to create different translation files for each country if you need it. 
* When no exact match, it will set the Laravel Locale to the language only. 
* It will set the locale for the [Date](https://github.com/jenssegers/date) package. 

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ phpunit
```

## How can I help?
Glad your asking! We can always use some more country info in this package. Copy the `_template.json` file in the `src/LangCountryData` direcory and fill in the blanks. You can then make a PR.
Some good resources:

* [http://www.localeplanet.com/icu/index.html](http://www.localeplanet.com/icu/index.html)
* [https://gist.github.com/mlconnor/1887156](https://gist.github.com/mlconnor/1887156)
* [http://www.lingoes.net/en/translator/langcode.htm](http://www.lingoes.net/en/translator/langcode.htm)

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email stef.rouschop@involvedgroup.eu instead of using the issue tracker.

## Credits

- [Stef Rouschop](https://github.com/stefro)
- [Jens Segers](https://github.com/jenssegers), For his awesome [Date](https://github.com/jenssegers/date) package.
- Ronald Huijgen: Background vocals, choreography and funny business.
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/InvolvedGroup/LaravelLangCountry.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/InvolvedGroup/LaravelLangCountry/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/InvolvedGroup/LaravelLangCountry.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/InvolvedGroup/LaravelLangCountry.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/InvolvedGroup/LaravelLangCountry.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/InvolvedGroup/LaravelLangCountry
[link-travis]: https://travis-ci.org/InvolvedGroup/LaravelLangCountry
[link-scrutinizer]: https://scrutinizer-ci.com/g/InvolvedGroup/LaravelLangCountry/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/InvolvedGroup/LaravelLangCountry
[link-downloads]: https://packagist.org/packages/InvolvedGroup/LaravelLangCountry
[link-author]: https://github.com/stefro
[link-contributors]: ../../contributors
