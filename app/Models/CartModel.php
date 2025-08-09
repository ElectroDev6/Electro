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
        }
        return $cartId;
    }

    private function getCartIdByUserId($userId)
    {
        $query = "SELECT cart_id FROM cart WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchColumn();
    }

    private function getCartIdBySessionId($sessionId)
    {
        $query = "SELECT cart_id FROM cart WHERE session_id = :session_id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':session_id' => $sessionId]);
        return $stmt->fetchColumn();
    }

    public function getCartId($userId, $sessionId)
    {
        return $userId ? $this->getCartIdByUserId($userId) : $this->getCartIdBySessionId($sessionId);
    }

    public function addToCart($cartId, $skuId, $quantity, $color = null, $warrantyEnabled = false, $imageUrl = null)
    {
        error_log("CartModel: Attempting to add to cart - CartID: $cartId, SKU: $skuId, Quantity: $quantity, Color: " . ($color ?? 'null') . ", Warranty: " . ($warrantyEnabled ? 'true' : 'false') . ", Image: " . ($imageUrl ?? 'null'));
        try {
            $this->pdo->beginTransaction();
            // Kiểm tra sản phẩm trùng dựa trên cart_id, sku_id, và color
            $queryCheck = "SELECT cart_item_id, quantity, warranty_enabled, image_url FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id AND color = :color FOR UPDATE";
            $stmtCheck = $this->pdo->prepare($queryCheck);
            $stmtCheck->execute([':cart_id' => $cartId, ':sku_id' => $skuId, ':color' => $color ?: null]);
            $existingItem = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // Tăng số lượng nếu trùng
                $newQuantity = $existingItem['quantity'] + $quantity;
                $newWarrantyEnabled = $warrantyEnabled || $existingItem['warranty_enabled'];
                $newImageUrl = $imageUrl ?? $existingItem['image_url'];
                $queryUpdate = "UPDATE cart_items SET quantity = :quantity, warranty_enabled = :warranty_enabled, image_url = :image_url, updated_at = CURRENT_TIMESTAMP WHERE cart_item_id = :cart_item_id";
                $stmtUpdate = $this->pdo->prepare($queryUpdate);
                $stmtUpdate->execute([
                    ':quantity' => $newQuantity,
                    ':warranty_enabled' => (int)$newWarrantyEnabled,
                    ':image_url' => $newImageUrl,
                    ':cart_item_id' => $existingItem['cart_item_id']
                ]);
                error_log("CartModel: Updated item - CartItemID: {$existingItem['cart_item_id']}, SKU: $skuId, Color: " . ($color ?? 'null') . ", New Quantity: $newQuantity, Image: " . ($newImageUrl ?? 'null'));
            } else {
                // Thêm mới nếu không trùng
                $queryInsert = "INSERT INTO cart_items (cart_id, sku_id, quantity, selected, color, warranty_enabled, image_url) VALUES (:cart_id, :sku_id, :quantity, 1, :color, :warranty_enabled, :image_url)";
                $stmtInsert = $this->pdo->prepare($queryInsert);
                $stmtInsert->execute([
                    ':cart_id' => $cartId,
                    ':sku_id' => $skuId,
                    ':quantity' => $quantity,
                    ':color' => $color ?: null,
                    ':warranty_enabled' => (int)$warrantyEnabled,
                    ':image_url' => $imageUrl
                ]);
                error_log("CartModel: Inserted item - SKU: $skuId, Color: " . ($color ?? 'null') . ", Quantity: $quantity, Image: " . ($imageUrl ?? 'null'));
            }
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("CartModel: Error adding to cart - SKU: $skuId, Color: " . ($color ?? 'null') . ", Error: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItemCount($cartId)
    {
        $query = "SELECT SUM(quantity) FROM cart_items WHERE cart_id = :cart_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':cart_id' => $cartId]);
        return (int)$stmt->fetchColumn() ?: 0;
    }

    public function updateSelectAll($cartId, $selectAll)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id");
        $stmt->execute([':selected' => (int)$selectAll, ':cart_id' => $cartId]);
    }

    public function updateProductSelection($cartId, $skuId, $selected)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id AND sku_id = :sku_id");
        $stmt->execute([':selected' => (int)$selected, ':cart_id' => $cartId, ':sku_id' => $skuId]);
    }

    public function updateProductColor($cartId, $skuId, $color, $imageUrl)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET color = :color, image_url = :image_url WHERE cart_id = :cart_id AND sku_id = :sku_id");
        $stmt->execute([':color' => $color, ':image_url' => $imageUrl, ':cart_id' => $cartId, ':sku_id' => $skuId]);
    }

    public function updateQuantity($cartId, $skuId, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND sku_id = :sku_id");
        $stmt->execute([':quantity' => $quantity, ':cart_id' => $cartId, ':sku_id' => $skuId]);
    }

    public function updateWarranty($cartId, $skuId, $enabled)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET warranty_enabled = :enabled WHERE cart_id = :cart_id AND sku_id = :sku_id");
        $stmt->execute([':enabled' => (int)$enabled, ':cart_id' => $cartId, ':sku_id' => $skuId]);
    }

    public function deleteCartItem($cartId, $skuId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id");
        $stmt->execute([':cart_id' => $cartId, ':sku_id' => $skuId]);
    }

    public function applyVoucher($cartId, $voucherCode)
    {
        $stmt = $this->pdo->prepare("UPDATE cart_items SET voucher_code = :voucher_code WHERE cart_id = :cart_id");
        $stmt->execute([':voucher_code' => $voucherCode, ':cart_id' => $cartId]);
    }
}
