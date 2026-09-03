<?php

namespace Hwkdo\IntranetAppZentrale\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hwkdo\IntranetAppZentrale\IntranetAppZentrale
 */
class IntranetAppZentrale extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hwkdo\IntranetAppZentrale\IntranetAppZentrale::class;
    }
}
