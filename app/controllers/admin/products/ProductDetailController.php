<?php

namespace App\Controllers\Admin\Products;
// namespace trong PHP dùng để định danh (xác định) vị trí và tên đầy đủ của class
use App\Models\ProductsModel;
use Core\View;
use Container;

class ProductDetailController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $id = $_GET['id'] ?? null;
        $product = null;
        $product = $productModel->getProductById($id);
        View::render('products/detail', [
            'product' => $product
        ]);
    }
}