<?php

namespace App\Controllers\Web;

use Core\View;

class AboutController
{
    public function showAbout()
    {
        View::render('about');
    }
}
