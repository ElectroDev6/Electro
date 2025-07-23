<?php

namespace App\Controllers\Web;

use App\Models\AuthModel;

class AuthController
{

    private $authModel;

    public function __construct(\PDO $pdo)
    {
        $this->authModel = new AuthModel($pdo);
    }

    public function login()
    {
        $users = $this->authModel->getAllUsers();
        render('login');
    }
}
