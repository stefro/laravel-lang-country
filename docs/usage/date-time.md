---
outline: deep
---

# Date/time helpers

Below you can find all the date/time helpers that are available in this package through the `LangCountry` facade.

### Only numbers

Returns a **date string** with only numbers and the separator that is used in the country.
You should provide a Carbon instance.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateNumbers($post->created_at); // Will return "27-09-2023"

// When the lang_country session is "en-US"
LangCountry::dateNumbers($post->created_at); // Will return "09/27/2023"

// When the lang_country session is "de-DE"
LangCountry::dateNumbers($post->created_at); // Will return "27.09.2023"
```

### Only numbers (string format)

Returns a **string format representation** with only numbers and the separator that is used in the
country.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateNumbersFormat(); // Will return "d-m-Y"

// When the lang_country session is "en-US"
LangCountry::dateNumbersFormat(); // Will return "m/d/Y"

// When the lang_country session is "de-DE"
LangCountry::dateNumbersFormat(); // Will return "d.m.Y"
```

### Only numbers full capital (string format)

Returns a **string format representation** with only capitals, a lot of javascript dates electors use this format.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateNumbersFullCapitalFormat(); // Will return "DD-MM-YYYY"

// When the lang_country session is "en-US"
LangCountry::dateNumbersFullCapitalFormat(); // Will return "MM/DD/YYYY"

// When the lang_country session is "de-DE"
LangCountry::dateNumbersFullCapitalFormat(); // Will return "DD.MM.YYYY"
```

### Only words, without day

Returns a **date string** with only words and without the day.
You should provide a Carbon instance.

```php

// When the lang_country session is "nl-NL"
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "27 september 2023"

// When the lang_country session is "en-US"
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "September 27th 2023"

// When the lang_country session is "fr-FR"
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "27 septembre 2023"
```

### Only words, without day (string format)

Returns a **string format representation** with only words and without the day.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateWordsWithoutDayFormat(); // Will return "j F Y"

// When the lang_country session is "en-US"
LangCountry::dateWordsWithoutDayFormat(); // Will return "F jS Y"

// When the lang_country session is "de-DE"
LangCountry::dateWordsWithoutDayFormat(); // Will return "j F Y"
```

### Only words, with day

Returns a **date string** with only words and with the day.
You should provide a Carbon instance.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateWordsWithDay($post->created_at); // Will return "woensdag 27 september 2023"

// When the lang_country session is "en-US"
LangCountry::dateWordsWithDay($post->created_at); // Will return "Wednesday September 27th 2023"

// When the lang_country session is "fr-FR"
LangCountry::dateWordsWithDay($post->created_at); // Will return "mercredi 27 septembre 2023"
```

### Only words, with day (string format)

Returns a **string format representation** with only words and with the day.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateWordsWithDayFormat(); // Will return "l j F Y"

// When the lang_country session is "en-US"
LangCountry::dateWordsWithDayFormat(); // Will return "l F jS Y"

// When the lang_country session is "de-DE"
LangCountry::dateWordsWithDayFormat(); // Will return "l j F Y"
```

### Birthday

Returns a **birthday string representation** that is used in the country.
You should provide a Carbon instance.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateBirthday($user->date_of_birth); // Will return "27 september"

// When the lang_country session is "en-US"
LangCountry::dateBirthday($user->date_of_birth); // Will return "September 27th"
```

### Birthday (string format)

Returns a **birthday string format representation** that is used in the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::dateBirthdayFormat(); // Will return "j F"

// When the lang_country session is "en-US"
LangCountry::dateBirthdayFormat(); // Will return "F jS"
```

### Time

Returns a **time string representation** that is used in the country.
You should provide a Carbon instance.

```php
// When the lang_country session is "nl-NL"
LangCountry::time($post->created_at); // Will return "12:00"

// When the lang_country session is "en-US"
LangCountry::time($post->created_at); // Will return "12:00 pm"

// When the lang_country session is "fr-FR"
LangCountry::time($post->created_at); // Will return "12:00"
```

::: tip
You can pass a second argument to override the lang_country. This can be helpful in some cases where you don't want to
use the current lang_country that is stored in the session.
:::

### Time (string format)

Returns a **time string format representation** that is used in the country.

```php
// When the lang_country session is "nl-NL"
LangCountry::timeFormat(); // Will return "H:i"

// When the lang_country session is "en-US"
LangCountry::timeFormat(); // Will return "h:i a"

// When the lang_country session is "fr-FR"
LangCountry::timeFormat(); // Will return "H:i"
```
