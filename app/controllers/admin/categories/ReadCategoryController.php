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
        $stats = $this->model->getCategoriesStats();
        
        View::render('categories/index', [
            'categories' => $categories,
            'stats' => $stats
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


    public function getSubcategories()
    {
        header('Content-Type: application/json');
        $category_id = $_GET['category_id'] ?? '';
        try {
            if (!$this->model) {
                throw new Exception('Model not initialized');
            }
            $result = $this->model->getSubcategories($category_id);
            echo json_encode($result ?: []); // Trả về mảng rỗng nếu null
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Lỗi server: ' . $e->getMessage()]);
        }
        exit;
    }

}