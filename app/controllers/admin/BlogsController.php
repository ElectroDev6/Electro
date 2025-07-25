<?php 
namespace App\Controllers\Admin;

use Core\View;
    class BlogsController
    {
        public function index() 
        {
            View::render('blogs'); // nếu View là class có hàm static render()
        }
    }