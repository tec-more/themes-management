<?php namespace DummyNamespace\Http\Controllers\Blog;

use Tukecx\Plugins\Blog\Models\Category;
use Tukecx\Plugins\Blog\Models\Contracts\CategoryModelContract;
use Tukecx\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use DummyNamespace\Http\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @var Category
     */
    protected $category;

    public function __construct(CategoryRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param Category $item
     * @param array $data
     * @return mixed
     */
    public function handle(CategoryModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->category = $item;

        $happyMethod = '_template_' . studly_case($item->page_template);

        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }
        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        return $this->view('front.category-templates.default');
    }
}
