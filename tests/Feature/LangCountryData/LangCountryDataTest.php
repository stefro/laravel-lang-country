<?php

it('should contain all attributes as given in the template file', function () {
    $attributes = array_keys(json_decode(file_get_contents(__DIR__ . '/../../../src/LangCountryData/_template.json'), true));

    // Retrieve all files from the LangCountryData directory, except the template file
    $files = glob(__DIR__ . '/../../../src/LangCountryData/*.json');
    $files = array_filter($files, function ($file) {
        return ! preg_match('/_template.json/', $file);
    });

    // Check if all files contain the same attributes from the $attributes array and that the values are not null or empty
    foreach ($files as $file) {
        $json = json_decode(file_get_contents($file), true);

        foreach ($attributes as $attribute) {
            expect(array_key_exists($attribute, $json))->toBeTrue()
                ->and($json[$attribute])->not->toBeNull()
                ->and($json[$attribute])->not->toBeEmpty();
        }
    }

});
