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
                // Truy vấn chính để lấy danh sách sản phẩm
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

                // Thêm điều kiện lọc
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

                // Thêm sắp xếp
                if (!empty($filters['price_sort']) && in_array($filters['price_sort'], ['asc', 'desc'])) {
                    $sql .= " ORDER BY sk.price " . ($filters['price_sort'] === 'asc' ? 'ASC' : 'DESC');
                } else {
                    $sql .= " ORDER BY p.created_at DESC";
                }

                // Thêm phân trang
                $sql .= " LIMIT :limit OFFSET :offset";

                // Truy vấn đếm tổng số sản phẩm
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

                // Chuẩn bị và thực thi truy vấn đếm
                $countStmt = $this->pdo->prepare($countSql);
                foreach ($params as $key => $value) {
                    $countStmt->bindValue($key, $value, PDO::PARAM_STR);
                }
                $countStmt->execute();
                $totalProducts = $countStmt->fetchColumn();

                // Chuẩn bị và thực thi truy vấn chính
                $stmt = $this->pdo->prepare($sql);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Xử lý dữ liệu mặc định nếu thiếu
                foreach ($products as &$product) {
                    $product['sku_price'] = $product['sku_price'] ?? 0;
                    $product['stock_quantity'] = $product['stock_quantity'] ?? 0;
                    $product['default_url'] = $product['default_url'] ?? '/img/products/default/default.png';
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

    public function getProductById($productId)
    {
        try {
            // Fetch basic product information
            $sql = "
                SELECT 
                    p.product_id,
                    p.name,
                    p.slug,
                    b.name AS brand_name,
                    c.name AS category_name,
                    c.category_id,
                    s.name AS subcategory_name
                FROM products p
                LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
                LEFT JOIN categories c ON s.category_id = c.category_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                WHERE p.product_id = :product_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return [];
            }

            $result = [
                'product_id' => $product['product_id'],
                'name' => htmlspecialchars($product['name']),
                'slug' => htmlspecialchars($product['slug']),
                'brand_name' => htmlspecialchars($product['brand_name'] ?? ''),
                'category_name' => htmlspecialchars($product['category_name'] ?? ''),
                'category_id' => $product['category_id'] ?? 0,
                'subcategory_name' => htmlspecialchars($product['subcategory_name'] ?? ''),
                'variants' => [],
                'images' => [],
                'attributes' => [],
                'descriptions' => [],
                'specs' => []
            ];

            // Fetch product descriptions
            $sql = "
                SELECT description, image_url
                FROM product_contents
                WHERE product_id = :product_id
                ORDER BY created_at ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $descriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result['descriptions'] = array_map(function($desc) {
                return [
                    'description' => htmlspecialchars($desc['description'] ?? ''),
                    'image_url' => htmlspecialchars($desc['image_url'] ?? 'default.png')
                ];
            }, $descriptions);

            // Fetch product specifications
            $sql = "
                SELECT spec_name, spec_value, display_order
                FROM product_specs
                WHERE product_id = :product_id
                ORDER BY display_order ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $result['specs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch SKUs (variants)
            $sql = "
                SELECT 
                    s.sku_id,
                    s.sku_code,
                    s.price,
                    s.stock_quantity
                FROM skus s
                WHERE s.product_id = :product_id AND s.is_active = 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch images for each SKU
            $imageSql = "
                SELECT 
                    image_id,
                    sku_id,
                    image_set AS gallery_image_url,
                    is_default,
                    sort_order
                FROM variant_images
                WHERE sku_id = :sku_id
                ORDER BY sort_order ASC";
            $imageStmt = $this->pdo->prepare($imageSql);

            // Fetch attributes for each SKU
            $attrSql = "
                SELECT 
                    a.name AS option_name,
                    ao.value AS option_value
                FROM attribute_option_sku aos
                JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
                JOIN attributes a ON ao.attribute_id = a.attribute_id
                WHERE aos.sku_id = :sku_id";
            $attrStmt = $this->pdo->prepare($attrSql);

            foreach ($variants as $variant) {
                $skuId = $variant['sku_id'];
                $variantData = [
                    'sku_id' => $skuId,
                    'sku_code' => htmlspecialchars($variant['sku_code'] ?? 'Chưa xác định'),
                    'price_original' => $variant['price'],
                    'price_discount' => $variant['price'] * 0.85, // Assuming 15% discount as per detail page
                    'discount_percent' => 15,
                    'discount_amount' => $variant['price'] * 0.15,
                    'stock_quantity' => $variant['stock_quantity']
                ];

                // Fetch images for this SKU
                $imageStmt->execute([':sku_id' => $skuId]);
                $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);
                $galleryUrls = [];
                $thumbnailUrls = [];
                foreach ($images as $image) {
                    $galleryUrls[] = htmlspecialchars($image['gallery_image_url'] ?? 'default.png');
                    $thumbnailUrls[] = htmlspecialchars($image['gallery_image_url'] ?? 'default.png'); // Use same URL for thumbnail as gallery for now
                }
                $result['images'][$skuId] = [
                    'gallery_urls' => $galleryUrls,
                    'thumbnail_url' => $thumbnailUrls
                ];

                // Fetch attributes for this SKU
                $attrStmt->execute([':sku_id' => $skuId]);
                $attributes = $attrStmt->fetchAll(PDO::FETCH_ASSOC);
                $result['attributes'][$skuId] = $attributes;
                $variantData['attributes'] = $attributes;

                $result['variants'][] = $variantData;
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy chi tiết sản phẩm: " . $e->getMessage());
            return [];
        }
    }

    public function createProduct($productData, $variantData)
    {
        try {
            $this->pdo->beginTransaction();

            // Insert into products table
            $sql = "INSERT INTO products (name, brand_id, subcategory_id, base_price, slug, is_featured, created_at, updated_at)
                    VALUES (:name, :brand_id, :subcategory_id, :base_price, :slug, :is_featured, NOW(), NOW())";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $productData['name'],
                ':brand_id' => $productData['brand_id'],
                ':subcategory_id' => $productData['subcategory_id'],
                ':base_price' => $productData['base_price'],
                ':slug' => $productData['slug'],
                ':is_featured' => $productData['is_featured'] ?? 0,
            ]);
            $productId = $this->pdo->lastInsertId();

            // Insert product contents (descriptions)
            if (!empty($productData['descriptions'])) {
                foreach ($productData['descriptions'] as $description) {
                    $sql = "INSERT INTO product_contents (product_id, description, image_url, created_at, updated_at)
                            VALUES (:product_id, :description, :image_url, NOW(), NOW())";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':product_id' => $productId,
                        ':description' => $description['text'] ?? '',
                        ':image_url' => $description['image_url'] ?? null,
                    ]);
                }
            }

            // Insert product specifications
            if (!empty($productData['specifications'])) {
                foreach ($productData['specifications'] as $index => $spec) {
                    $sql = "INSERT INTO product_specs (product_id, spec_name, spec_value, display_order)
                            VALUES (:product_id, :spec_name, :spec_value, :display_order)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':product_id' => $productId,
                        ':spec_name' => $spec['name'] ?? '',
                        ':spec_value' => $spec['value'] ?? '',
                        ':display_order' => $spec['display_order'] ?? $index,
                    ]);
                }
            }

            // Handle main image
            if (is_array($productData['main_image']) && $productData['main_image']['error'] === UPLOAD_ERR_OK) {
                $mainImageUrl = $this->uploadImage($productData['main_image'], 'default');
            } else {
                $mainImageUrl = '/img/default.png';
            }

            // Insert variants (skus)
            foreach ($variantData as $index => $variant) {
                // Generate SKU code
                $skuCode = $this->generateSkuCode($productData['name'], $variant['capacity'] ?? 'UNKNOWN', $index);
                $sql = "INSERT INTO skus (product_id, sku_code, price, stock_quantity, is_active, created_at, updated_at)
                        VALUES (:product_id, :sku_code, :price, :stock_quantity, 1, NOW(), NOW())";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':sku_code' => $skuCode,
                    ':price' => $variant['price'],
                    ':stock_quantity' => $variant['stock_quantity'],
                ]);
                $skuId = $this->pdo->lastInsertId();

                // Insert main image into variant_images
                $sql = "INSERT INTO variant_images (sku_id, image_set, sort_order, is_default)
                        VALUES (:sku_id, :image_set, 0, 1)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':sku_id' => $skuId,
                    ':image_set' => $mainImageUrl,
                ]);

                // Insert additional images for the variant
                if (!empty($variant['images'])) {
                    foreach ($variant['images'] as $image) {
                        if (is_array($image['file']) && $image['file']['error'] === UPLOAD_ERR_OK) {
                            $imageUrl = $this->uploadImage($image['file'], 'gallery');
                            $sql = "INSERT INTO variant_images (sku_id, image_set, sort_order, is_default)
                                    VALUES (:sku_id, :image_set, :sort_order, 0)";
                            $stmt = $this->pdo->prepare($sql);
                            $stmt->execute([
                                ':sku_id' => $skuId,
                                ':image_set' => $imageUrl,
                                ':sort_order' => $image['sort_order'] ?? 0,
                            ]);
                        }
                    }
                }
            }

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            error_log("Error creating product: " . $e->getMessage());
            return false;
        }
    }

    private function generateSkuCode($productName, $capacity, $index)
    {
        $namePart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $productName), 0, 5));
        $capacityPart = strtoupper(str_replace(' ', '', $capacity));
        return "SKU-{$namePart}-{$capacityPart}-{$index}";
    }

    private function uploadImage($file, $imageType = 'default')
    {
        $baseDir = '/img/products/';
        $subDirs = [
            'default' => 'default/',
            'thumbnail' => 'thumbnails/',
            'gallery' => 'gallery/',
        ];

        $fileExtension = pathinfo($file['name'] ?? 'image.jpg', PATHINFO_EXTENSION);
        $uniqueFileName = uniqid() . '.' . strtolower($fileExtension);
        $targetSubDir = $subDirs[$imageType] ?? $subDirs['gallery'];
        $uploadDir = $baseDir . $targetSubDir;

        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $targetPath = $fullPath . $uniqueFileName;
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $uploadDir . $uniqueFileName;
        }
        throw new \Exception('Không thể tải lên ảnh.');
    }


}