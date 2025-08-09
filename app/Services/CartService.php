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

    public function updateProductSelection($userId, $sessionId, $skuId, $selected)
    {
        $cartId = $this->cartModel->getCartId($userId, $sessionId);
        if ($cartId) {
            $this->cartModel->updateProductSelection($cartId, $skuId, $selected);
        }
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

    public function confirmOrder($userId, $sessionId)
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
}
