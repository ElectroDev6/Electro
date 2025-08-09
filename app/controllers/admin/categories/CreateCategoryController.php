<?php
namespace App\Controllers\Admin\Categories;

use App\Models\admin\CategoriesModel;
use Container;
use Core\View;

class CreateCategoryController
{
    private CategoriesModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new CategoriesModel($pdo);
    }

    public function index()
    {
        $categories = $this->model->fetchAllCategories();
        View::render('categories/create');
    }

    public function handleCreate()
    {
        session_start();
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = $_FILES['image'] ?? null;
        $slug = trim($_POST['slug'] ?? '');
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Vui lòng nhập tên danh mục.';
        } elseif ($this->model->categoryExistsByName($name)) {
            $errors['name'] = 'Tên danh mục đã tồn tại.';
        }
        if (empty($description)) {
            $errors['description'] = 'Vui lòng nhập mô tả danh mục.';
        }

        if (!empty($errors)) {
            View::render('categories/create', [
                'errors' => $errors,
                'name' => $name,
                'description' => $description,
                'slug' => $slug
            ]);
            return;
        }

        $imagePathForDB = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            if (!in_array($image['type'], $allowedTypes) || $image['size'] > $maxSize) {
                View::render('categories/create', [
                    'error' => 'Invalid image format or size exceeds 2MB',
                    'name' => $name,
                    'description' => $description,
                    'slug' => $slug
                ]);
                return;
            }
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/admin-ui/imgs/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                View::render('categories/create', [
                    'error' => 'Failed to create upload directory',
                    'name' => $name,
                    'description' => $description,
                    'slug' => $slug
                ]);
                return;
            }

            $filename = $image['name'];
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
                View::render('categories/create', [
                    'error' => 'Failed to upload image',
                    'name' => $name,
                    'description' => $description,
                    'slug' => $slug
                ]);
                return;
            }

            $imagePathForDB = '/admin-ui/imgs/' . $filename;
        }

        $id = $this->model->createCategory([
            'name' => $name,
            'description' => $description,
            'image' => $imagePathForDB,
            'slug' => $slug
        ]);

        if ($id) {
            $_SESSION['success'] = 'Tạo mới danh mục thành công!'; // Lưu thông báo vào session
            header('Location: /admin/categories/detail?id=' . $id);
            exit;
        }

        View::render('categories/create', [
            'error' => 'Không thể tạo danh mục.',
            'name' => $name,
            'description' => $description,
            'slug' => $slug
        ]);
    }
}
?>