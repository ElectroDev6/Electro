<?php 
namespace App\Controllers\Admin;

use Core\View;
    class CommentDetailController {
        public function index() {
             View::render('commentDetail');
        }
    }