<?php

namespace App\Controllers\Web;

use Core\View;
use Core\Redirect;
use App\Services\CartService;
use App\Models\CartModel;
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
        // Lấy danh sách sản phẩm đã chọn trong giỏ hàng cùng tổng tiền
        $Items = $this->cartService->getCart($this->userId, $this->sessionId);

        // Truyền dữ liệu sang view checkout
        View::render('checkout', [
            'Items' => $Items
        ]);
    }




    /**
     * Xác nhận đơn hàng (COD hoặc VNPAY)
     */
    public function submit()
    {
        error_log('Submit called');
        $postData = $_POST;
        error_log('POST data: ' . print_r($postData, true));

        $cartItems = $this->cartService->getSelectedCartItems($this->userId, $this->sessionId);
        error_log('Selected cart items: ' . print_r($cartItems, true));

        if (empty($cartItems)) {
            error_log('No selected cart items');
            Redirect::to('/cart');
            return;
        }

        $orderId = $this->checkoutService->createOrder($this->userId, $postData);

        if ($orderId) {
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
