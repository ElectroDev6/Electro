<?php

namespace App\Services;

use PDO;
use App\Models\CartModel;

class CartService
{
    private $cartModel;
    private $productService;

    public function __construct(PDO $pdo, ?ProductService $productService = null)
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

        $items = $this->cartModel->fetchCartItems($cartId);
        error_log("CartService: Fetched items: " . print_r($items, true));

        $products = [];
        $totalPrice = 0;
        $totalDiscount = 0;
        $shippingFee = 30000;
        $voucherCode = $items[0]['voucher_code'] ?? '';

        foreach ($items as $item) {
            $warrantyPrice = $item['warranty_enabled'] ? ($item['price'] * 0.1) : 0;
            $colors = $this->cartModel->getAvailableColors($item['sku_id']);
            $imageUrl = $item['image_url'] ?: $this->cartModel->getImageForVariant($item['sku_id'], $item['color']);
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
            $totalDiscount = $this->cartModel->calculateVoucherDiscount($totalPrice, $voucherCode);
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
            $imageUrl = $this->cartModel->getImageForVariant($skuId, $color);
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
            return $this->cartModel->applyVoucher($cartId, $voucherCode);
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
