<?php

namespace App\Controllers\Web;

use Core\View;

class ProductLaptopController
{
    public function showAllLaptops()
    {
        View::render('productLaptop');
    }
}
