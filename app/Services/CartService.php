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

    public function addToCart($skuId, $quantity = 1, $userId = null, $sessionId = null)
    {
        error_log("CartService: Attempting to add to cart - SKU: $skuId, Quantity: $quantity, UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));
        
        if ($quantity <= 0) {
            return ['success' => false, 'message' => 'Số lượng không hợp lệ.'];
        }

        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            error_log("CartService: Failed to get or create cart - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));
            return ['success' => false, 'message' => 'Không thể tạo giỏ hàng.'];
        }

        $result = $this->cartModel->addToCart($cartId, $skuId, $quantity);
        error_log("CartService: Add to cart result for SKU $skuId, CartID $cartId: " . ($result ? 'Success' : 'Failure'));
        
        if ($result) {
            return ['success' => true, 'message' => 'Thêm vào giỏ hàng thành công.'];
        } else {
            return ['success' => false, 'message' => 'Thêm vào giỏ hàng thất bại.'];
        }
    }

    public function getCart($userId = null, $sessionId = null)
    {
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        error_log("CartService: Retrieved cart_id: $cartId");
        
        if (!$cartId) {
            error_log("CartService: No cart_id found, returning empty cart");
            return $this->getEmptyCartResponse();
        }

        $items = $this->cartModel->getCartItemsWithDetails($cartId);
        error_log("CartService: Fetched items: " . print_r($items, true));

        $products = [];
        foreach ($items as $item) {
            $availableColors = $this->cartModel->getColorsBySku($item['sku_id']);

            $products[] = [
                'id' => $item['sku_id'],
                'name' => $item['name'],
                'image' => $item['image_url'] ?: '/img/placeholder/default.png',
                'price_current' => $item['price'],
                'price_original' => $item['price'],
                'quantity' => $item['quantity'],
                'selected' => false,
                'available_colors' => $availableColors,
                'color_id' => $availableColors[0]['attribute_option_id'] ?? null,
                'warranty' => [
                    'enabled' => false,
                    'price' => 0,
                    'price_original' => 0
                ]
            ];
        }

        $totalPrice = array_sum(array_map(fn($p) => $p['price_current'] * $p['quantity'], $products));
        $totalDiscount = 0;
        $shippingFee = $this->calculateShippingFee($totalPrice);
        $finalTotal = $totalPrice - $totalDiscount + $shippingFee;

        $summary = [
            'total_price' => $totalPrice,
            'total_discount' => $totalDiscount,
            'shipping_fee' => $shippingFee,
            'final_total' => $finalTotal
        ];

        return [
            'products' => $products,
            'summary' => $summary
        ];
    }

    private function calculateShippingFee($totalPrice)
    {
        if ($totalPrice >= 500000) {
            return 0;
        }
        return 30000;
    }

    public function updateCartItemQuantity($userId = null, $sessionId = null, $skuId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeFromCart($skuId, $userId, $sessionId);
        }

        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
        }

        $result = $this->cartModel->updateCartItemQuantity($cartId, $skuId, $quantity);
        
        if ($result) {
            return ['success' => true, 'message' => 'Cập nhật số lượng thành công.'];
        } else {
            return ['success' => false, 'message' => 'Cập nhật số lượng thất bại.'];
        }
    }

    public function removeFromCart($skuId, $userId = null, $sessionId = null)
    {
        error_log("CartService: Attempting to remove SKU $skuId - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));

        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
        }

        $result = $this->cartModel->removeFromCart($cartId, $skuId);
        
        if ($result) {
            $_SESSION['success_message'] = 'Xóa sản phẩm khỏi giỏ hàng thành công.';
            return ['success' => true, 'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công.'];
        } else {
            $_SESSION['error_message'] = 'Xóa sản phẩm khỏi giỏ hàng thất bại.';
            return ['success' => false, 'message' => 'Xóa sản phẩm khỏi giỏ hàng thất bại.'];
        }
    }

    public function clearCart($userId = null, $sessionId = null)
    {
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
        }

        $result = $this->cartModel->clearCart($cartId);
        
        if ($result) {
            return ['success' => true, 'message' => 'Xóa toàn bộ giỏ hàng thành công.'];
        } else {
            return ['success' => false, 'message' => 'Xóa toàn bộ giỏ hàng thất bại.'];
        }
    }

    public function getCartItems($userId = null, $sessionId = null)
{
    $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
    if (!$cartId) {
        return [];
    }
    return $this->cartModel->getCartItems($cartId);
}


    // ==== Phần sửa chính ở đây: ======

    public function getSelectedCartItems($userId, $sessionId)
    {
        // Gọi đúng hàm getCartItems nhận cartId, qua service
        $allItems = $this->getCartItems($userId, $sessionId);

        $selectedIds = $_SESSION['selected_cart_items'] ?? [];

        return array_filter($allItems, function ($item) use ($selectedIds) {
            return in_array($item['sku_id'], $selectedIds);
        });
    }

    public function getSelectedCartWithSummary($userId, $sessionId)
    {
        $items = $this->getSelectedCartItems($userId, $sessionId);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $items));

        return [
            'products' => $items,
            'total' => $total
        ];
    }

    public function clearSelectedItems($userId, $sessionId)
    {
        $selectedIds = $_SESSION['selected_cart_items'] ?? [];
        if (empty($selectedIds)) return;

        foreach ($selectedIds as $skuId) {
            $this->cartModel->removeFromCart($this->cartModel->getOrCreateCart($userId, $sessionId), $skuId);
        }

        unset($_SESSION['selected_cart_items']);
    }

    // Các hàm còn lại giữ nguyên...
}
