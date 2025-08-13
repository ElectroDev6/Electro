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
        $this->userId = $_SESSION['user_id'] ?? 0; // Không giả lập user_id = 1
        $this->sessionId = session_id();


            
    }

   public function index()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!$this->userId) {
        $_SESSION['errors'] = ['Bạn phải đăng nhập để tiếp tục.'];
        header("Location: /login");
        exit;
    }

    $cartData = $_SESSION['cart_data_' . ($this->userId ?? $this->sessionId)] ?? null;

    if (!$cartData || empty($cartData['products'])) {
        $cartData = $this->cartService->getSelectedCartItems($this->userId, $this->sessionId);
        if (empty($cartData['products'])) {
            $_SESSION['errors'] = ['Không có sản phẩm nào được chọn để thanh toán.'];
            header("Location: /cart");
            exit;
        }
        $_SESSION['cart_data_' . ($this->userId ?? $this->sessionId)] = $cartData;
    }

    $data = $this->checkoutService->getCheckoutData($this->userId, $cartData);

    View::render('checkout', [
        'user' => $data['user'],
        'user_address' => $data['user_address'],
        'cart_data' => $data['cart_data'],
        'errors' => $data['errors'] ?: ($_SESSION['errors'] ?? [])
    ]);

    unset($_SESSION['errors']);
}




 public function submit()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!$this->userId) {
        $_SESSION['errors'] = ['Bạn phải đăng nhập để đặt hàng.'];
        header("Location: /login");
        exit;
    }

    $cartData = $_SESSION['cart_data_' . $this->userId] ?? null;
    if (!$cartData || empty($cartData['products'])) {
        $_SESSION['errors'] = ['Giỏ hàng trống hoặc không có sản phẩm được chọn.'];
        header("Location: /cart");
        exit;
    }

    $data = $this->checkoutService->getCheckoutData($this->userId, $cartData);
    $userAddressId = $data['user_address']['user_address_id'] ?? null;
    if (!$userAddressId) {
        $_SESSION['errors'] = ['Không tìm thấy địa chỉ mặc định.'];
        header("Location: /checkout");
        exit;
    }

    $orderId = $this->checkoutService->createOrder(
        $this->userId,
        $userAddressId,
        null, // coupon_id, thêm logic nếu cần
        $_POST,
        $cartData
    );

    if ($orderId) {
        if ($_POST['payment_method'] === 'vnpay') {
            $total = array_sum(array_map(fn($p) => ($p['price_current'] ?? 0) * ($p['quantity'] ?? 1), $cartData['products']));
            $vnpayUrl = $this->checkoutService->createVNPayUrl($orderId, $total);
            header("Location: $vnpayUrl");
            exit;
        }
        unset($_SESSION['cart_data_' . $this->userId]);
        header("Location: /order/success?order_id=" . $orderId);
        exit;
    } else {
        $_SESSION['errors'] = ['Lỗi khi tạo đơn hàng. Vui lòng thử lại.'];
        header("Location: /checkout");
        exit;
    }
}
public function history()
{
    session_start();

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header("Location: /login");
        exit;
    }

    $orders = $_SESSION['orders'] ?? [];

    // Lọc đơn hàng của user đang đăng nhập
    $userOrders = array_filter($orders, fn($order) => $order['user_id'] == $userId);

    View::render('order_history', [
        'orders' => $userOrders,
    ]);
}






    

    

    
    
}