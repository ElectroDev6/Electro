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

    // Tạo đơn hàng mới
    public function createOrder(array $orderData): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (user_id, name, phone, address, payment_method, total_price, created_at)
            VALUES (:user_id, :name, :phone, :address, :payment_method, :total_price, NOW())
        ");

        $stmt->execute([
            ':user_id' => $orderData['user_id'],
            ':name' => $orderData['name'],
            ':phone' => $orderData['phone'],
            ':address' => $orderData['address'],
            ':payment_method' => $orderData['payment_method'],
            ':total_price' => $orderData['total_price'],
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    // Lưu từng sản phẩm trong đơn hàng vào bảng order_items
    public function addOrderItem(array $itemData): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (:order_id, :product_id, :quantity, :price)
        ");

        $stmt->execute([
            ':order_id' => $itemData['order_id'],
            ':product_id' => $itemData['product_id'],
            ':quantity' => $itemData['quantity'],
            ':price' => $itemData['price'],
        ]);
    }

    // (Tùy chọn) Lấy chi tiết đơn hàng theo ID
    public function getOrderById(int $orderId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute([':id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // (Tùy chọn) Lấy danh sách sản phẩm của đơn hàng
    public function getOrderItems(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
