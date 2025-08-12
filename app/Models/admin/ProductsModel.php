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
        $sql = "SELECT 
            p.product_id,
            p.name AS product_name,
            b.name AS brand_name,
            s.name AS subcategory_name,
            c.name AS category_name,
            first_sku.price AS sku_price,
            first_sku.stock_quantity,
            vi.default_url,
            vi.thumbnail_url
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
        LEFT JOIN categories c ON s.category_id = c.category_id
        LEFT JOIN (
            SELECT sk.*, 
                   ROW_NUMBER() OVER (PARTITION BY sk.product_id ORDER BY sk.sku_id) as rn
            FROM skus sk
            WHERE sk.is_active = 1 -- Chỉ lấy SKU đang hoạt động
        ) first_sku ON p.product_id = first_sku.product_id AND first_sku.rn = 1
        LEFT JOIN variant_images vi ON first_sku.sku_id = vi.sku_id AND vi.is_default = 1
        ORDER BY p.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Xử lý dữ liệu mặc định nếu thiếu
        foreach ($products as &$product) {
            $product['sku_price'] = $product['sku_price'] ?? 0;
            $product['stock_quantity'] = $product['stock_quantity'] ?? 0;
            $product['default_url'] = $product['default_url'] ?? '/img/default.png';
            $product['thumbnail_url'] = $product['thumbnail_url'] ?? $product['default_url'];
        }
        unset($product); // Hủy tham chiếu

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
                p.description,
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
                'description_html' => htmlspecialchars($product['description'] ?? ''),
                'category_id' => $product['category_id'] ?? 0,
                'brand_name' => $product['brand_name'] ?? '',
            ];

            // Lấy tất cả SKU (biến thể) của sản phẩm
            $sql = "SELECT 
                s.sku_id AS id,
                s.price,
                s.stock_quantity,
                ao.value AS capacity_group
            FROM skus s
            LEFT JOIN attribute_option_sku aos ON s.sku_id = aos.sku_id
            LEFT JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id AND ao.attribute_id = 2 -- Giả định attribute_id 2 là Capacity
            WHERE s.product_id = :product_id AND s.is_active = 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':product_id' => $productId]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result['variants'] = [];
            foreach ($variants as $variant) {
                $variantData = [
                    'id' => $variant['id'],
                    'capacity_group' => $variant['capacity_group'] ?? 'Chưa xác định', // Đảm bảo có giá trị mặc định
                    'price' => $variant['price'] ?? $product['base_price'] ?? 0,
                    'original_price' => $product['base_price'] ?? $variant['price'] ?? 0,
                    'stock_quantity' => $variant['stock_quantity'] ?? 0,
                    'colors' => [],
                    'main_media' => [], // Khởi tạo main_media
                ];

                // Lấy màu sắc cho biến thể (giả định attribute_id 1 là Color)
                $sqlColors = "SELECT 
                    ao.attribute_option_id AS color_id,
                    ao.value AS color_name,
                    ao.value AS hex_code, -- Cần ánh xạ thêm nếu có bảng màu riêng
                    s.stock_quantity,
                    s.is_active
                FROM attribute_option_sku aos
                JOIN skus s ON aos.sku_id = s.sku_id
                JOIN attribute_options ao ON aos.attribute_option_id = ao.attribute_option_id AND ao.attribute_id = 1
                WHERE s.sku_id = :sku_id";

                $stmtColors = $this->pdo->prepare($sqlColors);
                $stmtColors->execute([':sku_id' => $variant['id']]);
                $colors = $stmtColors->fetchAll(PDO::FETCH_ASSOC);

                foreach ($colors as $color) {
                    $colorData = [
                        'color_id' => $color['color_id'],
                        'color_name' => $color['color_name'] ?? 'Chưa đặt tên',
                        'hex_code' => $color['hex_code'] ?? '#000000', // Giả định hex_code tạm thời
                        'stock_quantity' => $color['stock_quantity'] ?? 0,
                        'is_active' => $color['is_active'] ? 1 : 0,
                        'images' => [],
                    ];

                    // Lấy tất cả ảnh cho màu sắc (bao gồm gallery)
                    $sqlImages = "SELECT 
                        vi.image_id,
                        vi.default_url AS gallery_image_url,
                        vi.thumbnail_url,
                        vi.gallery_url,
                        vi.sort_order,
                        :product_name AS gallery_image_alt
                    FROM variant_images vi
                    WHERE vi.sku_id = :sku_id";

                    $stmtImages = $this->pdo->prepare($sqlImages);
                    $stmtImages->execute([
                        ':sku_id' => $variant['id'],
                        ':product_name' => $product['product_name']
                    ]);
                    $images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($images as $image) {
                        $colorData['images'][] = [
                            'gallery_image_url' => $image['gallery_image_url'] ?? $image['gallery_url'] ?? '',
                            'gallery_image_alt' => $image['gallery_image_alt'] ?? $image['gallery_image_alt'] ?? '',
                            'sort_order' => $image['sort_order'] ?? 0,
                        ];
                    }

                    $variantData['colors'][] = $colorData;
                }

                // Lấy ảnh chính cho biến thể (lấy ảnh đầu tiên nếu có nhiều ảnh)
                $sqlMainImage = "SELECT 
                    vi.default_url AS url,
                    :product_name AS alt_text
                FROM variant_images vi
                WHERE vi.sku_id = :sku_id
                ORDER BY vi.sort_order ASC
                LIMIT 1";

                $stmtMainImage = $this->pdo->prepare($sqlMainImage);
                $stmtMainImage->execute([
                    ':sku_id' => $variant['id'],
                    ':product_name' => $product['product_name']
                ]);
                $mainImage = $stmtMainImage->fetch(PDO::FETCH_ASSOC);
                if ($mainImage) {
                    $variantData['main_media'] = $mainImage;
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
        $sql = "INSERT INTO products (name, brand_id, subcategory_id, description, base_price, slug, is_featured, created_at, updated_at)
                VALUES (:name, :brand_id, :subcategory_id, :description, :base_price, :slug, :is_featured, NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $productData['name'],
            ':brand_id' => $productData['brand_id'],
            ':subcategory_id' => $productData['subcategory_id'],
            ':description' => $productData['description'],
            ':base_price' => $productData['base_price'],
            ':slug' => $productData['slug'],
            ':is_featured' => $productData['is_featured'],
        ]);
        $productId = $this->pdo->lastInsertId();

        // Handle main image (store as default)
        if (is_array($productData['main_image']) && $productData['main_image']['error'] === UPLOAD_ERR_OK) {
            $mainImageUrl = $this->uploadImage($productData['main_image'], 'default');
        } else {
            throw new \Exception('Ảnh chính không hợp lệ.');
        }

        // Insert variants (skus)
        foreach ($variantData as $variant) {
            // Generate SKU code
            $skuCode = $this->generateSkuCode($productData['name'], $variant['capacity_id']);
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

            // Insert main image into variant_images for the first SKU as default
            $sql = "INSERT INTO variant_images (sku_id, default_url, thumbnail_url, gallery_url, sort_order, is_default)
                    VALUES (:sku_id, :default_url, :thumbnail_url, :gallery_url, 0, 1)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':sku_id' => $skuId,
                ':default_url' => $mainImageUrl,
                ':thumbnail_url' => $mainImageUrl, // For simplicity, use default as thumbnail initially
                ':gallery_url' => $mainImageUrl,
            ]);

            // Insert into attribute_option_sku for capacity
            $sql = "INSERT INTO attribute_option_sku (sku_id, attribute_option_id)
                    VALUES (:sku_id, :attribute_option_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':sku_id' => $skuId,
                ':attribute_option_id' => $variant['capacity_id'],
            ]);

            // Insert into attribute_option_sku for colors and variant_images
            foreach ($variant['colors'] as $color) {
                $sql = "INSERT INTO attribute_option_sku (sku_id, attribute_option_id)
                        VALUES (:sku_id, :attribute_option_id)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':sku_id' => $skuId,
                    ':attribute_option_id' => $color['color_id'],
                ]);

                // Handle color images
                foreach ($color['images'] as $image) {
                    if (is_array($image['file']) && $image['file']['error'] === UPLOAD_ERR_OK) {
                        $imageUrl = $this->uploadImage($image['file'], 'gallery');
                        $thumbnailUrl = $this->uploadImage($image['file'], 'thumbnail');

                        $sql = "INSERT INTO variant_images (sku_id, default_url, thumbnail_url, gallery_url, sort_order, is_default)
                                VALUES (:sku_id, :default_url, :thumbnail_url, :gallery_url, :sort_order, 0)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sku_id' => $skuId,
                            ':default_url' => $imageUrl,
                            ':thumbnail_url' => $thumbnailUrl,
                            ':gallery_url' => $imageUrl,
                            ':sort_order' => $image['sort_order'],
                        ]);
                    }
                }
            }
        }

        $this->pdo->commit();
        return true;
    } catch (\PDOException $e) {
        $this->pdo->rollBack();
        error_log("Error creating product: " . $e->getMessage());
        return false;
    }
}

    private function generateSkuCode($productName, $capacityId)
    {
        $sql = "SELECT value FROM attribute_options WHERE attribute_option_id = :capacity_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':capacity_id' => $capacityId]);
        $capacity = $stmt->fetchColumn();

        $namePart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $productName), 0, 5));
        $capacityPart = strtoupper(str_replace(' ', '', $capacity));
        return "SKU-{$namePart}-{$capacityPart}";
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

    public function getAttributeOptions($attributeId)
    {
        $sql = "SELECT attribute_option_id AS id, value AS name, value AS hex_code
                FROM attribute_options
                WHERE attribute_id = :attribute_id
                ORDER BY display_order";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':attribute_id' => $attributeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}