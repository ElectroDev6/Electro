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
        $limit = $options['limit'] ?? 6;
        $page = $options['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $where = [];
        $joins = [];
        $params = [];

        if (!empty($options['subcategory_ids'])) {
            $placeholders = [];
            foreach ($options['subcategory_ids'] as $index => $id) {
                $key = ":subcategory_id_$index";
                $placeholders[] = $key;
                $params["subcategory_id_$index"] = (int) $id;
            }
            $where[] = "p.subcategory_id IN (" . implode(',', $placeholders) . ")";
        } elseif (!empty($options['subcategory_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.subcategory_id = :subcategory_id";
            $params['subcategory_id'] = (int) $options['subcategory_id'];
        } elseif (!empty($options['category_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.category_id = :category_id";
            $params['category_id'] = (int) $options['category_id'];
        }

        if (!empty($options['brand'])) {
            $brands = is_array($options['brand']) ? $options['brand'] : [$options['brand']];
            $placeholders = [];
            foreach ($brands as $index => $brand) {
                $key = ":brand_$index";
                $placeholders[] = $key;
                $params["brand_$index"] = $brand;
            }
            $where[] = "b.name IN (" . implode(',', $placeholders) . ")";
            $joins[] = "INNER JOIN brands b ON p.brand_id = b.brand_id";
        } else {
            $joins[] = "LEFT JOIN brands b ON p.brand_id = b.brand_id";
        }

        $joins[] = "LEFT JOIN promotions pr 
            ON pr.sku_code = s.sku_code
            AND pr.start_date <= NOW()
            AND pr.end_date >= NOW()";

        // error_log("ProductModel: Attributes received: " . json_encode($options['attributes']));
        // Dynamic attribute filters
        if (!empty($options['attributes'])) {
            foreach ($options['attributes'] as $attr_id => $values) {
                if (empty($values)) continue;
                $prefix = "attr" . $attr_id;
                $joins[] = "INNER JOIN attribute_option_sku aos_$prefix ON s.sku_id = aos_$prefix.sku_id"; // Dùng s thay vì s_attr1
                $joins[] = "INNER JOIN attribute_options ao_$prefix ON aos_$prefix.attribute_option_id = ao_$prefix.attribute_option_id";
                $where[] = "ao_$prefix.attribute_id = :{$prefix}_id";
                $params["{$prefix}_id"] = (int) $attr_id;
                $placeholders = [];
                foreach ($values as $i => $val) {
                    $key = "{$prefix}_$i";
                    $placeholders[] = ":{$prefix}_$i";
                    $params[$key] = $val;
                }
                $where[] = "ao_$prefix.value IN (" . implode(',', $placeholders) . ")";
            }
        }

        // Price filters
        $price_expr = "CASE 
            WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
            ELSE s.price
        END";

        if (!empty($options['price'])) {
            $price_conditions = [];
            foreach ($options['price'] as $range) {
                if ($range === 'all') continue;
                switch ($range) {
                    case '30-40':
                        $min = 30000000;
                        $max = 39999999;
                        break;
                    case '25-30':
                        $min = 25000000;
                        $max = 29999999;
                        break;
                    case '20-25':
                        $min = 20000000;
                        $max = 24999999;
                        break;
                    case '15-20':
                        $min = 15000000;
                        $max = 19999999;
                        break;
                    case 'duoi15':
                        $min = 0;
                        $max = 14999999;
                        break;
                    default:
                        continue 2;
                }
                $price_conditions[] = "($price_expr >= $min AND $price_expr <= $max)";
            }
            if (!empty($price_conditions)) {
                $where[] = "(" . implode(' OR ', $price_conditions) . ")";
            }
        }

        if (!empty($options['is_sale'])) {
            $where[] = "pr.discount_percent IS NOT NULL";
            if (($options['sale_mode'] ?? '') === 'today') {
                $where[] = "DATE(pr.start_date) <= CURDATE()";
                $where[] = "DATE(pr.end_date) >= CURDATE()";
            } elseif (($options['sale_mode'] ?? '') === 'custom' && !empty($options['date'])) {
                $where[] = "DATE(pr.start_date) <= :custom_date";
                $where[] = "DATE(pr.end_date) >= :custom_date";
                $params['custom_date'] = $options['date'];
            }
        }

        if (!empty($options['is_featured'])) {
            $where[] = "p.is_featured = 1";
        }

        if (!empty($options['exclude_id'])) {
            $where[] = "p.product_id != :exclude_id";
            $params['exclude_id'] = (int) $options['exclude_id'];
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";
        $orderBy = !empty($options['is_sale']) ? "ORDER BY pr.discount_percent DESC, p.created_at DESC" : "ORDER BY p.created_at DESC";

        $sql = "
            SELECT 
                p.product_id,
                p.name,
                p.slug,
                p.subcategory_id,
                s.price AS price_original,
                vi.image_set AS default_image,
                pr.start_date,
                pr.end_date,
                SUBSTRING_INDEX(SUBSTRING_INDEX(s.sku_code, '-', 2), '-', -1) AS storage,
                b.name AS brand_name,
                $price_expr AS price_discount,
                pr.discount_percent AS discount,
                (s.price - $price_expr) AS discount_amount
            FROM products p
            INNER JOIN skus s ON s.product_id = p.product_id AND s.is_default = 1
            LEFT JOIN variant_images vi ON vi.sku_id = s.sku_id AND vi.is_default = 1
            " . implode("\n", $joins) . "
            $whereSQL
            $orderBy
            LIMIT :limit OFFSET :offset
        ";

        error_log("ProductModel: getProducts Query: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(":$key", $value, $paramType);
        }
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("ProductModel: getProducts Result: " . json_encode($result));
        return $result;
    }

    public function getSubcategoryBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM subcategories WHERE subcategory_slug = :slug LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("ProductModel: getSubcategoryBySlug Result: " . json_encode($result));
        return $result ?: null;
    }

    public function getProductsCount(array $options = []): int
    {
        $where = [];
        $joins = [];
        $params = [];

        if (!empty($options['subcategory_ids'])) {
            $placeholders = [];
            foreach ($options['subcategory_ids'] as $index => $id) {
                $key = ":subcategory_id_$index";
                $placeholders[] = $key;
                $params["subcategory_id_$index"] = (int) $id;
            }
            $where[] = "p.subcategory_id IN (" . implode(',', $placeholders) . ")";
        } elseif (!empty($options['subcategory_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.subcategory_id = :subcategory_id";
            $params['subcategory_id'] = (int) $options['subcategory_id'];
        } elseif (!empty($options['category_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.category_id = :category_id";
            $params['category_id'] = (int) $options['category_id'];
        }

        if (!empty($options['brand'])) {
            $brands = is_array($options['brand']) ? $options['brand'] : [$options['brand']];
            $placeholders = [];
            foreach ($brands as $index => $brand) {
                $key = ":brand_$index";
                $placeholders[] = $key;
                $params["brand_$index"] = $brand;
            }
            $where[] = "b.name IN (" . implode(',', $placeholders) . ")";
            $joins[] = "INNER JOIN brands b ON p.brand_id = b.brand_id";
        } else {
            $joins[] = "LEFT JOIN brands b ON p.brand_id = b.brand_id";
        }

        $joins[] = "LEFT JOIN promotions pr 
            ON pr.sku_code = s.sku_code
            AND pr.start_date <= NOW()
            AND pr.end_date >= NOW()";

        error_log("ProductModel: Attributes received: " . json_encode($options['attributes']));

        if (!empty($options['attributes'])) {
            foreach ($options['attributes'] as $attr_id => $values) {
                if (empty($values)) continue;
                $prefix = "attr" . $attr_id;
                $joins[] = "INNER JOIN attribute_option_sku aos_$prefix ON s.sku_id = aos_$prefix.sku_id"; // Dùng s thay vì s_attr1
                $joins[] = "INNER JOIN attribute_options ao_$prefix ON aos_$prefix.attribute_option_id = ao_$prefix.attribute_option_id";
                $where[] = "ao_$prefix.attribute_id = :{$prefix}_id";
                $params["{$prefix}_id"] = (int) $attr_id;
                $placeholders = [];
                foreach ($values as $i => $val) {
                    $key = "{$prefix}_$i";
                    $placeholders[] = ":{$prefix}_$i";
                    $params[$key] = $val;
                }
                $where[] = "ao_$prefix.value IN (" . implode(',', $placeholders) . ")";
            }
        }

        $price_expr = "CASE 
            WHEN pr.discount_percent IS NOT NULL THEN ROUND(s.price * (100 - pr.discount_percent) / 100, 0)
            ELSE s.price
        END";

        if (!empty($options['price'])) {
            $price_conditions = [];
            foreach ($options['price'] as $range) {
                if ($range === 'all') continue;
                switch ($range) {
                    case '30-40':
                        $min = 30000000;
                        $max = 39999999;
                        break;
                    case '25-30':
                        $min = 25000000;
                        $max = 29999999;
                        break;
                    case '20-25':
                        $min = 20000000;
                        $max = 24999999;
                        break;
                    case '15-20':
                        $min = 15000000;
                        $max = 19999999;
                        break;
                    case 'duoi15':
                        $min = 0;
                        $max = 14999999;
                        break;
                    default:
                        continue 2;
                }
                $price_conditions[] = "($price_expr >= $min AND $price_expr <= $max)";
            }
            if (!empty($price_conditions)) {
                $where[] = "(" . implode(' OR ', $price_conditions) . ")";
            }
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "
            SELECT COUNT(DISTINCT p.product_id)
            FROM products p
            INNER JOIN skus s ON s.product_id = p.product_id AND s.is_default = 1
            " . implode("\n", $joins) . "
            $whereSQL
        ";

        error_log("ProductModel: getProductsCount Query: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(":$key", $value, $paramType);
        }

        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getAvailableAttributes(array $filters = []): array
    {
        $where = [];
        $params = [];
        $joins = [];

        if (!empty($filters['category_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.category_id = :category_id";
            $params['category_id'] = (int) $filters['category_id'];
        }

        if (!empty($filters['subcategory_id'])) {
            $where[] = "sc.subcategory_id = :subcategory_id";
            $params['subcategory_id'] = (int) $filters['subcategory_id'];
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "
            SELECT DISTINCT a.attribute_id, a.name, a.display_type
            FROM attributes a
            INNER JOIN attribute_options ao ON a.attribute_id = ao.attribute_id
            INNER JOIN attribute_option_sku aos ON ao.attribute_option_id = aos.attribute_option_id
            INNER JOIN skus s ON aos.sku_id = s.sku_id
            INNER JOIN products p ON s.product_id = p.product_id
            " . implode("\n", $joins) . "
            $whereSQL
            ORDER BY a.attribute_id
        ";
        error_log("ProductModel: getAvailableAttributes Query: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value, PDO::PARAM_INT);
        }
        $stmt->execute();
        $attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($attributes as &$attr) {
            $attr['options'] = $this->getAttributeOptions($attr['attribute_id'], $filters);
        }

        return $attributes;
    }

    private function getAttributeOptions(int $attrId, array $filters): array
    {
        $where = ["ao.attribute_id = :attr_id"];
        $params = ['attr_id' => $attrId];
        $joins = [];

        if (!empty($filters['category_id'])) {
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $where[] = "sc.category_id = :category_id";
            $params['category_id'] = (int) $filters['category_id'];
        }

        if (!empty($filters['subcategory_id'])) {
            $where[] = "sc.subcategory_id = :subcategory_id";
            $params['subcategory_id'] = (int) $filters['subcategory_id'];
        }

        $whereSQL = implode(" AND ", $where);

        $sql = "
            SELECT DISTINCT ao.value, ao.display_order
            FROM attribute_options ao
            INNER JOIN attribute_option_sku aos ON ao.attribute_option_id = aos.attribute_option_id
            INNER JOIN skus s ON aos.sku_id = s.sku_id
            INNER JOIN products p ON s.product_id = p.product_id
            " . implode("\n", $joins) . "
            WHERE $whereSQL
            ORDER BY ao.display_order
        ";

        error_log("ProductModel: getAttributeOptions Query: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBrands(array $options = []): array
    {
        // If subcategory_slug is iPhone, return fixed brand Apple
        if (!empty($options['subcategory_slug']) && $options['subcategory_slug'] === 'iphone') {
            return [['name' => 'Apple']];
        }

        $where = [];
        $joins = [];
        $params = [];

        if (!empty($options['subcategory_slug'])) {
            $where[] = "sc.subcategory_slug = :subcategory_slug";
            $joins[] = "INNER JOIN products p ON p.brand_id = b.brand_id";
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $params['subcategory_slug'] = $options['subcategory_slug'];
        } elseif (!empty($options['category_id'])) {
            $where[] = "c.category_id = :category_id";
            $joins[] = "INNER JOIN products p ON p.brand_id = b.brand_id";
            $joins[] = "INNER JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id";
            $joins[] = "INNER JOIN categories c ON sc.category_id = c.category_id";
            $params['category_id'] = (int) $options['category_id'];
        } else {
            $joins[] = "INNER JOIN products p ON p.brand_id = b.brand_id";
        }

        $whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "
            SELECT DISTINCT b.name
            FROM brands b
            " . implode("\n", $joins) . "
            $whereSQL
            ORDER BY b.name
        ";

        error_log("ProductModel: getBrands Query: $sql, Params: " . json_encode($params));
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(":$key", $value, $paramType);
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("ProductModel: getBrands Result: " . json_encode($result));
        return $result;
    }

    public function getCategoryBySlug(string $slug): ?array
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':slug' => $slug]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("ProductModel: getCategoryBySlug Result: " . json_encode($result));
        return $result ?: null;
    }

    public function getSubcategories(int $category_id): array
    {
        $sql = "SELECT subcategory_id, name, subcategory_slug FROM subcategories WHERE category_id = :category_id ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':category_id' => $category_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("ProductModel: getSubcategories Result: " . json_encode($result));
        return $result;
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

    public function addReview(int $product_id, int $user_id, ?int $parent_review_id, string $comment_text): bool
    {
        $sql = "INSERT INTO reviews (product_id, user_id, parent_review_id, comment_text, status) 
            VALUES (:product_id, :user_id, :parent_review_id, :comment_text, 'approved')";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':product_id' => $product_id,
            ':user_id' => $user_id,
            ':parent_review_id' => $parent_review_id ?? null,
            ':comment_text' => $comment_text
        ];
        error_log("ProductModel: addReview Query: $sql, Params: " . json_encode($params));
        $result = $stmt->execute($params);
        error_log("ProductModel: addReview Result: " . ($result ? 'success' : 'failed'));
        return $result;
    }

    public function getUserById($id): ?array
    {
        $sql = "SELECT name FROM users WHERE user_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getDefaultSkuByProductId(int $productId): ?array
    {
        $sql = "
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
        AND s.is_default = 1
        LIMIT 1
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $sku = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sku) {
            error_log("ProductModel: No default SKU found for product_id: $productId");
            return null;
        }

        // Lấy ảnh mặc định của SKU
        $imageSql = "
        SELECT vi.image_set
        FROM variant_images vi
        WHERE vi.sku_id = :sku_id
        AND vi.is_default = 1
        LIMIT 1
    ";
        $stmt = $this->pdo->prepare($imageSql);
        $stmt->bindValue(':sku_id', $sku['sku_id'], PDO::PARAM_INT);
        $stmt->execute();
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        $sku['image_url'] = $image ? $image['image_set'] : null;

        // Lấy thuộc tính mặc định (ví dụ: color)
        $attrSql = "
        SELECT ao.value AS option_value
        FROM attribute_option_sku aos
        INNER JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
        INNER JOIN attributes a ON ao.attribute_id = a.attribute_id
        WHERE aos.sku_id = :sku_id
        AND a.name = 'Color'
        LIMIT 1
    ";
        $stmt = $this->pdo->prepare($attrSql);
        $stmt->bindValue(':sku_id', $sku['sku_id'], PDO::PARAM_INT);
        $stmt->execute();
        $attr = $stmt->fetch(PDO::FETCH_ASSOC);
        $sku['color'] = $attr ? $attr['option_value'] : null;

        return $sku;
    }

    public function getReviewsByProductId(int $product_id): array
    {
        $sql = "
        SELECT r.review_id, r.user_id, r.parent_review_id, r.comment_text, r.review_date, u.name
        FROM reviews r
        LEFT JOIN users u ON r.user_id = u.user_id
        WHERE r.product_id = :product_id AND r.status = 'approved'
        ORDER BY r.review_date DESC
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // error_log(json_encode($reviews));

        // Build comment tree
        $comment_tree = [];
        $child_comments = [];
        foreach ($reviews as $review) {
            $review['replies'] = [];
            if ($review['parent_review_id']) {
                $child_comments[$review['parent_review_id']][] = $review;
            } else {
                $comment_tree[$review['review_id']] = $review;
            }
        }
        foreach ($child_comments as $parent_id => $replies) {
            if (isset($comment_tree[$parent_id])) {
                $comment_tree[$parent_id]['replies'] = $replies;
            }
        }

        // error_log("ProductModel: getReviewsByProductId Result: " . json_encode($comment_tree));
        return array_values($comment_tree);
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
