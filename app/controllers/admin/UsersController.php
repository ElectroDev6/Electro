<?php 
namespace App\Controllers\Admin;
use App\Models\UsersModel;
use Container;
use Core\View;
class UsersController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $usersModel = new UsersModel($pdo);
        $users = $usersModel->getAllUsers();
        View::render('users', [
            'users' => $users
        ]);
    }
}