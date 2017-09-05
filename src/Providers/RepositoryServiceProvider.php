<?php namespace Tukecx\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\ThemesManagement\Models\Theme;
use Tukecx\Base\ThemesManagement\Models\ThemeOption;
use Tukecx\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use Tukecx\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;
use Tukecx\Base\ThemesManagement\Repositories\ThemeOptionRepository;
use Tukecx\Base\ThemesManagement\Repositories\ThemeOptionRepositoryCacheDecorator;
use Tukecx\Base\ThemesManagement\Repositories\ThemeRepository;
use Tukecx\Base\ThemesManagement\Repositories\ThemeRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\ThemesManagement';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ThemeRepositoryContract::class, function () {
            $repository = new ThemeRepository(new Theme());

            if (config('tukecx-caching.repository.enabled')) {
                return new ThemeRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(ThemeOptionRepositoryContract::class, function () {
            $repository = new ThemeOptionRepository(new ThemeOption());

            if (config('tukecx-caching.repository.enabled')) {
                return new ThemeOptionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
