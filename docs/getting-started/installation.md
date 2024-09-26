---
outline: deep
---

# Installation

## Requirements

For version 4.0.0 and above, you need to have at least PHP 8.1 and Laravel 9 or above.

For older PHP and Laravel versions, please use the [V2.x](https://github.com/stefro/laravel-lang-country/tree/V2.x)
branch. Please note that this documentation is only for the latest version of the package.

## Install

### Composer

You can install this package via composer using this command:

``` bash
composer require stefro/laravel-lang-country
```

### Laravel configuration file

The package will automatically register itself.

You can publish the config-file with:

``` bash
php artisan vendor:publish --provider="Stefro\LaravelLangCountry\LaravelLangCountryServiceProvider" --tag="config"
```

### Middleware (optional)

Set the middleware. Add this in your `app\Http\Kernel.php` file to the $middlewareGroups web property:

``` php
protected $middlewareGroups = [
    'web' => [
        ....
        'lang_country'
    ],
```

You can find more information about the middleware [here](/usage/middleware).

### Migration

As soon as you run the migration, a `lang_country` column will be set for your User table. The migration will be load
through the service provider of the package, so you don't need to publish it first.

``` php
php artisan migrate
```

Make sure your `lang_country` on your User model can be stored by adding it to the $fillable property. Example:

``` php
protected $fillable = [
    'firstname', 'lastname', 'email', 'password', 'lang_country'
];
```

### Login event listener

By default, the package will listen to the `Illuminate\Auth\Events\Login` event. When this event is fired, the package
will set the right sessions for the newly logged-in user based on the users database preferences.
The `Illuminate\Auth\Events\Login` event is dispatched when you're using the default Laravel authentication system (
Breeze/Jetstream).

If you're using a custom authentication system, you need to add the following to the code that is being handled after a
user is logged in:

```php
public function authenticated(Request $request, $user)
{
    // Set the right sessions
    if (null != $user->lang_country) {
        \LangCountry::setAllSessions($user->lang_country);
    }

    //...
}
```

**That's all!**
