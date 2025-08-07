<?php
namespace App\Controllers\Admin\Categories;

use App\Models\admin\CategoriesModel;
use Container;
use Core\View;

class UpdateCategoryController
{
    private CategoriesModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new CategoriesModel($pdo);
    }
    public function index()
    {   
        $id = $_GET['id'];
        $category   = $this->model->getCategoryById($id);
        View::render('categories/update', [
            'category'   => $category,
        ]);
    }

   public function handle()
{
    $id = $_POST['category_id'];
    $category = $this->model->getCategoryById($id);

    if (!$id || !$category) {
        View::render('categories/update', [
            'error' => 'Danh mục không tồn tại.'
        ]);
        return;
    }

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = $_FILES['image'] ?? null;

    if (!$name || !$description) {
        View::render('categories/update', [
            'error'    => 'Vui lòng nhập đủ tên và mô tả.',
            'category' => $category
        ]);
        return;
    }

    $imagePathForDB = $category['image'] ?? null;

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg','image/png','image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($image['type'], $allowedTypes) || $image['size'] > $maxSize) {
            View::render('categories/update', [
                'error'    => 'Ảnh không hợp lệ hoặc quá lớn.',
                'category' => $category
            ]);
            return;
        }

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/img/category/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = basename($image['name']);
        $target = $uploadDir . $filename;

        if (!move_uploaded_file($image['tmp_name'], $target)) {
            View::render('categories/update', [
                'error'    => 'Không thể tải ảnh lên.',
                'category' => $category
            ]);
            return;
        }
        $imagePathForDB = '/img/category/' . $filename;
    }

    $success = $this->model->updateCategory($id, [
        'name'        => $name,
        'description' => $description,
        'image'       => $imagePathForDB
    ]);

    if ($success) {
    View::render('categories/detail', [
        'success' => 'Thay đổi danh mục thành công!',
        'category' => $this->model->getCategoryById($id)
    ]);
    exit;
    }

    View::render('categories/update', [
        'error'    => 'Cập nhật danh mục thất bại.',
        'category' => $category
    ]);
}

}
