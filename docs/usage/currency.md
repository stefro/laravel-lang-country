---
outline: deep
---

# Currency helpers

### Currency ISO-4217 code if the country

This will return the **three character ISO-4217** code representation of the currency of the country.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::currencyCode(); // Will return "EUR"

session(['lang_country' => 'en-GB']);
LangCountry::currencyCode(); // Will return "GBP"
```

### Currency symbol of the country

This will return the **currency symbol** of the country.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::currencySymbol(); // Will return "€"

session(['lang_country' => 'en-GB']);
LangCountry::currencySymbol(); // Will return "£"
```

### Currency symbol of the country (local)

This will return the `localized` symbol of the officially recognised (primary) currency of the country.

```php
session(['lang_country' => 'es-CO']);
LangCountry::currencySymbolLocal(); // Will return "COP$"

session(['lang_country' => 'en-CA']);
LangCountry::currencySymbolLocal(); // Will return "CA$"
```

### Currency name of the country

This will return the **currency name** of the country.

```php
session(['lang_country' => 'nl-NL'])
LangCountry::currencyName(); // Will return "Euro"

session(['lang_country' => 'en-GB'])
LangCountry::currencyName(); // Will return "Pound Stirling"

session(['lang_country' => 'es-CO']);
LangCountry::currencyName(); // Will return "Peso"

session(['lang_country' => 'en-CA']);
LangCountry::currencyName(); // Will return "Canadian Dollar"
```

### Currency name of the country (local)

This will return the `localized` name of the officially recognised (primary) currency of the country.

```php
session(['lang_country' => 'en-AU']);
LangCountry::currencyNameLocal(); // Will return "Australian Dollar"

session(['lang_country' => 'lt-LT']);
LangCountry::currencyNameLocal(); // Will return "Euras"
```
