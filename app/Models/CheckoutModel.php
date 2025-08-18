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
     * Lấy kết nối PDO
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Lấy thông tin địa chỉ người dùng theo user_id
     * @param int $userId
     * @return array|null
     */
    public function getUserAddress(int $userId): ?array
    {
        try {
            $stmt = $this->pdo->prepare("
            SELECT 
                u.name, 
                u.email, 
                u.phone_number, 
                ua.address, 
                ua.ward_commune, 
                ua.district, 
                ua.province_city
            FROM users u
            LEFT JOIN user_address ua ON u.user_id = ua.user_id
            WHERE u.user_id = :user_id
            LIMIT 1
        ");
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            error_log("CheckoutModel: Error in getUserAddress - UserID: $userId, Error: " . $e->getMessage());
            return null;
        }
    }


    /**
     * Tạo đơn hàng mới
     * @param array $orderData
     * @return int ID của đơn hàng mới
     */
    public function createOrder(array $orderData): int
    {
        try {
            $orderCode = 'ORD-' . time() . '-' . rand(1000, 9999);
            $stmt = $this->pdo->prepare("
                INSERT INTO orders (user_id, user_address_id, coupon_id, order_code, total_price, status, created_at)
                VALUES (:user_id, :user_address_id, :coupon_id, :order_code, :total_price, 'pending', NOW())
            ");
            $stmt->execute([
                ':user_id' => $orderData['user_id'],
                ':user_address_id' => $orderData['user_address_id'],
                ':coupon_id' => $orderData['coupon_id'] ?? null,
                ':order_code' => $orderCode,
                ':total_price' => $orderData['total_price'],
            ]);
            return (int)$this->pdo->lastInsertId();
        } catch (\Exception $e) {
            error_log("CheckoutModel: Error in createOrder - UserID: {$orderData['user_id']}, Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Thêm mục đơn hàng
     * @param array $itemData
     * @return bool
     */
    public function addOrderItem(array $itemData): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO order_items (order_id, sku_id, quantity, price)
                VALUES (:order_id, :sku_id, :quantity, :price)
            ");
            return $stmt->execute([
                ':order_id' => $itemData['order_id'],
                ':sku_id' => $itemData['sku_id'],
                ':quantity' => $itemData['quantity'],
                ':price' => $itemData['price'],
            ]);
        } catch (\Exception $e) {
            error_log("CheckoutModel: Error in addOrderItem - OrderID: {$itemData['order_id']}, SKU: {$itemData['sku_id']}, Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Thêm thông tin thanh toán
     * @param array $paymentData
     * @return bool
     */
    public function addPayment(array $paymentData): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO payments (order_id, payment_method, amount, status, payment_date)
                VALUES (:order_id, :payment_method, :amount, 'pending', NOW())
            ");
            return $stmt->execute([
                ':order_id' => $paymentData['order_id'],
                ':payment_method' => $paymentData['payment_method'],
                ':amount' => $paymentData['amount'],
            ]);
        } catch (\Exception $e) {
            error_log("CheckoutModel: Error in addPayment - OrderID: {$paymentData['order_id']}, Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Thêm thông tin vận chuyển
     * @param array $shippingData
     * @return bool
     */
    public function addShipping(array $shippingData): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO shipping (order_id, carrier, status, created_at)
                VALUES (:order_id, :carrier, 'waiting', NOW())
            ");
            return $stmt->execute([
                ':order_id' => $shippingData['order_id'],
                ':carrier' => $shippingData['carrier'] ?? 'Giao Hang Nhanh',
            ]);
        } catch (\Exception $e) {
            error_log("CheckoutModel: Error in addShipping - OrderID: {$shippingData['order_id']}, Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Xóa các mục giỏ hàng đã chọn
     * @param int $cartId
     * @return bool
     */
    public function clearSelectedCartItems(int $cartId): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id AND selected = 1");
            return $stmt->execute([':cart_id' => $cartId]);
        } catch (\Exception $e) {
            error_log("CheckoutModel: Error in clearSelectedCartItems - CartID: $cartId, Error: " . $e->getMessage());
            throw $e;
        }
    }
}
