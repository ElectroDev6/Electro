<?php 
namespace App\Controllers\Admin;

use Core\View;
    class UserDetailController {
        public function index() {
            View::render('userDetail');
        }
    }