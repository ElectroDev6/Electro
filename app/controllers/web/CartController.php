<?php

namespace App\Controllers\Web;

use Core\View;

class CartController
{
    public function showCart()
    {
        View::render('cart');
    }
}
