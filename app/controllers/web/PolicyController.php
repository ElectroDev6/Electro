<?php

namespace App\Controllers\Web;

use Core\View;

class PolicyController
{
    public function showMobilePolicy()
    {
        View::render('policy-mobile');
    }
}
