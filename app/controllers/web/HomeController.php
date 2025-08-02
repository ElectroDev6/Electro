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


        // echo "<pre>";
        // print_r($iphoneProducts);
        // exit;
        // echo "</pre>";

        View::render('home', [
            'iphoneProducts' => $iphoneProducts
        ]);

        View::render('home');
    }
}
