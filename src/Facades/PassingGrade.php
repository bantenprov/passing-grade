<?php namespace Bantenprov\PassingGrade\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The PassingGrade facade.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGrade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'passing-grade';
    }
}
