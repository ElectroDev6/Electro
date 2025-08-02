<?php
namespace App\Controllers\Admin\Categories;

use App\Models\CategoriesModel;
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
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $category   = $this->model->getCategoryById($id);
        $categories = $this->model->fetchAllCategories();
        View::render('categories/update', [
            'category'   => $category,
            'categories' => $categories,
        ]);
    }


    public function handle()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $name = trim($_POST['name'] ?? '');
        $content_html = trim($_POST['content_html'] ?? '');
        $image = $_FILES['image'] ?? null;

        // Lấy luôn record cũ để đổ lại form nếu lỗi
        $category = $this->model->getCategoryById($id);

        if (!$id || !$name || !$content_html) {
            View::render('categories/update', [
                'error'    => 'Vui lòng nhập đủ tên và mô tả.',
                'category' => $category
            ]);
            return;
        }

        $imagePathForDB = $category['image'] ?? null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            // xử lý upload giống Create...
            $allowedTypes = ['image/jpeg','image/png','image/gif'];
            $maxSize = 2*1024*1024;
            if (!in_array($image['type'],$allowedTypes) || $image['size']>$maxSize) {
                View::render('categories/update', [
                    'error'    => 'Ảnh không hợp lệ hoặc quá lớn.',
                    'category' => $category
                ]);
                return;
            }
            $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/admin-ui/imgs/';
            if (!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
            $filename = $image['name'];
            $target = $uploadDir.$filename;
            if (!move_uploaded_file($image['tmp_name'],$target)) {
                View::render('categories/update', [
                    'error'    => 'Không thể tải ảnh lên.',
                    'category' => $category
                ]);
                return;
            }
            $imagePathForDB = '/admin-ui/imgs/'.$filename;
        }

        $success = $this->model->updateCategory($id, [
            'name'         => $name,
            'content_html' => $content_html,
            'image'        => $imagePathForDB
        ]);

        if ($success) {
            header('Location: /admin/categories/detail?id='.$id);
            exit;
        }

        View::render('categories/update', [
            'error'    => 'Cập nhật danh mục thất bại.',
            'category' => $category
        ]);
    }
}
