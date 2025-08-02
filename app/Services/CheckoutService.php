<?php

namespace App\Services;

use App\Services\CartService;
use App\Models\Order;

class CheckoutService
{
    protected CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Tạo đơn hàng mới từ giỏ hàng
     */
    public function createOrder(int $userId, array $data): string
    {
        $cart = $this->cartService->getCartWithSummary($userId);

        if (empty($cart['products'])) {
            return '';
        }

        $orderId = uniqid('order_');

        $order = [
            'id' => $orderId,
            'user_id' => $userId,
            'products' => $cart['products'],
            'summary' => $cart['summary'],
            'info' => [
                'fullname' => $data['fullname'] ?? '',
                'phone' => $data['phone'] ?? '',
                'email' => $data['email'] ?? '',
                'address' => $data['address'] ?? '',
                'note' => $data['note'] ?? '',
            ],
            'payment_method' => $data['payment_method'] ?? 'cod',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Lưu vào session (giả lập DB)
        $_SESSION['orders'][] = $order;

        // Nếu có model lưu DB: Order::create($order);

        return $orderId;
    }

    /**
     * Lấy URL thanh toán VNPay (giả lập)
     */
    public function createVNPayUrl(int $userId): string
    {
        $txnId = uniqid('vnp_');
        return "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?vnp_TxnRef=$txnId";
    }

    /**
     * Lấy tất cả đơn hàng trong session
     */
    public function getOrders(): array
    {
        return $_SESSION['orders'] ?? [];
    }

    /**
     * Xóa tất cả đơn hàng
     */
    public function clearOrders(): void
    {
        $_SESSION['orders'] = [];
    }
}
