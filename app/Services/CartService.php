<?php

namespace App\Services;

use PDO;
use App\Models\CartModel;

class CartService
{
    private $cartModel;
    private $productService;

    public function __construct(\PDO $pdo, ?ProductService $productService = null)
    {
        $this->cartModel = new CartModel($pdo);
        $this->productService = $productService;
    }

    public function addToCart($skuId, $quantity = 1, $userId = null, $sessionId = null, $color = null, $warrantyEnabled = false, $imageUrl = null)
    {
        error_log("CartService: Attempting to add to cart - SKU: $skuId, Quantity: $quantity, Color: " . ($color ?? 'null') . ", Warranty: " . ($warrantyEnabled ? 'true' : 'false') . ", Image: " . ($imageUrl ?? 'null') . ", UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            error_log("CartService: Failed to get or create cart");
            return ['success' => false, 'message' => 'Không thể tạo giỏ hàng.'];
        }

        $result = $this->cartModel->addToCart($cartId, $skuId, $quantity, $color, $warrantyEnabled, $imageUrl);
        if ($result) {
            return ['success' => true, 'message' => 'Thêm vào giỏ hàng thành công.', 'redirect' => '/cart'];
        }
        return ['success' => false, 'message' => 'Thêm vào giỏ hàng thất bại.'];
    }

    public function getCart($userId = null, $sessionId = null)
    {
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            error_log("CartService: No cart_id found, returning empty cart");
            return ['products' => [], 'summary' => ['total_price' => 0, 'total_discount' => 0, 'shipping_fee' => 0, 'final_total' => 0, 'voucher_code' => '']];
        }

        $pdo = $this->cartModel->getPdo();
        $stmt = $pdo->prepare("
            SELECT ci.cart_item_id, ci.cart_id, ci.sku_id, ci.quantity, ci.selected, ci.color, ci.warranty_enabled, ci.voucher_code, ci.image_url,
                   s.price, p.name
            FROM cart_items ci
            JOIN skus s ON ci.sku_id = s.sku_id
            JOIN products p ON s.product_id = p.product_id
            WHERE ci.cart_id = :cart_id
        ");
        $stmt->execute([':cart_id' => $cartId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("CartService: Fetched items: " . print_r($items, true));

        $products = [];
        $totalPrice = 0;
        $totalDiscount = 0;
        $shippingFee = 30000;
        $voucherCode = $items[0]['voucher_code'] ?? '';

        foreach ($items as $item) {
            $warrantyPrice = $item['warranty_enabled'] ? ($item['price'] * 0.1) : 0;
            $colors = $this->getAvailableColors($item['sku_id']);
            $imageUrl = $item['image_url'] ?: $this->getImageForVariant($item['sku_id'], $item['color']);
            $subtotal = $item['price'] * $item['quantity'] + $warrantyPrice;
            if ($item['selected']) {
                $totalPrice += $subtotal;
            }
            $products[] = [
                'id' => $item['sku_id'],
                'cart_item_id' => $item['cart_item_id'],
                'name' => $item['name'],
                'image' => $imageUrl ?: '/img/placeholder/default.png',
                'price_current' => $item['price'],
                'price_original' => $item['price'],
                'quantity' => $item['quantity'],
                'selected' => (bool)$item['selected'],
                'available_colors' => $colors,
                'color' => $item['color'] ?: ($colors[0] ?? ''),
                'warranty' => [
                    'enabled' => (bool)$item['warranty_enabled'],
                    'price' => $warrantyPrice,
                    'price_original' => $warrantyPrice
                ]
            ];
        }

        if ($voucherCode) {
            $totalDiscount = $this->calculateVoucherDiscount($totalPrice, $voucherCode);
        }

        return [
            'products' => $products,
            'summary' => [
                'total_price' => $totalPrice,
                'total_discount' => $totalDiscount,
                'shipping_fee' => $shippingFee,
                'final_total' => max(0, $totalPrice - $totalDiscount + $shippingFee),
                'voucher_code' => $voucherCode
            ]
        ];
    }

    private function getAvailableColors($skuId)
    {
        $pdo = $this->cartModel->getPdo();
        $stmt = $pdo->prepare("
            SELECT DISTINCT ao.value
            FROM attribute_options ao
            JOIN attribute_option_sku aos ON ao.attribute_option_id = aos.attribute_option_id
            JOIN attributes a ON ao.attribute_id = a.attribute_id
            JOIN skus s ON aos.sku_id = s.sku_id
            WHERE s.product_id = (SELECT product_id FROM skus WHERE sku_id = :sku_id)
            AND a.name = 'Color'
        ");
        $stmt->execute([':sku_id' => $skuId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getImageForVariant($skuId, $color)
    {
        $pdo = $this->cartModel->getPdo();
        // Ưu tiên lấy ảnh mặc định của sku_id
        $stmt = $pdo->prepare("
            SELECT image_set
            FROM variant_images
            WHERE sku_id = :sku_id AND is_default = TRUE
            LIMIT 1
        ");
        $stmt->execute([':sku_id' => $skuId]);
        $image = $stmt->fetchColumn();

        if ($image) {
            return "$image";
        }

        // Fallback lấy ảnh từ sku khác cùng màu
        if ($color) {
            $stmt = $pdo->prepare("
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
            if ($image) {
                return "$image";
            }
        }

        // Dùng màu mặc định nếu color rỗng
        $stmt = $pdo->prepare("
            SELECT DISTINCT ao.value
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
        if ($defaultColor) {
            $stmt = $pdo->prepare("
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
            if ($image) {
                return "$image";
            }
        }

        return '/img/placeholder.jpg';
    }

    private function calculateVoucherDiscount($totalPrice, $voucherCode)
    {
        $pdo = $this->cartModel->getPdo();
        $stmt = $pdo->prepare("
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
    }

    public function updateSelectAll($userId, $sessionId, $selectAll)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $this->cartModel->updateSelectAll($cartId, $selectAll);
        }
    }

   public function updateProductSelection(?int $userId, string $sessionId, string $skuId, bool $selected): void
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if (!$cartId) {
            error_log("CartService::updateProductSelection - No cart_id found for user_id=$userId, session_id=$sessionId");
            return;
        }

        $sql = "UPDATE cart_items SET selected = :selected WHERE cart_id = :cart_id AND sku_id = :sku_id";
        $this->cartModel->executeQuery($sql, [
            'selected' => $selected ? 1 : 0,
            'cart_id' => $cartId,
            'sku_id' => $skuId
        ]);
        error_log("CartService::updateProductSelection - SQL: $sql, Params: " . print_r(['selected' => $selected ? 1 : 0, 'cart_id' => $cartId, 'sku_id' => $skuId], true));
    }

    public function updateProductColor($userId, $sessionId, $skuId, $color)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $imageUrl = $this->getImageForVariant($skuId, $color);
            $this->cartModel->updateProductColor($cartId, $skuId, $color, $imageUrl);
        }
    }

    public function updateQuantity($userId, $sessionId, $skuId, $quantity)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $this->cartModel->updateQuantity($cartId, $skuId, $quantity);
        }
    }

    public function updateWarranty($userId, $sessionId, $skuId, $enabled)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $this->cartModel->updateWarranty($cartId, $skuId, $enabled);
        }
    }

    public function removeProductFromCart($skuId, $userId, $sessionId)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $this->cartModel->deleteCartItem($cartId, $skuId);
        }
    }

    public function applyVoucher($userId, $sessionId, $voucherCode)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $pdo = $this->cartModel->getPdo();
            $stmt = $pdo->prepare("
                SELECT coupon_id
                FROM coupons
                WHERE code = :code AND is_active = TRUE
                AND start_date <= NOW() AND (expires_at IS NULL OR expires_at > NOW())
                LIMIT 1
            ");
            $stmt->execute([':code' => $voucherCode]);
            if ($stmt->fetch()) {
                $this->cartModel->applyVoucher($cartId, $voucherCode);
                return ['success' => true, 'message' => 'Voucher applied successfully.'];
            }
            return ['success' => false, 'message' => 'Invalid or expired voucher code.'];
        }
        return ['success' => false, 'message' => 'Failed to apply voucher.'];
    }
public function mergeSessionCartToUserCart(string $sessionId, int $userId): void
{
    if (!$sessionId || !$userId) {
        return;
    }

    $sessionCartId = $this->cartModel->getCartId(null, $sessionId);
    $userCartId = $this->cartModel->getOrCreateCart($userId, null);

    if (!$sessionCartId || !$userCartId) {
        return;
    }

    $sessionItems = $this->cartModel->getCartItems($sessionCartId);

    foreach ($sessionItems as $item) {
        $existingItem = $this->cartModel->getCartItemBySku($userCartId, $item['sku_id'], $item['color'] ?? null);
        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $item['quantity'];
            $this->cartModel->updateQuantity($userCartId, $item['sku_id'], $newQuantity);
        } else {
            $this->cartModel->addToCart($userCartId, $item['sku_id'], $item['quantity'], $item['color'] ?? null, $item['warranty_enabled'] ?? 0, $item['image_url'] ?? null);
        }
    }

    // Xóa giỏ hàng session và các item của nó
    $this->cartModel->clearCartBySessionId($sessionId);
}

    public function confirm($userId, $sessionId)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $cart = $this->getCart($userId, $sessionId);
            if (empty($cart['products']) || !array_filter($cart['products'], fn($p) => $p['selected'])) {
                return ['success' => false, 'message' => 'Please select at least one product.'];
            }
            $_SESSION['cart_data'] = $cart;
            return ['success' => true, 'message' => 'Order confirmed, proceeding to checkout.'];
        }
        return ['success' => false, 'message' => 'Invalid cart.'];
    }

    public function getCartItemCount($userId = null, $sessionId = null)
    {
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return 0;
        }
        return $this->cartModel->getCartItemCount($cartId);
    }
  

    public function clearSelectedItems($userId = null, $sessionId = null)
    {
        return $this->cartModel->clearSelectedFromCart($userId, $sessionId);
    }
 public function updateSelectedStatus(?int $userId, string $sessionId, array $selectedSkuIds): void
{
    $cartId = $this->cartModel->getCartId($userId, $sessionId);
    if (!$cartId) {
        error_log("CartService::updateSelectedStatus - No cart_id");
        throw new \Exception('Không tìm thấy giỏ hàng.');
    }

    try {
        // Reset tất cả selected = 0
        $sqlReset = "UPDATE cart_items SET selected = 0 WHERE cart_id = ?";
        $this->cartModel->executeQuery($sqlReset, [$cartId]);

        // Cập nhật các sản phẩm được chọn
        if (!empty($selectedSkuIds)) {
            $placeholders = implode(',', array_fill(0, count($selectedSkuIds), '?'));
            $sqlSelect = "UPDATE cart_items SET selected = 1 WHERE cart_id = ? AND sku_id IN ($placeholders)";
            $params = array_merge([$cartId], $selectedSkuIds);
            $this->cartModel->executeQuery($sqlSelect, $params);
        }

        // Lấy toàn bộ sản phẩm trong cart, đánh dấu selected theo $selectedSkuIds
        $sqlGetCartItems = "
            SELECT 
                ci.cart_item_id,
                ci.cart_id,
                ci.sku_id,
                ci.quantity,
                ci.color,
                ci.warranty_enabled,
                ci.image_url,
                p.name AS product_name,
                s.price AS sku_price,
                p.base_price AS product_base_price,
                pr.discount_percent,
                CASE WHEN ci.sku_id IN (" . (empty($selectedSkuIds) ? 'NULL' : implode(',', array_map('intval', $selectedSkuIds))) . ") THEN 1 ELSE 0 END AS selected
            FROM cart_items ci
            INNER JOIN skus s  ON ci.sku_id = s.sku_id
            INNER JOIN products p ON s.product_id = p.product_id
            LEFT JOIN promotions pr ON s.sku_code = pr.sku_code
                AND NOW() BETWEEN pr.start_date AND pr.end_date
            WHERE ci.cart_id = :cart_id
        ";

        $stmt = $this->cartModel->executeQuery($sqlGetCartItems, ['cart_id' => $cartId]);
        $cartProducts = $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];

        // Tính tổng tạm (bạn có thể tùy chỉnh hoặc tính ở nơi khác)
        $total_price = 0;
        $total_discount = 0;
        $shipping_fee = 30000; // giả sử cố định

        foreach ($cartProducts as &$product) {
            $skuPrice = (float)$product['sku_price'];
            $quantity = max(1, (int)$product['quantity']);
            $discountPercent = (int)($product['discount_percent'] ?? 0);

            if ($discountPercent > 0) {
                $discountAmount = $skuPrice * $discountPercent / 100;
                $finalPrice = $skuPrice - $discountAmount;
            } else {
                $finalPrice = $skuPrice;
            }

            $lineTotal = $finalPrice * $quantity;
            $total_price += $lineTotal;

            $lineDiscount = ($skuPrice - $finalPrice) * $quantity;
            if ($lineDiscount > 0) {
                $total_discount += $lineDiscount;
            }
        }
        unset($product);

        $final_total = $total_price + $shipping_fee;

        $summary = [
            'total_price' => $total_price,
            'total_discount' => $total_discount,
            'shipping_fee' => $shipping_fee,
            'final_total' => $final_total,
        ];

        // Lưu vào session toàn bộ cart data (products + summary)
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $sessionKey = $userId ? "cart_data_{$userId}" : "cart_data_{$sessionId}";
        $_SESSION[$sessionKey] = [
            'products' => $cartProducts,
            'summary' => $summary
        ];

        error_log("CartService::updateSelectedStatus - Updated selected products and saved full cart data to session key: $sessionKey");

    } catch (\Throwable $e) {
        error_log("CartService::updateSelectedStatus - DB Error: " . $e->getMessage());
        throw new \Exception('Lỗi khi cập nhật trạng thái sản phẩm: ' . $e->getMessage());
    }
}





public function getSelectedCartItems(?int $userId, string $sessionId): array
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Key session lưu dữ liệu cart (bạn lưu theo userId hoặc sessionId)
    $sessionKey = $userId ? "cart_data_{$userId}" : "cart_data_{$sessionId}";

    // Lấy dữ liệu cart đã lưu trong session
    $cartData = $_SESSION[$sessionKey] ?? null;

    if (!$cartData || empty($cartData['products'])) {
        // Nếu không có dữ liệu, trả về mảng rỗng
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

    // Tính toán tổng (nếu bạn muốn, hoặc để nguyên summary đã lưu)
    $products = $cartData['products'];
    $summary = $cartData['summary'] ?? [
        'total_price' => 0,
        'total_discount' => 0,
        'shipping_fee' => 30000,
        'final_total' => 0
    ];

    $total_price = 0;
    $total_discount = 0;
    $shipping_fee = $summary['shipping_fee'] ?? 30000;

    foreach ($products as $product) {
        $priceCurrent = $product['sku_price'] ?? null;
        $quantity = $product['quantity'] ?? 1;
        $discountPercent = $product['discount_percent'] ?? 0;

        if ($priceCurrent === null) {
            continue;
        }

        $priceCurrent = (float)$priceCurrent;
        $quantity = max(1, (int)$quantity);
        $discountPercent = (int)$discountPercent;

        if ($discountPercent > 0) {
            $discountAmount = $priceCurrent * $discountPercent / 100;
            $finalPrice = $priceCurrent - $discountAmount;
        } else {
            $finalPrice = $priceCurrent;
        }

        $lineTotal = $finalPrice * $quantity;
        $total_price += $lineTotal;

        $lineDiscount = ($priceCurrent - $finalPrice) * $quantity;
        if ($lineDiscount > 0) {
            $total_discount += $lineDiscount;
        }
    }

    $final_total = $total_price + $shipping_fee;

    $summary['total_price'] = $total_price;
    $summary['total_discount'] = $total_discount;
    $summary['final_total'] = $final_total;

    return [
        'products' => $products,
        'summary' => $summary
    ];
}





}
