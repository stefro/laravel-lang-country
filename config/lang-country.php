<?php

return [
    'fallback' => 'en-GB',

    'allowed' => [
        'bn-BD',
        'ca-ES',
        'da-DA',
        'de-AT',
        'de-CH',
        'de-DE',
        'en-AU',
        'en-CA',
        'en-GB',
        'en-US',
        'es-CO',
        'es-ES',
        'fr-BE',
        'fr-CA',
        'fr-CH',
        'fr-FR',
        'id-ID',
        'it-IT',
        'lt-LT',
        'nl-BE',
        'nl-NL',
        'ps-AF',
        'pt-PT',
        'pl-PL',
        'ru-RU',
    ],

    'lang_switcher_middleware' => ['web'],

    'lang_switcher_uri' => 'change_lang_country',

    'fallback_based_on_current_locale' => false,
];
