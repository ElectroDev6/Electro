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
   public function createOrder(int $userId, int $userAddressId, ?int $couponId, array $postData, array $cartItems): ?int
{
    $paymentMethod = $postData['payment_method'] ?? 'cod';

    if (empty($cartItems['products']) || !is_array($cartItems['products'])) {
        return null;
    }

    // Tính tổng tiền
    $total = 0;
    foreach ($cartItems['products'] as $item) {
        $price = (float)($item['price_current'] ?? 0);
        $quantity = max(0, (int)($item['quantity'] ?? 0));
        if ($quantity <= 0) continue;
        $total += $price * $quantity;
    }

    if ($total <= 0) {
        return null;
    }

    $pdo = $this->checkoutModel->getPdo();
    $pdo->beginTransaction();

    try {
        // Tạo đơn hàng theo schema mới
        $orderId = $this->checkoutModel->createOrder([
            'user_id' => $userId,
            'user_address_id' => $userAddressId,
            'coupon_id' => $couponId,
            'status' => 'pending',
            'total_price' => $total
        ]);

        if (!$orderId) {
            throw new \Exception("Failed to create order");
        }

        // Thêm sản phẩm vào order_items
        foreach ($cartItems['products'] as $item) {
            $quantity = max(0, (int)($item['quantity'] ?? 0));
            if ($quantity <= 0) continue;

            $this->checkoutModel->addOrderItem([
                'order_id' => $orderId,
                'sku_id' => $item['sku_id'],
                'quantity' => $quantity,
                'price' => (float)($item['price_current'] ?? 0)
            ]);
        }

        // Tạo record thanh toán trong bảng payments
        $stmt = $pdo->prepare("
            INSERT INTO payments (order_id, payment_method, amount, payment_date, status)
            VALUES (:order_id, :payment_method, :amount, NOW(), :status)
        ");

        if (!$stmt->execute([
            ':order_id' => $orderId,
            ':payment_method' => $paymentMethod,
            ':amount' => $total,
            ':status' => 'pending'
        ])) {
            throw new \Exception("Failed to create payment record");
        }

        // Xóa giỏ hàng
        $this->cartService->clearCart($userId);

        $pdo->commit();
        return $orderId;
    } catch (\Exception $e) {
        $pdo->rollBack();
        error_log("CheckoutService::createOrder - " . $e->getMessage());
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
