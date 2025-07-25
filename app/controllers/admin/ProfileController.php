<?php
namespace App\Controllers\Admin;

use Core\View;
    class ProfileController {
        public function index() {
            View::render('profile');
        }
    }