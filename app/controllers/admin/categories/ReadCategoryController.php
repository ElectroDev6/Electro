<?php
namespace App\Controllers\Admin\Categories;

use App\Models\CategoriesModel;
use Container;
use Core\View;

class ReadCategoryController
{
    private CategoriesModel $model;

    public function __construct()
    {
        $this->model = new CategoriesModel(Container::get('pdo'));
    }

    public function list()
    {
        $categories = $this->model->fetchAllCategories();
        View::render('categories/index', [
            'categories' => $categories,
            'deleted'    => $_GET['deleted'] ?? null,
        ]);
    }

    public function detail()
    {
        $id = $_GET['category_id'];
        $category   = $this->model->getCategoryById($id);
        $categories = $this->model->fetchAllCategories();

        View::render('categories/detail', [ 
            'category'   => $category,
            'categories' => $categories,
        ]);
    }
}
