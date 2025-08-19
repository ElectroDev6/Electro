<?php
namespace App\Controllers\Admin\Products;

use App\Models\admin\ProductsModel;
use App\Models\admin\CategoriesModel;
use Core\View;
use Container;

class UpdateProductController
{
    private $model;
    private $categoriesModel;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new ProductsModel($pdo);
        $this->categoriesModel = new CategoriesModel($pdo);
    }

    public function index()
    {
        $productId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }

        $product = $this->model->getProductById($productId);
        if (!$product) {
            header('Location: /admin/products');
            exit;
        }

        $categories = $this->categoriesModel->fetchAllCategories();
        $brands = $this->model->getAllBrands();
        $colors = $this->model->getAllColors();
        $capacities = $this->model->getAllCapacities();
        
        // Lấy category_id từ subcategory để load subcategories
        $categoryId = null;
        if (!empty($product['subcategory_id'])) {
            $subcategory = $this->model->getSubcategoryById($product['subcategory_id']);
            $categoryId = $subcategory['category_id'] ?? null;
        }
        
        $subcategories = $categoryId ? $this->model->getSubcategoriesByCategoryId($categoryId) : [];

        View::render('products/update', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'colors' => $colors,
            'capacities' => $capacities,
            'subcategories' => $subcategories,
        ]);
    }

    public function handle()
    {
        $productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);

        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }
        if (!isset($_POST['brand_id']) || !filter_var($_POST['brand_id'], FILTER_VALIDATE_INT)) {
            header('Location: /admin/products');
            exit;
        }



        $currentProduct = $this->model->getProductById($productId);

        if (!$currentProduct) {
            header('Location: /admin/products');
            exit;
        }

        $productData = $this->validateBasicProductData($_POST);

        // Validate and prepare descriptions
        $descriptions = $this->validateDescriptions($_POST['descriptions'] ?? [], $_FILES['descriptions'] ?? []);
        $specifications = $this->validateSpecifications($_POST['specs'] ?? []);
        // Validate and prepare variants
        $variants = $this->validateVariants($_POST['variants'] ?? [], $_FILES['variants'] ?? []);

        $updateData = [
            'product_id' => $productId,
            'basic_info' => $productData,
            'descriptions' => $descriptions,
            'specifications' => $specifications,
            'variants' => $variants
        ];
        $result = $this->model->updateCompleteProduct($updateData);
        
        if ($result) {
            header('Location: /admin/products?updated=1');
            exit;
        } else {
            throw new \Exception('Không thể cập nhật sản phẩm. Vui lòng thử lại.');
        }
    }
        

    private function validateBasicProductData($postData)
    {
        $data = [];
        $productName = trim($postData['product_name'] ?? '');
        if (empty($productName)) {
            throw new \Exception('Tên sản phẩm không được để trống.');
        }
        $data['name'] = $productName;
        $slug = trim($postData['slug'] ?? '');
        $data['slug'] = !empty($slug) ? $slug : $this->generateSlug($productName);
        $brandId = $postData['brand_id'];
        if ($brandId <= 0) {
            throw new \Exception('Vui lòng chọn thương hiệu.');
        }
        $data['brand_id'] = $brandId;
        // echo $postData['subcategory_id'];
        // exit;
        $subcategoryId = $postData['subcategory_id'];
        if ($subcategoryId <= 0) {
            throw new \Exception('Vui lòng chọn danh mục phụ.');
        }
        $subcategory = $this->model->getSubcategoryById($subcategoryId);
        if (!$subcategory) {
            throw new \Exception('Danh mục phụ không tồn tại.');
        }
        
        $categoryId = filter_var($postData['category_id'] ?? 0, FILTER_VALIDATE_INT);
        if ($categoryId <= 0) {
            throw new \Exception('Vui lòng chọn danh mục chính.');
        }
        
        if ($subcategory['category_id'] != $categoryId) {
            throw new \Exception('Danh mục phụ không thuộc danh mục chính đã chọn.');
        }
        
        $data['subcategory_id'] = $subcategoryId;
        
        return $data;
    }

    private function validateDescriptions($descriptions, $files)
{
    $validatedDescriptions = [];

    foreach ($descriptions as $index => $description) {
        $desc = [
            'content_id' => filter_var($description['content_id'] ?? null, FILTER_VALIDATE_INT) ?: null,
            'description' => trim($description['description'] ?? ''),
            'current_image' => $description['current_image'] ?? '',
            'new_image' => null
        ];
        if (empty($desc['description']) && empty($desc['current_image'])) {
            continue;
        }
        if (!empty($files['name'][$index]['new_image']) && isset($files['error'][$index]['new_image'])) {
            $file = [
                'name' => $files['name'][$index]['new_image'] ?? '',
                'type' => $files['type'][$index]['new_image'] ?? '',
                'tmp_name' => $files['tmp_name'][$index]['new_image'] ?? '',
                'error' => $files['error'][$index]['new_image'] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$index]['new_image'] ?? 0
            ];

            // Check for upload errors
            if ($file['error'] === UPLOAD_ERR_OK) {
                try {
                    $uploadResult = $this->handleImageUpload($file, 'descriptions');
                    if ($uploadResult) {
                        $desc['new_image'] = $uploadResult;
                    } else {
                        error_log("Image upload failed for description at index $index: Empty result from handleImageUpload");
                    }
                } catch (Exception $e) {
                    error_log("Image upload failed for description at index $index: " . $e->getMessage());
                }
            } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                // Log error if it's not a "no file uploaded" case
                error_log("Image upload error for description at index $index: Error code " . $file['error']);
            }
        }

        $validatedDescriptions[] = $desc;
    }

    return $validatedDescriptions;
}
    private function validateSpecifications($specs)
    {
        $validatedSpecs = [];
        
        foreach ($specs as $spec) {
            $specName = trim($spec['spec_name'] ?? '');
            $specValue = trim($spec['spec_value'] ?? '');
            
            // Skip empty specs
            if (empty($specName) || empty($specValue)) {
                continue;
            }
            $validatedSpecs[] = [
                'spec_id' => filter_var($spec['spec_id'] ?? null, FILTER_VALIDATE_INT) ?: null,
                'product_id' => $_POST['product_id'],
                'spec_name' => $specName,
                'spec_value' => $specValue,
                'display_order' => filter_var($spec['display_order'] ?? 1, FILTER_VALIDATE_INT) ?: 1
            ];
        }
        
        return $validatedSpecs;
    }

   private function validateVariants($variants, $files)
    {
        $validatedVariants = [];

        foreach ($variants as $index => $variant) {
            // Kiểm tra dữ liệu cơ bản của biến thể
            $skuCode = trim($variant['sku_code'] ?? '');
            $price = filter_var($variant['price'] ?? 0, FILTER_VALIDATE_FLOAT);
            $stockQuantity = filter_var($variant['stock_quantity'] ?? 0, FILTER_VALIDATE_INT);
            if (empty($skuCode) || $price === false || $price < 0 || $stockQuantity === false || $stockQuantity < 0) {
                continue;
            }

            $variantData = [
                'sku_id' => filter_var($variant['sku_id'] ?? null, FILTER_VALIDATE_INT) ?: null,
                'sku_code' => $skuCode,
                'price' => $price,
                'stock_quantity' => $stockQuantity,
                'is_default' => isset($variant['is_default']) ? 1 : 0,
                'is_active' => 1,
                'attributes' => [],
                'images' => [
                    'current_images' => $variant['current_images'] ?? [],
                    'new_images' => []
                ]
            ];
            $attributes = $variant['attributes'] ?? [];
            foreach (['color', 'capacity', 'ram', 'cpu', 'screen_size'] as $attrKey) {
                $attrValue = trim($attributes[$attrKey] ?? '');
                if (!empty($attrValue)) {
                    $variantData['attributes'][] = [
                        'attribute_name' => $this->getAttributeDisplayName($attrKey),
                        'attribute_value' => $attrValue
                    ];
                }
            }
            if (isset($files['name'][$index]['new_images'])) {
                foreach ($files['name'][$index]['new_images'] as $imageIndex => $imageName) {
                    if ($files['error'][$index]['new_images'][$imageIndex] === UPLOAD_ERR_OK && !empty($imageName)) {
                        try {
                            $filename = time() . '_' . $imageName;
                            $galleryDir = "img/products/gallery/";
                            $thumbnailDir = "img/products/thumbnails/";
                            $galleryPath = $galleryDir . $filename;
                            $thumbnailPath = $thumbnailDir . $filename;

                            // Tạo thư mục nếu chưa có
                            if (!is_dir($galleryDir)) {
                                mkdir($galleryDir, 0755, true);
                            }
                            
                            if (!is_dir($thumbnailDir)) {
                                mkdir($thumbnailDir, 0755, true);
                            }

                            // Di chuyển file vào gallery
                            if (move_uploaded_file($files['tmp_name'][$index]['new_images'][$imageIndex], $galleryPath)) {
                                // Sao chép file vào thumbnails
                                if (!copy($galleryPath, $thumbnailPath)) {
                                    error_log("Lỗi sao chép ảnh sang thumbnails cho biến thể $index, ảnh $imageIndex");
                                }
                                $variantData['images']['new_images'][] = $filename;
                            } else {
                                error_log("Lỗi upload ảnh cho biến thể $index, ảnh $imageIndex: Không di chuyển được file.");
                            }
                        } catch (\Exception $e) {
                            error_log("Lỗi upload ảnh cho biến thể $index, ảnh $imageIndex: " . $e->getMessage());
                        }
                    }
                }
            }

            $validatedVariants[] = $variantData;
        }

        if (empty($validatedVariants)) {
            throw new \Exception('Vui lòng nhập thông tin cho ít nhất một biến thể sản phẩm hợp lệ.');
        }

        return $validatedVariants;
    }

    private function handleImageUpload($file, $type)
    {
        try {
            // Dùng tên file gốc
            $filename = $file['name'];
            $uploadDir = "uploads/{$type}/";
            $uploadPath = $uploadDir . $filename;
            
            // Tạo thư mục nếu chưa có
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Di chuyển file
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return '/' . $uploadPath;
            }
            
            throw new \Exception('Không upload được file.');
            
        } catch (\Exception $e) {
            error_log("Lỗi upload: " . $e->getMessage());
            return null;
        }
    }

    private function getAttributeDisplayName($attributeKey)
    {
        $mapping = [
            'color' => 'Color',
            'capacity' => 'Capacity',
            'ram' => 'RAM',
            'cpu' => 'CPU',
            'screen_size' => 'Screen Size'
        ];
        
        return $mapping[$attributeKey] ?? ucfirst($attributeKey);
    }

    private function generateSlug($name)
    {
        // Convert to lowercase
        $slug = strtolower(trim($name));
        
        // Replace Vietnamese characters
        $vietnamese = ['à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
                      'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
                      'ì', 'í', 'ị', 'ỉ', 'ĩ',
                      'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
                      'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
                      'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
                      'đ'];
        $latin = ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                 'i', 'i', 'i', 'i', 'i',
                 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                 'y', 'y', 'y', 'y', 'y',
                 'd'];
        
        $slug = str_replace($vietnamese, $latin, $slug);
        
        // Replace non-alphanumeric characters with dashes
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        
        // Replace multiple consecutive dashes with single dash
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Remove dashes from beginning and end
        return trim($slug, '-');
    }
}