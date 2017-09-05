<?php namespace Tukecx\Base\ThemesManagement\Http\Controllers;

use Tukecx\Base\Core\Http\Controllers\BaseAdminController;
use Illuminate\Support\Facades\Artisan;
use Tukecx\Base\ThemesManagement\Http\DataTables\ThemesListDataTable;

class ThemeController extends BaseAdminController
{
    protected $module = 'tukecx-themes-management';

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addLink('主题');

        $this->setPageTitle('主题');

        $this->getDashboardMenu($this->module);
    }

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ThemesListDataTable $themesListDataTable)
    {
        $this->dis['dataTable'] = $themesListDataTable->run();

        return do_filter('tukecx-themes-management.index.get', $this)->viewAdmin('list');
    }

    /**
     * Set data for DataTable plugin
     * @param ThemesListDataTable $themesListDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(ThemesListDataTable $themesListDataTable)
    {
        return do_filter('datatables.tukecx-themes-management.index.post', $themesListDataTable, $this);
    }

    public function postChangeStatus($alias, $status)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages('Theme not exists', true, \Constants::ERROR_CODE);
        }

        switch ((bool)$status) {
            case true:
                $check = check_module_require($theme);
                if ($check['error']) {
                    return $check;
                }

                return themes_management()->enableTheme($alias)->refreshComposerAutoload();
                break;
            default:
                return themes_management()->disableTheme($alias)->refreshComposerAutoload();
                break;
        }
    }

    public function postInstall($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages('Theme not exists', true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:install', [
            'alias' => $alias
        ]);

        return response_with_messages('Installed theme dependencies');
    }

    public function postUpdate($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages('Theme not exists', true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:update', [
            'alias' => $alias
        ]);

        return response_with_messages('Your theme has been updated');
    }

    public function postUninstall($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages('Theme not exists', true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:uninstall', [
            'alias' => $alias
        ]);

        return response_with_messages('Uninstalled theme dependencies');
    }
}
