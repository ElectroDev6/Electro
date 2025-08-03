<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use Core\View;

class HomeController
{
    private $productService;

    public function __construct(\PDO $pdo)
    {
        // Truyền PDO vào Service
        $this->productService = new ProductService($pdo);
    }

    public function index()
    {
        $iphoneProducts = $this->productService->getHomeProductsByCategoryId(1, 15);
        $saleProducts = $this->productService->getSaleProducts(5);

        $featuredProducts = $this->productService->getFeaturedProducts(9);


        // Tách ra 1 sản phẩm featured + các sản phẩm còn lại
        $featuredProduct = $featuredProducts[0] ?? null;
        $regularProducts = array_slice($featuredProducts, 1);

        // echo "<pre>";
        // print_r($regularProducts);
        // exit;
        // echo "</pre>";

        View::render('home', [
            'iphoneProducts' => $iphoneProducts,
            'saleProducts' => $saleProducts,
            'featuredProduct' => $featuredProduct,
            'regularProducts' => $regularProducts
        ]);
    }
}
