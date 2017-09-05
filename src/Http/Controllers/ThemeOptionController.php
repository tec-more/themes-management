<?php namespace Tukecx\Base\ThemesManagement\Http\Controllers;

use Tukecx\Base\Core\Http\Controllers\BaseAdminController;
use Tukecx\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use Tukecx\Base\ThemesManagement\Repositories\ThemeOptionRepository;

class ThemeOptionController extends BaseAdminController
{
    protected $module = 'tukecx-themes-management';

    /**
     * @param ThemeOptionRepository $repository
     */
    public function __construct(ThemeOptionRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->getDashboardMenu('tukecx-theme-options');
        $this->breadcrumbs->addLink('主题选项');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->setPageTitle('主题选项');

        return do_filter('theme-options.index.get', $this)->viewAdmin('theme-options-index');
    }

    public function postIndex()
    {
        $data = $this->request->except([
            '_token',
            '_tab',
        ]);

        /**
         * Filter
         */
        $data = do_filter('theme-options.before-edit.post', $data, $this);

        $result = $this->repository->updateOptions($data);

        $msgType = $result['error'] ? 'danger' : 'success';

        $this->flashMessagesHelper
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        do_action('theme-options.after-edit.post', $result, $this);

        return redirect()->back();
    }
}
