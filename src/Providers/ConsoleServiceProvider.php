<?php namespace Tukecx\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->generatorCommands();
        $this->otherCommands();
    }

    private function generatorCommands()
    {
        $this->commands([
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeTheme::class,
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeController::class,
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeView::class,
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeProvider::class,
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Generators\MakeCriteria::class,
        ]);
    }

    private function otherCommands()
    {
        $this->commands([
            \Tukecx\Base\ThemesManagement\Console\Commands\EnableThemeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Commands\DisableThemeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Commands\InstallThemeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Commands\UpdateThemeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Commands\UninstallThemeCommand::class,
            \Tukecx\Base\ThemesManagement\Console\Commands\GetAllThemesCommand::class,
        ]);
    }
}
