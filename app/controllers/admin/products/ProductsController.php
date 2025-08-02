<?php

namespace App\Controllers\Admin\Products;

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use Core\View;
use Container;
class ProductsController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        // Khởi tạo model và lấy dữ liệu
        $productModel = new ProductsModel($pdo);
        $categoriesModel = new CategoriesModel($pdo);
        // $products = $productModel->getAllProducts();
        $getProducts = $productModel->getProducts();
        $categories = $categoriesModel->fetchAllCategories();
        // Truyền dữ liệu sang view
        View::render('products/index', [
            // 'products' => $products,
            'categories' => $categories,
            'getProducts' => $getProducts,
        ]);
    }
}
