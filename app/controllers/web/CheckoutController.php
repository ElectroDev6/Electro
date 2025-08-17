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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) die("Bạn cần đăng nhập");

            $userAddressId = $_POST['user_address_id'] ?? null;
            $couponId = $_POST['coupon_id'] ?? null;

            $orderId = $this->checkoutService->createOrder($userId, $userAddressId, $couponId);

            if ($orderId) {
                header("Location: /checkout/thankyou?order_id=".$orderId);
                exit;
            } else {
                die("Đặt hàng thất bại.");
            }
        }
    }

    public function thankyou()
    {
        $orderId = $_GET['order_id'] ?? null;
        return View::render('checkout/thankyou', ['orderId' => $orderId]);
    }

}
