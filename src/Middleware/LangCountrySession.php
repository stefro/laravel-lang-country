<?php

namespace Stefro\LaravelLangCountry\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class LangCountrySession
{
    public function handle(Request $request, Closure $next)
    {
        if (! session()->has('lang_country') || ! session()->has('locale')) {

            if (\Auth::user() && \Auth::user()?->lang_country !== null) {
                $preferred_lang = \Auth::user()->lang_country;
            } else {
                $preferred_lang = $request->server('HTTP_ACCEPT_LANGUAGE');
            }

            \LangCountry::setAllSessions($preferred_lang);

            if (\Auth::user() && array_key_exists('lang_country', \Auth::user()->getAttributes()) && \Auth::user()->lang_country === null) {
                \Auth::user()->lang_country = session('lang_country');
                \Auth::user()->save();
            }
        }

        App::setLocale(session('locale'));


        return $next($request);
    }
}
