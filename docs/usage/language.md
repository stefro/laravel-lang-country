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

### All 
