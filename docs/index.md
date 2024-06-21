![laravel-langcountry.png](./public/laravel-langcountry.png)

## TLDR;

Laravel has great localisation functionality, but it is all based on the locale. The locale only refers to a language,
not a country. This package adds the ability to localize based on the country.
**Why?** Mainly because dates dates can be pronounced the same in a language, but be formatted differently in different
countries.
The package also adds more convenience functions to get localized country names, currency symbols and more.

## Introduction

::: warning Highlights
Have you ever had the problem that you needed a date format had to be localized? <br>
Or that you needed to show a date in a specific language? <br>
Or that you needed to show a country name in the local language? <br>
Or that you needed to show a currency symbol in the local currency? <br>
Or that you ...

**The Laravel Lang Country package is here to help you with that!**
:::

Setting the locale in Laravel is not enough most of the time, some countries use more than one language. Also,
different countries use different date notations formats despite their language. Proper localization gives us many
challenges. **This package will help you out with new tools in your tool belt**.

## In a nutshell

* You can set all supported languages and countries of your choice and make use of all the tools and data that are
  available in this package.
* It will automatically try to find the best match for the user based on the **browser settings** when a user first
  visits your app.
* It has a smart fallback.
* It provides a middleware that will set the locale and the country of the user.
* It provides an (optional) language switcher that is based on countries (with flags) and not only on languages. So for
  some countries, it will even show multiple languages. [(Read more)](/usage/language-switcher)
* It provides you with [date/time helpers](/usage/date-time).
* It provides you with [language helpers](/usage/language)
* It provides you with [currency helpers](/usage/currency).
* It will store the users preferred language and country in the database.
* And more...

I've also written an article about
it [here](https://stefrouschop.nl/why-a-locale-is-sometimes-not-enough-in-laravel-28b1e82029cc).

## What will it do?

For each user or guest it will create a four character `lang_country` code. For guests, it will try to make a perfect
match based on the browser settings. For users, it will load the last used `lang_country`, because we will store it in
the DB.

**There will ALWAYS be two sessions set:**

- `lang_country` (example: `nl-BE`)
- `locale` (examples: `nl`, `en`, `fr`, `es`, `de`, ...)

When a user will log in to your app, it will load the last `lang_country` and set the sessions accordingly.

::: tip Why do we need these session?
With these sessions, you can use the Laravel localization features as you are used to. But now you can also use the new
helpers that are available in this package.
:::
