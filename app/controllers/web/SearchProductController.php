<?php

namespace App\Controllers\Web;

use Core\View;

class SearchProductController
{
    public function searchProducts()
    {
        View::render('searchProduct');
    }
}
