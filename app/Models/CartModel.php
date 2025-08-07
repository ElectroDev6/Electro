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
    public function getCartProducts($cartId): array
{
    $sql = "SELECT 
                ci.sku_id AS product_id,
                ci.quantity,
                p.name,
                p.price,
                p.image
            FROM cart_items ci
            JOIN products p ON ci.sku_id = p.id
            WHERE ci.cart_id = :cart_id";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['cart_id' => $cartId]);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


    // 
     public function getCartId($userId, $sessionId)
    {
        if ($userId) {
            $stmt = $this->pdo->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT cart_id FROM cart WHERE session_id = ?");
            $stmt->execute([$sessionId]);
        }

        return $stmt->fetchColumn(); // trả về cart_id
    }


    public function removeFromCartModel($cartId)
{
    
        $query = "DELETE FROM cart_items WHERE cart_id = :cart_id LIMIT 1";
        $stmt = $this->pdo->prepare($query);
         if ($stmt->execute([':cart_id' => $cartId])) {
            return ['success' => true, 'message' => 'Product deleted from cart.'];
             } else {
            return ['success' => false, 'message' => 'Failed to delete product.'];
    
         }
        }
        public function updateProductQuantity($userId, $sessionId)
{
    // Lấy cart_id dựa trên user_id hoặc session_id
    if ($userId) {
        $stmt = $this->pdo->prepare("SELECT cart_id FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
    } else {
        $stmt = $this->pdo->prepare("SELECT cart_id FROM cart WHERE session_id = ?");
        $stmt->execute([$sessionId]);
    }

    return $stmt->fetchColumn(); // trả về cart_id nếu tìm thấy
}

    // Cập nhật số lượng sản phẩm 
public function updateProductQuantityByCartId($cartId, $productId, $quantity)
{
    $query = "UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND sku_id = :product_id";
    $stmt = $this->pdo->prepare($query);

    if ($stmt->execute([
        ':quantity' => $quantity,
        ':cart_id' => $cartId,
        ':product_id' => $productId,
    ])) {
        return ['success' => true, 'message' => 'Cập nhật số lượng thành công.'];
    } else {
        return ['success' => false, 'message' => 'Cập nhật số lượng thất bại.'];
    }
}
 public function updateSelectAll($cartId, $isSelected)
{
    $sql = "UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':selected' => $isSelected ? 1 : 0,
        ':cart_id' => $cartId
    ]);
}
public function getCartIdBySessionOrUserOnly($userId = null, $sessionId = null)
{
    if ($userId !== null) {
        $sql = "SELECT id FROM carts WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
    } elseif ($sessionId !== null) {
        $sql = "SELECT id FROM carts WHERE session_id = :session_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['session_id' => $sessionId]);
    } else {
        return null;
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}
public function isValidColorAttributeOption(int $attributeOptionId): bool
{
    $query = "SELECT COUNT(*) FROM attribute_options WHERE id = :id AND attribute_id = 1";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $attributeOptionId]);

    return $stmt->fetchColumn() > 0;
}

public function getColorOptions(): array
{
$query = "UPDATE cart_items SET color_id = :color_id 
          WHERE attribute_option_id = :sku_id AND product_id = :product_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['attribute_id' => 1]); // 1 là ID của "Màu sắc" trong bảng `attributes`
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function updateColor(int $cartItemId, int $colorId): bool
{
$query = "UPDATE cart_items SET color_id = :color_id 
          WHERE attribute_option_id = :sku_id AND product_id = :product_id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        'color_id' => $colorId,
        'cart_item_id' => $cartItemId,
    ]);
}
public function updateProductColorByAttributeId(int $skuId, int $colorId, int $productId, ?int $userId = null, ?string $sessionId = null): bool
{
    $query = "UPDATE cart_items 
              SET color_id = :color_id 
              WHERE attribute_option_id = :sku_id 
              AND product_id = :product_id";

    if ($userId !== null) {
        $query .= " AND user_id = :user_id";
    } elseif ($sessionId !== null) {
        $query .= " AND session_id = :session_id";
    } else {
        return false;
    }

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':color_id', $colorId);
    $stmt->bindValue(':sku_id', $skuId);
    $stmt->bindValue(':product_id', $productId);

    if ($userId !== null) {
        $stmt->bindValue(':user_id', $userId);
    } else {
        $stmt->bindValue(':session_id', $sessionId);
    }

    return $stmt->execute();
}


public function fetchSelectedItems(?int $userId, ?string $sessionId): array
{
    $query = "SELECT ci.*, p.name, p.price, p.image
              FROM cart_items ci
              JOIN products p ON ci.product_id = p.id
              WHERE ci.is_selected = 1";

    $params = [];

    if ($userId !== null) {
        $query .= " AND ci.user_id = :user_id";
        $params['user_id'] = $userId;
    } else {
        $query .= " AND ci.session_id = :session_id";
        $params['session_id'] = $sessionId;
    }

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}







    // Hàm lấy cartItem theo session hoặc user
    public function getCartItemById(int $cartItemId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cart_items WHERE id = :id");
        $stmt->execute([':id' => $cartItemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ?: null;
    }

public function getCartWithSummary(int $userId): array
{
    $query = "SELECT ci.*, p.name, p.price, p.image
              FROM cart_items ci
              JOIN products p ON ci.product_id = p.id
              WHERE ci.user_id = :user_id AND ci.is_selected = 1";

    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $total = 0;
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return [
        'items' => $items,
        'total' => $total
    ];
}


}


