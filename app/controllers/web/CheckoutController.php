<?php

namespace App\Controllers\Web;

use Core\View;

class CheckoutController
{
    public function index()
    {
        View::render('checkout');
    }
}
