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
    public function createOrder(int $userId, array $postData, string $sessionId): ?int
    {
        $userAddressId = $postData['user_address_id'] ?? null;
        $paymentMethod = $postData['payment_method'] ?? 'cod';
        $couponCode = $postData['coupon_code'] ?? null;

        // Validate payment method
        $validPaymentMethods = ['cod', 'bank_transfer', 'credit_card', 'momo', 'zalopay'];
        if (!in_array($paymentMethod, $validPaymentMethods)) {
            error_log("CheckoutService: Invalid payment method - PaymentMethod: $paymentMethod");
            return null;
        }

        // Validate user_address_id
        if (!$userAddressId) {
            error_log("CheckoutService: Missing user_address_id - UserID: $userId");
            return null;
        }

        $cartId = $this->cartModel->getCartIdByUserId($userId) ?? $this->cartModel->getCartIdBySessionId($sessionId);
        if (!$cartId) {
            error_log("CheckoutService: No cart found - UserID: $userId, SessionID: $sessionId");
            return null;
        }

        $cartItems = $this->cartModel->fetchCartItems($cartId);
        $selectedItems = array_filter($cartItems, fn($item) => $item['selected']);
        if (empty($selectedItems)) {
            error_log("CheckoutService: No selected items in cart - CartID: $cartId");
            return null;
        }

        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $selectedItems));
        $couponId = $this->getCouponId($couponCode); // Giả sử có phương thức này

        $pdo = $this->checkoutModel->getPdo();
        $pdo->beginTransaction();

        try {
            $orderId = $this->checkoutModel->createOrder([
                'user_id' => $userId,
                'user_address_id' => $userAddressId,
                'coupon_id' => $couponId,
                'total_price' => $total
            ]);

            foreach ($selectedItems as $item) {
                $this->checkoutModel->addOrderItem([
                    'order_id' => $orderId,
                    'sku_id' => $item['sku_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            $this->checkoutModel->addPayment([
                'order_id' => $orderId,
                'payment_method' => $paymentMethod,
                'amount' => $total
            ]);

            $this->checkoutModel->addShipping([
                'order_id' => $orderId,
                'carrier' => 'Giao Hang Nhanh' // Có thể lấy từ form hoặc cấu hình
            ]);

            $this->checkoutModel->clearSelectedCartItems($cartId);
            $pdo->commit();
            error_log("CheckoutService: Order created - OrderID: $orderId, UserID: $userId, CartID: $cartId");
            return $orderId;
        } catch (\Exception $e) {
            $pdo->rollBack();
            error_log("CheckoutService: Error creating order - UserID: $userId, Error: " . $e->getMessage());
            return null;
        }
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
