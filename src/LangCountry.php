<?php

namespace InvolvedGroup\LaravelLangCountry;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use InvolvedGroup\LaravelLangCountry\Services\PreferedLanguage;

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
        $this->lang_country = session('lang_country', config('lang-country.fallback'));
        $this->data = $this->getDataFromFile($this->lang_country);
    }

    /**
     * It will return the right language. This can be a two char representation (ex. "nl", dutch)
     * or a four char representation (ex. es_CO; Spanish-colombian).
     *
     * @return string
     */
    public function lang()
    {
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
    public function dateNumbers(Carbon $carbon)
    {
        return Date::instance($carbon)->format($this->data->date_numbers);
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
    public function dateWordsWithoutDay(Carbon $carbon)
    {
        return Date::instance($carbon)->format($this->data->date_words_without_day);
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
    public function dateWordsWithDay(Carbon $carbon)
    {
        return Date::instance($carbon)->format($this->data->date_words_with_day);
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
    public function dateBirthday(Carbon $carbon)
    {
        return Date::instance($carbon)->format($this->data->date_birthday);
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
    public function time(Carbon $carbon)
    {
        return Date::instance($carbon)->format($this->data->time_format);
    }

    /**
     * It will return a collection with the current language, country and name
     * and also the other available language, country and name.
     */
    public function langSelectorHelper()
    {
        return collect(config('lang-country.allowed'))
            ->map(function ($item) {
                $file = $this->getDataFromFile($item);

                return [
                    'lang' => $file->lang,
                    'country' => $file->country,
                    'name' => $file->name,
                    'lang_country' => $item,
                ];
            })->reduce(function ($carry, $item) {
                if ($item['lang_country'] != session('lang_country')) {
                    $carry['available'][] = $item;
                } else {
                    $carry['current'] = $item;
                }

                return $carry;
            });
    }

    public function setAllSessions($prefered_lang)
    {
        $lang = new PreferedLanguage($prefered_lang);
        session(['lang_country' => $lang->lang_country]);
        session(['locale' => $lang->locale]);
        session(['locale_for_date' => $lang->locale_for_date]);
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
            return[];
        }

        $resource = __DIR__.'/LangCountryData/'.$lang_country.'.json';

        return json_decode(file_get_contents($resource));
    }
}
