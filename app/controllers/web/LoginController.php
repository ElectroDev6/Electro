<?php

namespace App\controllers\web;

use Core\View;

class LoginController
{
    private $fakeUsers = [
        [
            'username' => 'admin',
            'password' => '123456',
            'phone' => '0909999999',
            'role' => 'Admin'
        ],
        [
            'username' => 'user1',
            'password' => 'password',
            'phone' => '0911111111',
            'role' => 'Khách hàng'
        ]
    ];

    public function showLoginForm()
    {
        View::render('login', ['error' => null]);
    }

    public function handleAuth()
    {
        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            $this->handleLogin();
        } elseif ($action === 'register') {
            $this->handleRegister();
        } else {
            View::render('login', ['error' => 'Yêu cầu không hợp lệ']);
        }
    }

    private function handleLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        foreach ($this->fakeUsers as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $_SESSION['user'] = $user;

                // Chuyển hướng dựa theo role
                if ($user['role'] === 'Admin') {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit;
            }
        }

        View::render('login', ['error' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }

    private function handleRegister()
    {
        $username = $_POST['reg_username'] ?? '';
        $password = $_POST['reg_password'] ?? '';
        $rePassword = $_POST['reg_repassword'] ?? '';
        $phone = $_POST['reg_phone'] ?? '';

        if ($password !== $rePassword) {
            View::render('login', ['error' => 'Mật khẩu nhập lại không khớp']);
            return;
        }

        // Mặc định user đăng ký là khách hàng
        $_SESSION['user'] = [
            'username' => $username,
            'password' => $password,
            'phone' => $phone,
            'role' => 'Khách hàng'
        ];

        header('Location: /');
        exit;
    }
}
