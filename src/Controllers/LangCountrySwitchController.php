<?php

namespace Stefro\LaravelLangCountry\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class LangCountrySwitchController extends Controller
{
    public function switch(string $lang_country): RedirectResponse
    {
        if (!in_array($lang_country, config('lang-country.allowed'))) {
            return redirect()->back();
        }

        \LangCountry::setAllSessions($lang_country);

        if (\Auth::user() && array_key_exists('lang_country', \Auth::user()->getAttributes())) {
            \Auth::user()->lang_country = $lang_country;
            \Auth::user()->save();
        }

        return redirect()->back();
    }
}
