<?php

namespace App\Controllers\Web;

use Core\View;
use Core\Redirect;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\ProductService;

class CheckoutController
{
    protected CartService $cartService;
    protected CheckoutService $checkoutService;
    protected int $userId;
    protected string $sessionId;

    public function __construct(\PDO $pdo)
    {
        $productService = new ProductService($pdo);

        $this->cartService = new CartService($pdo, $productService);
        $this->checkoutService = new CheckoutService($pdo, $productService);

        $this->userId = $_SESSION['user_id'] ?? 1; // Giả lập nếu chưa login
        $this->sessionId = session_id();
    }

    /**
     * Trang checkout
     */
    public function index()
    {
        // Chỉ lấy sản phẩm đã chọn để thanh toán
        $cartData = $this->cartService->getSelectedCartWithSummary($this->userId, $this->sessionId);

        if (empty($cartData['products'])) {
            $_SESSION['error_message'] = "Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.";
            Redirect::to('/cart');
            return;
        }

        View::render('checkout', ['cart' => $cartData]);
    }

    /**
     * Xác nhận đơn hàng (COD)
     */
    public function submit()
    {
        $postData = $_POST;

        // Lấy sản phẩm đã chọn
        $cartItems = $this->cartService->getSelectedCartItems($this->userId, $this->sessionId);

        if (empty($cartItems)) {
            Redirect::to('/checkout?error=cart-empty');
            return;
        }

        // Tạo đơn
        $orderId = $this->checkoutService->createOrder($this->userId, $postData, $cartItems);

        if ($orderId) {
            // Xóa sản phẩm đã chọn khỏi giỏ
            $this->cartService->clearSelectedItems($this->userId, $this->sessionId);

            Redirect::to('/thank-you');
        } else {
            Redirect::to('/checkout?error=order-failed');
        }
    }

    /**
     * Thanh toán VNPay
     */
    public function vnpayCheckout()
    {
        $redirectUrl = $this->checkoutService->createVNPayUrl($this->userId);
        header("Location: $redirectUrl");
        exit;
    }
}
