<?php

namespace App\Controllers\Web;


use Core\View;

class ProductController
{
    public function showAll()
    {
        View::render('product');
    }
}
