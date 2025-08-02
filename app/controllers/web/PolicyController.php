<?php

namespace App\Controllers\Web;

use Core\View;

class PolicyController
{
    public function Policy()
    {
        View::render('policy');
    }
}
