<?php
namespace App\Models\admin;
use PDO;

class ProductsModel 
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAllProducts($filters = [], $limit = 10, $offset = 0)
    {
        try {
            $sql = "
                SELECT 
                    p.product_id,
                    p.name AS product_name,
                    b.name AS brand_name,
                    s.name AS subcategory_name,
                    c.name AS category_name,
                    sk.price AS sku_price,
                    sk.stock_quantity,
                    COALESCE(
                        (SELECT vi.image_set 
                        FROM variant_images vi 
                        WHERE vi.sku_id = sk.sku_id 
                        AND vi.is_default = 1 
                        LIMIT 1),
                        (SELECT vi.image_set 
                        FROM variant_images vi 
                        WHERE vi.sku_id = sk.sku_id 
                        ORDER BY vi.sort_order ASC 
                        LIMIT 1),
                        '/img/products/default/default.png'
                    ) AS default_url
                FROM products p
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                LEFT JOIN categories c ON s.category_id = c.category_id
                LEFT JOIN (
                    SELECT 
                        sk1.*
                    FROM skus sk1
                    INNER JOIN (
                        SELECT product_id, MIN(sku_id) AS min_sku_id
                        FROM skus
                        WHERE is_active = 1
                        GROUP BY product_id
                    ) sk2 ON sk1.product_id = sk2.product_id AND sk1.sku_id = sk2.min_sku_id
                    WHERE sk1.is_active = 1
                ) sk ON p.product_id = sk.product_id
                WHERE 1=1
            ";

            $params = [];
            if (!empty($filters['name'])) {
                $sql .= " AND p.name LIKE :name";
                $params[':name'] = '%' . $filters['name'] . '%';
            }
            if (!empty($filters['category'])) {
                $sql .= " AND c.name = :category";
                $params[':category'] = $filters['category'];
            }
            if (!empty($filters['brand'])) {
                $sql .= " AND b.name = :brand";
                $params[':brand'] = $filters['brand'];
            }

            if (!empty($filters['price_sort']) && in_array($filters['price_sort'], ['asc', 'desc'])) {
                $sql .= " ORDER BY sk.price " . ($filters['price_sort'] === 'asc' ? 'ASC' : 'DESC');
            } else {
                $sql .= " ORDER BY p.created_at DESC";
            }

            $sql .= " LIMIT :limit OFFSET :offset";

            $countSql = "
                SELECT COUNT(*) as total
                FROM products p
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                LEFT JOIN categories c ON s.category_id = c.category_id
                LEFT JOIN (
                    SELECT 
                        sk1.*
                    FROM skus sk1
                    INNER JOIN (
                        SELECT product_id, MIN(sku_id) AS min_sku_id
                        FROM skus
                        WHERE is_active = 1
                        GROUP BY product_id
                    ) sk2 ON sk1.product_id = sk2.product_id AND sk1.sku_id = sk2.min_sku_id
                    WHERE sk1.is_active = 1
                ) sk ON p.product_id = sk.product_id
                WHERE 1=1
            ";

            if (!empty($filters['name'])) {
                $countSql .= " AND p.name LIKE :name";
            }
            if (!empty($filters['category'])) {
                $countSql .= " AND c.name = :category";
            }
            if (!empty($filters['brand'])) {
                $countSql .= " AND b.name = :brand";
            }

            $countStmt = $this->pdo->prepare($countSql);
            foreach ($params as $key => $value) {
                $countStmt->bindValue($key, $value, PDO::PARAM_STR);
            }
            $countStmt->execute();
            $totalProducts = $countStmt->fetchColumn();

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as &$product) {
                $product['sku_price'] = $product['sku_price'] ?? 0;
                $product['stock_quantity'] = $product['stock_quantity'] ?? 0;
                $product['default_url'] = $product['default_url'];
            }
            unset($product);

            return [
                'products' => $products,
                'total' => $totalProducts,
                'perPage' => $limit,
                'currentPage' => ($offset / $limit) + 1
            ];
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy danh sách sản phẩm: " . $e->getMessage());
            return [
                'products' => [],
                'total' => 0,
                'perPage' => $limit,
                'currentPage' => ($offset / $limit) + 1
            ];
        }
    }

    public function getCategories()
    {
        $sql = "SELECT name FROM categories ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getBrands()
    {
        $sql = "SELECT name FROM brands ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getAllBrands()
    {
        $sql = "SELECT brand_id, name FROM brands ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllColors()
    {
        $sql = "SELECT attribute_option_id AS color_id, value AS name FROM attribute_options WHERE attribute_id = 1 ORDER BY display_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCapacities()
    {
        $sql = "SELECT attribute_option_id AS capacity_id, value AS name FROM attribute_options WHERE attribute_id = 2 ORDER BY display_order ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContentProduct() {
        
    }

    public function getSubcategoriesByCategoryId($categoryId)
    {
        $sql = "SELECT subcategory_id, name, category_id FROM subcategories WHERE category_id = :category_id ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategoryById($subcategoryId)
    {
        $sql = "SELECT subcategory_id, name, category_id FROM subcategories WHERE subcategory_id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $subcategoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductById($productId)
    {
        try {
            $sql = "
                SELECT 
                    p.product_id, p.name, p.slug, p.brand_id, p.is_featured,
                    b.name AS brand_name,
                    c.name AS category_name, c.category_id,
                    s.name AS subcategory_name, s.subcategory_id
                FROM products p
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                LEFT JOIN categories c ON s.category_id = c.category_id
                WHERE p.product_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return [];
            }

            $result = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'brand_name' => $product['brand_name'] ?? '',
                'brand_id' => $product['brand_id'] ?? 0,
                'category_name' => $product['category_name'] ?? '',
                'category_id' => $product['category_id'] ?? 0,
                'subcategory_name' => $product['subcategory_name'] ?? '',
                'subcategory_id' => $product['subcategory_id'] ?? 0,
                'is_featured' => $product['is_featured'],
                'variants' => [],
                'images' => [],
                'attributes' => [],
                'descriptions' => [],
                'specs' => []
            ];

            // Get product descriptions
            $sql = "
                SELECT content_id, description, image_url
                FROM product_contents
                WHERE product_id = :id
                ORDER BY created_at";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $result['descriptions'] = array_map(fn($desc) => [
                'content_id' => $desc['content_id'] ?? null,
                'description' => $desc['description'] ?? '',
                'image_url' => $desc['image_url'] ?? ''
            ], $stmt->fetchAll(PDO::FETCH_ASSOC));

            // Get product specifications
            $sql = "
                SELECT spec_id, spec_name, spec_value, display_order
                FROM product_specs
                WHERE product_id = :id
                ORDER BY display_order, spec_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $result['specs'] = array_map(fn($spec) => [
                'spec_id' => $spec['spec_id'] ?? null,
                'spec_name' => $spec['spec_name'] ?? '',
                'spec_value' => $spec['spec_value'] ?? '',
                'display_order' => $spec['display_order'] ?? 0
            ], $stmt->fetchAll(PDO::FETCH_ASSOC));

            // Get product variants (SKUs)
            $sql = "
                SELECT sku_id, sku_code, price, stock_quantity, is_default, is_active
                FROM skus
                WHERE product_id = :id
                ORDER BY is_default DESC, sku_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $productId]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Prepare statements for images and attributes
            $imageSql = "
                SELECT image_id, image_set AS image_url, is_default, sort_order
                FROM variant_images
                WHERE sku_id = :sku_id
                ORDER BY sort_order, is_default DESC";
            $imageStmt = $this->pdo->prepare($imageSql);

            $attrSql = "
                SELECT a.name AS option_name, ao.value AS option_value,
                    a.attribute_id, ao.attribute_option_id
                FROM attribute_option_sku aos
                JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
                JOIN attributes a ON ao.attribute_id = a.attribute_id
                WHERE aos.sku_id = :sku_id
                ORDER BY a.attribute_id";
            $attrStmt = $this->pdo->prepare($attrSql);

            foreach ($variants as $variant) {
                $skuId = $variant['sku_id'];
                $variantData = [
                    'sku_id' => $skuId,
                    'sku_code' => $variant['sku_code'],
                    'price_original' => floatval($variant['price']),
                    'stock_quantity' => (int) $variant['stock_quantity'],
                    'is_default' => (int) $variant['is_default'],
                    'is_active' => (int) $variant['is_active'],
                    'attributes' => [],
                    'images' => []
                ];

                // Get variant images
                $imageStmt->execute([':sku_id' => $skuId]);
                $galleryUrls = array_column($imageStmt->fetchAll(PDO::FETCH_ASSOC), 'image_url');
                $result['images'][$skuId] = [
                    'gallery_urls' => $galleryUrls,
                    'thumbnail_url' => $galleryUrls
                ];
                $variantData['images'] = $galleryUrls;

                // Get variant attributes
                $attrStmt->execute([':sku_id' => $skuId]);
                $result['attributes'][$skuId] = array_map(fn($attr) => [
                    'option_name' => $attr['option_name'] ?? '',
                    'option_value' => $attr['option_value'] ?? '',
                    'attribute_id' => $attr['attribute_id'] ?? null,
                    'attribute_option_id' => $attr['attribute_option_id'] ?? null
                ], $attrStmt->fetchAll(PDO::FETCH_ASSOC));
                $variantData['attributes'] = $result['attributes'][$skuId];

                $result['variants'][] = $variantData;
            }

            return $result;

        } catch (PDOException $e) {
            error_log("Lỗi khi lấy thông tin sản phẩm: " . $e->getMessage());
            return [];
        }
    }

    public function updateCompleteProduct($data)
    {
        try {
            $this->pdo->beginTransaction();
            $productId = $data['product_id'];
            $basicInfo = $data['basic_info'];
            $descriptions = $data['descriptions'];
            $specifications = $data['specifications'];
            $variants = $data['variants'];

            // Update basic product information
            if (!empty($basicInfo)) {
                $this->updateProductBasicInfo($productId, $basicInfo);
            }

            // Update product descriptions
            $this->updateProductDescriptions($productId, $descriptions);

            // Update product specifications
            $this->updateProductSpecifications($productId, $specifications);

            // Update product variants
            $this->updateProductVariants($productId, $variants);

            $this->pdo->commit();
            return true;

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            error_log("Lỗi cập nhật sản phẩm: " . $e->getMessage());
            throw $e;
        }
    }

    private function updateProductBasicInfo($productId, $basicInfo)
    {
        $updateFields = [];
        $params = [':product_id' => $productId];

        foreach ($basicInfo as $field => $value) {
            if ($value !== null && $value !== '') {
                $updateFields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $value;
            }
        }

        if (!empty($updateFields)) {
            $sql = "UPDATE products SET " . implode(', ', $updateFields) . ", updated_at = NOW() WHERE product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        }
    }

    private function updateProductDescriptions($productId, $descriptions)
    {
        // Delete existing descriptions that are not in the update list
        $existingIds = array_filter(array_column($descriptions, 'content_id'));
        if (!empty($existingIds)) {
            $placeholders = str_repeat('?,', count($existingIds) - 1) . '?';
            $sql = "DELETE FROM product_contents WHERE product_id = ? AND content_id NOT IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_merge([$productId], $existingIds));
        } else {
            // Delete all existing descriptions if none are being kept
            $sql = "DELETE FROM product_contents WHERE product_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productId]);
        }

        // Insert or update descriptions
        foreach ($descriptions as $desc) {
            $imageUrl = $desc['new_image'] ?: $desc['current_image'];
            
            if ($desc['content_id']) {
                // Update existing description
                $sql = "UPDATE product_contents SET description = :description, image_url = :image_url, updated_at = NOW() WHERE content_id = :content_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':description' => $desc['description'],
                    ':image_url' => $imageUrl,
                    ':content_id' => $desc['content_id']
                ]);
            } else {
                // Insert new description
                $sql = "INSERT INTO product_contents (product_id, description, image_url, created_at, updated_at) VALUES (:product_id, :description, :image_url, NOW(), NOW())";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':description' => $desc['description'],
                    ':image_url' => $imageUrl
                ]);
            }
        }
    }

    private function updateProductSpecifications($productId, $specifications)
    {
        // Kiểm tra dữ liệu đầu vào
        foreach ($specifications as $spec) {
            if (empty($spec['spec_name']) || empty($spec['spec_value']) || strlen($spec['spec_name']) > 255 || strlen($spec['spec_value']) > 255) {
                throw new Exception("Tên hoặc giá trị thông số không hợp lệ");
            }
            if (!is_numeric($spec['display_order'])) {
                throw new Exception("Thứ tự hiển thị không hợp lệ");
            }
        }

        // Thêm hoặc cập nhật thông số
        foreach ($specifications as $spec) {
            // Nếu có spec_id, cập nhật dựa trên spec_id
            if (!empty($spec['spec_id']) && is_numeric($spec['spec_id'])) {
                $sql = "UPDATE product_specs SET spec_name = :spec_name, spec_value = :spec_value, display_order = :display_order WHERE spec_id = :spec_id AND product_id = :product_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':spec_name' => $spec['spec_name'],
                    ':spec_value' => $spec['spec_value'],
                    ':display_order' => $spec['display_order'],
                    ':spec_id' => $spec['spec_id'],
                    ':product_id' => $productId
                ]);
            } else {
                // Nếu không có spec_id, kiểm tra xem spec_name đã tồn tại cho product_id chưa
                $sql = "SELECT spec_id FROM product_specs WHERE product_id = :product_id AND spec_name = :spec_name";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':spec_name' => $spec['spec_name']
                ]);
                $existingSpec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingSpec) {
                    // Nếu spec_name đã tồn tại, cập nhật
                    $sql = "UPDATE product_specs SET spec_value = :spec_value, display_order = :display_order WHERE spec_id = :spec_id AND product_id = :product_id";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':spec_value' => $spec['spec_value'],
                        ':display_order' => $spec['display_order'],
                        ':spec_id' => $existingSpec['spec_id'],
                        ':product_id' => $productId
                    ]);
                } else {
                    // Nếu không tồn tại, thêm mới
                    $sql = "INSERT INTO product_specs (product_id, spec_name, spec_value, display_order) VALUES (:product_id, :spec_name, :spec_value, :display_order)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':product_id' => $productId,
                        ':spec_name' => $spec['spec_name'],
                        ':spec_value' => $spec['spec_value'],
                        ':display_order' => $spec['display_order']
                    ]);
                }
            }
        }
    }

    private function updateProductVariants($productId, $variants)
    {
        // Get existing SKU IDs for this product
        $existingSkuIds = array_filter(array_column($variants, 'sku_id'));
        
        if (!empty($existingSkuIds)) {
            $placeholders = str_repeat('?,', count($existingSkuIds) - 1) . '?';
            
            // Delete SKUs not in the update list
            $sql = "DELETE FROM skus WHERE product_id = ? AND sku_id NOT IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_merge([$productId], $existingSkuIds));
        } else {
            // Delete all existing SKUs if none are being kept
            $sql = "DELETE FROM skus WHERE product_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productId]);
        }

        // Handle default variant logic
        $hasDefault = false;
        foreach ($variants as $variant) {
            if ($variant['is_default']) {
                $hasDefault = true;
                break;
            }
        }
        
        // If no default is set, make the first variant default
        if (!$hasDefault && !empty($variants)) {
            $variants[0]['is_default'] = 1;
        }

        // Reset all existing variants to not default if we have a new default
        if ($hasDefault) {
            $sql = "UPDATE skus SET is_default = 0 WHERE product_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$productId]);
        }

        // Insert or update variants
        foreach ($variants as $variant) {
            if ($variant['sku_id']) {
                // Update existing variant
                $sql = "UPDATE skus SET sku_code = :sku_code, price = :price, stock_quantity = :stock_quantity, is_default = :is_default, is_active = :is_active, updated_at = NOW() WHERE sku_id = :sku_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':sku_code' => $variant['sku_code'],
                    ':price' => $variant['price'],
                    ':stock_quantity' => $variant['stock_quantity'],
                    ':is_default' => $variant['is_default'],
                    ':is_active' => $variant['is_active'],
                    ':sku_id' => $variant['sku_id']
                ]);
                $skuId = $variant['sku_id'];
            } else {
                // Insert new variant
                $sql = "INSERT INTO skus (product_id, sku_code, price, stock_quantity, is_default, is_active, created_at, updated_at) VALUES (:product_id, :sku_code, :price, :stock_quantity, :is_default, :is_active, NOW(), NOW())";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':sku_code' => $variant['sku_code'],
                    ':price' => $variant['price'],
                    ':stock_quantity' => $variant['stock_quantity'],
                    ':is_default' => $variant['is_default'],
                    ':is_active' => $variant['is_active']
                ]);
                $skuId = $this->pdo->lastInsertId();
            }

            // Update variant attributes
            $this->updateVariantAttributes($skuId, $variant['attributes']);

            // Update variant images
            $this->updateVariantImages($skuId, $variant['images']);
        }
    }

    private function updateVariantAttributes($skuId, $attributes)
    {
        // Delete existing attributes
        $sql = "DELETE FROM attribute_option_sku WHERE sku_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$skuId]);

        // Insert new attributes
        foreach ($attributes as $attribute) {
            $attributeOptionId = $this->getOrCreateAttributeOption($attribute['attribute_name'], $attribute['attribute_value']);
            if ($attributeOptionId) {
                $sql = "INSERT INTO attribute_option_sku (sku_id, attribute_option_id) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$skuId, $attributeOptionId]);
            }
        }
    }

    private function getOrCreateAttributeOption($attributeName, $attributeValue)
    {
        try {
            // Get attribute ID
            $sql = "SELECT attribute_id FROM attributes WHERE name = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$attributeName]);
            $attributeId = $stmt->fetchColumn();

            if (!$attributeId) {
                // Create new attribute
                $sql = "INSERT INTO attributes (name, created_at, updated_at) VALUES (?, NOW(), NOW())";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$attributeName]);
                $attributeId = $this->pdo->lastInsertId();
            }

            // Check if attribute option exists
            $sql = "SELECT attribute_option_id FROM attribute_options WHERE attribute_id = ? AND value = ? LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$attributeId, $attributeValue]);
            $attributeOptionId = $stmt->fetchColumn();

            if (!$attributeOptionId) {
                // Create new attribute option
                $sql = "INSERT INTO attribute_options (attribute_id, value, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$attributeId, $attributeValue]);
                $attributeOptionId = $this->pdo->lastInsertId();
            }

            return $attributeOptionId;

        } catch (\Exception $e) {
            error_log("Error creating attribute option: " . $e->getMessage());
            return null;
        }
    }

    private function updateVariantImages($skuId, $images)
    {
        // Delete existing images not in current list
        $currentImages = $images['current_images'] ?? [];
        if (!empty($currentImages)) {
            $placeholders = str_repeat('?,', count($currentImages) - 1) . '?';
            $sql = "DELETE FROM variant_images WHERE sku_id = ? AND image_set NOT IN ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_merge([$skuId], $currentImages));
        } else {
            // Delete all existing images if none are being kept
            $sql = "DELETE FROM variant_images WHERE sku_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$skuId]);
        }

        // Insert new images
        $newImages = $images['new_images'] ?? [];
        $sortOrder = count($currentImages);
        
        foreach ($newImages as $imageUrl) {
            $sql = "INSERT INTO variant_images (sku_id, image_set, is_default, sort_order, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$skuId, $imageUrl, 0, $sortOrder]);
            $sortOrder++;
        }

        // Ensure at least one image is marked as default
        if (!empty($currentImages) || !empty($newImages)) {
            $sql = "UPDATE variant_images SET is_default = 1 WHERE sku_id = ? AND is_default = 0 ORDER BY sort_order LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$skuId]);
        }
    }

    // Legacy method for backward compatibility
    public function updateProduct($data)
    {
        // Convert legacy format to new format
        $newData = [
            'product_id' => $data['product_id'],
            'basic_info' => [],
            'descriptions' => [],
            'specifications' => [],
            'variants' => $data['variants'] ?? []
        ];

        // Map basic product info
        if (isset($data['product_name'])) {
            $newData['basic_info']['name'] = $data['product_name'];
        }
        if (isset($data['slug'])) {
            $newData['basic_info']['slug'] = $data['slug'];
        }
        if (isset($data['brand_id'])) {
            $newData['basic_info']['brand_id'] = $data['brand_id'];
        }
        if (isset($data['category_id'])) {
            $newData['basic_info']['category_id'] = $data['category_id'];
        }
        if (isset($data['subcategory_id'])) {
            $newData['basic_info']['subcategory_id'] = $data['subcategory_id'];
        }

        return $this->updateCompleteProduct($newData);
    }
}
