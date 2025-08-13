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

   public function fetchAllProducts()
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
                    vi.image_set AS default_url
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
                LEFT JOIN variant_images vi ON sk.sku_id = vi.sku_id AND vi.is_default = 1
                ORDER BY p.created_at DESC
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Xử lý dữ liệu mặc định nếu thiếu
            foreach ($products as &$product) {
                $product['sku_price'] = $product['sku_price'] ?? 0;
                $product['stock_quantity'] = $product['stock_quantity'] ?? 0;
                $product['default_url'] = $product['default_url'] ?? '/img/default.png';
            }
            unset($product);

            return $products;
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy danh sách sản phẩm: " . $e->getMessage());
            return [];
        }
    }

        public function getProductById($productId)
    {
        try {
            // Lấy thông tin cơ bản của sản phẩm
            $sql = "SELECT 
                p.product_id,
                p.name AS product_name,
                p.base_price,
                c.category_id,
                c.name AS category_name,
                b.name AS brand_name
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

            // Chuẩn bị dữ liệu trả về
            $result = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'category_id' => $product['category_id'] ?? 0,
                'brand_name' => $product['brand_name'] ?? '',
                'base_price' => $product['base_price'] ?? 0,
            ];

            // Lấy nội dung mô tả từ product_contents
            $sql = "SELECT description, image_url
                    FROM product_contents
                    WHERE product_id = :product_id
                    ORDER BY created_at ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result['descriptions'] = array_map(function($content) {
                return [
                    'description' => htmlspecialchars($content['description'] ?? ''),
                    'image_url' => $content['image_url'] ?? '/img/default.png'
                ];
            }, $contents);

            // Lấy thông số kỹ thuật từ product_specs
            $sql = "SELECT spec_name, spec_value, display_order
                    FROM product_specs
                    WHERE product_id = :product_id
                    ORDER BY display_order ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $specs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result['specifications'] = $specs;

            // Lấy tất cả SKU (biến thể) của sản phẩm
            $sql = "SELECT 
                s.sku_id AS id,
                s.sku_code,
                s.price,
                s.stock_quantity
            FROM skus s
            WHERE s.product_id = :product_id AND s.is_active = 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result['variants'] = [];
            foreach ($variants as $variant) {
                $variantData = [
                    'id' => $variant['id'],
                    'sku_code' => $variant['sku_code'] ?? 'Chưa xác định',
                    'price' => $variant['price'] ?? $product['base_price'] ?? 0,
                    'stock_quantity' => $variant['stock_quantity'] ?? 0,
                    'images' => [],
                    'attributes' => [], // Thêm phần attributes mới
                ];

                // Lấy attributes (bao gồm colors) cho biến thể
                $sqlAttributes = "SELECT 
                    a.name AS attribute_name,
                    ao.value AS attribute_value
                FROM attribute_option_sku aos
                JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id
                JOIN attributes a ON ao.attribute_id = a.attribute_id
                WHERE aos.sku_id = :sku_id";
                $stmtAttributes = $this->pdo->prepare($sqlAttributes);
                $stmtAttributes->execute([':sku_id' => $variant['id']]);
                $attributes = $stmtAttributes->fetchAll(PDO::FETCH_ASSOC);

                foreach ($attributes as $attr) {
                    $variantData['attributes'][$attr['attribute_name']] = $attr['attribute_value'];
                }

                // Lấy tất cả ảnh cho biến thể
                $sqlImages = "SELECT 
                    image_id,
                    image_set AS gallery_image_url,
                    is_default,
                    sort_order,
                    :product_name AS gallery_image_alt
                FROM variant_images
                WHERE sku_id = :sku_id
                ORDER BY sort_order ASC";
                $stmtImages = $this->pdo->prepare($sqlImages);
                $stmtImages->execute([
                    ':sku_id' => $variant['id'],
                    ':product_name' => $product['product_name']
                ]);
                $images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

                foreach ($images as $image) {
                    $variantData['images'][] = [
                        'gallery_image_url' => $image['gallery_image_url'] ?? '/img/default.png',
                        'gallery_image_alt' => $image['gallery_image_alt'] ?? $product['product_name'],
                        'is_default' => $image['is_default'] ?? 0,
                        'sort_order' => $image['sort_order'] ?? 0,
                    ];
                }

                // Lấy ảnh chính cho biến thể
                $sqlMainImage = "SELECT 
                    image_set AS url,
                    :product_name AS alt_text
                FROM variant_images
                WHERE sku_id = :sku_id AND is_default = 1
                LIMIT 1";
                $stmtMainImage = $this->pdo->prepare($sqlMainImage);
                $stmtMainImage->execute([
                    ':sku_id' => $variant['id'],
                    ':product_name' => $product['product_name']
                ]);
                $mainImage = $stmtMainImage->fetch(PDO::FETCH_ASSOC);
                if ($mainImage) {
                    $variantData['main_media'] = $mainImage;
                } else {
                    $variantData['main_media'] = [
                        'url' => '/img/default.png',
                        'alt_text' => $product['product_name']
                    ];
                }

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

    public function getCategories()
    {
        $sql = "SELECT category_id AS id, name FROM categories ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories()
    {
        $sql = "SELECT subcategory_id AS id, category_id, name FROM subcategories ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBrands()
    {
        $sql = "SELECT brand_id AS id, name FROM brands ORDER BY name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}