<?php

namespace App\Models;

use PDO;
use Exception;

class CartModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getOrCreateCart($userId = null, $sessionId = null)
    {
        error_log("CartModel: getOrCreateCart - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));
        $cartId = null;
        if ($userId) {
            $query = "INSERT INTO cart (user_id) VALUES (:user_id) ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':user_id' => $userId]);
            $cartId = $this->pdo->lastInsertId() ?: $this->getCartIdByUserId($userId);
        } elseif ($sessionId) {
            $cartId = $this->getCartIdBySessionId($sessionId);
            if (!$cartId) {
                $query = "INSERT INTO cart (session_id) VALUES (:session_id) ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':session_id' => $sessionId]);
                $cartId = $this->pdo->lastInsertId() ?: $this->getCartIdBySessionId($sessionId);
            }
            error_log("CartModel: Retrieved or created cart_id for session $sessionId: $cartId");
        } else {
            error_log("CartModel: No valid UserID or SessionID");
            return null;
        }
        return $cartId;
    }

    private function getCartIdByUserId($userId)
    {
        $query = "SELECT cart_id FROM cart WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("CartModel: getCartIdByUserId result: " . ($result['cart_id'] ?? 'null'));
        return $result['cart_id'] ?? null;
    }

    private function getCartIdBySessionId($sessionId)
    {
        $query = "SELECT cart_id FROM cart WHERE session_id = :session_id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':session_id' => $sessionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("CartModel: getCartIdBySessionId result for $sessionId: " . ($result['cart_id'] ?? 'null'));
        return $result['cart_id'] ?? null;
    }

    public function addToCart($cartId, $skuId, $quantity)
    {
        try {
            $this->pdo->beginTransaction();
            error_log("CartModel: Attempting to add SKU $skuId to CartID $cartId with Quantity $quantity");

            $queryCheck = "SELECT quantity FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id FOR UPDATE";
            $stmtCheck = $this->pdo->prepare($queryCheck);
            $stmtCheck->execute([':cart_id' => $cartId, ':sku_id' => $skuId]);
            $existingItem = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                $queryUpdate = "UPDATE cart_items SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP WHERE cart_id = :cart_id AND sku_id = :sku_id";
                $stmtUpdate = $this->pdo->prepare($queryUpdate);
                $stmtUpdate->execute([':quantity' => $newQuantity, ':cart_id' => $cartId, ':sku_id' => $skuId]);
                error_log("CartModel: Updated existing item - SKU $skuId, New Quantity: $newQuantity");
            } else {
                $queryInsert = "INSERT INTO cart_items (cart_id, sku_id, quantity) VALUES (:cart_id, :sku_id, :quantity)";
                $stmtInsert = $this->pdo->prepare($queryInsert);
                $stmtInsert->execute([':cart_id' => $cartId, ':sku_id' => $skuId, ':quantity' => $quantity]);
                error_log("CartModel: Inserted new item - SKU $skuId, Quantity: $quantity");
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("CartModel: Error adding to cart - SKU $skuId, Error: " . $e->getMessage());
            return false;
        }
    }
}
