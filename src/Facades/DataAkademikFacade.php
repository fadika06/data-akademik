<?php

namespace Bantenprov\DataAkademik\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The DataAkademik facade.
 *
 * @package Bantenprov\DataAkademik
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class DataAkademikFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'data-akademik';
    }
}
