<?php
namespace App\Controllers\Admin\Products;

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use Core\View;
use Container;

class CreateProductController
{
    private ProductsModel $productModel;
    private CategoriesModel $categoriesModel;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->productModel = new ProductsModel($pdo);
        $this->categoriesModel = new CategoriesModel($pdo);
    }

    public function index()
    {
        $categories = $this->categoriesModel->fetchAllCategories();
        $colors = $this->productModel->getAllColors();

        View::render('products/create', [
            'categories' => $categories,
            'colors' => $colors
        ]);
    }

    public function handleCreate()
    {
        error_log('$_FILES: ' . print_r($_FILES, true));

        $data = [
            'product_name' => trim(filter_input(INPUT_POST, 'product_name', FILTER_DEFAULT)) ?? '',
            'description_html' => trim(filter_input(INPUT_POST, 'description_html', FILTER_DEFAULT)) ?? '',
            'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT) ?? '',
            'media_alt' => trim(filter_input(INPUT_POST, 'media_alt', FILTER_DEFAULT)) ?? '',
            'variants' => $this->processVariants($_POST['variants'] ?? [])
        ];

        // Xử lý ảnh chính
        $imagePathForDB = null;
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $imagePathForDB = $this->productModel->uploadFile($_FILES['main_image']);
            if (!$imagePathForDB) {
                View::render('products/create', [
                    'error' => 'Không thể upload ảnh chính. Định dạng không hợp lệ, kích thước vượt quá 2MB, hoặc lỗi thư mục.',
                    'categories' => $this->categoriesModel->fetchAllCategories(),
                    'colors' => $this->productModel->getAllColors()
                ]);
                return;
            }
            $data['main_image'] = $imagePathForDB;
        }

        if (empty($data['product_name']) || empty($data['category_id']) || empty($data['main_image'])) {
            View::render('products/create', [
                'error' => 'Tên sản phẩm, danh mục và ảnh chính là bắt buộc.',
                'categories' => $this->categoriesModel->fetchAllCategories(),
                'colors' => $this->productModel->getAllColors()
            ]);
            return;
        }

        $success = $this->productModel->createProduct($data);

        if ($success) {
            header('Location: /admin/products?success=1');
            exit;
        }

        View::render('products/create', [
            'error' => 'Không thể tạo sản phẩm. Vui lòng kiểm tra dữ liệu hoặc file upload.',
            'categories' => $this->categoriesModel->fetchAllCategories(),
            'colors' => $this->productModel->getAllColors()
        ]);
    }

    private function processVariants($rawVariants)
    {
        $variants = [];
        if (!is_array($rawVariants)) {
            return $variants;
        }
        foreach ($rawVariants as $index => $variant) {
            $variants[] = [
                'capacity_group' => $variant['capacity_group'] ?? '',
                'price' => filter_var($variant['price'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0,
                'original_price' => filter_var($variant['original_price'] ?? 0, FILTER_VALIDATE_FLOAT) ?: 0,
                'stock_quantity' => filter_var($variant['stock_quantity'] ?? 0, FILTER_VALIDATE_INT) ?: 0,
                'colors' => $this->processColors($variant['colors'] ?? [], $index)
            ];
        }
        return $variants;
    }

    private function processColors($rawColors, $variantIndex)
    {
        $colors = [];
        if (!is_array($rawColors)) {
            return $colors;
        }
        foreach ($rawColors as $colorIndex => $color) {
            $colorData = [
                'color_id' => filter_var($color['color_id'] ?? 0, FILTER_VALIDATE_INT) ?: 0,
                'stock_quantity' => filter_var($color['stock_quantity'] ?? 0, FILTER_VALIDATE_INT) ?: 0,
                'is_active' => isset($color['is_active']) ? filter_var($color['is_active'], FILTER_VALIDATE_INT) : 1,
                'images' => $this->processImages($color['images'] ?? [], $variantIndex, $colorIndex)
            ];
            if ($colorData['color_id']) {
                $colors[] = $colorData;
            }
        }
        return $colors;
    }

   private function processImages($rawImages, $variantIndex, $colorIndex)
{
    $images = [];
    if (!is_array($rawImages)) {
        error_log("Không có ảnh trong rawImages cho biến thể $variantIndex, màu $colorIndex");
        return $images;
    }

    // Log toàn bộ $_FILES để debug
    error_log('$_FILES trong processImages: ' . print_r($_FILES, true));

    // Kiểm tra cấu trúc $_FILES - Sửa lại đường dẫn truy cập
    if (!isset($_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'])) {
        error_log("Không tìm thấy ảnh trong $_FILES cho biến thể $variantIndex, màu $colorIndex");
        return $images;
    }

    $variantImages = $_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'] ?? [];
    $variantTypes = $_FILES['variants']['type'][$variantIndex]['colors'][$colorIndex]['images'] ?? [];
    $variantTmpNames = $_FILES['variants']['tmp_name'][$variantIndex]['colors'][$colorIndex]['images'] ?? [];
    $variantErrors = $_FILES['variants']['error'][$variantIndex]['colors'][$colorIndex]['images'] ?? [];
    $variantSizes = $_FILES['variants']['size'][$variantIndex]['colors'][$colorIndex]['images'] ?? [];

    foreach ($rawImages as $imageIndex => $image) {
        // Kiểm tra nếu file tồn tại và không có lỗi - Sửa lại cách truy cập
        if (isset($variantImages[$imageIndex]['file']) && 
            isset($variantErrors[$imageIndex]['file']) && 
            $variantErrors[$imageIndex]['file'] === UPLOAD_ERR_OK) {
            $file = [
                'name' => $variantImages[$imageIndex]['file'],
                'type' => $variantTypes[$imageIndex]['file'],
                'tmp_name' => $variantTmpNames[$imageIndex]['file'],
                'error' => $variantErrors[$imageIndex]['file'],
                'size' => $variantSizes[$imageIndex]['file']
            ];

            error_log("Đang xử lý ảnh $imageIndex cho biến thể $variantIndex, màu $colorIndex: " . print_r($file, true));

            $imagePath = $this->productModel->uploadFile($file);
            if ($imagePath) {
                $images[] = [
                    'url' => $imagePath,
                    'gallery_image_alt' => $image['gallery_image_alt'] ?? '',
                    'sort_order' => filter_var($image['sort_order'] ?? $imageIndex, FILTER_VALIDATE_INT) ?: $imageIndex
                ];
                error_log("Upload thành công ảnh $imageIndex cho biến thể $variantIndex, màu $colorIndex: $imagePath");
            } else {
                error_log("Không thể upload ảnh $imageIndex cho biến thể $variantIndex, màu $colorIndex");
            }
        } else {
            $errorCode = $variantErrors[$imageIndex]['file'] ?? 'không xác định';
            error_log("Ảnh $imageIndex không hợp lệ cho biến thể $variantIndex, màu $colorIndex, mã lỗi: $errorCode");
            
            // Thêm thông tin debug chi tiết hơn
            if (isset($variantImages[$imageIndex]['file'])) {
                error_log("Tên file: " . $variantImages[$imageIndex]['file']);
            }
            if (isset($variantSizes[$imageIndex]['file'])) {
                error_log("Kích thước file: " . $variantSizes[$imageIndex]['file']);
            }
        }
    }

    error_log("Đã xử lý " . count($images) . " ảnh thành công cho biến thể $variantIndex, màu $colorIndex");
    return $images;
}
}