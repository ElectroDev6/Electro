<?php

namespace App\Models;

class Order
{
    /**
     * Lưu đơn hàng vào database (chuẩn bị cho DB sau này)
     */
    public static function create(array $orderData): bool
    {
        // Tạm thời chưa kết nối DB
        // Sau này dùng PDO để insert vào bảng orders
        return true;
    }

    /**
     * Lấy danh sách đơn hàng (giả lập)
     */
    public static function all(): array
    {
        return $_SESSION['orders'] ?? [];
    }

    /**
     * Tìm đơn hàng theo ID
     */
    public static function find(string $id): ?array
    {
        $orders = $_SESSION['orders'] ?? [];
        foreach ($orders as $order) {
            if ($order['id'] === $id) {
                return $order;
            }
        }
        return null;
    }

    /**
     * Xoá đơn hàng theo ID
     */
    public static function delete(string $id): void
    {
        if (!isset($_SESSION['orders'])) return;

        $_SESSION['orders'] = array_filter($_SESSION['orders'], function ($order) use ($id) {
            return $order['id'] !== $id;
        });
    }
}
