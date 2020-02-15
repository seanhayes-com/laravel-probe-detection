<?php

namespace SeanHayes\Probe;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SeanHayes\Probe\Probe
 */
class ProbeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-probe-detection';
    }
}