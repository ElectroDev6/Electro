<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use Core\View;

class ProductController
{
    private $productService;
    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
    }
    public function showAll()
    {
        View::render('product', []);
    }
}
