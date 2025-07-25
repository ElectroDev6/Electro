<?php
namespace App\Controllers\Admin;

use Core\View;
    class CommentsController
    {
        public function index()
        {
            View::render('comments');
        }
    }