<?php

namespace App\controllers\web;

use Core\View;

class LoginController
{
    public function login()
    {
        View::render('login');
    }
}
