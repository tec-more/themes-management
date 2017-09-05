<?php namespace Tukecx\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\ThemesManagement';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'tukecx-themes-management',
            'priority' => 1002,
            'parent_id' => null,
            'heading' => null,
            'title' => '主题',
            'font_icon' => 'icon-magic-wand',
            'link' => route('admin::themes.index.get'),
            'css_class' => null,
            'permissions' => ['view-themes'],
        ]);
        if (cms_theme_options()->count()) {
            \DashboardMenu::registerItem([
                'id' => 'tukecx-theme-options',
                'priority' => 1002,
                'parent_id' => null,
                'heading' => null,
                'title' => '主题选项',
                'font_icon' => 'icon-settings',
                'link' => route('admin::theme-options.index.get'),
                'css_class' => null,
            ]);
        }
    }
}
