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
        try {
            $products = $this->model->fetchAllProducts();
            View::render('products/index', [
                'products' => $products
            ]);
        } catch (\Exception $e) {
            echo "<pre>";
            var_dump($e);
            echo "</pre>";
            die;
        }
    }

    public function detail()
    {
        $productId = $_GET['id'] ?? null;

        if (!$productId) {
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