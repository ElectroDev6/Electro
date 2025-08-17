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
   public function submit($request) {
    $userId = $_SESSION['user_id'];
    $orderCode = uniqid('ORD');
    
    $cartItems = $this->cartModel->getCartItemsByUser($userId);

    if (empty($cartItems)) {
        throw new \Exception("Giỏ hàng trống");
    }

    $orderId = $this->checkoutService->createOrder($userId, $cartItems, $orderCode);

    // Redirect sang trang cảm ơn
    header("Location: /checkout/thankyou?order_id=" . $orderId);
    exit;
}



    /**
     * Kiểm tra xem yêu cầu có phải AJAX không
     * @return bool
     */
    private function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
