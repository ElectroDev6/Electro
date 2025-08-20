<?php

namespace App\Models;

use PDO;

class HistoryModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOrdersByUser(int $userId, ?string $status = null): array
    {
        $sql = "
            SELECT 
                o.order_id,
                o.order_code,
                o.status,
                o.total_price,
                o.created_at,
                oi.quantity,
                oi.price AS item_price,
                p.name AS product_name,
                p.slug,
                s.sku_code,
                vi.image_set AS product_image
            FROM orders o
            LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN skus s ON oi.sku_id = s.sku_id
            LEFT JOIN products p ON s.product_id = p.product_id
            LEFT JOIN variant_images vi ON s.sku_id = vi.sku_id AND vi.is_default = 1
            WHERE o.user_id = :user_id
        ";

        // Thêm điều kiện lọc theo trạng thái nếu có
        if ($status) {
            $sql .= " AND o.status = :status";
        }

        $sql .= " ORDER BY o.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

        if ($status) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
