<?php

namespace App\Controllers\Admin;

use App\Models\ProductsModel;
use Core\View;
use Container;

class ProductDetailController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $products = $productModel->getAllProducts();

        $id = $_GET['id'] ?? null;
        $product = null;
        foreach ($products as $p) {
            if ($p['product_id'] == $id) {
                $product = $p;
                break;
            }
        }
        View::render('product', [
            'productDetail' => $product
        ]);
    }
}