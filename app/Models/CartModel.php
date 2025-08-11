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

     public function getCartId(?int $userId, string $sessionId): ?int
{
    error_log("CartModel::getCartId - User ID: " . ($userId ?? 'null') . ", Session ID: $sessionId");
    try {
        // Kiểm tra cả user_id và session_id
        $sql = "SELECT cart_id FROM cart WHERE user_id = :user_id OR session_id = :session_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId ?? null,
            'session_id' => $sessionId
        ]);
        $cartId = $stmt->fetchColumn();
        error_log("CartModel::getCartId - Fetched cart_id: " . ($cartId ?: 'null'));

        if ($cartId) {
            return (int)$cartId;
        }

        // Tạo giỏ hàng mới
        error_log("CartModel::getCartId - Creating new cart");
        $sqlInsert = "INSERT INTO cart (user_id, session_id, created_at) VALUES (:user_id, :session_id, NOW())";
        $stmt = $this->pdo->prepare($sqlInsert);
        $stmt->execute([
            'user_id' => $userId ?? null,
            'session_id' => $sessionId
        ]);
        $newCartId = (int)$this->pdo->lastInsertId();
        error_log("CartModel::getCartId - Created cart_id: $newCartId");
        return $newCartId;
    } catch (\PDOException $e) {
        error_log("CartModel::getCartId - SQL Error: " . $e->getMessage());
        throw new \Exception('Lỗi khi lấy hoặc tạo giỏ hàng: ' . $e->getMessage());
    }
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
public function executeQuery(string $sql, array $params = []): ?\PDOStatement
{
    try {
        error_log("CartModel::executeQuery - SQL: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (\PDOException $e) {
        error_log("CartModel::executeQuery - SQL Error: $sql, Error: " . $e->getMessage());
        return null;
    }
}


    public function getSelectedCartItems(?int $userId, string $sessionId): array
{
    error_log("CartService::getSelectedCartItems - User ID: " . ($userId ?? 'null') . ", Session ID: $sessionId");
    $cartId = $this->cartModel->getCartId($userId, $sessionId);
    if (!$cartId) {
        error_log("CartService::getSelectedCartItems - No cart_id found");
        return [
            'products' => [],
            'summary' => [
                'total_price' => 0,
                'total_discount' => 0,
                'shipping_fee' => 0,
                'final_total' => 0
            ]
        ];
    }
    error_log("CartService::getSelectedCartItems - Cart ID: $cartId");

    try {
        $sql = "
            SELECT ci.cart_item_id, ci.cart_id, ci.sku_id, ci.quantity, ci.color, ci.warranty_enabled, ci.image_url,
                   p.name, s.price as price_current, s.discount_price
            FROM cart_items ci
            JOIN skus s ON ci.sku_id = s.sku_id
            JOIN products p ON s.product_id = p.product_id
            WHERE ci.cart_id = :cart_id AND ci.selected = 1
        ";
        $stmt = $this->cartModel->executeQuery($sql, ['cart_id' => $cartId]);
        $products = $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
        error_log("CartService::getSelectedCartItems - Fetched products: " . print_r($products, true));

        $total_price = 0;
        $total_discount = 0;
        $shipping_fee = 30000;

        foreach ($products as $product) {
            if (!isset($product['price_current'], $product['quantity'])) {
                error_log("CartService::getSelectedCartItems - Invalid product data: " . print_r($product, true));
                continue;
            }
            $price = (float)$product['price_current'];
            $quantity = max(1, (int)$product['quantity']);
            $discount_price = isset($product['discount_price']) ? (float)$product['discount_price'] : null;

            $line_price = $price * $quantity;
            $total_price += $line_price;

            if ($discount_price !== null && $discount_price < $price) {
                $line_discount = ($price - $discount_price) * $quantity;
                $total_discount += max(0, $line_discount);
            }
        }

        $final_total = $total_price - $total_discount + $shipping_fee;

        return [
            'products' => $products,
            'summary' => [
                'total_price' => $total_price,
                'total_discount' => $total_discount,
                'shipping_fee' => $shipping_fee,
                'final_total' => $final_total
            ]
        ];
    } catch (\PDOException $e) {
        error_log("CartService::getSelectedCartItems - SQL Error: " . $e->getMessage());
        throw new \Exception('Lỗi khi lấy sản phẩm: ' . $e->getMessage());
    }
}


    public function clearSelected($userId, $sessionId): void
{
    $sql = "UPDATE cart SET selected = 0 WHERE ";
    $params = [];

    if ($userId) {
        $sql .= "user_id = :user_id";
        $params['user_id'] = $userId;
    } else {
        $sql .= "session_id = :session_id";
        $params['session_id'] = $sessionId;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
}

public function setSelected($userId, $sessionId, $skuId, int $status): void
{
    $sql = "UPDATE cart SET selected = :status WHERE sku_id = :sku_id AND ";
    $params = [
        'status' => $status,
        'sku_id' => $skuId
    ];

    if ($userId) {
        $sql .= "user_id = :user_id";
        $params['user_id'] = $userId;
    } else {
        $sql .= "session_id = :session_id";
        $params['session_id'] = $sessionId;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
}
public function clearSelectedStatus(?int $userId = null, ?string $sessionId = null): void
{
    $sql = "UPDATE cart_items SET selected = 0 WHERE cart_id = (
        SELECT cart_id FROM cart WHERE 1=1";
    $params = [];

    if ($userId) {
        $sql .= " AND user_id = :user_id";
        $params['user_id'] = $userId;
    } else {
        $sql .= " AND session_id = :session_id";
        $params['session_id'] = $sessionId;
    }

    $sql .= ")";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
}

public function setSelectedStatus(?int $userId = null, ?string $sessionId = null, array $skuIds = []): void
{
    if (empty($skuIds)) {
        return;
    }

    $placeholders = implode(',', array_fill(0, count($skuIds), '?'));

    $sql = "UPDATE cart_items SET selected = 1 WHERE sku_id IN ($placeholders) AND cart_id = (
        SELECT cart_id FROM cart WHERE 1=1";
    $params = $skuIds;

    if ($userId) {
        $sql .= " AND user_id = ?";
        $params[] = $userId;
    } else {
        $sql .= " AND session_id = ?";
        $params[] = $sessionId;
    }

    $sql .= ")";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
}

}
