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

    public function createOrder(int $userId, array $postData, array $cartItems): ?int
    {
        // Kiểm tra dữ liệu đầu vào
        $name = $postData['name'] ?? '';
        $phone = $postData['phone'] ?? '';
        $address = $postData['address'] ?? '';
        $payment = $postData['payment_method'] ?? 'cod';

        if (!$name || !$phone || !$address) {
            return null;
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Tạo đơn hàng
        $orderId = $this->checkoutModel->createOrder([
            'user_id' => $userId,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'payment_method' => $payment,
            'total_price' => $total
        ]);

        // 2. Ghi từng sản phẩm
        foreach ($cartItems as $item) {
            $this->checkoutModel->addOrderItem([
                'order_id' => $orderId,
                'product_id' => $item['product_id'] ?? $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return $orderId;
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

