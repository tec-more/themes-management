<?php namespace Tukecx\Base\ThemesManagement\Repositories;

use Tukecx\Base\Caching\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use Tukecx\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;

class ThemeRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements ThemeRepositoryContract
{
    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
