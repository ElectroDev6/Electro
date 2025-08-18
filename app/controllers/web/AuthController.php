<?php

namespace App\Controllers\Web;

use App\Services\AuthService;
use App\Models\CartModel;
use Core\View;

class AuthController
{
    private $authService;
    private $cartModel;

    public function __construct(\PDO $pdo)
    {
        $this->authService = new AuthService($pdo);
        $this->cartModel = new CartModel($pdo); // Khởi tạo CartModel
    }

    public function showAuthForm()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        View::render('auth', ['error' => null, 'old' => [], 'formType' => null]);
    }

    public function handleAuth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Thiết lập session timeout trước khi bắt đầu session
            ini_set('session.gc_maxlifetime', 3600);
            session_set_cookie_params(3600);
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
        $isAjax = $this->isAjax();
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
            $_SESSION['user_role'] = $user['role'];

            // Hợp nhất giỏ hàng session_id với user_id
            if (
                !empty($_SESSION['post_login_redirect']) &&
                in_array($_SESSION['post_login_redirect'], ['/cart', '/checkout']) &&
                $this->cartModel->sessionCartExists(session_id())
            ) {
                $sessionId = session_id();
                $userCartId = $this->cartModel->getOrCreateCart($user['user_id'], $sessionId, true);
                error_log("AuthController: Merged cart for UserID: {$user['user_id']}, SessionID: $sessionId, CartID: $userCartId");
            }

            // Nếu chọn "Nhớ mật khẩu", tái tạo session ID
            if ($remember) {
                session_regenerate_id(true);
            }

            $redirect = $_SESSION['post_login_redirect'] ?? ($user['role'] === 'admin' ? '/admin/index' : '/');
            unset($_SESSION['post_login_redirect']);

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công', 'redirect' => $redirect]);
                exit;
            }

            // Chuyển hướng dựa trên post_login_redirect hoặc vai trò
            if ($redirect === '/cart/confirm') {
                $redirect = '/checkout';
            }
            header('Location: ' . $redirect);
            exit;
        }

        View::render('auth', [
            'error' => 'Tên đăng nhập hoặc mật khẩu không đúng',
            'old' => $old,
            'formType' => 'login'
        ]);
    }

    private function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
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

        if ($name === '' || $phone === '' || $password === '' || $rePassword === '') {
            View::render('auth', [
                'error' => 'Vui lòng nhập đầy đủ thông tin',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        if (!preg_match('/^0\d{8,10}$/', $phone)) {
            View::render('auth', [
                'error' => 'Số điện thoại không hợp lệ',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

        if ($password !== $rePassword) {
            View::render('auth', [
                'error' => 'Mật khẩu nhập lại không khớp',
                'old' => $old,
                'formType' => 'register'
            ]);
            return;
        }

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
