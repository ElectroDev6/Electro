<?php

namespace App\Controllers\Web;

use App\Models\Web\AuthModel;

class AuthController
{

    private $authModel;

    public function __construct(\PDO $pdo)
    {
        $this->authModel = new AuthModel($pdo);
    }

    public function login()
    {
        echo "Đây là trang đăng nhập";
        $users = $this->authModel->getAllUsers();
        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }
}
