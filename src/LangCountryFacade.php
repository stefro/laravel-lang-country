<?php

namespace Stefro\LaravelLangCountry;

use Illuminate\Support\Facades\Facade;

class LangCountryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LangCountry::class;
    }
}
