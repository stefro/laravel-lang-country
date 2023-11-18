<?php

return [
    'fallback' => 'en-GB',

    'allowed' => [
        'nl-NL',
        'nl-BE',
        'fr-BE',
        'en-GB',
        'de-DE',
        'en-US',
        'en-CA',
        'en-AU',
        'fr-CA',
        'ca-ES',
        'de-AT',
        'fr-CH',
        'de-CH',
        'fr-FR',
        'es-ES',
        'es-CO',
        'it-IT',
        'lt-LT',
        'pt-PT',
    ],

    'lang_switcher_middleware' => ['web'],

    'lang_switcher_uri' => 'change_lang_country',

    'fallback_based_on_current_locale' => false,
];
