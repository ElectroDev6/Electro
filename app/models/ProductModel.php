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
    public function getProducts(array $options = []): array
    {
        $limit = $options['limit'] ?? 8;
        $where = [];
        $joins = [];
        $params = [];

        // Lọc theo category
        if (!empty($options['category_id'])) {
            $where[] = "c.category_id = :category_id";
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
                        INNER JOIN categories c ON sc.category_id = c.category_id";
            $params['category_id'] = (int) $options['category_id'];
        }

        if (!empty($options['exclude_id'])) {
            $where[] = "p.product_id != :exclude_id";
            $params['exclude_id'] = (int) $options['exclude_id'];
        }

        // Lọc sản phẩm đang giảm giá
        if (!empty($options['is_sale'])) {
            $joins[] = "INNER JOIN promotions pr 
                        ON pr.sku_code = s.sku_code";
            if (!empty($options['date'])) {
                // Lọc theo ngày cụ thể
                $startOfDay = $options['date'] . ' 00:00:00';
                $endOfDay = $options['date'] . ' 23:59:59';
                $where[] = "pr.start_date <= :endOfDay";
                $where[] = "pr.end_date >= :startOfDay";
                $params['startOfDay'] = $startOfDay;
                $params['endOfDay'] = $endOfDay;
            } else {
                // Lọc theo thời gian hiện tại
                $where[] = "pr.start_date <= NOW()";
                $where[] = "pr.end_date >= NOW()";
            }
            $where[] = "pr.discount_percent IS NOT NULL";
        } else {
            $joins[] = "LEFT JOIN promotions pr 
                        ON pr.sku_code = s.sku_code
                        AND pr.start_date <= NOW()
                        AND pr.end_date >= NOW()";
        }

        // Lọc sản phẩm nổi bật
        if (!empty($options['is_featured'])) {
            $where[] = "p.is_featured = 1";
        }

        // Ghép điều kiện WHERE
        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        // Order by
        $orderBy = !empty($options['is_sale']) ? "ORDER BY pr.discount_percent DESC, p.created_at DESC" : "ORDER BY p.created_at DESC";

        $sql = "
            SELECT 
                p.product_id,
                p.name,
                p.slug,
                s.price AS price_original,
                vi.image_set AS default_image,
                CASE 
                    WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                    ELSE s.price
                END AS price_discount,
                pr.discount_percent AS discount,
                CASE 
                    WHEN pr.discount_percent IS NOT NULL THEN s.price - ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
                    ELSE 0
                END AS discount_amount
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
            LEFT JOIN variant_images vi 
                ON vi.sku_id = s.sku_id 
                AND vi.is_default = 1
            " . implode("\n", $joins) . "
            $whereSQL
            $orderBy
            LIMIT :limit
        ";

        $stmt = $this->pdo->prepare($sql);

        // Bind parameters
        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(":$key", $value, $paramType);
        }
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

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
        // 1. Lấy thông tin sản phẩm
        $sql = "
        SELECT 
            p.product_id,
            p.name,
            p.slug,
            s.subcategory_id,
            s.category_id,
            c.category_id,
            c.name AS category_name
        FROM products p
        JOIN subcategories s ON p.subcategory_id = s.subcategory_id
        JOIN categories c ON s.category_id = c.category_id
        WHERE p.slug = :slug
        LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':slug', $slug, \PDO::PARAM_STR);
        $stmt->execute();

        $product = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$product) {
            error_log("ProductModel: No product found for slug: $slug");
            return [];
        }

        // 2. Lấy tất cả biến thể (SKU) của sản phẩm
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
            ON pr.sku_code = s.sku_code
            AND pr.start_date <= NOW() 
            AND pr.end_date >= NOW()
        WHERE s.product_id = :product_id
    ";
        $stmt = $this->pdo->prepare($skuSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['variants'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Lấy mô tả chi tiết
        $descSql = "
        SELECT
            product_id,
            description,
            image_url
        FROM product_contents
        WHERE product_id = :product_id
    ";
        $stmt = $this->pdo->prepare($descSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['descriptions'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3.1 Thông số kỹ thuật
        $specSql = "
        SELECT
            product_id,
            spec_name,
            spec_value
        FROM product_specs
        WHERE product_id = :product_id
    ";
        $stmt = $this->pdo->prepare($specSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['specs'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3.2 Lấy bình luận
        // 3.2 Lấy bình luận kèm tên người dùng
        $commentSql = "
        SELECT
            r.review_id,
            r.user_id,
            u.name AS user_name,
            u.email AS user_email,
            r.product_id,
            r.parent_review_id,
            r.rating,
            r.comment_text,
            r.status
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        WHERE r.product_id = :product_id
        ORDER BY r.review_id ASC
    ";
        $stmt = $this->pdo->prepare($commentSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $product['comments'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // 4. Lấy ảnh theo SKU (ảnh default + gallery)
        $imageSql = "
        SELECT 
            vi.sku_id, 
            vi.image_set,
            vi.is_default,
            vi.sort_order
        FROM variant_images vi
        INNER JOIN skus s ON s.sku_id = vi.sku_id
        WHERE s.product_id = :product_id
        ORDER BY vi.sku_id, vi.sort_order
    ";
        $stmt = $this->pdo->prepare($imageSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 5. Gom ảnh vào từng SKU
        $product['images'] = [];
        foreach ($images as $image) {
            $skuId = $image['sku_id'];
            $imageFile = $image['image_set'];

            if (!isset($product['images'][$skuId])) {
                $product['images'][$skuId] = [
                    'thumbnail_url' => null, // Ảnh default
                    'gallery_urls' => [],    // Toàn bộ ảnh của SKU
                ];
            }


            // Thêm tất cả ảnh vào gallery
            $product['images'][$skuId]['gallery_urls'][] = $imageFile;
            $product['images'][$skuId]['thumbnail_url'][] = $imageFile;
        }

        // 6. Lấy attributes
        $attrSql = "
        SELECT 
            aos.sku_id,
            a.name AS option_name,
            ao.value AS option_value
        FROM attribute_option_sku aos
        INNER JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
        INNER JOIN attributes a ON ao.attribute_id = a.attribute_id
        INNER JOIN skus s ON aos.sku_id = s.sku_id
        WHERE s.product_id = :product_id
    ";
        $stmt = $this->pdo->prepare($attrSql);
        $stmt->bindValue(':product_id', $product['product_id'], \PDO::PARAM_INT);
        $stmt->execute();
        $attributes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $product['attributes'] = [];
        foreach ($attributes as $attr) {
            $product['attributes'][$attr['sku_id']][] = [
                'option_name' => $attr['option_name'],
                'option_value' => $attr['option_value'],
            ];
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
