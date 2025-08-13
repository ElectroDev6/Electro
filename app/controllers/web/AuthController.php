<?php

namespace App\Controllers\Web;

use App\Services\AuthService;
use Core\View;

class AuthController
{
    private $authService;

    public function __construct(\PDO $pdo)
    {
        $this->authService = new AuthService($pdo);
    }

    // Hiển thị form login/register
    public function showAuthForm()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Nếu đã login rồi redirect sang trang chính
        if (!empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        View::render('auth', ['error' => null, 'old' => [], 'formType' => null]);
    }

    public function handleAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            $this->handleLogin();
        } elseif ($action === 'register') {
            $this->handleRegister();
        } else {
            View::render('auth', ['error' => 'Yêu cầu không hợp lệ', 'old' => [], 'formType' => null]);
        }
    }

    private function handleLogin()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $old = ['username' => $username, 'remember' => $remember ? 'checked' : ''];

        if ($username === '' || $password === '') {
            View::render('auth', [
                'error' => 'Vui lòng nhập đầy đủ thông tin',
                'old' => $old,
                'formType' => 'login'
            ]);
            return;
        }

        $user = $this->authService->login($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];

            // Nếu chọn "Nhớ mật khẩu", lưu session có thời gian 1 giờ
            if ($remember) {
                // Tạo session với thời gian 1 giờ (3600s)
                ini_set('session.gc_maxlifetime', 3600);
                session_set_cookie_params(3600);
                session_regenerate_id(true);
            }

            if ($user['role'] === 'admin') {
                header('Location: /admin');
            } else {
                header('Location: /');
            }
            exit;
        }

        View::render('auth', [
            'error' => 'Tên đăng nhập hoặc mật khẩu không đúng',
            'old' => $old,
            'formType' => 'login'
        ]);
    }

    private function handleRegister()
    {
        $name = trim($_POST['reg_username'] ?? '');
        $phone = trim($_POST['reg_phone'] ?? '');
        $email = trim($_POST['reg_email'] ?? '');
        $password = $_POST['reg_password'] ?? '';
        $rePassword = $_POST['reg_repassword'] ?? '';

        $old = [
            'reg_username' => $name,
            'reg_phone' => $phone,
        ];

        // Validate bắt buộc
        if ($name === '' || $phone === '' || $password === '' || $rePassword === '') {
            View::render('auth', [
                'error' => 'Vui lòng nhập đầy đủ thông tin',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        // Validate số điện thoại: bắt đầu bằng 0, tối đa 11 số, chỉ số
        if (!preg_match('/^0\d{8,10}$/', $phone)) {
            View::render('auth', [
                'error' => 'Số điện thoại không hợp lệ',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        // Mật khẩu khớp
        if ($password !== $rePassword) {
            View::render('auth', [
                'error' => 'Mật khẩu nhập lại không khớp',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        // Email validate
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            View::render('auth', [
                'error' => 'Email không hợp lệ hoặc đã được sử dụng',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        $user = $this->authService->register($name, $email, $phone, $password);

        if (is_array($user) && isset($user['error'])) {
            View::render('auth', [
                'error' => $user['error'],
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        if ($user) {
            View::render('auth', [
                'success' => 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục',
                'old' => [],
                'formType' => 'register'
            ]);
            return;
        }

        View::render('auth', [
            'error' => 'Đăng ký thất bại hoặc lỗi hệ thống',
            'old' => $old,
            'formType' => 'register'
        ]);
    }

    // Hiển thị form quên mật khẩu
    public function showForgotPasswordForm()
    {
        View::render('forgot-password', ['error' => null, 'success' => null]);
    }

    // Xử lý form gửi email quên mật khẩu
    public function handleForgotPassword()
    {
        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            View::render('forgot-password', ['error' => 'Vui lòng nhập email', 'success' => null]);
            return;
        }

        $result = $this->authService->sendPasswordResetLink($email);

        if ($result) {
            View::render('forgot-password', ['error' => null, 'success' => 'Vui lòng kiểm tra email để đặt lại mật khẩu']);
        } else {
            View::render('forgot-password', ['error' => 'Email không tồn tại hoặc lỗi hệ thống', 'success' => null]);
        }
    }

    // Hiển thị form đặt lại mật khẩu mới
    public function showResetPasswordForm()
    {
        $token = $_GET['token'] ?? '';

        if (!$token || !$this->authService->validateResetToken($token)) {
            echo "Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.";
            exit;
        }

        View::render('reset-password', ['error' => null, 'token' => $token]);
    }

    // Xử lý đặt lại mật khẩu mới
    public function handleResetPassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $rePassword = $_POST['re_password'] ?? '';

        if ($password === '' || $rePassword === '') {
            View::render('reset-password', ['error' => 'Vui lòng nhập đầy đủ mật khẩu', 'token' => $token]);
            return;
        }

        if ($password !== $rePassword) {
            View::render('reset-password', ['error' => 'Mật khẩu nhập lại không khớp', 'token' => $token]);
            return;
        }

        if ($this->authService->resetPassword($token, $password)) {
            header('Location: /login?reset=success');
            exit;
        } else {
            View::render('reset-password', ['error' => 'Link không hợp lệ hoặc đã hết hạn', 'token' => $token]);
        }
    }
}
