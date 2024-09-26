# Upgrade Guide

## Version 3 -> 4

Version 4 adds Carbon Macros and IDE autocompletion.

#### Minimum Requirements

* You need PHP 8.1 or higher.
* You need Laravel 9 or higher.

#### Migration

No migration required.

#### Breaking Changes

There should not be any breaking changes in this release.

## Version 2 -> 3

#### Minimum Requirements

* You now need PHP 8.1 or higher.
* You now need Laravel 9 or higher.

#### Breaking Changes

* The namespace has changed from `InvolvedGroup\LaravelLangCountry` to `Stefro\LaravelLangCountry`. In case you have
  used the namespace in your code, you need to update it.
* A typo has slipped into the codebase. In case you're using the class `PreferedLanguage` directly, it has now been
  changed to `PreferredLanguage`. You should do a find and replace in your codebase to fix this.
* In case you were using any of the methods from the `PreferredLanguage` class directly, you should also rename the
  methods `clientPreferedLanguages` to `clientPreferredLanguages`.
