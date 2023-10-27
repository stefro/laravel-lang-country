# Language Switcher

## How to switch lang_country

There is a named route `lang_country.switch` you can use that will take the new `lang_country` as a parameter. In the
example below we're switching to `nl-BE`:

``` php
route('lang_country.switch', ['lang_country' => 'nl-BE'])
```

It will first check if the requested `lang_country` is in your `allowed` list of your config file. When so, it will
change all the sessions accordingly. If it detects there is a logged in `User`, it will also change the `lang_country`
preference of this user to the database.

## Create a language selector

It's really easy to create a language selector! You can use `LangCountry::langSelectorHelper()`.
The output will be based on the `allowed` list of your config file. It will return an array with the following example:

``` php
Array
(
    [available] => Array
        (
            [0] => Array
                (
                    [country] => NL
                    [country_name] => The Netherlands
                    [country_name_local] => Nederlands
                    [lang] => nl
                    [name] => Nederlands
                    [lang_country] => nl-NL
                    [emoji_flag] => 🇳🇱
                    [currency_code] => EUR
                    [currency_symbol] => €
                    [currency_symbol_local] => €
                    [currency_name] => Euro
                    [currency_name_local] => Euro
                )

            [1] => Array
                (
                    [country] => BE
                    [country_name] => The Netherlands
                    [country_name_local] => Nederlands
                    [lang] => nl
                    [name] => België - Vlaams
                    [lang_country] => nl-BE
                    [emoji_flag] => 🇧🇪
                    [currency_code] => EUR
                    [currency_symbol] => €
                    [currency_symbol_local] => €
                    [currency_name] => Euro
                    [currency_name_local] => Euro
                )

            [2] => Array
                (
                    [country] => GB
                    [country_name] => United Kingdom
                    [country_name_local] => United Kingdom
                    [lang] => en
                    [name] => English
                    [lang_country] => en-GB
                    [emoji_flag] => 🇬🇧
                    [currency_code] => GBP
                    [currency_symbol] => £
                    [currency_symbol_local] => £
                    [currency_name] => Pound Stirling
                    [currency_name_local] => Pound
                )

            [3] => Array
                ( 
                    [country] => CA
                    [country_name] => Canada
                    [country_name_local] => Canada
                    [lang] => en
                    [name] => Canadian English
                    [lang_country] => en-CA
                    [emoji_flag] => 🇨🇦
                    [currency_code] => CAD
                    [currency_symbol] => $
                    [currency_symbol_local] => CA$
                    [currency_name] => Dollar
                    [currency_name_local] => Canadian Dollar
                )

        )

    [current] => Array
        (
            [country] => US
            [country_name] => United States of America
            [country_name_local] => America
            [lang] => en
            [name] => American English
            [lang_country] => en-US
            [emoji_flag] => 🇺🇸
            [currency_code] => USD
            [currency_symbol] => $
            [currency_symbol_local] => US$
            [currency_name] => Dollar
            [currency_name_local] => US Dollar
        )

)
```

With this array, you're able to create a dynamic language/country switcher like this in your own frontend framework of
choice.

![lang-switcher.png](/public/lang-switcher.png)

