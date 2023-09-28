# Configuration

After you've published the config file, you can find it in `config/langcountry.php`. You can set your preferences here.

## Fallback

When a user visits your app for the first time, it will try to find the best match based on the browser settings. If it
can't find a match, it will use the fallback locale and country. You can set these in the config file.

```php
return [
    'fallback' => 'en-GB',
    // ...
]
```

## Allowed languages and countries

The `allowed` array key in the config file contains all the allowed languages and countries. You can add or remove them
by uncommenting or adding them. These are the languages and countries that will be used in all the functions in this
package.

```php

return [
    'allowed' => [
    'nl-BE',
    'nl-NL',
    'en-GB',
    'en-US',
    'fr-BE',
    'fr-FR',
    // ...
];

```

## Middleware

The `lang_switcher_middleware` array key in the config file contains the middleware applied on the language switcher
route.

```php
return [
    'lang_switcher_middleware' => ['web'],
    // ...
]
```

## Fallback based on current Laravel locale

This is a very specific setting. If you want to use the fallback locale based on the current Laravel locale instead of
the LangCountry fallback from this config file, you can set this to `true`.

```php
return [
    'fallback_based_on_current_locale' => false,
    // ...
]
```
