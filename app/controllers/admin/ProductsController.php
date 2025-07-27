<?php

namespace App\Controllers\Admin;

use App\Models\ProductsModel;
use Core\View;
use Container;

class ProductsController
{
    public function index()
    {
        // Lấy PDO từ container
        $pdo = Container::get('pdo');

        // Khởi tạo model và lấy dữ liệu
        $productModel = new ProductsModel($pdo);
        $products = $productModel->getAllProducts();

        // Truyền dữ liệu sang view
        View::render('products', [
            'products' => $products
        ]);
    }
}
