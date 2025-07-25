<?php
namespace App\Controllers\Admin;

use Core\View;
    class OrderDetailController
    {
        public function index()
        {
            View::render('orderDetail');
        }
    }