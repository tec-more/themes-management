<?php namespace DummyNamespace\Http\Controllers\Blog;

use Tukecx\Plugins\Blog\Models\Contracts\PostModelContract;
use Tukecx\Plugins\Blog\Models\Post;
use Tukecx\Plugins\Blog\Repositories\CategoryRepository;
use Tukecx\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use Tukecx\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use Tukecx\Plugins\Blog\Repositories\PostRepository;
use DummyNamespace\Http\Controllers\AbstractController;

class PostController extends AbstractController
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(PostRepositoryContract $repository, CategoryRepositoryContract $categoryRepository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Post $item
     * @return mixed
     */
    public function handle(PostModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->post = $item;

        $happyMethod = '_template_' . studly_case($item->page_template);
        if (method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }
        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        return $this->view('front.post-templates.default');
    }
}
