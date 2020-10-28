<?php

namespace Kineticamobile\Duna\Facades;

use Illuminate\Support\Facades\Facade;

class Duna extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'duna';
    }
}
