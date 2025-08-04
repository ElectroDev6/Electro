<?php

namespace App\Controllers\Web;

use Core\View;
use Core\Redirect;
use App\Services\CartService;
use App\Services\CheckoutService;

class CheckoutController
{
    protected CartService $cartService;
    protected CheckoutService $checkoutService;
    protected int $userId = 1; // Giả lập người dùng (thay bằng session khi cần)

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->checkoutService = new CheckoutService();
    }

    // Hiển thị trang thanh toán
    public function index()
    {
        $cartData = $this->cartService->getCartWithSummary($this->userId);

        View::render('checkout', ['cart' => $cartData]);
    }

    // Xử lý khi người dùng đặt hàng (COD)
    public function submit()
    {
        $postData = $_POST;

        $orderId = $this->checkoutService->createOrder($this->userId, $postData);

        if ($orderId) {
            $this->cartService->clearCart($this->userId);
            Redirect::to('/thank-you');
        } else {
            Redirect::to('/checkout?error=cart-empty');
        }
    }

    // Xử lý thanh toán bằng VNPay
    public function vnpayCheckout()
    {
        $redirectUrl = $this->checkoutService->createVNPayUrl($this->userId);
        header("Location: $redirectUrl");
        exit;
    }
}
