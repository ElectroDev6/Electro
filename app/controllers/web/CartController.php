<?php

namespace App\Controllers\Web;

use App\Services\CartService;
use Core\View;

class CartController
{
    private $cartService;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo); // Truyền $pdo vào CartService
    }

    public function showCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        error_log("CartController: UserID: " . ($userId ?? 'null') . ", SessionID: $sessionId");
        $cart = $this->cartService->getCart($userId, $sessionId);

        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // exit;

        View::render('cart', ['cart' => $cart]);
    }
    public function delete()
{
    $productId = $_POST['product_id'] ?? null;
    if (!$productId) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm']);
        return;
    }
  
    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    $result = $this->cartService->removeFromCart($productId, $userId, $sessionId);
    echo json_encode($result);
    // if ($result['success']) {
    //     $_SESSION['message'] = 'Sản phẩm đã được xoá khỏi giỏ hàng.';
    // } else {
    //     $_SESSION['message'] = 'Không thể xoá sản phẩm khỏi giỏ hàng.';
    // }
    header('Location: /cart');
    exit;
}
public function updateProductQuantity()
{
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if (!$productId || $quantity === null) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm hoặc số lượng']);
        return;
    }

    // Chuyển đổi về kiểu int để tránh lỗi
    $quantity = (int)$quantity;

    // Không cho số lượng nhỏ hơn 1
    if ($quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Số lượng phải lớn hơn 0']);
        return;
    }

    $userId = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    $result = $this->cartService->setProductQuantity($productId, $quantity, $userId, $sessionId);
    echo json_encode($result);

    // Điều hướng về trang giỏ hàng nếu cần
    header('Location: /cart');
    exit;
}
public function toggleSelectAll()
{
    $isSelected = isset($_POST['selected']) ? (int)$_POST['selected'] : 0;

    $sessionId = $_COOKIE['session_id'] ?? null;
    $userId = $_SESSION['user']['id'] ?? null;

    $result = $this->cartService->setSelectAll($isSelected, $userId, $sessionId);

    if ($result['success']) {
        $_SESSION['success_message'] = $result['message'];
    } else {
        $_SESSION['error_message'] = $result['message'];
    }

    header("Location: /cart");
    exit();
}
public function updateColor()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return Redirect::backWithError("Phương thức không hợp lệ.");
    }

    $skuId = $_POST['sku_id'] ?? null; // Đây là attribute_option_id tương ứng với màu
    $productId = $_POST['product_id'] ?? null;

    $userId = $_SESSION['user']['id'] ?? null;
    $sessionId = $_COOKIE['session_id'] ?? null;

    if (!$skuId || !$productId) {
        return Redirect::backWithError("Thiếu thông tin màu hoặc sản phẩm.");
    }

    $result = $this->cartService->updateColorByAttributeId(
        (int)$skuId,
        (int)$productId,
        $userId,
        $sessionId
    );

    if ($result['success']) {
        return Redirect::backWithSuccess($result['message']);
    } else {
        return Redirect::backWithError($result['message']);
    }
}
public function confirmOrder()
{
    $userId = $_SESSION['user']['id'] ?? null;
    $sessionId = $_COOKIE['session_id'] ?? null;

    // Lấy danh sách sản phẩm được chọn từ giỏ hàng
    $selectedProducts = $this->cartService->getSelectedCartItems($userId, $sessionId);

    if (empty($selectedProducts)) {
        return Redirect::backWithError("Không có sản phẩm nào được chọn.");
    }

    // Tính tổng tiền
    $totalPrice = 0;
    foreach ($selectedProducts as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Lưu thông tin đơn hàng tạm vào SESSION
    $_SESSION['checkout'] = [
        'products' => $selectedProducts,
        'total_price' => $totalPrice
    ];

    return Redirect::to('/checkout'); // chuyển sang trang checkout
}













}
