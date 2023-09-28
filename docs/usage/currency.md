---
outline: deep
---

# Currency helpers

### Currency ISO-4217 code if the country

This will return the **three character ISO-4217** code representation of the currency of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::currencyCode(); // Will return "EUR"

// When the lang_country session is "en-GB"
LangCountry::currencyCode(); // Will return "GBP"
```

### Currency symbol of the country

This will return the **currency symbol** of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::currencySymbol(); // Will return "€"

// When the lang_country session is "en-GB"
LangCountry::currencySymbol(); // Will return "£"
```

### Currency symbol of the country (local)

This will return the `localized` symbol of the officially recognised (primary) currency of the country.

```php
// When the lang_country session is "es-CO"
LangCountry::currencySymbolLocal(); // Will return "COP$"

// When the lang_country session is "en-CA"
LangCountry::currencySymbolLocal(); // Will return "CA$"
```

### Currency name of the country

This will return the **currency name** of the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::currencyName(); // Will return "Euro"

// When the lang_country session is "en-GB"
LangCountry::currencyName(); // Will return "Pound Stirling"

// When the lang_country session is "es-CO"
LangCountry::currencyName(); // Will return "Peso"

// When the lang_country session is "en-CA"
LangCountry::currencyName(); // Will return "Canadian Dollar"
```

### Currency name of the country (local)

This will return the `localized` name of the officially recognised (primary) currency of the country.

```php
// When the lang_country session is "en-AU"
LangCountry::currencyNameLocal(); // Will return "Australian Dollar"

// When the lang_country session is "lt-LT"
LangCountry::currencyNameLocal(); // Will return "Euras"
```
