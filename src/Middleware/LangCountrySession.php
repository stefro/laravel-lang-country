<?php

namespace Stefro\LaravelLangCountry\Middleware;

use App;
use Closure;

class LangCountrySession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! session()->has('lang_country')) {
            \LangCountry::setAllSessions($request->server('HTTP_ACCEPT_LANGUAGE'));
        }

        // Set the right locale for the laravel App and also for Date (https://github.com/jenssegers/date)
        App::setLocale(session('locale'));

        return $next($request);
    }
}
