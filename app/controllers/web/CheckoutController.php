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
    protected int $userId = 1; // Giả lập người dùng (thay bằng session khi cần)

     public function __construct(\PDO $pdo)
{
    $productService = new ProductService($pdo);

    $this->cartService = new CartService($pdo, $productService); 
    $this->checkoutService = new CheckoutService($pdo, $productService); // ✅ sửa chỗ này
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

    // Lấy toàn bộ sản phẩm từ cart của user
    $cartItems = $this->cartService->getCartItems($this->userId);

    // Nếu giỏ hàng rỗng thì không tạo đơn
    if (empty($cartItems)) {
        Redirect::to('/checkout?error=cart-empty');
        return;
    }

    // Tạo đơn hàng và lưu chi tiết sản phẩm từ cart
    $orderId = $this->checkoutService->createOrder($this->userId, $postData, $cartItems);

    if ($orderId) {
        // Xóa giỏ hàng sau khi đặt
        $this->cartService->clearCart($this->userId);
        Redirect::to('/thank-you');
    } else {
        Redirect::to('/checkout?error=order-failed');
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
