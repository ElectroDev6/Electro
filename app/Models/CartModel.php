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

    public function getOrCreateCart($userId = null, $sessionId = null, $mergeIfNeeded = false)
    {
        error_log("CartModel: getOrCreateCart - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));
        try {
            $cartId = null;

            if ($userId) {
                $cartId = $this->getCartIdByUserId($userId);
                if (!$cartId) {
                    $stmt = $this->pdo->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
                    $stmt->execute([':user_id' => $userId]);
                    $cartId = $this->pdo->lastInsertId();
                    error_log("CartModel: Created new cart for UserID: $userId, CartID: $cartId");
                }

                // Chỉ merge nếu được yêu cầu
                if ($mergeIfNeeded && $sessionId) {
                    $this->mergeCart($userId, $sessionId, $cartId);
                }
            } elseif ($sessionId) {
                $cartId = $this->getCartIdBySessionId($sessionId);
                if (!$cartId) {
                    $stmt = $this->pdo->prepare("INSERT INTO cart (session_id) VALUES (:session_id)");
                    $stmt->execute([':session_id' => $sessionId]);
                    $cartId = $this->pdo->lastInsertId();
                    error_log("CartModel: Created new cart for SessionID: $sessionId, CartID: $cartId");
                }
            }

            return $cartId;
        } catch (\Throwable $e) {
            error_log("CartModel: Error in getOrCreateCart - " . $e->getMessage());
            return null;
        }
    }

    public function sessionCartExists($sessionId)
    {
        $sql = "SELECT COUNT(*) as total 
            FROM cart_items ci
            JOIN cart c ON ci.cart_id = c.cart_id
            WHERE c.session_id = :session_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['session_id' => $sessionId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row && $row['total'] > 0;
    }

    public function mergeCart($userId, $sessionId, $userCartId)
    {
        error_log("CartModel: Merging cart - UserID: $userId, SessionID: $sessionId, UserCartID: $userCartId");

        // Lấy cart_id của session_id
        $sessionCartId = $this->getCartIdBySessionId($sessionId);
        if (!$sessionCartId || $sessionCartId == $userCartId) {
            error_log("CartModel: No session cart to merge or same as user cart - SessionID: $sessionId");
            return;
        }

        // Lấy các sản phẩm từ giỏ hàng session_id
        $sessionItems = $this->fetchCartItems($sessionCartId);
        if (empty($sessionItems)) {
            error_log("CartModel: No items to merge from SessionCartID: $sessionCartId");
            // Xóa giỏ hàng session_id nếu không có sản phẩm
            $this->deleteCart($sessionCartId);
            return;
        }

        // Chuyển từng sản phẩm sang giỏ hàng user_id
        foreach ($sessionItems as $item) {
            $this->addToCart(
                $userCartId,
                $item['sku_id'],
                $item['quantity'],
                $item['color'],
                $item['warranty_enabled'],
                $item['image_url']
            );
        }

        // Xóa giỏ hàng session_id sau khi hợp nhất
        $this->deleteCart($sessionCartId);
        error_log("CartModel: Successfully merged and deleted SessionCartID: $sessionCartId into UserCartID: $userCartId");
    }

    private function deleteCart($cartId)
    {
        try {
            // Xóa cart_items trước do ràng buộc FOREIGN KEY
            $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
            $stmt->execute([':cart_id' => $cartId]);
            // Xóa cart
            $stmt = $this->pdo->prepare("DELETE FROM cart WHERE cart_id = :cart_id");
            $stmt->execute([':cart_id' => $cartId]);
            error_log("CartModel: Deleted cart - CartID: $cartId");
        } catch (Exception $e) {
            error_log("CartModel: Error in deleteCart - CartID: $cartId, Error: " . $e->getMessage());
        }
    }

    public function deleteAllCartItems($cartId)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
            $stmt->execute([':cart_id' => $cartId]);
            error_log("CartModel: Deleted cart items - CartID: $cartId");
        } catch (Exception $e) {
            error_log("CartModel: Error in deleteCartItems - CartID: $cartId, Error: " . $e->getMessage());
        }
    }

    public function getCartIdByUserId($userId)
    {
        $query = "SELECT cart_id FROM cart WHERE user_id = :user_id AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchColumn() ?: null;
    }

    public function getCartIdBySessionId($sessionId)
    {
        $query = "SELECT cart_id FROM cart WHERE session_id = :session_id AND created_at > DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':session_id' => $sessionId]);
        return $stmt->fetchColumn() ?: null;
    }

    public function getCartId($userId, $sessionId)
    {
        return $userId ? $this->getCartIdByUserId($userId) : $this->getCartIdBySessionId($sessionId);
    }

    public function getImageForVariant($skuId, $color)
    {
        try {
            // Truy vấn ảnh dựa trên màu
            if ($color) {
                $stmt = $this->pdo->prepare("
                    SELECT vi.image_set
                    FROM variant_images vi
                    JOIN skus s ON vi.sku_id = s.sku_id
                    JOIN attribute_option_sku aos ON s.sku_id = aos.sku_id
                    JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
                    JOIN attributes a ON ao.attribute_id = a.attribute_id
                    WHERE s.product_id = (SELECT product_id FROM skus WHERE sku_id = :sku_id)
                    AND a.name = 'Color' AND LOWER(ao.value) = LOWER(:color)
                    AND vi.is_default = TRUE
                    LIMIT 1
                ");
                $stmt->execute([':sku_id' => $skuId, ':color' => $color]);
                $image = $stmt->fetchColumn();
                error_log("CartModel: getImageForVariant - SKU: $skuId, Color: $color, Color Image: " . ($image ?? 'null'));

                if ($image) {
                    return $image;
                }
            }

            // Truy vấn ảnh mặc định cho SKU
            $stmt = $this->pdo->prepare("
                SELECT image_set
                FROM variant_images
                WHERE sku_id = :sku_id AND is_default = TRUE
                LIMIT 1
            ");
            $stmt->execute([':sku_id' => $skuId]);
            $image = $stmt->fetchColumn();
            error_log("CartModel: getImageForVariant - SKU: $skuId, Color: " . ($color ?? 'null') . ", Default Image: " . ($image ?? 'null'));

            if ($image) {
                return $image;
            }

            // Fallback lấy màu mặc định
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT LOWER(ao.value) as value
                FROM attribute_options ao
                JOIN attribute_option_sku aos ON ao.attribute_option_id = aos.attribute_option_id
                JOIN attributes a ON ao.attribute_id = a.attribute_id
                JOIN skus s ON aos.sku_id = s.sku_id
                WHERE s.product_id = (SELECT product_id FROM skus WHERE sku_id = :sku_id)
                AND a.name = 'Color'
                LIMIT 1
            ");
            $stmt->execute([':sku_id' => $skuId]);
            $defaultColor = $stmt->fetchColumn();
            error_log("CartModel: getImageForVariant - SKU: $skuId, Default Color: " . ($defaultColor ?? 'null'));

            if ($defaultColor) {
                $stmt = $this->pdo->prepare("
                    SELECT vi.image_set
                    FROM variant_images vi
                    JOIN skus s ON vi.sku_id = s.sku_id
                    JOIN attribute_option_sku aos ON s.sku_id = aos.sku_id
                    JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
                    JOIN attributes a ON ao.attribute_id = a.attribute_id
                    WHERE s.product_id = (SELECT product_id FROM skus WHERE sku_id = :sku_id)
                    AND a.name = 'Color' AND LOWER(ao.value) = LOWER(:color)
                    AND vi.is_default = TRUE
                    LIMIT 1
                ");
                $stmt->execute([':sku_id' => $skuId, ':color' => $defaultColor]);
                $image = $stmt->fetchColumn();
                error_log("CartModel: getImageForVariant - SKU: $skuId, Default Color Image: " . ($image ?? 'null'));

                if ($image) {
                    return $image;
                }
            }

            return '/img/placeholder.jpg';
        } catch (Exception $e) {
            error_log("CartModel: Error in getImageForVariant - SKU: $skuId, Color: " . ($color ?? 'null') . ", Error: " . $e->getMessage());
            return '/img/placeholder.jpg';
        }
    }

    public function fetchCartItems($cartId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT ci.cart_item_id, ci.cart_id, ci.sku_id, ci.quantity, ci.selected, LOWER(ci.color) as color, ci.warranty_enabled, ci.voucher_code, ci.image_url,
                       s.price, p.name
                FROM cart_items ci
                JOIN skus s ON ci.sku_id = s.sku_id
                JOIN products p ON s.product_id = p.product_id
                WHERE ci.cart_id = :cart_id
            ");
            $stmt->execute([':cart_id' => $cartId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("CartModel: Error in fetchCartItems - CartID: $cartId, Error: " . $e->getMessage());
            return [];
        }
    }

    public function getAvailableColors($skuId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT LOWER(ao.value) as value
                FROM attribute_options ao
                JOIN attribute_option_sku aos ON ao.attribute_option_id = aos.attribute_option_id
                JOIN attributes a ON ao.attribute_id = a.attribute_id
                JOIN skus s ON aos.sku_id = s.sku_id
                WHERE s.product_id = (SELECT product_id FROM skus WHERE sku_id = :sku_id)
                AND a.name = 'Color'
            ");
            $stmt->execute([':sku_id' => $skuId]);
            $colors = $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
            error_log("CartModel: Available colors for SKU $skuId: " . print_r($colors, true));
            return $colors;
        } catch (Exception $e) {
            error_log("CartModel: Error in getAvailableColors - SKU: $skuId, Error: " . $e->getMessage());
            return [];
        }
    }

    public function calculateVoucherDiscount($totalPrice, $voucherCode)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT discount_percent
                FROM coupons
                WHERE code = :code AND is_active = TRUE
                AND start_date <= NOW() AND (expires_at IS NULL OR expires_at > NOW())
                LIMIT 1
            ");
            $stmt->execute([':code' => $voucherCode]);
            $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($coupon) {
                return $totalPrice * ($coupon['discount_percent'] / 100);
            }
            return 0;
        } catch (Exception $e) {
            error_log("CartModel: Error in calculateVoucherDiscount - Voucher: $voucherCode, Error: " . $e->getMessage());
            return 0;
        }
    }

    public function addToCart($cartId, $skuId, $quantity, $color = null, $warrantyEnabled = false, $imageUrl = null)
    {
        error_log("CartModel: Attempting to add to cart - CartID: $cartId, SKU: $skuId, Quantity: $quantity, Color: " . ($color ?? 'null') . ", Warranty: " . ($warrantyEnabled ? 'true' : 'false') . ", Image: " . ($imageUrl ?? 'null'));
        try {
            $this->pdo->beginTransaction();
            $queryCheck = "SELECT cart_item_id, quantity, warranty_enabled, image_url FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id AND LOWER(color) = LOWER(:color) FOR UPDATE";
            $stmtCheck = $this->pdo->prepare($queryCheck);
            $stmtCheck->execute([':cart_id' => $cartId, ':sku_id' => $skuId, ':color' => $color ?: null]);
            $existingItem = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                $newQuantity = $existingItem['quantity'] + $quantity;
                $newWarrantyEnabled = $warrantyEnabled || $existingItem['warranty_enabled'];
                $newImageUrl = $imageUrl ?? $existingItem['image_url'] ?? $this->getImageForVariant($skuId, $color);
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
                $newImageUrl = $imageUrl ?? $this->getImageForVariant($skuId, $color);
                $queryInsert = "INSERT INTO cart_items (cart_id, sku_id, quantity, selected, color, warranty_enabled, image_url) VALUES (:cart_id, :sku_id, :quantity, 1, :color, :warranty_enabled, :image_url)";
                $stmtInsert = $this->pdo->prepare($queryInsert);
                $stmtInsert->execute([
                    ':cart_id' => $cartId,
                    ':sku_id' => $skuId,
                    ':quantity' => $quantity,
                    ':color' => $color ?: null,
                    ':warranty_enabled' => (int)$warrantyEnabled,
                    ':image_url' => $newImageUrl
                ]);
                error_log("CartModel: Inserted item - SKU: $skuId, Color: " . ($color ?? 'null') . ", Quantity: $quantity, Image: " . ($newImageUrl ?? 'null'));
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
        try {
            $query = "SELECT SUM(quantity) FROM cart_items WHERE cart_id = :cart_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':cart_id' => $cartId]);
            return (int)$stmt->fetchColumn() ?: 0;
        } catch (Exception $e) {
            error_log("CartModel: Error in getCartItemCount - CartID: $cartId, Error: " . $e->getMessage());
            return 0;
        }
    }

    public function updateSelectAll($cartId, $selectAll)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id");
            $stmt->execute([':selected' => (int)$selectAll, ':cart_id' => $cartId]);
        } catch (Exception $e) {
            error_log("CartModel: Error in updateSelectAll - CartID: $cartId, SelectAll: $selectAll, Error: " . $e->getMessage());
        }
    }


    public function updateProductSelection($cartId, $skuId, $selected)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id AND sku_id = :sku_id");
            $stmt->execute([':selected' => (int)$selected, ':cart_id' => $cartId, ':sku_id' => $skuId]);
        } catch (Exception $e) {
            error_log("CartModel: Error in updateProductSelection - CartID: $cartId, SKU: $skuId, Selected: $selected, Error: " . $e->getMessage());
        }
    }

    public function updateProductColor($cartId, $skuId, $color, $imageUrl = null)
    {
        try {
            $imageUrl = $this->getImageForVariant($skuId, $color);
            error_log("CartModel: Updating color - CartID: $cartId, SKU: $skuId, Color: $color, Image: " . ($imageUrl ?? 'null'));
            $stmt = $this->pdo->prepare("
                UPDATE cart_items 
                SET color = :color, image_url = :image_url 
                WHERE cart_id = :cart_id AND sku_id = :sku_id
            ");
            $stmt->execute([
                ':color' => $color,
                ':image_url' => $imageUrl,
                ':cart_id' => $cartId,
                ':sku_id' => $skuId
            ]);
        } catch (Exception $e) {
            error_log("CartModel: Error in updateProductColor - CartID: $cartId, SKU: $skuId, Color: $color, Error: " . $e->getMessage());
        }
    }

    public function updateQuantity($cartId, $skuId, $quantity)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE cart_items SET quantity = :quantity WHERE cart_id = :cart_id AND sku_id = :sku_id");
            $stmt->execute([':quantity' => $quantity, ':cart_id' => $cartId, ':sku_id' => $skuId]);
        } catch (Exception $e) {
            error_log("CartModel: Error in updateQuantity - CartID: $cartId, SKU: $skuId, Quantity: $quantity, Error: " . $e->getMessage());
        }
    }

    public function updateWarranty($cartId, $skuId, $enabled)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE cart_items SET warranty_enabled = :enabled WHERE cart_id = :cart_id AND sku_id = :sku_id");
            $stmt->execute([':enabled' => (int)$enabled, ':cart_id' => $cartId, ':sku_id' => $skuId]);
        } catch (Exception $e) {
            error_log("CartModel: Error in updateWarranty - CartID: $cartId, SKU: $skuId, Enabled: $enabled, Error: " . $e->getMessage());
        }
    }

    public function deleteCartItem($cartId, $skuId)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id AND sku_id = :sku_id");
            $stmt->execute([':cart_id' => $cartId, ':sku_id' => $skuId]);
        } catch (Exception $e) {
            error_log("CartModel: Error in deleteCartItem - CartID: $cartId, SKU: $skuId, Error: " . $e->getMessage());
        }
    }
public function getCartItems($userId) {
    $sql = "
        SELECT ci.*, s.price, s.sku_code, p.name, v.image_set
        FROM cart_items ci
        INNER JOIN cart c ON ci.cart_id = c.cart_id
        INNER JOIN skus s ON ci.sku_id = s.sku_id
        INNER JOIN products p ON s.product_id = p.product_id
        LEFT JOIN variant_images v ON s.sku_id = v.sku_id AND v.is_default = 1
        WHERE c.user_id = ?
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getCartItemsByUser($userId) {
    $sql = "SELECT ci.*, p.name, p.price 
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function clearCart(int $userId): bool {
        $stmt = $this->pdo->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $userId]);
    }

    public function applyVoucher($cartId, $voucherCode)
    {
        try {
            $this->pdo->beginTransaction();

            // Kiểm tra mã voucher hợp lệ
            $stmt = $this->pdo->prepare("
                SELECT coupon_id, max_usage
                FROM coupons
                WHERE code = :code AND is_active = TRUE
                AND start_date <= NOW() AND (expires_at IS NULL OR expires_at > NOW())
                LIMIT 1
            ");
            $stmt->execute([':code' => $voucherCode]);
            $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$coupon) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn.'];
            }

            // Kiểm tra số lần sử dụng
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as usage_count
                FROM coupon_usage
                WHERE coupon_id = :coupon_id
            ");
            $stmt->execute([':coupon_id' => $coupon['coupon_id']]);
            $usageCount = $stmt->fetchColumn();

            if ($usageCount >= $coupon['max_usage']) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => 'Mã voucher đã đạt giới hạn sử dụng.'];
            }

            // Lưu voucher_code vào cart_items
            $stmt = $this->pdo->prepare("
                UPDATE cart_items 
                SET voucher_code = :voucher_code 
                WHERE cart_id = :cart_id
            ");
            $stmt->execute([':voucher_code' => $voucherCode, ':cart_id' => $cartId]);

            // Ghi lại lần sử dụng
            $stmt = $this->pdo->prepare("
                INSERT INTO coupon_usage (coupon_id, cart_id)
                VALUES (:coupon_id, :cart_id)
            ");
            $stmt->execute([':coupon_id' => $coupon['coupon_id'], ':cart_id' => $cartId]);

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Áp dụng voucher thành công.'];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("CartModel: Error in applyVoucher - CartID: $cartId, Voucher: $voucherCode, Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi khi áp dụng voucher.'];
        }
    }
}
