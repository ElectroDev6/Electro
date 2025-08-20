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

        if (!$userId) {
            return [
                'items' => ['products' => [], 'summary' => ['total_price' => 0, 'total_discount' => 0, 'shipping_fee' => 0, 'final_total' => 0]],
                'user_address' => null,
                'errors' => ['Vui lòng đăng nhập để tiếp tục thanh toán.']
            ];
        }

        $userAddress = $this->checkoutModel->getUserAddress($userId);
        if (!$userAddress) {
            error_log("CheckoutService: No user address found - UserID: $userId");
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

                // Tính tổng giá gốc
                $itemTotal = $item['price'] * $item['quantity'];
                $totalPrice += $itemTotal;

                // Áp dụng giảm giá nếu có voucher_code
                if ($item['voucher_code']) {
                    $coupon = $this->checkoutModel->getCouponByCode($item['voucher_code']);
                    if ($coupon) {
                        $discountPercent = $coupon['discount_percent'];
                        $itemDiscount = $itemTotal * ($discountPercent / 100);
                        $totalDiscount += $itemDiscount;
                    } else {
                        // Nếu coupon không hợp lệ, có thể thêm lỗi hoặc bỏ qua
                        error_log("CheckoutService: Invalid coupon - Code: {$item['voucher_code']}, ItemID: {$item['cart_item_id']}");
                        // Optional: $errors[] = "Mã giảm giá {$item['voucher_code']} không hợp lệ cho sản phẩm {$item['name']}.";
                    }
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
            'errors' => $errors
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

        // Debug
        error_log("CheckoutService: Creating order - UserID: $userId, user_address_id: " . ($userAddressId ?? 'null'));

        // Validate payment method
        $validPaymentMethods = ['cod', 'vnpay', 'credit_card', 'momo', 'zalopay'];
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

            // Dùng luôn order_id này làm TxnRef
            $vnp_TxnRef = $orderId;

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

    public function updateAfterVNPay(int $orderId, array $vnpayData): bool
    {
        if ($vnpayData['vnp_ResponseCode'] !== '00') {
            return false;
        }
        $transactionNo = $vnpayData['vnp_TransactionNo'] ?? '';
        return $this->checkoutModel->updateOrderAfterPayment($orderId, 'paid', 'success', $transactionNo);
    }

    public function updateOrderAfterPayment(int $orderId, string $statusOrder, string $statusPayment, string $transactionNo): bool
    {
        return $this->checkoutModel->updateOrderAfterPayment($orderId, $statusOrder, $statusPayment, $transactionNo);
    }

    public function getOrderTotal(int $orderId): float
    {
        return $this->checkoutModel->getOrderTotal($orderId);
    }
}
