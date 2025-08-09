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
    public function updateAllSelectedStatus($cartId, $selected)
    {
        $stmt = $this->pdo->prepare("
            UPDATE cart_items 
            SET selected = :selected
            WHERE cart_id = :cart_id
        ");
        return $stmt->execute([
            ':selected' => $selected ? 1 : 0,
            ':cart_id'  => $cartId
        ]);
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

    /**
     * Lấy chi tiết các item trong cart với thông tin product và image
     */
    public function getCartItemsWithDetails($cartId)
    {
        $stmt = $this->pdo->prepare("
            SELECT ci.*, s.price, p.name, vi.image_url,
                   ci.sku_id, ci.quantity, ci.created_at, ci.updated_at
            FROM cart_items ci
            JOIN skus s ON ci.sku_id = s.sku_id
            JOIN products p ON s.product_id = p.product_id
            LEFT JOIN (
                SELECT sku_id, MIN(thumbnail_url) AS image_url
                FROM variant_images
                GROUP BY sku_id
            ) vi ON s.sku_id = vi.sku_id
            WHERE ci.cart_id = :cart_id
            ORDER BY ci.created_at DESC
        ");
        
        $stmt->execute([':cart_id' => $cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật số lượng item trong cart
     */
    public function updateCartItemQuantity($cartId, $skuId, $quantity)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE cart_items 
                SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP 
                WHERE cart_id = :cart_id AND sku_id = :sku_id
            ");
            
            return $stmt->execute([
                ':cart_id' => $cartId,
                ':sku_id' => $skuId,
                ':quantity' => $quantity
            ]);
        } catch (Exception $e) {
            error_log("CartModel: Error updating cart item quantity - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa một item khỏi cart
     */
    public function removeFromCart($cartId, $skuId)
    {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM cart_items 
                WHERE cart_id = :cart_id AND sku_id = :sku_id
            ");
            
            return $stmt->execute([
                ':cart_id' => $cartId,
                ':sku_id' => $skuId
            ]);
        } catch (Exception $e) {
            error_log("CartModel: Error removing item from cart - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa tất cả items trong cart
     */
    public function clearCart($cartId)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
            return $stmt->execute([':cart_id' => $cartId]);
        } catch (Exception $e) {
            error_log("CartModel: Error clearing cart - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Đếm tổng số lượng items trong cart
     */
    public function getCartItemCount($cartId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT SUM(quantity) as total_count 
                FROM cart_items 
                WHERE cart_id = :cart_id
            ");
            
            $stmt->execute([':cart_id' => $cartId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['total_count'] ? (int)$result['total_count'] : 0;
        } catch (Exception $e) {
            error_log("CartModel: Error getting cart item count - " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Kiểm tra xem item có tồn tại trong cart không
     */
    public function isItemInCart($cartId, $skuId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 1 FROM cart_items 
            WHERE cart_id = :cart_id AND sku_id = :sku_id
        ");
        
        $stmt->execute([':cart_id' => $cartId, ':sku_id' => $skuId]);
        return $stmt->fetch() !== false;
    }

    /**
     * Lấy số lượng của một item trong cart
     */
    public function getItemQuantity($cartId, $skuId)
    {
        $stmt = $this->pdo->prepare("
            SELECT quantity FROM cart_items 
            WHERE cart_id = :cart_id AND sku_id = :sku_id
        ");
        
        $stmt->execute([':cart_id' => $cartId, ':sku_id' => $skuId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? (int)$result['quantity'] : 0;
    }

    /**
     * Cập nhật trạng thái selected của item
     */
    public function updateItemSelection($cartId, $skuId, $selected)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE cart_items 
                SET selected = :selected, updated_at = CURRENT_TIMESTAMP 
                WHERE cart_id = :cart_id AND sku_id = :sku_id
            ");
            
            return $stmt->execute([
                ':cart_id' => $cartId,
                ':sku_id' => $skuId,
                ':selected' => $selected ? 1 : 0
            ]);
        } catch (Exception $e) {
            error_log("CartModel: Error updating item selection - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cập nhật trạng thái selected cho tất cả items trong cart
     */
    public function updateAllItemsSelection($cartId, $selected)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE cart_items 
                SET selected = :selected, updated_at = CURRENT_TIMESTAMP 
                WHERE cart_id = :cart_id
            ");
            
            return $stmt->execute([
                ':cart_id' => $cartId,
                ':selected' => $selected ? 1 : 0
            ]);
        } catch (Exception $e) {
            error_log("CartModel: Error updating all items selection - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy các items được selected trong cart
     */
    public function getSelectedItems($cartId)
    {
        $stmt = $this->pdo->prepare("
            SELECT ci.*, s.price, p.name, vi.image_url
            FROM cart_items ci
            JOIN skus s ON ci.sku_id = s.sku_id
            JOIN products p ON s.product_id = p.product_id
            LEFT JOIN (
                SELECT sku_id, MIN(thumbnail_url) AS image_url
                FROM variant_images
                GROUP BY sku_id
            ) vi ON s.sku_id = vi.sku_id
            WHERE ci.cart_id = :cart_id AND ci.selected = 1
            ORDER BY ci.created_at DESC
        ");
        
        $stmt->execute([':cart_id' => $cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Merge cart khi user login (từ session cart sang user cart)
     */
    public function mergeCarts($sessionCartId, $userCartId)
    {
        try {
            $this->pdo->beginTransaction();
            
            // Lấy tất cả items từ session cart
            $sessionItems = $this->getCartItemsWithDetails($sessionCartId);
            
            foreach ($sessionItems as $item) {
                // Kiểm tra xem item đã có trong user cart chưa
                $existingQuantity = $this->getItemQuantity($userCartId, $item['sku_id']);
                
                if ($existingQuantity > 0) {
                    // Nếu đã có, cộng thêm số lượng
                    $newQuantity = $existingQuantity + $item['quantity'];
                    $this->updateCartItemQuantity($userCartId, $item['sku_id'], $newQuantity);
                } else {
                    // Nếu chưa có, thêm mới
                    $this->addToCart($userCartId, $item['sku_id'], $item['quantity']);
                }
            }
            
            // Xóa session cart
            $this->clearCart($sessionCartId);
            
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("CartModel: Error merging carts - " . $e->getMessage());
            return false;
        }
    }

    // =============================================================================
    // UPDATED OLD METHODS
    // =============================================================================

    public function getCartProducts($cartId): array
    {
        try {
            $sql = "SELECT 
                        ci.sku_id AS product_id,
                        ci.quantity,
                        ci.selected,
                        p.name,
                        s.price as price_current,
                        s.price as price_original, 
                        vi.image_url as image
                    FROM cart_items ci
                    JOIN skus s ON ci.sku_id = s.sku_id
                    JOIN products p ON s.product_id = p.product_id
                    LEFT JOIN (
                        SELECT sku_id, MIN(thumbnail_url) AS image_url
                        FROM variant_images
                        GROUP BY sku_id
                    ) vi ON s.sku_id = vi.sku_id
                    WHERE ci.cart_id = :cart_id
                    ORDER BY ci.created_at DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['cart_id' => $cartId]);
            $cartItems = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Thêm available_colors cho mỗi sản phẩm
            foreach ($cartItems as &$item) {
                $item['available_colors'] = $this->getAvailableColorsForProduct($item['product_id']);
                $item['selected'] = (bool)$item['selected'];
                $item['warranty'] = [
                    'enabled' => false,
                    'price' => 0,
                    'price_original' => 0
                ];
                
                $item['color'] = ''; // Có thể lấy từ variant info sau
                $item['image'] = $item['image'] ?: '/img/placeholder/default.png';
            }

            return $cartItems;
        } catch (Exception $e) {
            error_log("CartModel: Error in getCartProducts - " . $e->getMessage());
            return [];
        }
    }

    // Hàm lấy cartItem theo session hoặc user
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

    /**
     * IMPROVED: Xóa item cụ thể thay vì xóa bừa
     */
    public function removeFromCartModel($cartId, $skuId = null)
    {
        try {
            if ($skuId) {
                // Xóa item cụ thể
                $query = "DELETE FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id";
                $params = [':cart_id' => $cartId, ':sku_id' => $skuId];
            } else {
                // Xóa 1 item bất kỳ (giữ nguyên logic cũ)
                $query = "DELETE FROM cart_items WHERE cart_id = :cart_id LIMIT 1";
                $params = [':cart_id' => $cartId];
            }
            
            $stmt = $this->pdo->prepare($query);
            
            if ($stmt->execute($params)) {
                return ['success' => true, 'message' => 'Product deleted from cart.'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete product.'];
            }
        } catch (Exception $e) {
            error_log("CartModel: Error in removeFromCartModel - " . $e->getMessage());
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

    /**
     * IMPROVED: Cập nhật số lượng sản phẩm với sku_id nhất quán
     */
    public function updateProductQuantityByCartId($cartId, $skuId, $quantity)
    {
        try {
            $query = "UPDATE cart_items SET quantity = :quantity, updated_at = CURRENT_TIMESTAMP WHERE cart_id = :cart_id AND sku_id = :sku_id";
            $stmt = $this->pdo->prepare($query);

            if ($stmt->execute([
                ':quantity' => $quantity,
                ':cart_id' => $cartId,
                ':sku_id' => $skuId, // đổi từ :product_id thành :sku_id cho nhất quán
            ])) {
                return ['success' => true, 'message' => 'Cập nhật số lượng thành công.'];
            } else {
                return ['success' => false, 'message' => 'Cập nhật số lượng thất bại.'];
            }
        } catch (Exception $e) {
            error_log("CartModel: Error in updateProductQuantityByCartId - " . $e->getMessage());
            return ['success' => false, 'message' => 'Cập nhật số lượng thất bại.'];
        }
    }

    /**
     * IMPROVED: Thêm updated_at
     */
     public function updateSelectAll($cartId, $isSelected)
{
    $sql = "UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id ";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':selected' => $isSelected ? 1 : 0,
        ':cart_id' => $cartId
    ]);
}
public function getCartIdByUserOrSession(int $userId, string $sessionId): ?int
{
    $stmt = $this->pdo->prepare("
        SELECT cart_id FROM cart 
        WHERE user_id = :user_id OR session_id = :session_id
        LIMIT 1
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':session_id' => $sessionId
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['cart_id'] : null;
}
public function getCartItems($cartId)
{
    $stmt = $this->pdo->prepare("
        SELECT ci.*, s.price, p.name
        FROM cart_items ci
        JOIN skus s ON ci.sku_id = s.sku_id
        JOIN products p ON s.product_id = p.product_id
        WHERE ci.cart_id = :cart_id
    ");
    $stmt->execute(['cart_id' => $cartId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}




public function getSelectedCartItemsFromSession(): array
{
    return $_SESSION['cart_selected'] ?? [];
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

    // Lấy tất cả màu available (từ attribute_options với attribute_id = 1)
    private function getAvailableColorsForProduct($productId): array
    {
        $sql = "SELECT 
                    id as attribute_option_id,
                    value
                FROM attribute_options
                WHERE attribute_id = 1  
                ORDER BY value";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
public function getColorsBySku($skuId)
{
    $sql = "
        SELECT ao.value
        FROM skus s
        JOIN attribute_options ao ON attribute_option_id = ao.attribute_option_id
        JOIN attributes a ON ao.attribute_id = a.attribute_id
        WHERE s.sku_id = :sku_id
        AND a.name = 'color'
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['sku_id' => $skuId]);
    return $stmt->fetchAll(\PDO::FETCH_COLUMN);
}

    // Hàm lấy cartItem theo session hoặc user
    public function getCartItemById(int $cartItemId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cart_items WHERE id = :id");
        $stmt->execute([':id' => $cartItemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ?: null;
    }

    /**
     * Method để lấy cart với tính toán summary
     */
    public function getCartWithSummary($userId = null, $sessionId = null): array
    {
        $cartId = $this->getOrCreateCart($userId, $sessionId);
        
        if (!$cartId) {
            return [
                'items' => [],
                'total' => 0,
                'total_selected' => 0
            ];
        }

        $items = $this->getCartProducts($cartId);
        $selectedItems = array_filter($items, fn($item) => $item['selected']);
        
        $total = array_sum(array_map(fn($item) => $item['price_current'] * $item['quantity'], $items));
        $totalSelected = array_sum(array_map(fn($item) => $item['price_current'] * $item['quantity'], $selectedItems));

        return [
            'items' => $items,
            'total' => $total,
            'total_selected' => $totalSelected,
            'selected_count' => count($selectedItems)
        ];
    }
    public function placeOrder(int $userId, int $addressId, array $items, float $totalPrice): array
{
    try {
        $this->pdo->beginTransaction();

        // 1. Tạo order mới
        $stmtOrder = $this->pdo->prepare("INSERT INTO orders (user_id, user_address_id, total_price, status, created_at, updated_at) VALUES (:user_id, :address_id, :total_price, 'pending', NOW(), NOW())");
        $stmtOrder->execute([
            ':user_id' => $userId,
            ':address_id' => $addressId,
            ':total_price' => $totalPrice,
        ]);
        $orderId = $this->pdo->lastInsertId();

        // 2. Thêm từng sản phẩm vào order_items
        $stmtItem = $this->pdo->prepare("INSERT INTO order_items (order_id, sku_id, quantity, price, created_at, updated_at) VALUES (:order_id, :sku_id, :quantity, :price, NOW(), NOW())");
        
        foreach ($items as $item) {
            $stmtItem->execute([
                ':order_id' => $orderId,
                ':sku_id' => $item['sku_id'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price'],
            ]);
        }

        // 3. Xóa giỏ hàng
        $cartId = $this->getOrCreateCart($userId, null);
        $this->clearCart($cartId);

        $this->pdo->commit();
        return ['success' => true, 'order_id' => $orderId, 'message' => 'Đơn hàng đã được tạo thành công.'];
    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("CartModel: placeOrder error - " . $e->getMessage());
        return ['success' => false, 'message' => 'Lỗi khi tạo đơn hàng.'];
    }
}

}