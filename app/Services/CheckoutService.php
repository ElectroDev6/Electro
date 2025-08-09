<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\CheckoutModel;
use App\Services\ProductService;

class CheckoutService
{
    protected CartModel $cartModel;
    protected CheckoutModel $checkoutModel;
    protected ?ProductService $productService;
    protected CartService $cartService;

    public function __construct(\PDO $pdo, ?ProductService $productService = null)
    {
        $this->cartModel = new CartModel($pdo);
        $this->checkoutModel = new CheckoutModel($pdo); // ✅ thiếu dòng này gây lỗi
        $this->productService = $productService;
        $this->cartService = new CartService($pdo, $productService);
    }

    /**
     * Tạo đơn hàng mới
     * @param int $userId
     * @param array $postData
     * @param array $cartItems Mảng sản phẩm đã chọn trong giỏ
     * @return int|null
     */
   public function createOrder(int $userId, array $postData, array $cartItems): ?int
{
    $name = trim($postData['name'] ?? '');
    $phone = trim($postData['phone'] ?? '');
    $address = trim($postData['address'] ?? '');
    $payment = $postData['payment_method'] ?? 'cod';

    if (!$name || !$phone || !$address) {
        return null;
    }

    // 🔹 Lấy danh sách sku_id đã chọn từ session
    $selectedItems = $_SESSION['selected_cart_items'] ?? [];

    // 🔹 Lọc lại chỉ những sản phẩm được chọn
    $cartItems = array_filter($cartItems, function($item) use ($selectedItems) {
        return in_array($item['sku_id'], $selectedItems);
    });

    if (empty($cartItems)) {
        return null; // Không có sản phẩm được chọn
    }

    $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cartItems));

    $pdo = $this->checkoutModel->getPdo();
    $pdo->beginTransaction();

    try {
        $orderId = $this->checkoutModel->createOrder([
            'user_id' => $userId,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'payment_method' => $payment,
            'total_price' => $total
        ]);

        foreach ($cartItems as $item) {
            $this->checkoutModel->addOrderItem([
                'order_id' => $orderId,
                'sku_id' => $item['sku_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $this->cartService->clearCart($userId);

        $pdo->commit();
        return $orderId;

    } catch (\Exception $e) {
        $pdo->rollBack();
        error_log("CheckoutService: " . $e->getMessage());
        return null;
    }
}

    public function createVNPayUrl(int $userId): string
    {
        $txnId = uniqid('vnp_');
        return "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?vnp_TxnRef=$txnId";
    }

    public function getOrders(): array
    {
        return $_SESSION['orders'] ?? [];
    }

    public function clearOrders(): void
    {
        $_SESSION['orders'] = [];
    }
}
