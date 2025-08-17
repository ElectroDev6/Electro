<?php

namespace App\Services;

use PDO;
use App\Models\CartModel;
use App\Models\CheckoutModel;

class CheckoutService
{
    private CartModel $cartModel;
    private CheckoutModel $checkoutModel;

    public function __construct(PDO $pdo)
    {
        $this->cartModel = new CartModel($pdo);
        $this->checkoutModel = new CheckoutModel($pdo);
    }

    /**
     * Lấy dữ liệu cho trang checkout
     * @param int|null $userId
     * @param string $sessionId
     * @return array [items, user_address, errors]
     */
    public function getCheckoutData(?int $userId, string $sessionId): array
    {
        $errors = [];

        // Kiểm tra đăng nhập
        if (!$userId) {
            return [
                'items' => ['products' => [], 'summary' => ['total_price' => 0, 'total_discount' => 0, 'shipping_fee' => 0, 'final_total' => 0]],
                'user_address' => null,
                'errors' => ['Vui lòng đăng nhập để tiếp tục thanh toán.']
            ];
        }

        // Lấy thông tin địa chỉ người dùng
        $userAddress = $this->checkoutModel->getUserAddress($userId);
        if (!$userAddress) {
            // Chuyển hướng sang trang cập nhật địa chỉ
            header("Location: /profile");
            exit;
        }

        // Lấy giỏ hàng
        $cartId = $this->cartModel->getCartIdByUserId($userId) ?? $this->cartModel->getCartIdBySessionId($sessionId);
        if (!$cartId) {
            return [
                'items' => ['products' => [], 'summary' => ['total_price' => 0, 'total_discount' => 0, 'shipping_fee' => 0, 'final_total' => 0]],
                'user_address' => $userAddress,
                'errors' => ['Giỏ hàng trống.']
            ];
        }

        $items = $this->cartModel->fetchCartItems($cartId);
        $products = [];
        $totalPrice = 0;
        $totalDiscount = 0;
        $shippingFee = 30000;

        foreach ($items as $item) {
            if ($item['selected']) {
                $products[] = [
                    'cart_item_id' => $item['cart_item_id'],
                    'cart_id' => $item['cart_id'],
                    'sku_id' => $item['sku_id'],
                    'quantity' => $item['quantity'],
                    'selected' => $item['selected'],
                    'color' => $item['color'],
                    'warranty_enabled' => $item['warranty_enabled'],
                    'voucher_code' => $item['voucher_code'],
                    'image_url' => $item['image_url'],
                    'price' => $item['price'],
                    'name' => $item['name']
                ];
                $totalPrice += $item['price'] * $item['quantity'];
                if ($item['voucher_code']) {
                    // Giả sử có logic lấy discount từ coupon
                    $totalDiscount += 0; // Cần thêm logic thực tế
                }
            }
        }

        $finalTotal = $totalPrice + $shippingFee - $totalDiscount;

        return [
            'items' => [
                'products' => $products,
                'summary' => [
                    'total_price' => $totalPrice,
                    'total_discount' => $totalDiscount,
                    'shipping_fee' => $shippingFee,
                    'final_total' => $finalTotal
                ]
            ],
            'user_address' => $userAddress,
            'errors' => []
        ];
    }

    /**
     * Tạo đơn hàng mới
     * @param int $userId
     * @param array $postData
     * @param string $sessionId
     * @return int|null
     */
public function createOrder($userId, $orderData, $sessionId) {
    $this->db->beginTransaction();
    try {
        // 1. Insert vào orders
        $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, user_address_id, order_code, total_price, status, created_at) 
            VALUES (:user_id, :user_address_id, :order_code, :total_price, :status, NOW())
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':user_address_id' => $orderData['user_address_id'],  // bắt buộc
            ':order_code' => $orderData['order_code'],
            ':total_price' => $orderData['total_price'],
            ':status' => 'pending'
        ]);

        $orderId = $this->db->lastInsertId();

        // 2. Lấy cart items của user
        $cartItems = $this->cartModel->getCartItems($userId);

        // 3. Insert từng cart item vào order_items (phải dùng sku_id, không phải product_id)
        $stmtItem = $this->db->prepare("
            INSERT INTO order_items (order_id, sku_id, quantity, price) 
            VALUES (:order_id, :sku_id, :quantity, :price)
        ");
        foreach ($cartItems as $item) {
            $stmtItem->execute([
                ':order_id' => $orderId,
                ':sku_id'   => $item['sku_id'],
                ':quantity' => $item['quantity'],
                ':price'    => $item['price']
            ]);
        }

        // 4. Xóa cart_items sau khi tạo đơn
        $this->cartModel->clearCart($userId);

        $this->db->commit();
        return $orderId;

    } catch (\Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}






public function processCheckout(int $userId, string $paymentMethod, ?string $couponCode): ?int {
        $cartItems = $this->cartModel->getCartItems($userId);
        if (empty($cartItems)) return null;

        // Tính tổng giá trị
        $totalPrice = array_reduce($cartItems, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);

        // (Optional) validate coupon
        $couponId = null; // gọi couponModel nếu có

        // Tạo order
        $orderId = $this->checkoutModel->createOrder([
            'user_id' => $userId,
            'total_price' => $totalPrice,
            'payment_method' => $paymentMethod,
            'coupon_id' => $couponId
        ]);

        // Tạo order_items từ cart_items
        foreach ($cartItems as $item) {
            $this->checkoutModel->addOrderItem($orderId, $item);
        }

        // Xóa giỏ hàng
        $this->cartModel->clearCart($userId);

        return $orderId;
    }
    /**
     * Lấy coupon_id từ coupon_code (giả lập)
     * @param string|null $couponCode
     * @return int|null
     */
    private function getCouponId(?string $couponCode): ?int
    {
        if (!$couponCode) {
            return null;
        }
        try {
            $stmt = $this->checkoutModel->getPdo()->prepare("
                SELECT coupon_id FROM coupons 
                WHERE coupon_code = :coupon_code 
                AND start_date <= NOW() 
                AND end_date >= NOW()
            ");
            $stmt->execute([':coupon_code' => $couponCode]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int)$result['coupon_id'] : null;
        } catch (\Exception $e) {
            error_log("CheckoutService: Error in getCouponId - CouponCode: $couponCode, Error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tạo URL thanh toán VNPay (giả lập)
     * @param int $userId
     * @param int $orderId
     * @return string
     */
    public function createVNPayUrl(int $userId, int $orderId): string
    {
        $txnId = 'VNP-' . $orderId . '-' . time();
        return "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?vnp_TxnRef=$txnId";
    }
}
