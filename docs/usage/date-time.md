---
outline: deep
---

# Date (& time) helpers

Below you can find all the date helpers (that can also be chained to add time) that are available in this package
through the `LangCountry` facade or the Carbon macros.

::: tip Carbon Macros
On most IDE's, the Carbon Macros will be autocompleted.
:::

### Only numbers

Returns a **date string** with only numbers and the separator that is used in the country.
You should provide a Carbon instance.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateNumbers($post->created_at); // Will return "27-09-2023"
$post->created_at->langCountryDateNumbers(); // Will return "27-09-2023"

session(['lang_country' => 'en-US']);
LangCountry::dateNumbers($post->created_at); // Will return "09/27/2023"
$post->created_at->langCountryDateNumbers(); // Will return "09/27/2023"

session(['lang_country' => 'de-DE']);
LangCountry::dateNumbers($post->created_at); // Will return "27.09.2023"
$post->created_at->langCountryDateNumbers(); // Will return "27.09.2023"

```

### Only numbers (string format)

Returns a **string format representation** with only numbers and the separator that is used in the
country.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateNumbersFormat(); // Will return "d-m-Y"

session(['lang_country' => 'en-US']);
LangCountry::dateNumbersFormat(); // Will return "m/d/Y"

session(['lang_country' => 'de-DE']);
LangCountry::dateNumbersFormat(); // Will return "d.m.Y"
```

### Only numbers full capital (string format)

Returns a **string format representation** with only capitals, a lot of javascript dates electors use this format.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateNumbersFullCapitalFormat(); // Will return "DD-MM-YYYY"

session(['lang_country' => 'en-US']);
LangCountry::dateNumbersFullCapitalFormat(); // Will return "MM/DD/YYYY"

session(['lang_country' => 'de-DE']);
LangCountry::dateNumbersFullCapitalFormat(); // Will return "DD.MM.YYYY"
```

### Only words, without day

Returns a **date string** with only words and without the day.
You should provide a Carbon instance.

```php

session(['lang_country' => 'nl-NL']);
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "27 september 2023"
$post->created_at->langCountryDateWordsWithoutDay(); // Will return "27 september 2023"

session(['lang_country' => 'en-US']);
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "September 27th 2023"
$post->created_at->langCountryDateWordsWithoutDay(); // Will return "September 27th 2023"

session(['lang_country' => 'fr-FR']);
LangCountry::dateWordsWithoutDay($post->created_at); // Will return "27 septembre 2023"
$post->created_at->langCountryDateWordsWithoutDay(); // Will return "27 septembre 2023"
```

### Only words, without day (string format)

Returns a **string format representation** with only words and without the day.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateWordsWithoutDayFormat(); // Will return "j F Y"

session(['lang_country' => 'en-US']);
LangCountry::dateWordsWithoutDayFormat(); // Will return "F jS Y"

session(['lang_country' => 'de-DE']);
LangCountry::dateWordsWithoutDayFormat(); // Will return "j F Y"
```

### Only words, with day

Returns a **date string** with only words and with the day.
You should provide a Carbon instance.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateWordsWithDay($post->created_at); // Will return "woensdag 27 september 2023"
$post->created_at->langCountryDateWordsWithDay(); // Will return "woensdag 27 september 2023"

session(['lang_country' => 'en-US']);
LangCountry::dateWordsWithDay($post->created_at); // Will return "Wednesday September 27th 2023"
$post->created_at->langCountryDateWordsWithDay(); // Will return "Wednesday September 27th 2023"

session(['lang_country' => 'fr-FR']);
LangCountry::dateWordsWithDay($post->created_at); // Will return "mercredi 27 septembre 2023"
$post->created_at->langCountryDateWordsWithDay(); // Will return "mercredi 27 septembre 2023"
```

### Only words, with day (string format)

Returns a **string format representation** with only words and with the day.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateWordsWithDayFormat(); // Will return "l j F Y"

session(['lang_country' => 'en-US']);
LangCountry::dateWordsWithDayFormat(); // Will return "l F jS Y"

session(['lang_country' => 'de-DE']);
LangCountry::dateWordsWithDayFormat(); // Will return "l j F Y"
```

### Birthday

Returns a **birthday string representation** that is used in the country.
You should provide a Carbon instance.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateBirthday($user->date_of_birth); // Will return "27 september"
$user->date_of_birth->langCountryDateBirthday(); // Will return "27 september"

session(['lang_country' => 'en-US']);
LangCountry::dateBirthday($user->date_of_birth); // Will return "September 27th"
$user->date_of_birth->langCountryDateBirthday(); // Will return "September 27th"
```

### Birthday (string format)

Returns a **birthday string format representation** that is used in the country.

```php
session(['lang_country' => 'nl-NL']);
LangCountry::dateBirthdayFormat(); // Will return "j F"

session(['lang_country' => 'en-US']);
LangCountry::dateBirthdayFormat(); // Will return "F jS"
```

### Add time to dates and date strings

If you would like to add a time to a date string, you can use the `withTime` method. This method will add the time to
the date string. It is a chainable method, you call it before the date format method. It will work in combination with
these date format methods:

* `dateNumbersFormat`
* `dateNumbers`
* `dateWordsWithoutDayFormat`
* `dateWordsWithoutDay`
* `dateWordsWithDayFormat`
* `dateWordsWithDay`
* `dateNumbersFullCapitalsFormat`

```php
session(['lang_country' => 'en-US']);
LangCountry::withTime()->dateNumbersFormat(); // Will return "m/d/Y"
LangCountry::withTime()->dateNumbers($post->created_at); // Will return "09/27/2023 01:05 pm"
LangCountry::withTime()->dateWordsWithoutDayFormat(); // Will return "F jS Y h:i a"
LangCountry::withTime()->dateWordsWithoutDay($post->created_at); // Will return "September 27th 2023 01:05 pm"
LangCountry::withTime()->dateWordsWithDayFormat(); // Will return "l F jS Y h:i a"
LangCountry::withTime()->dateWordsWithDay($post->created_at); // Will return "Wednesday September 27th 2023 01:05 pm"
LangCountry::withTime()->dateNumbersFullCapitalsFormat(); // Will return "MM/DD/YYYY h:i a"

// When using macros, you can pass `true` as the second parameter
$post->created_at->langCountryDateNumbers(false, true); // Will return "09/27/2023 01:05 pm"
$post->created_at->langCountryDateWordsWithoutDay(false, true); // Will return "September 27th 2023 01:05 pm"
$post->created_at->langCountryDateWordsWithDay(false, true); // Will return "Wednesday September 27th 2023 01:05 pm"

```
