<?php namespace Tukecx\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use Tukecx\Base\ThemesManagement\Support\ThemesManagement;

class ThemesManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemesManagement::class;
    }
}
