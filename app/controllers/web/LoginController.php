<?php

namespace App\controllers\web;

use Core\View;

class LoginController
{
    public function index()
    {
        View::render('login');
    }
}
