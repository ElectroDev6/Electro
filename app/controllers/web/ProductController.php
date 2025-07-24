<?php

namespace App\Controllers\Web;


use Core\View;

class ProductController
{
    public function product()
    {
        View::render('product');
    }
}
