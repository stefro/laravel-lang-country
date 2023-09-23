# Middleware

The middleware is optional [middleware](/getting-started/installation#middleware-optional). You can create your own
middleware tailored to your needs. But you can also use the “out of the box” middleware. This is what the default
middleware will do:

* It will check the users browser language preferences if there is no LangCountry is set. Then it will try to make the
  most perfect match to the `allowed` lang_country’s in your settings file.
* When there is no perfect match (language AND country) it will try to make a match on language only.
* When there is still no match, it will return to your fallback setting.
* It will ALWAYS store a `lang_country` session, so you can safely use all the LangCountry features it in your app.
* When a lang_country is already set, it will not run any unnecessary scripts.
* If you're
  using [Translation Strings As Keys](https://laravel.com/docs/master/localization#using-translation-strings-as-keys):
  Based on the `lang_country` it will check your (Laravel) `lang/` folder for an exact match in your
  json translation files (example es_CO). If an exact match is found it will set the Laravel Locale to this value. This
  way you’re able to create different translation files for each country if you need it.
* When no exact match, it will set the Laravel Locale to the language only.
