---
outline: deep
---

# Language and locale helpers

Below you can find all the language and locale helpers that are available in this package through the `LangCountry`
facade.

### Country

This will return the **two character ISO-3166** code representation of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::country(); // Will return "NL"

// When the lang_country session is "en-GB"
LangCountry::country(); // Will return "GB"
```

### Country name (English)

This will return the **English** name of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::countryName(); // Will return "The Netherlands"

// When the lang_country session is "en-GB"
LangCountry::countryName(); // Will return "United Kingdom"
```

### Country name (local)

This will return the **local** name of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::countryNameLocal(); // Will return "Nederland"

// When the lang_country session is "nl-BE"
LangCountry::countryNameLocal(); // Will return "België"

// When the lang_country session is "fr-BE"
LangCountry::countryNameLocal(); // Will return "Belgique"
```

### Language

This will return the **two character ISO-639** code representation of the language or a four char representation.

```php
// When the lang_country session is "nl-NL"
LangCountry::lang(); // Will return "nl"

// When the lang_country session is "en-GB"
LangCountry::lang(); // Will return "en"
```

::: tip
You can pass a second argument to override the lang_country. This can be helpful in some cases where you don't want to
use the current lang_country that is stored in the session.

```php
// When the lang_country session is "nl-NL"
LangCountry::lang('fr-BE'); // Will return "fr"
```

:::

### Language name (local)

This will return the name of the language **translated in the language in question**. You can use this for nice
country-selectors in your app.

```php
// When the lang_country session is "de-CH"
LangCountry::name(); // Will return "Schweiz - Deutsch"

// When the lang_country session is "nl-BE"
LangCountry::name(); // Will return "België - Vlaams"

// When the lang_country session is "fr-BE"
LangCountry::name(); // Will return "Belgique - Français"
```

### Emoji flag

This will return the emoji flag of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::emojiFlag(); // Will return "🇳🇱"

// When the lang_country session is "en-GB"
LangCountry::emojiFlag(); // Will return "🇬🇧"
```

### All available languages

This will return a Collection with all the available languages including their properties that are set in the config
file
under `allowed`.

```php
LangCountry::availableLanguages(); 
// Will return a Collection with all the available languages
Illuminate\Support\Collection {
    all: [
      [
        "country" => "NL",
        "country_name" => "The Netherlands",
        "country_name_local" => "Nederland",
        "lang" => "nl",
        "name" => "Nederlands",
        "lang_country" => "nl-NL",
        "emoji_flag" => "🇳🇱",
        "currency_code" => "EUR",
        "currency_symbol" => "€",
        "currency_symbol_local" => "€",
        "currency_name" => "Euro",
        "currency_name_local" => "Euro",
      ],
      [
        "country" => "BE",
        "country_name" => "Belgium",
        "country_name_local" => "België",
        "lang" => "nl",
        "name" => "België - Vlaams",
        "lang_country" => "nl-BE",
        "emoji_flag" => "🇧🇪",
        "currency_code" => "EUR",
        "currency_symbol" => "€",
        "currency_symbol_local" => "€",
        "currency_name" => "Euro",
        "currency_name_local" => "Euro",
      ],
      //...
  ]
 }
```

### Language selector helper

This will return an array with the current language, country and name and also the other available (set in config file
under `allowed`) language, country and name.

```php
LangCountry::langSelectorHelper();
// Will return an array with all the available languages
[
    "current" => [
      "country" => "NL",
      "country_name" => "The Netherlands",
      "country_name_local" => "Nederland",
      "lang" => "nl",
      "name" => "Nederlands",
      "lang_country" => "nl-NL",
      "emoji_flag" => "🇳🇱",
      "currency_code" => "EUR",
      "currency_symbol" => "€",
      "currency_symbol_local" => "€",
      "currency_name" => "Euro",
      "currency_name_local" => "Euro",
    ],
    "available" => [
      [
        "country" => "BE",
        "country_name" => "Belgium",
        "country_name_local" => "België",
        "lang" => "nl",
        "name" => "België - Vlaams",
        "lang_country" => "nl-BE",
        "emoji_flag" => "🇧🇪",
        "currency_code" => "EUR",
        "currency_symbol" => "€",
        "currency_symbol_local" => "€",
        "currency_name" => "Euro",
        "currency_name_local" => "Euro",
      ],
      [
        "country" => "BE",
        "country_name" => "Belgium",
        "country_name_local" => "Belgique",
        "lang" => "fr",
        "name" => "Belgique - Français",
        "lang_country" => "fr-BE",
        "emoji_flag" => "🇧🇪",
        "currency_code" => "EUR",
        "currency_symbol" => "€",
        "currency_symbol_local" => "€",
        "currency_name" => "Euro",
        "currency_name_local" => "Euro",
      ],
      [
        "country" => "GB",
        "country_name" => "United Kingdom",
        "country_name_local" => "United Kingdom",
        "lang" => "en",
        "name" => "English",
        "lang_country" => "en-GB",
        "emoji_flag" => "🇬🇧",
        "currency_code" => "GBP",
        "currency_symbol" => "£",
        "currency_symbol_local" => "£",
        "currency_name" => "Pound Stirling",
        "currency_name_local" => "Pound",
      ],
      
      //...
]
```
