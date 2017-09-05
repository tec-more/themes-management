<?php namespace Tukecx\Base\ThemesManagement\Repositories;

use Tukecx\Base\Caching\Services\Traits\Cacheable;
use Tukecx\Base\Core\Repositories\Eloquent\EloquentBaseRepository;
use Tukecx\Base\Caching\Services\Contracts\CacheableContract;
use Tukecx\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;

class ThemeRepository extends EloquentBaseRepository implements ThemeRepositoryContract, CacheableContract
{
    use Cacheable;

    protected $rules = [

    ];

    protected $editableFields = [
        '*',
    ];

    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        return $this->where('alias', '=', $alias)->first();
    }
}
