<?php

namespace App\Controllers\Admin;

use Core\View;
class ProductsController
{
    public function index()
    {
        View::render('products');
    }
}
