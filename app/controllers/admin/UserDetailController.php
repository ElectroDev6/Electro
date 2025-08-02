<?php 
namespace App\Controllers\Admin;
use App\Models\UsersModel;
use Container;
use Core\View;
    class UserDetailController {
        public function index() {
            $pdo = Container::get('pdo');
            $usersModel = new UsersModel($pdo);
            $users = $usersModel->getAllUsers();
            $id = $_GET['id'] ?? null;
            $user = null;
            foreach ($users as $u) {
                if ($u['id'] == $id) {
                    $user = $u;
                    break;
                }
            }
            View::render('userDetail', [
                'user' => $user
            ]);
        }
    }