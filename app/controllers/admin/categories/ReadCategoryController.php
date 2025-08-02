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

    // Hiển thị list (trang chính)
    public function list()
    {
        $categories = $this->model->fetchAllCategories();
        // Chuyển tên view thành 'categories/index' nếu bạn lưu ở đó
        View::render('categories/index', [
            'categories' => $categories,
            'deleted'    => $_GET['deleted'] ?? null,
        ]);
    }

    // Hiển thị detail để sửa
    public function detail()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $category   = $this->model->getCategoryById($id);
        $categories = $this->model->fetchAllCategories();

        if (!$category) {
            View::render('categories/index', [
                'error'      => 'Không tìm thấy danh mục.',
                'categories' => $categories
            ]);
            return;
        }

        View::render('categories/detail', [
            'category'   => $category,
            'categories' => $categories,
        ]);
    }
}
