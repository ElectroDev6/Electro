<?php

namespace App\Controllers\Web;

use App\Services\AuthService;
use App\Models\AuthModel;
use Core\View;

class AuthController
{
    private $authService;

    public function __construct(\PDO $pdo)
    {
        $authModel = new AuthModel($pdo);
        $this->authService = new AuthService($authModel);
    }

    public function showAuthForm()
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
        $email = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            View::render('login', ['error' => 'Vui lòng nhập đầy đủ thông tin']);
            return;
        }

        $user = $this->authService->login($email, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];

            if ($user['role'] === 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /');
            }
            exit;
        }

        View::render('login', ['error' => 'Email hoặc mật khẩu không đúng']);
    }

    private function handleRegister()
    {
        $name = $_POST['reg_username'] ?? '';
        $email = $name; // Sử dụng email làm username tạm thời, cần điều chỉnh form để lấy email thực tế
        $phone = $_POST['reg_phone'] ?? '';
        $password = $_POST['reg_password'] ?? '';
        $rePassword = $_POST['reg_repassword'] ?? '';

        if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($rePassword)) {
            View::render('login', ['error' => 'Vui lòng nhập đầy đủ thông tin']);
            return;
        }

        if ($password !== $rePassword) {
            View::render('login', ['error' => 'Mật khẩu nhập lại không khớp']);
            return;
        }

        $user = $this->authService->register($name, $email, $phone, $password);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['register_success'] = true; // Đặt flag thành công

            // Render lại trang login với thông báo
            View::render('login', ['success' => 'Đăng ký thành công!']);
            exit;
        }

        View::render('login', ['error' => 'Đăng ký thất bại. Email đã tồn tại hoặc lỗi hệ thống']);
    }
}
