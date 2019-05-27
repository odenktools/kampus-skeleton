<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @package App\Facades
 *
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2019, Pribumi Technology
 * @link       https://odenktools.com
 */
class Kampus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kampus.facade';
    }
}
