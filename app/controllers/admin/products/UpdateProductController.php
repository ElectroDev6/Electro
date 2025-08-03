<?php

namespace App\Controllers\Admin\Products;

use App\Models\ProductsModel;
use App\Models\CategoriesModel;
use Core\View;
use Container;

class UpdateProductController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $categoriesModel = new CategoriesModel($pdo);
        $productId = $_GET['id'] ?? null;

        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $product = $productModel->getProductById($productId);
        $categories = $categoriesModel->fetchAllCategories();
        $colors = $productModel -> getAllColors();

        if (!$product) {
            header('Location: /admin/products');
            exit;
        }

        View::render('products/update', [
            'product' => $product,
            'categories' => $categories,
            'colors' => $colors
        ]);
    }

    public function handle()
    {   
        $pdo = Container::get('pdo');
        $productModel = new ProductsModel($pdo);
        $categoriesModel = new CategoriesModel($pdo);
        $productId = 'product_id';

        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $data = [
            'product_id' => $productId,
            'product_name' => trim('product_name') ?? '',
            'description_html' => trim('description_html') ?? '',
            'category_id' => 'category_id' ?? '',
            'media_alt' => trim('media_alt') ?? '',
            'variants' => $this->processVariants($_POST['variants'] ?? [])
        ];

        // Xử lý ảnh chính (nếu có upload ảnh mới)
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            $imagePathForDB = $productModel->uploadFile($_FILES['main_image']);
            if (!$imagePathForDB) {
                View::render('products/update', [
                    'error' => 'Không thể upload ảnh chính. Định dạng không hợp lệ, kích thước vượt quá 2MB, hoặc lỗi thư mục.',
                    'product' => $productModel->getProductById($productId),
                    'categories' => $categoriesModel->fetchAllCategories(),
                    'productModel' => $productModel
                ]);
                return;
            }
            $data['main_image'] = $imagePathForDB;
        }

        // Validate dữ liệu bắt buộc
        if (empty($data['product_name']) || empty($data['category_id'])) {
            View::render('products/update', [
                'error' => 'Tên sản phẩm và danh mục là bắt buộc.',
                'product' => $productModel->getProductById($productId),
                'categories' => $categoriesModel->fetchAllCategories(),
                'productModel' => $productModel
            ]);
            return;
        }

        $success = $productModel->updateProduct($data);

        if ($success) {
            header('Location: /admin/products?updated=1');
            exit;
        }

        View::render('products/update', [
            'error' => 'Không thể cập nhật sản phẩm. Vui lòng kiểm tra dữ liệu hoặc file upload.',
            'product' => $productModel->getProductById($productId),
            'categories' => $categoriesModel->fetchAllCategories(),
            'productModel' => $productModel
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
                'variant_id' => $variant['variant_id'] ?? null, // ID của variant hiện tại (nếu có)
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
                'variant_color_id' => $color['variant_color_id'] ?? null, // ID của variant_color hiện tại (nếu có)
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

  // Trong file ProductsModel.php, thay thế method processImages (dòng 126-175) bằng code này:

    private function processImages($rawImages, $variantIndex, $colorIndex)
    {
        $images = [];
        if (!is_array($rawImages)) {
            error_log("Không có ảnh trong rawImages cho biến thể $variantIndex, màu $colorIndex");
            return $images;
        }

        // Log để debug
        error_log('$_FILES structure: ' . print_r($_FILES, true));

        // ĐIỂM SỬA CHÍNH: Cấu trúc truy cập $_FILES đúng
        if (!isset($_FILES['variants']['name'][$variantIndex]['colors'][$colorIndex]['images'])) {
            error_log("Không tìm thấy ảnh trong $_FILES cho biến thể $variantIndex, màu $colorIndex");
            return $images;
        }

        foreach ($rawImages as $imageIndex => $image) {
            // ĐIỂM SỬA CHÍNH: Truy cập đúng cấu trúc $_FILES
            $fileName = $_FILES['variants']['name'][$variantIndex]['colors'][$imageIndex]['file'] ?? '';
            $fileType = $_FILES['variants']['type'][$variantIndex]['colors'][$imageIndex]['file'] ?? '';
            $fileTmpName = $_FILES['variants']['tmp_name'][$variantIndex]['colors'][$imageIndex]['file'] ?? '';
            $fileError = $_FILES['variants']['error'][$variantIndex]['colors'][$imageIndex]['file'] ?? UPLOAD_ERR_NO_FILE;
            $fileSize = $_FILES['variants']['size'][$variantIndex]['colors'][$imageIndex]['file'] ?? 0;

            // Kiểm tra file có hợp lệ không
            if ($fileError === UPLOAD_ERR_OK && !empty($fileName)) {
                $file = [
                    'name' => $fileName,
                    'type' => $fileType,
                    'tmp_name' => $fileTmpName,
                    'error' => $fileError,
                    'size' => $fileSize
                ];

                error_log("Xử lý ảnh $imageIndex cho biến thể $variantIndex, màu $colorIndex: " . $fileName);

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
                }
            }
        }

        error_log("Tổng cộng xử lý " . count($images) . " ảnh cho biến thể $variantIndex, màu $colorIndex");
        return $images;
    }
}