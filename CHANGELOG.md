# Changelog

All notable changes to `LaravelLangCountry` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](https://keepachangelog.com/) principles.

## Unreleased

* Make use of the `lang_path()` instead of the old Laravel `resources\lang` path.
* Drop support for < PHP 8.1
* Drop Support for < Laravel 9
* move to namespace `Stefro/LaravelLangCountry` from `InvolvedGroup/LaravelLangCountry`
* Prefered -> preferred typo changed in the entire codebase.
* Middleware has been changed to use the user lang_country when available.

## [2.1.0] - 2020-05-05

### Added

- LangCountryData.php : I've added 7 new properties to each file to distinguish between `language name`
  and `country name`. I have also added a `_local` option so the app can use the localised translation. I have also
  include the country's official currency too.

* `country_name` Added a default name of the country the app's primary demographic (e.g. `Spain`)
* `country_name_local` Added a localized name of the country in the language of this file (e.g. `España`)
* `currency_code` Added the ISO-4217 code for this country's primary/official currency (e.g. `USD`)
* `currency_symbol` Added a default symbol for this country's primary/official currency (e.g. `$`)
* `currency_symbol_local` Added a localized symbol for this country's primary/official currency (e.g. `US$`)
* `currency_name` Added a default name for this country's primary/official currency (e.g. `Dollar`)
* `currency_name_local` Added a localized name for this country's primary/official currency (e.g. `US Dollar`)

- laravel-lang-country.php : Included the full ISO-3166 list of countries as new `locale` options to the `allowed`
  array. This will make it simpler to enable/disable locales as they become available.
- 2018_04_29_074240_add_lang_country_column_to_users_table.php : Added a char limit of `5` to the `lang_country` column.
- langCountry.php : Added methods to return the data files new parameters.

* Added countryName()
* Added countryNameLocal()
* Added currencyCode()
* Added currencySymbol()
* Added currencySymbolLocal()
* Added currencyName()
* Added currencyNameLocal()

- LangCountryTest.php : Added new tests for each of the new methods and to reflect the changes to the data files.
- lang-country-overrides/nl.NL.json : included new parameters to reflect those made within LangCountryData/...json

### Deprecated

- Nothing

### Fixed

- phpunit.xml.dist : Fixed PhpUnit Warning "- Element 'log', attribute 'charset': The attribute 'charset' is not
  allowed."
- phpunit.xml.dist : Fixed PhpUnit Warning "- Element 'log', attribute 'yui': The attribute 'yui' is not allowed."
- phpunit.xml.dist : Fixed PhpUnit Warning "- Element 'log', attribute 'highlight': The attribute 'highlight' is not
  allowed."

### Amended

- README.md
- CHANGELOG.md

### Removed

- Nothing

### Security

- Nothing
