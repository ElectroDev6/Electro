<?php

namespace App\Controllers\Web;

use Core\View;

class SearchLaptopController
{
    public function searchLaptops()
    {
        View::render('searchLaptop');
    }
}
