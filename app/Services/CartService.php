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
                'selected' => in_array($item['sku_id'], $_SESSION['selected_cart_items'] ?? []),
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

    private function getEmptyCartResponse()
    {
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

    /**
     * Get cart items by user ID (for authenticated users) or session ID (for guests)
     * This method now properly uses the cart service pattern
     */
    public function getCartItems($userId = null, $sessionId = null) 
    {
        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return [];
        }

        return $this->cartModel->getCartItemsWithDetails($cartId);
    }

    /**
     * Calculate total price from cart items array
     */
    public function calculateTotalPrice($cartItems) 
    {
        $totalPrice = 0;
        
        foreach ($cartItems as $item) {
            // Handle both array and object formats
            if (is_array($item)) {
                $totalPrice += $item['quantity'] * $item['price'];
            } elseif (is_object($item)) {
                $totalPrice += $item->quantity * $item->price;
            }
        }

        return $totalPrice;
    }

    /**
     * Get selected cart items based on session storage
     */
    public function getSelectedCartItems($userId = null, $sessionId = null)
{
    // Lấy nguyên mảng products và summary từ getCart
    $cartData = $this->getCart($userId, $sessionId);

    // Lấy danh sách tất cả sản phẩm trong giỏ
    $allItems = $cartData['products'];

    // Lấy mảng các id sản phẩm đã chọn từ session
    $selectedIds = $_SESSION['selected_cart_items'] ?? [];

    // Lọc lấy những sản phẩm có id nằm trong selectedIds
    $filteredItems = array_filter($allItems, function ($item) use ($selectedIds) {
        return in_array($item['id'], $selectedIds);
    });

    // Đảm bảo key mảng liền mạch
    return array_values($filteredItems);
}



    /**
     * Get selected cart items with summary calculation
     */
   public function getSelectedCartWithSummary($userId, $sessionId)
{
    $cart = $this->getCart($userId, $sessionId);

    $selectedItems = $_SESSION['selected_cart_items'] ?? [];

    $selectedProducts = array_filter($cart['products'], function ($p) use ($selectedItems) {
        return in_array($p['id'], $selectedItems);
    });

    $totalPrice = array_sum(array_map(function ($p) {
        return $p['price_current'] * $p['quantity'];
    }, $selectedProducts));

    return [
        'products' => array_values($selectedProducts),
        'summary' => [
            'total_price' => $totalPrice,
            'total_discount' => 0,
            'shipping_fee' => 30000,
            'final_total' => $totalPrice + 30000,
        ]
    ];
}



public function placeOrder(int $userId, int $addressId)
{
    // Lấy các sản phẩm được chọn trong cart
    $cartId = $this->cartModel->getOrCreateCart($userId, null);
    if (!$cartId) {
        return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
    }

    $selectedItems = $this->cartModel->getSelectedItems($cartId);
    if (empty($selectedItems)) {
        return ['success' => false, 'message' => 'Không có sản phẩm nào được chọn để đặt hàng.'];
    }

    // Tính tổng tiền đơn hàng
    $totalPrice = 0;
    $itemsForOrder = [];
    foreach ($selectedItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
        $itemsForOrder[] = [
            'sku_id' => $item['sku_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ];
    }

    // Gọi model để tạo order
    $result = $this->cartModel->placeOrder($userId, $addressId, $itemsForOrder, $totalPrice);

    if ($result['success']) {
        return ['success' => true, 'message' => 'Đặt hàng thành công!', 'order_id' => $result['order_id']];
    } else {
        return ['success' => false, 'message' => $result['message']];
    }
}
public function mergeSessionCartToUserCart(string $sessionId, int $userId): bool
{
    // Lấy cart của session
    $sessionCartId = $this->cartModel->getOrCreateCart(null, $sessionId);
    // Lấy cart của user
    $userCartId = $this->cartModel->getOrCreateCart($userId, null);

    if (!$sessionCartId || !$userCartId) {
        return false;
    }

    // Lấy tất cả sản phẩm của giỏ session
    $sessionItems = $this->cartModel->getCartItems($sessionCartId);

    foreach ($sessionItems as $item) {
        // Thêm hoặc cập nhật sản phẩm vào giỏ user
        $this->cartModel->addOrUpdateCartItem($userCartId, $item['sku_id'], $item['quantity']);
    }

    // Xóa giỏ session
    $this->cartModel->clearCart($sessionCartId);

    return true;
}

    /**
     * Clear selected items from cart
     */
    public function clearSelectedItems($userId = null, $sessionId = null)
    {
        $selectedIds = $_SESSION['selected_cart_items'] ?? [];
        if (empty($selectedIds)) {
            return ['success' => true, 'message' => 'Không có sản phẩm nào được chọn.'];
        }

        $cartId = $this->cartModel->getOrCreateCart($userId, $sessionId);
        if (!$cartId) {
            return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
        }

        $success = true;
        foreach ($selectedIds as $skuId) {
            $result = $this->cartModel->removeFromCart($cartId, $skuId);
            if (!$result) {
                $success = false;
            }
        }

        if ($success) {
            unset($_SESSION['selected_cart_items']);
            return ['success' => true, 'message' => 'Xóa các sản phẩm đã chọn thành công.'];
        } else {
            return ['success' => false, 'message' => 'Có lỗi xảy ra khi xóa một số sản phẩm.'];
        }
    }
}