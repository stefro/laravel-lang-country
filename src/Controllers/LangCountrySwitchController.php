<?php

namespace InvolvedGroup\LaravelLangCountry\Controllers;

use Illuminate\Routing\Controller;

class LangCountrySwitchController extends Controller
{
    public function switch($lang_country)
    {
        // If a lang_country does not match any of the allowed, go back without doing anything.
        if (! in_array($lang_country, config('lang-country.allowed'))) {
            return redirect()->back();
        }

        // Set the right sessions
        \LangCountry::setAllSessions($lang_country);

        // If a user is logged in and it has a lang_country propperty, set the new lang_country.
        if (\Auth::user() && array_key_exists('lang_country', \Auth::user()->getAttributes())) {
            try {
                \Auth::user()->lang_country = $lang_country;
                \Auth::user()->save();
            } catch (\Exception $e) {
                \Log::error(get_class($this).' at '.__LINE__.': '.$e->getMessage());
            }
        }

        return redirect()->back();
    }
}
