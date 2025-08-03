<?php

namespace App\Models;

class Cart
{
    protected $userId;
    protected $items = [];

    public function __construct(int $userId)
    {
        // Khởi động session nếu chưa khởi
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userId = $userId;
        $this->items = $_SESSION['cart'][$userId] ?? [];
    }

    // Lấy giỏ hàng của user (array thuần)
    public static function getByUser(int $userId): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Dữ liệu giả cho user mới
        if (empty($_SESSION['cart'][$userId])) {
            $_SESSION['cart'][$userId] = [
                1 => [
                    'productId' => 1,
                    'quantity' => 1,
                    'selected' => true,
                    'warranty_enabled' => false,
                ],
                2 => [
                    'productId' => 2,
                    'quantity' => 2,
                    'selected' => true,
                    'warranty_enabled' => false,
                ],
            ];
        }

        return $_SESSION['cart'][$userId];
    }

    // Trả về đối tượng Cart của user
    public static function getOrCreateByUser(int $userId): Cart
    {
        return new Cart($userId);
    }

    // Thêm sản phẩm vào giỏ
    public function addItem(int $productId, int $quantity = 1): void
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] += $quantity;
        } else {
            $this->items[$productId] = [
                'productId' => $productId,
                'quantity' => $quantity,
                'selected' => true,
                'warranty_enabled' => false,
            ];
        }
    }

    // Cập nhật số lượng sản phẩm
    public function updateQuantity(int $productId, int $quantity): void
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] = max(1, $quantity); // Không cho nhỏ hơn 1
        }
    }

    // Xoá sản phẩm
    public function removeItem(int $productId): void
    {
        unset($this->items[$productId]);
    }

    // Cập nhật trạng thái chọn
    public function updateSelect(int $productId, bool $selected): void
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['selected'] = $selected;
        }
    }

    // Cập nhật trạng thái bảo hành
    public function updateWarranty(int $productId, bool $enabled): void
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['warranty_enabled'] = $enabled;
        }
    }

    // Chọn tất cả sản phẩm
    public function selectAll(): void
    {
        foreach ($this->items as &$item) {
            $item['selected'] = true;
        }
    }

    // Bỏ chọn tất cả sản phẩm
    public function unselectAll(): void
    {
        foreach ($this->items as &$item) {
            $item['selected'] = false;
        }
    }

    // Xoá toàn bộ giỏ hàng
    public function clearAll(): void
    {
        $this->items = [];
    }

    // Lưu lại vào session
    public function save(): void
    {
        $_SESSION['cart'][$this->userId] = $this->items;
    }
    public function updateColor(int $productId, string $color): void
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['color'] = $color;
        }
    }
}
