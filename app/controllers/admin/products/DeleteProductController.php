<?php

namespace App\Controllers\Admin\Products;

use App\Models\ProductsModel;
use Container;

class DeleteProductController
{
    public function handle()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $productId = $_POST['product_id'] ?? null;

        if (!$productId) {
            // Handle error: No product ID provided
            header('Location: /admin/products?error=No product ID provided');
            exit;
        }

        $success = $productModel->deleteProduct($productId);

        if ($success) {
            header('Location: /admin/products');
            exit;
        } else {
            // Handle error
            header('Location: /admin/products?error=Failed to delete product');
            exit;
        }
    }
}