<?php
namespace App\Controllers\Admin\Categories;

use App\Models\admin\CategoriesModel;
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
            'categories' => $categories
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/categories');
            exit;
        }

        $category = $this->model->getCategoryById($id);
        if (!$category) {
            header('Location: /admin/categories');
            exit;
        }
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        View::render('categories/detail', [
            'category' => $category,
            'success' => $success
        ]);
    }
}
