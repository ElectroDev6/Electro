<?php
namespace App\Controllers\Admin\Categories;

use App\Models\CategoriesModel;
use Container;
use Core\View;

class DeleteCategoryController
{
    public static function handle()
    {
        $model = new CategoriesModel(Container::get('pdo'));
        // Lấy id từ GET thay vì POST
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            View::render('categories/index', [
                'error'      => 'ID danh mục không hợp lệ',
                'categories' => $model->fetchAllCategories()
            ]);
            return;
        }
        $success = $model->deleteCategory($id);
        if ($success) {
            header('Location: /admin/categories?deleted=' . $id);
            exit;
        }

        View::render('categories/index', [
            'error'      => 'Không thể xoá danh mục',
            'categories' => $model->fetchAllCategories()
        ]);
    }
}
