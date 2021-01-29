<?php

namespace Tipoff\Fees;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Fees\Fees
 */
class FeesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fees';
    }
}
