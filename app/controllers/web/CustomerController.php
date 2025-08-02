<?php

namespace App\Controllers\Web;

use Core\View;

class CustomerController
{
    public function Customer()
    {
        View::render('customer');
    }
}
