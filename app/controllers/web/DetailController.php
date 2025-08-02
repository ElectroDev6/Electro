<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use Core\View;

class DetailController
{
    private $productService;

    public function __construct(\PDO $pdo)
    {
        // Truyền PDO vào Service
        $this->productService = new ProductService($pdo);
    }

    public function showDetail($slug)
    {
        $product = $this->productService->getProductService($slug);
        // debug tạm thờ<i></i>
        // echo '<pre>';
        // print_r($product);
        // echo '</pre>';
        // exit;

        View::render('detail', ['product' => $product]);
    }
}
