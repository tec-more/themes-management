<?php namespace Tukecx\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use Tukecx\Base\ThemesManagement\Support\ThemeOptionsSupport;

class ThemeOptionsSupportFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOptionsSupport::class;
    }
}
