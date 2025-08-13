<?php
namespace App\Controllers\Admin\Products;

use App\Models\admin\ProductsModel;
use Core\View;
use Container;

class CreateProductController
{
    private ProductsModel $productModel;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->productModel = new ProductsModel($pdo);
    }
    

    public function index()
        {
            // Fetch data for form
            $categories = $this->productModel->getCategories();
            $subcategories = $this->productModel->getSubcategories();
            $brands = $this->productModel->getBrands();
            $colors = $this->productModel->getAttributeOptions(1); // attribute_id 1 = Color
            $capacities = $this->productModel->getAttributeOptions(2); // attribute_id 2 = Capacity

            // Render the create product form view
            View::render('products/create', [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'brands' => $brands,
                'colors' => $colors,
                'capacities' => $capacities,
            ]);
        }
        
        public function handleCreate()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Validate and sanitize input data
                    $productData = [
                        'name' => htmlspecialchars(trim($_POST['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'),
                        'brand_id' => filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT),
                        'subcategory_id' => $_POST['subcategory_id'] ?? null,
                        'description' => htmlspecialchars($_POST['description_html'] ?? '', ENT_QUOTES, 'UTF-8'),
                        'base_price' => $_POST['base_price'] ?? null,
                        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                        'slug' => $this->generateSlug($_POST['product_name']),
                        'main_image' => $_FILES['main_image'] ?? null,
                        'media_alt' => htmlspecialchars(trim($_POST['media_alt'] ?? ''), ENT_QUOTES, 'UTF-8'),
                    ];

                    // Validate required fields
                    if (!$productData['name'] || !$productData['brand_id'] || !$productData['subcategory_id'] || 
                        !$productData['base_price'] || !$productData['main_image'] || !$productData['media_alt']) {
                        throw new \Exception('Vui lòng điền đầy đủ các trường bắt buộc.');
                    }

                    // Process variants
                    $variants = $_POST['variants'] ?? [];
                    $variantData = [];
                    foreach ($variants as $v_idx => $variant) {
                        $variantData[$v_idx] = [
                            'price' => filter_var($variant['price'], FILTER_VALIDATE_FLOAT),
                            'original_price' => filter_var($variant['original_price'], FILTER_VALIDATE_FLOAT),
                            'stock_quantity' => filter_var($variant['stock_quantity'], FILTER_VALIDATE_INT),
                            'capacity_id' => filter_var($variant['capacity_id'], FILTER_VALIDATE_INT),
                            'colors' => [],
                        ];

                        foreach ($variant['colors'] ?? [] as $c_idx => $color) {
                            $variantData[$v_idx]['colors'][$c_idx] = [
                                'color_id' => filter_var($color['color_id'], FILTER_VALIDATE_INT),
                                'stock_quantity' => filter_var($color['stock_quantity'], FILTER_VALIDATE_INT),
                                'is_active' => isset($color['is_active']) ? 1 : 0,
                                'images' => [],
                            ];

                            foreach ($color['images'] ?? [] as $i_idx => $image) {
                                $fileKey = "variants[{$v_idx}][colors][{$c_idx}][images][{$i_idx}][file]";
                                $variantData[$v_idx]['colors'][$c_idx]['images'][$i_idx] = [
                                    'file' => isset($_FILES[$fileKey]) ? $_FILES[$fileKey] : null,
                                    'gallery_image_alt' => htmlspecialchars(trim($image['gallery_image_alt'] ?? ''), ENT_QUOTES, 'UTF-8'),
                                    'sort_order' => filter_var($image['sort_order'], FILTER_VALIDATE_INT, ['default' => $i_idx]),
                                ];
                            }
                        }
                    }

                    // Validate variant data
                    if (empty($variantData)) {
                        throw new \Exception('Phải có ít nhất một biến thể sản phẩm.');
                    }

                    // Create product
                    $result = $this->productModel->createProduct($productData, $variantData);

                    if ($result) {
                        header('Location: /admin/products?success=Sản phẩm đã được tạo thành công');
                        exit;
                    } else {
                        throw new \Exception('Không thể tạo sản phẩm.');
                    }
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }

            // Fetch data for form
            $categories = $this->productModel->getCategories();
            $subcategories = $this->productModel->getSubcategories();
            $brands = $this->productModel->getBrands();
            $colors = $this->productModel->getAttributeOptions(1); // attribute_id 1 = Color
            $capacities = $this->productModel->getAttributeOptions(2); // attribute_id 2 = Capacity

            // Render view
            View::render('admin/products/create', [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'brands' => $brands,
                'colors' => $colors,
                'capacities' => $capacities,
                'error' => $error ?? null,
            ]);
        }

    private function generateSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        return $slug;
    }
}