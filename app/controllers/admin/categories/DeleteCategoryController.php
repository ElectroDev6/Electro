<?php
namespace App\Controllers\Admin\Categories;

use App\Models\admin\CategoriesModel;
use Container;
use Core\View;

class DeleteCategoryController
{
    public static function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ.";
            return;
        }
        $model = new CategoriesModel(Container::get('pdo'));
        $id = $_POST['id'];
        $name = $_POST['name'];
        if (!$id) {
            View::render('categories/index', [
                'error'      => 'ID danh mục không hợp lệ',
                'categories' => $model->fetchAllCategories()
            ]);
            return;
        }
        $success = $model->deleteCategory($id);
        if ($success) {
            header('Location: /admin/categories?success=Đã xoá danh mục  ' .$name);
            exit;
        }
        View::render('categories/index', [
            'error'      => 'Không thể xoá danh mục',
            'categories' => $model->fetchAllCategories()
        ]);
    }
}
