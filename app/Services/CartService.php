<?php

namespace App\Services;

use PDO; // Thêm dòng này

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
            return ['products' => [], 'summary' => ['total_price' => 0, 'total_discount' => 0, 'shipping_fee' => 0, 'final_total' => 0]];
        }

        $pdo = $this->cartModel->getPdo();
        $stmt = $pdo->prepare("
    SELECT ci.*, s.price, p.name, vi.image_url
    FROM cart_items ci
    JOIN skus s ON ci.sku_id = s.sku_id
    JOIN products p ON s.product_id = p.product_id
    LEFT JOIN (
        SELECT sku_id, MIN(thumbnail_url) AS image_url
        FROM variant_images
        GROUP BY sku_id
    ) vi ON s.sku_id = vi.sku_id
    WHERE ci.cart_id = :cart_id
");


        $stmt->execute([':cart_id' => $cartId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("CartService: Fetched items: " . print_r($items, true));

        $products = [];
        foreach ($items as $item) {
            $products[] = [
                'id' => $item['sku_id'],
                'name' => $item['name'],
                'image' => $item['image_url'] ?: '/img/placeholder/default.png',
                'price_current' => $item['price'],
                'price_original' => $item['price'],
                'quantity' => $item['quantity'],
                'selected' => false,
                'available_colors' => [],
                'color' => '',
                'warranty' => ['enabled' => false, 'price' => 0, 'price_original' => 0]
            ];
        }

        $totalPrice = array_sum(array_map(fn($p) => $p['price_current'] * $p['quantity'], $products));
        $totalDiscount = 0;
        $shippingFee = 0;
        $finalTotal = $totalPrice + $shippingFee;

        return [
            'products' => $products,
            'summary' => [
                'total_price' => $totalPrice,
                'total_discount' => $totalDiscount,
                'shipping_fee' => $shippingFee,
                'final_total' => $finalTotal
            ]
        ];
    }
    public function removeFromCart($productId, $userId = null, $sessionId = null)
{
    error_log("CartService: Attempting to remove SKU $productId - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));

    $cartId = $this->cartModel->getCartId($userId, $sessionId);
    if (!$cartId) {
        return ['success' => false, 'message' => 'Không thể tìm thấy giỏ hàng.'];
    }

    $result = $this->cartModel->removeFromCartModel($cartId);
    if ($result['success']) {
    // Có thể lưu message vào session để hiển thị thông báo:
    $_SESSION['success_message'] = $result['message'];
} else {
    $_SESSION['error_message'] = $result['message'];
}
}
public function setProductQuantity($productId, $quantity, $userId = null, $sessionId = null)
{
    error_log("CartService: Attempting to update quantity for SKU $productId to $quantity - UserID: " . ($userId ?? 'null') . ", SessionID: " . ($sessionId ?? 'null'));

    $cartId = $this->cartModel->updateProductQuantity($userId, $sessionId);
    if (!$cartId) {
        return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
    }

    $result = $this->cartModel->updateProductQuantityByCartId($cartId, $productId, $quantity);

    if ($result) {
        $_SESSION['success_message'] = 'Cập nhật số lượng sản phẩm thành công.';
        return ['success' => true, 'message' => 'Đã cập nhật số lượng.'];
    } else {
        $_SESSION['error_message'] = 'Không thể cập nhật số lượng sản phẩm.';
        return ['success' => false, 'message' => 'Cập nhật thất bại.'];
    }
}

public function updateProductQuantityByCartId($productId, $quantity, $userId = null, $sessionId = null)
{
    $cartId = $this->cartModel->updateProductQuantity($userId, $sessionId);
    if (!$cartId) {
        return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng'];
    }

    $result = $this->cartModel->updateProductQuantityByCartId($cartId, $productId, $quantity);

    if ($result) {
        return ['success' => true, 'message' => 'Cập nhật số lượng thành công'];
    } else {
        return ['success' => false, 'message' => 'Cập nhật thất bại'];
    }
}

public function setSelectAll($isSelected, $userId = null, $sessionId = null)
{
    $cartId = $this->cartModel->getCartIdBySessionOrUserOnly($userId, $sessionId);

    if (!$cartId) {
        return ['success' => false, 'message' => 'Không tìm thấy giỏ hàng.'];
    }

    $result = $this->cartModel->updateSelectAllProducts($cartId, $isSelected);

    if ($result) {
        return ['success' => true, 'message' => 'Cập nhật chọn tất cả thành công.'];
    } else {
        return ['success' => false, 'message' => 'Cập nhật thất bại.'];
    }
}
    // Xử lý đổi màu sản phẩm
    // Đổi màu sản phẩm bằng attribute_option_id (tức là ID của màu)
public function updateColorByAttributeId(int $skuId, int $productId, ?int $userId = null, ?string $sessionId = null): array
{
    // B1: Kiểm tra xem skuId có phải là màu sắc hợp lệ không (attribute_id = 1)
    if (!$this->cartModel->isValidColorAttributeOption($skuId)) {
        return ['failed' => false, 'message' => 'Giá trị không phải màu sắc hợp lệ.'];
    }

    // B2: Cập nhật color_id = skuId (vì skuId chính là id của màu sắc trong attribute_options)
    $colorId = $skuId;

    $result = $this->cartModel->updateProductColorByAttributeId(
        $skuId,
        $colorId,
        $productId,
        $userId,
        $sessionId
    );

    if ($result) {
        return ['success' => true, 'message' => 'Cập nhật màu thành công.'];
    } else {
        return ['failed' => false, 'message' => 'Cập nhật màu thất bại.'];
    }
}

public function getAvailableColors(): array
{
    return $this->cartModel->getColorOptions();
}

public function updateProductColor(int $cartItemId, int $colorId): bool
{
    return $this->cartModel->updateColor($cartItemId, $colorId);
}





// CartService.php
public function getSelectedCartItems(?int $userId, ?string $sessionId): array
{
    return $this->cartModel->fetchSelectedItems($userId, $sessionId);
}



}
