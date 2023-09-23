---
outline: deep
---

# Installation

## Requirements

For version 3.0.0 and above, you need to have at least PHP 8.1 and Laravel 10 or above.

For older PHP and Laravel versions, please use the [V2.x](https://github.com/stefro/laravel-lang-country/tree/V2.x)
branch. Please note that this documentation is only for the latest version of the package.

## Install

### Composer

You can install this package via composer using this command:

``` bash
composer require involved-group/laravel-lang-country
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

To make sure this will be loaded and stored in the session add this to method to
your `app\Http\Controllers\Auth\LoginController.php`:

```php
public function authenticated(Request $request, $user)
{
    // Set the right sessions
    if (null != $user->lang_country) {
        \LangCountry::setAllSessions($user->lang_country);
    }

    return redirect()->intended($this->redirectPath());
}
```

**That's all folks!**
