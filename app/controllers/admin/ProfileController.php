<?php
namespace App\Controllers\Admin;

use App\Models\admin\UsersModel;
use Container;
use Core\View;

class ProfileController {
    private UsersModel $model;

    public function __construct() {
        $pdo = Container::get('pdo');
        $this->model = new UsersModel($pdo);
    }

    public function index() {
        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id) {
            $user = $this->model->getUserById($user_id);
            View::render('profile', ['user' => $user]);

        } else {
            echo "Chưa đăng nhập.";
        }
    }
}
