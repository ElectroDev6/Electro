<?php

namespace App\controllers\web;

use Core\View;

class LoginController
{
    public function showLoginForm()
    {
        View::render('login');
    }
}
