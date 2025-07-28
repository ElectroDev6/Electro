<?php

namespace App\Controllers\Web;

use Core\View;

class AboutController
{
    public function about()
    {
        View::render('about');
    }
}