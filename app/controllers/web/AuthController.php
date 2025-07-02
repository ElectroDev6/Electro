<?php

namespace App\Controllers\Web;

use App\Models\Web\AuthModel;

class AuthController
{
    public function login()
    {
        echo "Đây là trang đăng nhập";

        require_once BASE_PATH . './config/db.php';
        require_once BASE_PATH . './app/models/web/AuthModel.php';
        $authModel = new AuthModel($pdo);
        $users = $authModel->getAllUsers();
        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }
}
