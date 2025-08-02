<?php
namespace App\Controllers\Admin\Categories;

use App\Models\CategoriesModel;
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
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim(filter_input(INPUT_POST, 'name'));
    $description = trim(filter_input(INPUT_POST, 'content_html'));
    $image = $_FILES['image'] ?? null;

    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = 'Vui lòng nhập tên danh mục.';
    } elseif ($this->model->categoryExistsByName($name, $id)) {
        $errors[] = 'Tên danh mục đã tồn tại.';
    }

    if (empty($description)) {
        $errors[] = 'Vui lòng nhập mô tả danh mục.';
    }

    // Nếu có lỗi → render lại form
    if (!empty($errors)) {
        $category = $this->model->getCategoryById($id);
        View::render('categories/update', [
            'errors' => $errors,
            'category' => $category
        ]);
        return;
    }
        // Handle image upload
        $imagePathForDB = null;
        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($image['type'], $allowedTypes) || $image['size'] > $maxSize) {
                View::render('categories/create', [
                    'error' => 'Invalid image format or size exceeds 2MB',
                    'categories' => $this->model->fetchAllCategories()
                ]);
                return;
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/admin-ui/imgs/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                View::render('categories/create', [
                    'error' => 'Failed to create upload directory',
                    'categories' => $this->model->fetchAllCategories()
                ]);
                return;
            }

            $filename = $image['name'];
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
                View::render('categories/create', [
                    'error' => 'Failed to upload image',
                    'categories' => $this->model->fetchAllCategories()
                ]);
                return;
            }

            $imagePathForDB = '/admin-ui/imgs/' . $filename;
        }

        // Create category
        $id = $this->model->createCategory([
            'name' => $name,
            'content_html' => $description,
            'image' => $imagePathForDB
        ]);

        if ($id) {
            header('Location: /admin/categories/detail?id=' . $id . '&success=1');
            exit;
        }

        View::render('categories/create', [
            'error' => 'Failed to create category',
            'categories' => $this->model->fetchAllCategories()
        ]);
    }
}
?>