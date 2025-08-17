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
       public function getCartItems($userId)
    {
        return $this->cartModel->getCartItemsByUser($userId);
    }

    public function createOrder($userId, $userAddressId, $couponId = null)
    {
        $cartItems = $this->cartModel->getCartItemsByUser($userId);

        if (empty($cartItems)) {
            return false;
        }

        // Tính tổng giá trị giỏ hàng
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Lưu orders
        $orderId = $this->CheckoutModel->createOrder($userId, $userAddressId, $total, $couponId);

        if ($orderId) {
            foreach ($cartItems as $item) {
                $this->CheckoutModel->addOrderItem(
                    $orderId,
                    $item['sku_id'],  // chuẩn DB
                    $item['quantity'],
                    $item['price']
                );
            }

            // Clear cart
            $this->cartModel->clearCart($userId);
            return $orderId;
        }

        return false;
    }     




}







