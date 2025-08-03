<?php

namespace App\Controllers\Web;

use Core\View;

class CheckoutController
{
    public function showCheckoutForm()
    {
        View::render('checkout');
    }
}
