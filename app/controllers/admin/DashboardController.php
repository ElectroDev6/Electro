<?php

namespace App\Controllers\Admin;

use Core\View;

class DashboardController
{
    public function index()
    {
        View::render('dashboard');
    }
}
