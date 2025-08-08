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

   public function createOrder(int $userId, array $postData): ?int
{
    $name = trim($postData['name'] ?? '');
    $phone = trim($postData['phone'] ?? '');
    $address = trim($postData['address'] ?? '');
    $payment = $postData['payment_method'] ?? 'cod';

    if (!$name || !$phone || !$address) {
        return null;
    }

    $cartItems = $this->cartService->getCartItems($userId);
    if (empty($cartItems)) {
        return null;
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
                'sku_id' => $item['sku_id'], // dùng sku_id để khớp DB
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

