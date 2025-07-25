<?php
namespace App\Controllers\Admin;

use Core\View;
    class OrdersController
    {
        public function index()
        {
            View::render('orders');
        }
    }