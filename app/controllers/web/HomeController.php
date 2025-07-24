<?php

namespace App\Controllers\Web;

use Core\View;

class HomeController
{
    public function index()
    {
        View::render('home', [
            'products' => [
                ['id' => 1, 'name' => 'Sản phẩm A', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 2, 'name' => 'Sản phẩm B', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 3, 'name' => 'Sản phẩm C', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 4, 'name' => 'Sản phẩm D', 'price' => 1000, 'image' => '/img/product1.webp'],
            ]
        ]);
    }
}
