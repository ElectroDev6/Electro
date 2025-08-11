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

    $userId = $_SESSION['user_id'] ?? null;
    $user = null;

    if ($userId) {
        // Giả sử bạn có UserModel để lấy thông tin user
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId); // trả về array user info
    }

    // Lấy cart data từ session hoặc service như bạn đang làm
    $cartData = $_SESSION['cart_data_' . ($userId ?? session_id())] ?? null;

    if (!$cartData || empty($cartData['products'])) {
        // lấy cart từ service nếu session chưa có hoặc rỗng
        $cartData = $this->cartService->getSelectedCartItems($userId, session_id());
        if (empty($cartData['products'])) {
            header("Location: /cart?error=no-selected-products");
            exit;
        }
        $_SESSION['cart_data_' . ($userId ?? session_id())] = $cartData;
    }

    // Truyền user và cart data vào view
    View::render('checkout', [
        'user' => $user,
        'cartData' => $cartData,
        'errors' => $_SESSION['errors'] ?? []
    ]);

    unset($_SESSION['errors']);
}




    public function submit()
{
    session_start();

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        $_SESSION['errors'] = ['Bạn phải đăng nhập để đặt hàng.'];
        header("Location: /checkout");
        exit;
    }

    // Lấy dữ liệu form
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $note = trim($_POST['note'] ?? '');
    $paymentMethod = $_POST['payment_method'] ?? 'cod';

    $errors = [];

    if (!$name) $errors[] = "Tên người đặt hàng là bắt buộc.";
    if (!$phone) $errors[] = "Số điện thoại là bắt buộc.";
    if (!$address) $errors[] = "Địa chỉ nhận hàng là bắt buộc.";

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: /checkout");
        exit;
    }

    // Lấy cart từ session
    $cartData = $_SESSION['cart_data_' . $userId] ?? null;
    if (!$cartData || empty($cartData['products'])) {
        $_SESSION['errors'] = ["Giỏ hàng trống."];
        header("Location: /cart");
        exit;
    }

    // Tạo đơn hàng mới trong session (chưa lưu DB)
    $orders = $_SESSION['orders'] ?? [];

    $newOrder = [
        'order_id' => uniqid('order_'), // id tạm thời trong session
        'user_id' => $userId,
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'address' => $address,
        'note' => $note,
        'payment_method' => $paymentMethod,
        'products' => $cartData['products'],
        'summary' => $cartData['summary'],
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s'),
    ];

    $orders[] = $newOrder;
    $_SESSION['orders'] = $orders;

    // Xóa giỏ hàng sau khi đặt
    unset($_SESSION['cart_data_' . $userId]);

    // Chuyển sang trang lịch sử đơn hàng
    header("Location: /history");
    exit;
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