<?php

namespace Stefro\LaravelLangCountry\Services;

use Illuminate\Support\Collection;

class PreferredLanguage
{
    protected Collection $client_preferred;

    protected Collection $allowed;

    protected string $fallback;

    public string $lang_country;

    public string $locale;

    public function __construct(protected ?string $preferred_languages, ?Collection $allowed = null, ?string $fallback = null)
    {
        $this->allowed = $allowed ?? collect(config('lang-country.allowed'));
        $this->fallback = $fallback ?? config('lang-country.fallback');
        $this->client_preferred = $this->clientPreferredLanguages();
        $this->lang_country = $this->getLangCountry();
        $this->locale = $this->getLocale();
    }

    /**
     * It will return a list of preferred languages of the browser in order of preference.
     */
    public function clientPreferredLanguages(): Collection
    {
        // regex inspired from @GabrielAnderson on http://stackoverflow.com/questions/6038236/http-accept-language
        preg_match_all(
            '/([a-z]{1,8}(-[a-z]{1,8})*)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
            $this->preferred_languages,
            $lang_parse
        );

        $langs = $lang_parse[1];

        // Make sure the country chars (when available) are uppercase.
        $langs = collect($langs)->map(function (string $lang) {
            if (5 == strlen($lang)) {
                $lang = explode('-', $lang);
                $lang = implode('-', [$lang[0], strtoupper($lang[1])]);
            }

            return $lang;
        })->toArray();

        $ranks = $lang_parse[4];

        // (create an associative array 'language' => 'preference')
        $lang2pref = [];
        for ($i = 0; $i < count($langs); $i++) {
            $lang2pref[$langs[$i]] = (float)(!empty($ranks[$i]) ? $ranks[$i] : 1);
        }

        // (comparison function for uksort)
        $cmpLangs = function (string $a, string $b) use ($lang2pref) {
            if ($lang2pref[$a] > $lang2pref[$b]) {
                return -1;
            } elseif ($lang2pref[$a] < $lang2pref[$b]) {
                return 1;
            } elseif (strlen($a) > strlen($b)) {
                return -1;
            } elseif (strlen($a) < strlen($b)) {
                return 1;
            } else {
                return 0;
            }
        };

        // sort the languages by preferred language and by the most specific region
        uksort($lang2pref, $cmpLangs);

        return collect($lang2pref);
    }

    /**
     * It will find the first best match for lang_country according to the allowed list (from config file).
     */
    protected function getLangCountry(): string
    {
        $preferred = $this->findExactMatchForFourCharsOrReturnNull();

        if (null === $preferred) {
            $preferred = $this->findFirstMatchBasedOnOnlyTheLangChars();
        }

        // Get fallback if no results
        if (null === $preferred) {
            $preferred = $this->fallback;
        }

        return $preferred;
    }

    public function findExactMatchForFourCharsOrReturnNull(): ?string
    {
        return $this->client_preferred->keys()->filter(function (string $value) {
            return 5 == strlen($value);
        })->first(function (string $value) {
            return $this->allowed->contains($value);
        });
    }

    public function findFirstMatchBasedOnOnlyTheLangChars(): ?string
    {
        return $this->client_preferred->keys()->filter(function (string $value) {
            return 2 === strlen($value);
        })->map(function (string $item) {
            return $this->allowed->filter(function (string $value) use ($item) {
                return $item === explode('-', $value)[0];
            })->first();
        })->reject(function (?string $value) {
            return $value === null;
        })->first();
    }

    /**
     * Check if 4 char language (ex. en-US.json) file exists in /resources/lang/ dir.
     * If not, just return the first two chars (represents the language).
     */
    private function getLocale(): string
    {
        $path = lang_path() . $this->lang_country . '.json';

        if (file_exists($path)) {
            return $this->lang_country;
        } else {
            return substr($this->lang_country, 0, 2);
        }
    }
}
