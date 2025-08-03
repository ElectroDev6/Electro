<?php

namespace App\Controllers\Admin\Products;

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use Core\View;
use Container;

class ReadProductController
{
    public function list()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $categoriesModel = new CategoriesModel($pdo);
        $products = $productModel->getAllProducts();
        $categories = $categoriesModel->fetchAllCategories();
        $colors = $productModel->getAllColors();

        View::render('products/index', [
            'getProducts' => $products,
            'categories' => $categories,
            'colors' => $colors
        ]);
    }

    public function detail()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $categoriesModel = new CategoriesModel($pdo);
        $productId = $_GET['id'] ?? null;

        if (!$productId) {
            // Handle error: No product ID provided
            header('Location: /admin/products');
            exit;
        }

        $product = $productModel->getProductById($productId);
        $categories = $categoriesModel->fetchAllCategories();

        if (!$product) {
            // Handle error: Product not found
            header('Location: /admin/products');
            exit;
        }

        View::render('products/detail', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }
}