<?php

namespace App\Controllers\Web;

use Core\View;
use App\Services\CheckoutService;

class CheckoutController
{
    private CheckoutService $checkoutService;
    private ?int $userId;
    private string $sessionId;

    public function __construct(\PDO $pdo)
    {
        $this->checkoutService = new CheckoutService($pdo);
        $this->userId = $_SESSION['user_id'] ?? null;
        $this->sessionId = session_id();
    }

    /**
     * Hiển thị trang checkout
     */
    public function index()
    {
        $data = $this->checkoutService->getCheckoutData($this->userId, $this->sessionId);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;

        if (!empty($data['errors'])) {
            $_SESSION['error_message'] = $data['errors'][0];
            $_SESSION['post_login_redirect'] = '/checkout';
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => $data['errors'][0], 'redirect' => '/login']);
                exit;
            }
            header('Location: ' . ($this->userId ? '/cart' : '/login'));
            exit;
        }

        View::render('checkout', [
            'Items' => $data['items'],
            'user_address' => $data['user_address'],
            // 'errors' => $_SESSION['error_message'] ? [$_SESSION['error_message']] : []
        ]);

        unset($_SESSION['error_message']);
    }

    /**
     * Xử lý gửi form checkout
     */
    public function submit()
    {
        if (!$this->userId) {
            $_SESSION['error_message'] = 'Vui lòng đăng nhập để tiếp tục thanh toán.';
            $_SESSION['post_login_redirect'] = '/checkout';
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục thanh toán.', 'redirect' => '/login']);
                exit;
            }
            header('Location: /login');
            exit;
        }

        $orderId = $this->checkoutService->createOrder($this->userId, $_POST, $this->sessionId);

        if ($orderId) {
            if (($_POST['payment_method'] ?? 'cod') === 'zalopay') {
                $redirectUrl = $this->checkoutService->createVNPayUrl($this->userId, $orderId);
                if ($this->isAjax()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công.', 'redirect' => $redirectUrl]);
                    exit;
                }
                header("Location: $redirectUrl");
                exit;
            }
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công.', 'redirect' => '/thank-you']);
                exit;
            }
            header('Location: /thank-you');
            exit;
        } else {
            $_SESSION['error_message'] = 'Không thể tạo đơn hàng. Vui lòng thử lại.';
            if ($this->isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Không thể tạo đơn hàng. Vui lòng thử lại.', 'redirect' => '/checkout']);
                exit;
            }
            header('Location: /checkout');
            exit;
        }
    }

    /**
     * Kiểm tra xem yêu cầu có phải AJAX không
     * @return bool
     */
    private function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function pay()
    {
        // Lấy config
        require_once BASE_PATH . '/vnpay_php/vnpay_create_payment.php';
    }
}
