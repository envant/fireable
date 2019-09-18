<?php

namespace Envant\Fireable\Facades;

use Illuminate\Support\Facades\Facade;

class Fireable extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fireable';
    }
}
