![laravel-langcountry.png](./public/laravel-langcountry.png)

## Introduction

Setting the locale is not enough most of the time, some countries use more than one languages. Also, different countries
use different date notation formats despite of their language. This package is here to help you with that!

In a nutshell:

* You can set all supported languages and countries of your choice in the settings.
* It will try to find the best match for the user based on the browser settings when a user first visits your app.
* It has a smart fallback.
* It provides an (optional) language switcher that is based on countries (with flags) and not only on languages. So for
  some
  countries, it will show multiple languages.
* It provides a middleware that will set the locale and the country of the user.
* ... and more!

I've also written an article about
it [here](https://stefrouschop.nl/why-a-locale-is-sometimes-not-enough-in-laravel-28b1e82029cc).

## What will it do?

For each user or guest it will create a four character `lang_country` code. For guests it will try to make a perfect
match based on the browser settings. For users, it will load the last used `lang_country`, because we will store it in
the DB.

**There will ALWAYS be two sessions set:**

- `lang_country` (example: `nl-BE`)
- `locale` (examples: `nl`, `es-CO`)

When a user will log in to your app, it will load the last `lang_country` and set the sessions accordingly.

