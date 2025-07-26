<?php

namespace App\Controllers\Web;

use Core\View;

class InformationController
{
    public function information()
    {
        View::render('information');
    }
}
