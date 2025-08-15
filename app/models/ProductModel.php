<?php

namespace App\Models;

use PDO;

class ProductModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getHomeProductsByCategoryId(int $categoryId, int $limit = 8): array
    {
        $sql = "
            SELECT 
                p.product_id,
                p.name,
                p.slug,
                s.price AS price_original,
                -- Tính giá sau giảm:
                CASE 
                    WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                    ELSE s.price
                END AS price_discount,
                pr.discount_percent AS discount,
                -- Tính số tiền giảm:
                CASE 
                    WHEN pr.discount_percent IS NOT NULL THEN s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                    ELSE 0
                END AS discount_amount,
                vi.default_url
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
            -- Danh mục cha
            INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
            INNER JOIN categories c ON sc.category_id = c.category_id
            WHERE c.category_id = :category_id
            ORDER BY p.created_at DESC
            LIMIT :limit
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaleProducts(int $limit = 8): array
    {
        $sql = "
        SELECT 
            p.product_id,
            p.name,
            p.slug,
            s.price AS price_original,
            ROUND(s.price * (100 - pr.discount_percent) / 100, 0) AS price_discount,
            pr.discount_percent AS discount,
            s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0) AS discount_amount,
            vi.default_url
        FROM products p
        INNER JOIN (
            SELECT s1.*
            FROM skus s1
            INNER JOIN (
                SELECT product_id, MIN(sku_id) AS min_sku_id
                FROM skus
                GROUP BY product_id
            ) s2 ON s1.sku_id = s2.min_sku_id
        ) s ON s.product_id = p.product_id
        LEFT JOIN variant_images vi ON vi.sku_id = s.sku_id AND vi.is_default = 1
        INNER JOIN promotions pr 
            ON pr.sku_id = s.sku_id 
            AND pr.start_date <= NOW() 
            AND pr.end_date >= NOW()
        ORDER BY pr.discount_percent DESC, p.created_at DESC
        LIMIT :limit
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        $sql = "
         SELECT 
            p.product_id,
            p.name,
            p.slug,
            s.price AS price_original,
            ROUND(s.price * (100 - pr.discount_percent) / 100, 0) AS price_discount,
            pr.discount_percent AS discount,
            s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0) AS discount_amount,
            vi.default_url
        FROM products p
        INNER JOIN (
            SELECT s1.*
            FROM skus s1
            INNER JOIN (
                SELECT product_id, MIN(sku_id) AS min_sku_id
                FROM skus
                GROUP BY product_id
            ) s2 ON s1.sku_id = s2.min_sku_id
        ) s ON s.product_id = p.product_id
        LEFT JOIN variant_images vi ON vi.sku_id = s.sku_id AND vi.is_default = 1
        INNER JOIN promotions pr 
            ON pr.sku_id = s.sku_id 
            AND pr.start_date <= NOW() 
            AND pr.end_date >= NOW()
        ORDER BY pr.discount_percent DESC, p.created_at DESC
        LIMIT :limit
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSkuById($skuId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM skus WHERE id = ?");
        $stmt->execute([$skuId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }



    public function getProductDetailModel(string $slug): array
    {
        $sql = "
        SELECT 
            p.product_id,
            p.name,
            p.slug,
            p.description AS short_description
        FROM products p
        WHERE p.slug = :slug
        LIMIT 1
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug, \PDO::PARAM_STR);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$product) {
            return [];
        }

        // Lấy tất cả biến thể (SKU) của sản phẩm
        $skuSql = "
        SELECT 
            s.sku_id,
            s.sku_code,
            s.price AS price_original,
            s.stock_quantity,
            CASE 
                WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                ELSE s.price
            END AS price_discount,
            pr.discount_percent AS discount_percent,
            CASE 
                WHEN pr.discount_percent IS NOT NULL THEN s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                ELSE 0
            END AS discount_amount
        FROM skus s
        LEFT JOIN promotions pr 
            ON pr.sku_id = s.sku_id 
            AND pr.start_date <= NOW() 
            AND pr.end_date >= NOW()
        WHERE s.product_id = :product_id
    ";
        $stmt = $this->pdo->prepare($skuSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['variants'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Lấy mô tả chi tiết
        $descSql = "
        SELECT section_title, content_text, image_url, sort_order
        FROM product_descriptions
        WHERE product_id = :product_id
        ORDER BY sort_order ASC
    ";
        $stmt = $this->pdo->prepare($descSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['descriptions'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Lấy ảnh cho từng biến thể
        $imageSql = "
        SELECT vi.sku_id, vi.default_url, vi.thumbnail_url, vi.gallery_url, vi.sort_order
        FROM variant_images vi
        WHERE vi.sku_id IN (SELECT sku_id FROM skus WHERE product_id = :product_id)
        ORDER BY vi.sku_id, vi.sort_order ASC
    ";
        $stmt = $this->pdo->prepare($imageSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $product['images'] = [];
        foreach ($images as $image) {
            $product['images'][$image['sku_id']][] = array_diff_key($image, ['sku_id' => 0]);
        }

        // Lấy các thuộc tính cho từng biến thể
        $attrSql = "
        SELECT aos.sku_id, a.name AS attribute_name, ao.value AS option_value
        FROM attribute_option_sku aos
        INNER JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
        INNER JOIN attributes a ON ao.attribute_id = a.attribute_id
        WHERE aos.sku_id IN (SELECT sku_id FROM skus WHERE product_id = :product_id)
    ";
        $stmt = $this->pdo->prepare($attrSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $attributes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $product['attributes'] = [];
        foreach ($attributes as $attr) {
            $product['attributes'][$attr['sku_id']][] = array_diff_key($attr, ['sku_id' => 0]);
        }

        return $product;
    }
    public function getAllProducts(): array
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
        b.name AS brand_name

       
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

   
    -- Bộ lọc thương hiệu
    WHERE b.name IN ('Apple', 'Oppo', 'Vivo')

    
    ORDER BY p.created_at DESC
";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
