<?php

namespace LaravelLookbook\Facades;

use Illuminate\Support\Facades\Facade;

class Lookbook extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lookbook';
    }
}
