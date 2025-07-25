<?php
namespace App\Controllers\Admin;

use Core\View;
    class ReviewsController 
    {
        public function index() 
        {
         View::render('reviews');
        }
    }
    