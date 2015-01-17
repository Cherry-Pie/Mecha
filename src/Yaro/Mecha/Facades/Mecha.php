<?php

namespace Yaro\Mecha\Facades;

use Illuminate\Support\Facades\Facade;


class Mecha extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'yaro_mecha';
    } // end getFacadeAccessor

}