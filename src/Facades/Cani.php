<?php

namespace Winponta\Cani\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Cani facade
 */
class Cani extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cani';
    }
}
