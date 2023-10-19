<?php

namespace Stefro\LaravelLangCountry\Listeners;

class UserAuthenticated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        // Set the right sessions
        if (null != $event->user->lang_country) {
            \LangCountry::setAllSessions($event->user->lang_country);
        }
    }
}
