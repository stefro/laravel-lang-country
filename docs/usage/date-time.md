---
outline: deep
---

# Date/time helpers

### Date numbers

Returns **date string** with only numbers and the separator that is used in the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateNumbers($post->created_at); // Will return "27-09-2023"

// When the lang_country session is "en-US"
LangCountry::dateNumbers($post->created_at); // Will return "09/27/2023"

// When the lang_country session is "de-DE"
LangCountry::dateNumbers($post->created_at); // Will return "27.09.2023"
```

### Date numbers format

Returns **string format representation** with only numbers and the separator that is used in the
country.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateNumbersFormat(); // Will return "d-m-Y"

// When the lang_country session is "en-US"
LangCountry::dateNumbersFormat(); // Will return "m/d/Y"

// When the lang_country session is "de-DE"
LangCountry::dateNumbersFormat(); // Will return "d.m.Y"
```
