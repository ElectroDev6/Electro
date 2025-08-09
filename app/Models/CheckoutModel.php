<?php

namespace App\Models;

use PDO;

class CheckoutModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lấy kết nối PDO để service có thể dùng transaction
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Tạo đơn hàng mới
     * @param array $orderData
     * @return int ID của đơn hàng mới
     */
    public function createOrder(array $orderData): int
{
    $stmt = $this->pdo->prepare("
        INSERT INTO orders (user_id, name, phone, address, payment_method, total_price, created_at)
        VALUES (:user_id, :name, :phone, :address, :payment_method, :total_price, NOW())
    ");

    if (!$stmt->execute([
        ':user_id' => $orderData['user_id'],
        ':name' => $orderData['name'],
        ':phone' => $orderData['phone'],
        ':address' => $orderData['address'],
        ':payment_method' => $orderData['payment_method'],
        ':total_price' => $orderData['total_price'],
    ])) {
        throw new \RuntimeException('Failed to create order');
    }

    return (int)$this->pdo->lastInsertId();
}

public function addOrderItem(array $itemData): bool
{
    $stmt = $this->pdo->prepare("
        INSERT INTO order_items (order_id, sku_id, quantity, price)
        VALUES (:order_id, :sku_id, :quantity, :price)
    ");

    return $stmt->execute([
        ':order_id' => $itemData['order_id'],
        ':sku_id'   => $itemData['sku_id'],
        ':quantity' => $itemData['quantity'],
        ':price'    => $itemData['price'],
    ]);
}
public function getOrdersByUserId(int $userId): array
{
    $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->execute([':user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    /**
     * Lấy chi tiết đơn hàng theo ID
     */
    public function getOrderById(int $orderId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute([':id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Lấy danh sách sản phẩm của đơn hàng
     */
    public function getOrderItems(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
