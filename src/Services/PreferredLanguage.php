<?php

namespace Stefro\LaravelLangCountry\Services;

/**
 * Class PreferedLanguage.
 */
class PreferredLanguage
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $client_preferred;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $allowed;

    /**
     * HTTP_ACCEPT_LANGUAGE string.
     *
     * @var
     */
    protected $preferred_languages;

    /**
     * @var string
     */
    protected $fallback;

    /**
     * calculated lang_country result.
     *
     * @var string
     */
    public $lang_country;

    /**
     * Calculated locale result.
     *
     * @var string
     */
    public $locale;

    /**
     * PreferedLanguage constructor.
     *
     * @param $preferred_languages
     * @param null $allowed
     * @param null $fallback
     */
    public function __construct($preferred_languages, $allowed = null, $fallback = null)
    {
        $this->preferred_languages = $preferred_languages;
        $this->allowed = $allowed ?? collect(config('lang-country.allowed'));
        $this->fallback = $fallback ?? config('lang-country.fallback');
        $this->client_preferred = $this->clientPreferedLanguages();
        $this->lang_country = $this->getLangCountry();
        $this->locale = $this->getLocale();
    }

    /**
     * It will return a list of preferred languages of the browser in order of preference.
     *
     * @return \Illuminate\Support\Collection
     */
    public function clientPreferedLanguages()
    {
        // regex inspired from @GabrielAnderson on http://stackoverflow.com/questions/6038236/http-accept-language
        preg_match_all(
            '/([a-z]{1,8}(-[a-z]{1,8})*)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i',
            $this->preferred_languages,
            $lang_parse
        );

        $langs = $lang_parse[1];

        // Make sure the country chars (when available) are uppercase.
        $langs = collect($langs)->map(function ($lang) {
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
            $lang2pref[$langs[$i]] = (float)(! empty($ranks[$i]) ? $ranks[$i] : 1);
        }

        // (comparison function for uksort)
        $cmpLangs = function ($a, $b) use ($lang2pref) {
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
     *
     * @return \Illuminate\Config\Repository|int|mixed|string|static
     */
    protected function getLangCountry()
    {
        $preferred = $this->rewritePreferedToFourDigitValues();

        // Find exact match for 4 digits
        $preferred = $this->client_preferred->keys()->filter(function ($value) {
            return 5 == strlen($value);
        })->first(function ($value) {
            return $this->allowed->contains($value);
        });

        // Find first two digit (lang) match to four digit lang_country from the allowed-list
        if (null === $preferred) {
            $preferred = $this->client_preferred->keys()->filter(function ($value) {
                return 2 == strlen($value);
            })->map(function ($item) {
                return $this->allowed->filter(function ($value) use ($item) {
                    return $item == explode('-', $value)[0];
                })->first();
            })->reject(function ($value) {
                return $value === null;
            })->first();
        }

        // Get fallback if no results
        if (null === $preferred) {
            $preferred = $this->fallback;
        }

        return $preferred;
    }

    /**
     * @return string|null
     */
    private function rewritePreferedToFourDigitValues()
    {
        $preferred = $this->client_preferred->keys()->map(function ($value) {
            if (5 == strlen($value)) {
                return $value;
            } else {
                return $this->findFourDigitValueInOther($value);
            }
        })->reject(function ($value) {
            return $value === null;
        });

        return $preferred;
    }

    /**
     * @param $value
     * @return mixed
     */
    private function findFourDigitValueInOther($value)
    {
        return $this->allowed->filter(function ($item) use ($value) {
            return $value == explode('-', $value)[0];
        })->first();
    }

    /**
     * Check if 4 char language (ex. en-US.json) file exists in /resources/lang/ dir.
     * If not, just return the first two chars (represents the language).
     *
     * @return bool|\Illuminate\Config\Repository|int|PreferredLanguage|mixed|string
     */
    private function getLocale()
    {
        $path = lang_path() . $this->lang_country . '.json';

        if (file_exists($path)) {
            return $this->lang_country;
        } else {
            return substr($this->lang_country, 0, 2);
        }
    }

    private function getLocaleForDate()
    {
        return substr($this->lang_country, 0, 2);
    }
}
