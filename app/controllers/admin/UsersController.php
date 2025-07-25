<?php 
namespace App\Controllers\Admin;

use Core\View;
class UsersController
{
    public function index()
    {
        View::render('users');
    }
}