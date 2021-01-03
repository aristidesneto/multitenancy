<?php

namespace Aristides\Multitenancy;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aristides\Multitenancy\Multitenancy
 */
class MultitenancyFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'multitenancy';
    }
}
