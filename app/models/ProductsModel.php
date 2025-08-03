<?php
namespace App\Models;
use PDO;

class ProductsModel
{
    private $pdo;
    private $uploadDir = __DIR__ . '/../../uploads/';

    public function __construct(PDO $pdo)
{
    $this->pdo = $pdo;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/admin-ui/imgs';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    if (!is_writable($uploadDir)) {
        error_log("Thư mục upload không có quyền ghi: $uploadDir");
        chmod($uploadDir, 0755);
    }
}

    public function getAllColors()
    {
        $sql = "SELECT id, name, hex_code FROM colors";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts()
    {
        try {
            $sql = "SELECT 
                p.id AS product_id,
                p.name AS 'Tên',
                c.name AS 'Danh mục',
                CONCAT(FORMAT(v.price, 0), 'đ') AS 'Giá',
                v.stock_quantity AS 'Số lượng',
                p.media_url AS 'media_url',
                p.media_alt AS 'media_alt'
            FROM 
                products p
                INNER JOIN categories c ON p.category_id = c.id
                LEFT JOIN variants v ON p.id = v.product_id
                AND v.id = (
                    SELECT MIN(id) 
                    FROM variants 
                    WHERE product_id = p.id
                )
            WHERE 
                v.id IS NOT NULL OR p.id IS NOT NULL
            ORDER BY 
                p.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Lỗi cơ sở dữ liệu: ' . $e->getMessage());
            return [];
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "
                SELECT 
                    p.id AS product_id,
                    p.name AS product_name,
                    p.description_html,
                    c.id AS category_id,
                    c.name AS category_name
                FROM 
                    products p
                    INNER JOIN categories c ON p.category_id = c.id
                WHERE 
                    p.id = :id
                LIMIT 1
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return [];
            }

            $sql = "SELECT * FROM variants WHERE product_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($variants as &$variant) {
                $sql = "
                    SELECT 
                        col.id AS color_id,
                        col.name AS color_name,
                        col.hex_code,
                        col.is_active,
                        vc.id AS variant_color_id
                    FROM 
                        variant_colors vc
                        JOIN colors col ON vc.color_id = col.id
                    WHERE 
                        vc.variant_id = :variant_id
                ";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':variant_id', $variant['id'], PDO::PARAM_INT);
                $stmt->execute();
                $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($colors as &$color) {
                    $sql = "
                        SELECT 
                            gci.url AS gallery_image_url,
                            gci.alt_text AS gallery_image_alt,
                            gci.sort_order
                        FROM 
                            group_color_img gci
                        WHERE 
                            gci.variant_color_id = :variant_color_id
                        ORDER BY gci.sort_order ASC
                    ";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindValue(':variant_color_id', $color['variant_color_id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $color['images'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $variant['colors'] = $colors;
            }
            $product['variants'] = $variants;

            return $product;
        } catch (PDOException $e) {
            error_log('Lỗi cơ sở dữ liệu: ' . $e->getMessage());
            return [];
        }
    }

     public function deleteProduct($id)
    {
        try {
            $this->pdo->beginTransaction();

            $sql = "DELETE FROM variants WHERE product_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    public function createProduct($data)
    {
        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO products (name, description_html, category_id, media_url, media_alt) 
                    VALUES (:name, :description_html, :category_id, :media_url, :media_alt)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $data['product_name'],
                ':description_html' => $data['description_html'],
                ':category_id' => $data['category_id'],
                ':media_url' => $data['main_image'],
                ':media_alt' => $data['media_alt']
            ]);
            $productId = $this->pdo->lastInsertId();

            foreach ($data['variants'] as $variant) {
                $sql = "INSERT INTO variants (product_id, capacity_group, price, original_price, stock_quantity) 
                        VALUES (:product_id, :capacity_group, :price, :original_price, :stock_quantity)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    ':product_id' => $productId,
                    ':capacity_group' => $variant['capacity_group'],
                    ':price' => $variant['price'],
                    ':original_price' => $variant['original_price'],
                    ':stock_quantity' => $variant['stock_quantity']
                ]);
                $variantId = $this->pdo->lastInsertId();

                foreach ($variant['colors'] as $color) {
                    $sql = "INSERT INTO variant_colors (variant_id, color_id, stock) 
                            VALUES (:variant_id, :color_id, :stock)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':variant_id' => $variantId,
                        ':color_id' => $color['color_id'],
                        ':stock' => $color['stock_quantity']
                    ]);
                    $variantColorId = $this->pdo->lastInsertId();

                    foreach ($color['images'] as $image) {
                        $sql = "INSERT INTO group_color_img (variant_color_id, url, alt_text, sort_order) 
                                VALUES (:variant_color_id, :url, :alt_text, :sort_order)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':variant_color_id' => $variantColorId,
                            ':url' => $image['url'],
                            ':alt_text' => $image['gallery_image_alt'],
                            ':sort_order' => $image['sort_order']
                        ]);
                    }
                }
            }

            $this->pdo->commit();
            return $productId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('Lỗi cơ sở dữ liệu: ' . $e->getMessage());
            return false;
        }
    }

    public function uploadFile($file, $subDir = '')
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            error_log('Lỗi upload file: File không hợp lệ hoặc mã lỗi ' . ($file['error'] ?? 'không xác định'));
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file['type'], $allowedTypes) || !in_array($ext, $allowedExts) || $file['size'] > $maxSize) {
            error_log('Lỗi upload file: Loại file ' . $file['type'] . ', phần mở rộng ' . $ext . ', hoặc kích thước ' . $file['size'] . ' vượt quá 2MB');
            return null;
        }

        // Sử dụng thư mục public/admin-ui/imgs đã có sẵn
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/admin-ui/imgs';
        
        // Kiểm tra thư mục có tồn tại không
        if (!is_dir($targetDir)) {
            error_log('Lỗi upload file: Thư mục không tồn tại ' . $targetDir);
            return null;
        }

        // Kiểm tra quyền ghi
        if (!is_writable($targetDir)) {
            error_log('Lỗi upload file: Thư mục không có quyền ghi ' . $targetDir);
            return null;
        }

        $filename = uniqid() . '_' . basename($file['name']);
        $targetPath = $targetDir . '/' . $filename;

        // Log để debug
        error_log('Đường dẫn target: ' . $targetPath);
        error_log('File temp: ' . $file['tmp_name']);
        error_log('Thư mục tồn tại: ' . (is_dir($targetDir) ? 'Có' : 'Không'));
        error_log('Quyền ghi: ' . (is_writable($targetDir) ? 'Có' : 'Không'));

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log('Lỗi upload file: Không thể di chuyển file đến ' . $targetPath);
            error_log('PHP Error: ' . (error_get_last()['message'] ?? 'Không có lỗi cụ thể'));
            return null;
        }

        // Kiểm tra file đã được tạo thành công
        if (!file_exists($targetPath)) {
            error_log('Lỗi: File không tồn tại sau khi upload: ' . $targetPath);
            return null;
        }

        error_log('Upload thành công: ' . $targetPath);
        
        // Trả về đường dẫn web
        $webPath = '/admin-ui/imgs/' . $filename;
        return $webPath;
    }


    public function updateProduct($data)
{
    try {
        $this->pdo->beginTransaction();

        // Cập nhật thông tin cơ bản của sản phẩm
        $sql = "UPDATE products SET 
                name = :name, 
                description_html = :description_html, 
                category_id = :category_id";
        
        $params = [
            ':name' => $data['product_name'],
            ':description_html' => $data['description_html'],
            ':category_id' => $data['category_id'],
            ':product_id' => $data['product_id']
        ];

        // Nếu có ảnh chính mới thì cập nhật
        if (!empty($data['main_image'])) {
            $sql .= ", media_url = :media_url";
            $params[':media_url'] = $data['main_image'];
        }

        // Nếu có media_alt thì cập nhật
        if (!empty($data['media_alt'])) {
            $sql .= ", media_alt = :media_alt";
            $params[':media_alt'] = $data['media_alt'];
        }

        $sql .= " WHERE id = :product_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        // Xử lý variants
        foreach ($data['variants'] as $variant) {
            if (!empty($variant['variant_id'])) {
                // Cập nhật variant hiện có
                $this->updateVariant($variant, $data['product_id']);
            } else {
                // Tạo variant mới
                $this->createVariant($variant, $data['product_id']);
            }
        }

        $this->pdo->commit();
        return true;
    } catch (PDOException $e) {
        $this->pdo->rollBack();
        error_log('Lỗi cập nhật sản phẩm: ' . $e->getMessage());
        return false;
    }
}

private function updateVariant($variant, $productId)
{
    // Cập nhật variant
    $sql = "UPDATE variants SET 
            capacity_group = :capacity_group, 
            price = :price, 
            original_price = :original_price, 
            stock_quantity = :stock_quantity 
            WHERE id = :variant_id AND product_id = :product_id";
    
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':capacity_group' => $variant['capacity_group'],
        ':price' => $variant['price'],
        ':original_price' => $variant['original_price'],
        ':stock_quantity' => $variant['stock_quantity'],
        ':variant_id' => $variant['variant_id'],
        ':product_id' => $productId
    ]);

    // Xử lý colors của variant
    foreach ($variant['colors'] as $color) {
        if (!empty($color['variant_color_id'])) {
            // Cập nhật color hiện có
            $this->updateVariantColor($color, $variant['variant_id']);
        } else {
            // Tạo color mới
            $this->createVariantColor($color, $variant['variant_id']);
        }
    }
    }

    private function createVariant($variant, $productId)
    {
        $sql = "INSERT INTO variants (product_id, capacity_group, price, original_price, stock_quantity) 
                VALUES (:product_id, :capacity_group, :price, :original_price, :stock_quantity)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':product_id' => $productId,
            ':capacity_group' => $variant['capacity_group'],
            ':price' => $variant['price'],
            ':original_price' => $variant['original_price'],
            ':stock_quantity' => $variant['stock_quantity']
        ]);
        
        $variantId = $this->pdo->lastInsertId();

        // Tạo colors cho variant mới
        foreach ($variant['colors'] as $color) {
            $this->createVariantColor($color, $variantId);
        }
    }

    private function updateVariantColor($color, $variantId)
    {
        // Cập nhật variant_color
        $sql = "UPDATE variant_colors SET 
                color_id = :color_id, 
                stock = :stock 
                WHERE id = :variant_color_id AND variant_id = :variant_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':color_id' => $color['color_id'],
            ':stock' => $color['stock_quantity'],
            ':variant_color_id' => $color['variant_color_id'],
            ':variant_id' => $variantId
        ]);

        // Xử lý images
        foreach ($color['images'] as $image) {
            if (!empty($image['image_id'])) {
                // Cập nhật ảnh hiện có
                $this->updateColorImage($image);
            } else {
                // Tạo ảnh mới (nếu có URL)
                if (!empty($image['url'])) {
                    $this->createColorImage($image, $color['variant_color_id']);
                }
            }
        }
    }


    private function processColors($rawColors, $variantIndex)
{
    $colors = [];
    if (!is_array($rawColors)) {
        error_log("Không có màu cho biến thể $variantIndex");
        return $colors;
    }

    foreach ($rawColors as $colorIndex => $color) {
        $colorId = filter_var($color['color_id'] ?? 0, FILTER_VALIDATE_INT) ?: 0;
        if ($colorId === 0) {
            error_log("Bỏ qua màu tại biến thể $variantIndex, chỉ số $colorIndex vì color_id không hợp lệ: " . print_r($color, true));
            continue;
        }

        $colorData = [
            'color_id' => $colorId,
            'stock_quantity' => filter_var($color['stock_quantity'] ?? 0, FILTER_VALIDATE_INT) ?: 0,
            'is_active' => isset($color['is_active']) ? filter_var($color['is_active'], FILTER_VALIDATE_INT) : 1,
            'images' => $this->processImages($color['images'] ?? [], $variantIndex, $colorIndex)
        ];

        $colors[] = $colorData;
    }

    error_log("Đã xử lý " . count($colors) . " màu cho biến thể $variantIndex");
    return $colors;
}

    private function createVariantColor($color, $variantId)
    {
        $sql = "INSERT INTO variant_colors (variant_id, color_id, stock) 
                VALUES (:variant_id, :color_id, :stock)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':variant_id' => $variantId,
            ':color_id' => $color['color_id'],
            ':stock' => $color['stock_quantity']
        ]);
        
        $variantColorId = $this->pdo->lastInsertId();

        // Tạo images cho color mới
        foreach ($color['images'] as $image) {
            if (!empty($image['url'])) {
                $this->createColorImage($image, $variantColorId);
            }
        }
    }

    private function updateColorImage($image)
    {
        $sql = "UPDATE group_color_img SET ";
        $params = [':image_id' => $image['image_id']];
        $updates = [];

        // Chỉ cập nhật URL nếu có ảnh mới
        if (!empty($image['url']) && $image['url'] !== $image['current_url']) {
            $updates[] = "url = :url";
            $params[':url'] = $image['url'];
        }

        // Cập nhật alt text
        if (isset($image['gallery_image_alt'])) {
            $updates[] = "alt_text = :alt_text";
            $params[':alt_text'] = $image['gallery_image_alt'];
        }

        // Cập nhật sort order
        if (isset($image['sort_order'])) {
            $updates[] = "sort_order = :sort_order";
            $params[':sort_order'] = $image['sort_order'];
        }

        if (!empty($updates)) {
            $sql .= implode(', ', $updates) . " WHERE id = :image_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        }
    }

    private function createColorImage($image, $variantColorId)
    {
        $sql = "INSERT INTO group_color_img (variant_color_id, url, alt_text, sort_order) 
                VALUES (:variant_color_id, :url, :alt_text, :sort_order)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':variant_color_id' => $variantColorId,
            ':url' => $image['url'],
            ':alt_text' => $image['gallery_image_alt'] ?? '',
            ':sort_order' => $image['sort_order'] ?? 0
        ]);
    }


    private function processImages($rawImages, $variantIndex, $colorIndex)
{
    $images = [];
    if (!is_array($rawImages)) {
        error_log("Không có ảnh trong rawImages cho biến thể $variantIndex, màu $colorIndex");
        return $images;
    }

    // Log để debug
    error_log('=== DEBUG processImages ===');
    error_log("Variant: $variantIndex, Color: $colorIndex");
    error_log('RawImages count: ' . count($rawImages));
    error_log('RawImages data: ' . print_r($rawImages, true));

    // Kiểm tra cấu trúc $_FILES
    if (!isset($_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'])) {
        error_log("Không tìm thấy ảnh trong $_FILES cho biến thể $variantIndex, màu $colorIndex");
        error_log('$_FILES structure: ' . print_r($_FILES, true));
        return $images;
    }

    $filesImages = $_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'];
    error_log('Files images structure: ' . print_r($filesImages, true));

    foreach ($rawImages as $imageIndex => $image) {
        error_log("Processing image index: $imageIndex");
        
        // Truy cập đúng cấu trúc $_FILES
        $fileName = $_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'][$imageIndex]['file'] ?? '';
        $fileType = $_FILES['variants']['type'][$variantIndex]['colors'][$colorIndex]['images'][$imageIndex]['file'] ?? '';
        $fileTmpName = $_FILES['variants']['tmp_name'][$variantIndex]['colors'][$colorIndex]['images'][$imageIndex]['file'] ?? '';
        $fileError = $_FILES['variants']['error'][$variantIndex]['colors'][$colorIndex]['images'][$imageIndex]['file'] ?? UPLOAD_ERR_NO_FILE;
        $fileSize = $_FILES['variants']['size'][$variantIndex]['colors'][$colorIndex]['images'][$imageIndex]['file'] ?? 0;

        error_log("File info - Name: $fileName, Error: $fileError, Size: $fileSize");

        // Kiểm tra file có hợp lệ không
        if ($fileError === UPLOAD_ERR_OK && !empty($fileName)) {
            $file = [
                'name' => $fileName,
                'type' => $fileType,
                'tmp_name' => $fileTmpName,
                'error' => $fileError,
                'size' => $fileSize
            ];

            error_log("Uploading file: $fileName");

            $imagePath = $this->uploadFile($file);
            if ($imagePath) {
                $images[] = [
                    'url' => $imagePath,
                    'gallery_image_alt' => $image['gallery_image_alt'] ?? '',
                    'sort_order' => filter_var($image['sort_order'] ?? $imageIndex, FILTER_VALIDATE_INT) ?: $imageIndex
                ];
                error_log("Upload thành công: $imagePath");
            } else {
                error_log("Không thể upload ảnh $imageIndex");
            }
        } else {
            if ($fileError !== UPLOAD_ERR_NO_FILE) {
                error_log("Lỗi file $imageIndex: mã lỗi $fileError");
            } else {
                error_log("File $imageIndex: không có file được chọn");
            }
        }
    }

    error_log("Tổng cộng xử lý " . count($images) . " ảnh cho biến thể $variantIndex, màu $colorIndex");
    return $images;
}
}