<?php

namespace Stefro\LaravelLangCountry;

use Carbon\Carbon;
use Stefro\LaravelLangCountry\Services\PreferredLanguage;

class LangCountry
{
    /**
     * The lang_country from the session, or the fallback.
     *
     * @var string
     */
    protected $lang_country;

    /**
     * @array
     */
    protected $data;

    /**
     * LangCountry constructor.
     */
    public function __construct()
    {
        if (config('lang-country.fallback_based_on_current_locale', false) && ! session()->has('lang_country')) {
            $lang = new PreferredLanguage(app()->getLocale());
            $this->lang_country = $lang->lang_country;
        } else {
            $this->lang_country = session('lang_country', config('lang-country.fallback'));
        }
        $this->data = $this->getDataFromFile($this->lang_country);
    }

    public function overrideSession($lang_country)
    {
        // In case the override is not a 4 char value
        if (5 !== strlen($lang_country)) {
            $lang = new PreferredLanguage($lang_country);
            $lang_country = $lang->lang_country;
        }

        $this->lang_country = $lang_country;
        $this->data = $this->getDataFromFile($lang_country);
    }

    /**
     * Will return the current LangCountry value
     **/
    public function currentLangCountry()
    {
        return $this->lang_country;
    }

    /**
     * It will return the right language. This can be a two char representation (ex. "nl", dutch)
     * or a four char representation (ex. es_CO; Spanish-colombian).
     *
     * @return string
     */
    public function lang($override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $this->data->lang;
    }

    /**
     * It will return the two character code representation of the country.
     *
     * @return string
     */
    public function country()
    {
        return $this->data->country;
    }

    /**
     * It will return the name of the country represented by the country code.
     *
     * @return string
     */
    public function countryName()
    {
        return $this->data->country_name;
    }

    /**
     * It will return the two character code representation of the country.
     *
     * @return string
     */
    public function countryNameLocal()
    {
        return $this->data->country_name_local;
    }

    /**
     * It will return the name of the language TRANSLATED IN THE LANGUAGE IN QUESTION.
     * You can use this for nice country-selectors in your app.
     *
     * @return string
     */
    public function name()
    {
        return $this->data->name;
    }

    /**
     * String representation of the dateformat with only numbers.
     * Ex: "Y-m-d".
     *
     * @return string
     */
    public function dateNumbersFormat()
    {
        return $this->data->date_numbers;
    }

    /**
     * String representation of the date with only numbers from the Carbon instance provided.
     * It will be translated through \Date
     * Ex: "2018-04-24".
     *
     * @param Carbon $carbon
     * @return string
     */
    public function dateNumbers(Carbon $carbon, $override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $carbon->locale($this->data->lang)->translatedFormat($this->data->date_numbers);
    }

    /**
     * String representation of the dateformat with only capitals, some javascript dateselectors use this.
     * Ex: "DD-MM-YYYY".
     *
     * @return string
     */
    public function dateNumbersFullCapitalsFormat()
    {
        return $this->data->date_numbers_full_capitals;
    }

    /**
     * String representation of the dateformat with words but without the day.
     * Ex: "F jS Y".
     *
     * @return string
     */
    public function dateWordsWithoutDayFormat()
    {
        return $this->data->date_words_without_day;
    }

    /**
     * String representation of the date in words but without the day.
     * It will be translated through \Date
     * Ex: "April 24th 2018".
     *
     * @param Carbon $carbon
     * @return string
     */
    public function dateWordsWithoutDay(Carbon $carbon, $override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $carbon->locale($this->data->lang)->translatedFormat($this->data->date_words_without_day);
    }

    /**
     * String representation of the dateformat with words but without the day.
     * Ex: "l F jS Y".
     *
     * @return string
     */
    public function dateWordsWithDayFormat()
    {
        return $this->data->date_words_with_day;
    }

    /**
     * String representation of the date with words but without the day.
     * It will be translated through \Date
     * Ex: "Tuesday April 24th 2018".
     *
     * @param Carbon $carbon
     * @return string
     */
    public function dateWordsWithDay(Carbon $carbon, $override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $carbon->locale($this->data->lang)->translatedFormat($this->data->date_words_with_day);
    }

    /**
     * String representation of the dateformat for a birthday.
     * Ex: "F jS".
     *
     * @return string
     */
    public function dateBirthdayFormat()
    {
        return $this->data->date_birthday;
    }

    /**
     * String representation of a birthday date.
     * It will be translated through \Date
     * Ex: "April 24th".
     *
     * @param Carbon $carbon
     * @return string
     */
    public function dateBirthday(Carbon $carbon, $override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $carbon->locale($this->data->lang)->translatedFormat($this->data->date_birthday);
    }

    /**
     * String representation of the timeformat.
     * Ex: "h:i a".
     *
     * @return string
     */
    public function timeFormat()
    {
        return $this->data->time_format;
    }

    /**
     * String representation of time.
     * It will be translated through \Date
     * Ex: "12:00 pm".
     *
     * @param Carbon $carbon
     * @return string
     */
    public function time(Carbon $carbon, $override = false)
    {
        if ($override != false) {
            $this->overrideSession($override);
        }

        return $carbon->locale($this->data->lang)->translatedFormat($this->data->time_format);
    }

    /**
     * Emoji representation of language country flag.
     * Ex: "🇱🇹".
     *
     * @return string
     */
    public function emojiFlag()
    {
        return $this->data->emoji_flag;
    }

    public function allLanguages()
    {
        return collect(config('lang-country.allowed'))
            ->map(function ($item) {
                $file = $this->getDataFromFile($item);

                return [
                    'country' => $file->country,
                    'country_name' => $file->country_name,
                    'country_name_local' => $file->country_name_local,
                    'lang' => $file->lang,
                    'name' => $file->name,
                    'lang_country' => $item,
                    'emoji_flag' => $file->emoji_flag,
                    'currency_code' => $file->currency_code,
                    'currency_symbol' => $file->currency_symbol,
                    'currency_symbol_local' => $file->currency_symbol_local,
                    'currency_name' => $file->currency_name,
                    'currency_name_local' => $file->currency_name_local,
                ];
            });
    }

    /**
     * It will return the iso code of the country's currency.
     *
     * @return string
     */
    public function currencyCode()
    {
        return $this->data->currency_code;
    }

    /**
     * It will return the iso symbol of the country's currency.
     *
     * @return string
     */
    public function currencySymbol()
    {
        return $this->data->currency_symbol;
    }

    /**
     * It will return the iso symbol of the country's currency, prefixed with localization.
     *
     * @return string
     */
    public function currencySymbolLocal()
    {
        return $this->data->currency_symbol_local;
    }

    /**
     * It will return the name of the country's currency.
     *
     * @return string
     */
    public function currencyName()
    {
        return $this->data->currency_name;
    }

    /**
     * It will return the name of the country's currency as spoken locally by language code.
     *
     * @return string
     */
    public function currencyNameLocal()
    {
        return $this->data->currency_name_local;
    }

    /**
     * It will return a collection with the current language, country and name
     * and also the other available language, country and name.
     */
    public function langSelectorHelper()
    {
        return $this->allLanguages()->reduce(function ($carry, $item) {
            if ($item['lang_country'] != session('lang_country')) {
                $carry['available'][] = $item;
            } else {
                $carry['current'] = $item;
            }

            return $carry;
        });
    }

    public function setAllSessions($preferred_lang)
    {
        $lang = new PreferredLanguage($preferred_lang);
        session(['lang_country' => $lang->lang_country]);
        session(['locale' => $lang->locale]);
    }

    /**
     * Retreive the data for the lang_country from the external file.
     *
     * @param $lang_country
     * @return mixed
     */
    private function getDataFromFile($lang_country)
    {
        if ($lang_country === null) {
            return [];
        }

        if (file_exists(lang_path('lang-country-overrides') . $lang_country . '.json')) {
            $resource = lang_path('lang-country-overrides') . $lang_country . '.json';
        } else {
            $resource = __DIR__ . '/LangCountryData/' . $lang_country . '.json';
        }

        return json_decode(file_get_contents($resource));
    }
}
