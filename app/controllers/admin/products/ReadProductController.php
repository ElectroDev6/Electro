<?php
namespace App\Controllers\Admin\Products;

use App\Models\admin\ProductsModel;
use Core\View;
use Container;

class ReadProductController
{
    private ProductsModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        if (!$pdo) {
            error_log("Kết nối PDO thất bại trong ReadProductController");
            throw new \Exception("Không thể kết nối cơ sở dữ liệu.");
        }
        $this->model = new ProductsModel($pdo);
    }

    public function list()
    {
        $name = isset($_GET['name']) ? trim($_GET['name']) : '';
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';
        $brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
        $price_sort = isset($_GET['price_sort']) ? trim($_GET['price_sort']) : '';
        $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        $filters = [];
        if ($name !== '') $filters['name'] = $name;
        if ($category !== '') $filters['category'] = $category;
        if ($brand !== '') $filters['brand'] = $brand;
        if ($price_sort !== '') $filters['price_sort'] = $price_sort;
        $offset = ($page - 1) * $limit;
        try {
            $result = $this->model->fetchAllProducts($filters, $limit, $offset);
            $categories = $this->model->getCategories();
            $brands = $this->model->getBrands();

            View::render('products/index', [
                'products' => $result['products'],
                'totalProducts' => $result['total'],
                'productsPerPage' => $result['perPage'],
                'totalPages' => ceil($result['total'] / $result['perPage']),
                'page' => $result['currentPage'],
                'name' => $name,
                'category' => $category,
                'brand' => $brand,
                'price_sort' => $price_sort,
                'limit' => $limit,
                'categories' => $categories,
                'brands' => $brands
            ]);
        } catch (\Exception $e) {
            error_log("Lỗi trong controller: " . $e->getMessage());
            View::render('error', [
                'message' => 'Đã xảy ra lỗi khi tải danh sách sản phẩm.'
            ]);
        }
    }

    public function detail()
    {
        $productId = $_GET['id'] ?? null;

        if (!$productId || !is_numeric($productId)) {
            header('Location: /admin/products');
            exit;
        }
        
        $product = $this->model->getProductById($productId);

        if (!$product) {
            header('Location: /admin/products');
            exit;
        }

        View::render('products/detail', [
            'product' => $product
        ]);
        
    }
}
?>