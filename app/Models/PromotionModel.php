<?php

namespace App\Models;

use PDO;

class PromotionModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy các ngày sale tương lai
    public function getFutureSaleDates(string $startDate, string $endDate): array
    {
        $sql = "
            SELECT DISTINCT DATE(start_date) as sale_date
            FROM promotions
            WHERE start_date >= :startDate
            AND start_date <= :endDate
            ORDER BY sale_date
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Lấy thời gian kết thúc của sale cho một sản phẩm
    public function getSaleEndDate(int $productId): ?string
    {
        $sql = "
            SELECT end_date
            FROM promotions p
            JOIN skus s ON p.sku_code = s.sku_code
            WHERE s.product_id = :productId
            AND p.start_date <= NOW()
            AND p.end_date >= NOW()
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchColumn() ?: null;
    }

    // Lấy thời gian bắt đầu của sale cho một sản phẩm
    public function getSaleStartDate(int $productId): ?string
    {
        $sql = "
            SELECT start_date
            FROM promotions p
            JOIN skus s ON p.sku_code = s.sku_code
            WHERE s.product_id = :productId
            AND p.start_date <= NOW()
            AND p.end_date >= NOW()
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchColumn() ?: null;
    }
}
