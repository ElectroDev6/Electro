<?php

namespace App\Models;

use PDO;

class ProductLaptopModel
{
    private  $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function showAllLaptops(): array
    {
        $sql = "
    SELECT 
        p.product_id,
        p.name,
        p.slug,
        s.price AS price_original,
        CASE 
            WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
            ELSE s.price
        END AS price_discount,
        pr.discount_percent AS discount,
        CASE 
            WHEN pr.discount_percent IS NOT NULL THEN s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
            ELSE 0
        END AS discount_amount,
        vi.default_url,

        -- Dung lượng
        SUBSTRING_INDEX(SUBSTRING_INDEX(s.sku_code, '-', 2), '-', -1) AS storage,

        -- Thương hiệu
        b.name AS brand_name,

        --  Hệ điều hành
        os.name AS operating_system

    FROM products p

    -- SKU chính
    INNER JOIN (
        SELECT s1.*
        FROM skus s1
        INNER JOIN (
            SELECT product_id, MIN(sku_id) AS min_sku_id
            FROM skus
            GROUP BY product_id
        ) s2 ON s1.sku_id = s2.min_sku_id
    ) s ON s.product_id = p.product_id

    -- Ảnh
    LEFT JOIN variant_images vi ON vi.sku_id = s.sku_id AND vi.is_default = 1

    -- Khuyến mãi
    LEFT JOIN promotions pr 
        ON pr.sku_id = s.sku_id 
        AND pr.start_date <= NOW() 
        AND pr.end_date >= NOW()

    -- Thương hiệu
    LEFT JOIN brands b ON b.brand_id = p.brand_id

    --  Hệ điều hành
    LEFT JOIN operating_systems os ON os.id = p.operating_system_id

    -- Bộ lọc thương hiệu
    WHERE b.name IN ('Apple', 'Oppo', 'Vivo')

    -- (Tùy chọn) Bộ lọc hệ điều hành:
    -- AND os.slug = 'android'  -- hoặc 'ios'

    ORDER BY p.created_at DESC
";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}