<?php
namespace App\Controllers\Admin\Products;

use App\Models\admin\ProductsModel;
use App\Models\admin\CategoriesModel;
use Core\View;
use Container;

class CreateProductController
{
    private ProductsModel $productModel;
    private CategoriesModel $categoryModel;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->productModel = new ProductsModel($pdo);
        $this->categoryModel = new CategoriesModel($pdo);
    }
    

    public function index()
        {
            // Fetch data for form
            $categories = $this->categoryModel->fetchAllCategories();
            $brands = $this->productModel->getAllBrands();
            $colors = $this->productModel->getAllColors();
            $capacities = $this->productModel->getAllCapacities();

            // Render the create product form view
            View::render('products/create', [
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors,
                'capacities'=>$capacities,
            ]);
        }
        
        public function handleCreate()
{

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    exit;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $productData = [
                'name' => htmlspecialchars(trim($_POST['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'brand_id' => filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT),
                'subcategory_id' => filter_input(INPUT_POST, 'subcategory_id', FILTER_VALIDATE_INT),
                'description' => htmlspecialchars($_POST['description_html'] ?? '', ENT_QUOTES, 'UTF-8'),
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'slug' => $this->generateSlug($_POST['product_name'] ?? ''),
                'main_image' => $_FILES['main_image'] ?? null,
            ];

            // Validate required fields
            if (!$productData['name'] || !$productData['brand_id'] || !$productData['subcategory_id'] || 
                !isset($_FILES['main_image']) || $_FILES['main_image']['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception('Vui lòng điền đầy đủ các trường bắt buộc.');
            }

            // Process variants
            $variants = $_POST['variants'] ?? [];
            $variantData = [];

            foreach ($variants as $v_idx => $variant) {
                $variantData[$v_idx] = [
                    'price' => filter_var($variant['price'] ?? 0, FILTER_VALIDATE_FLOAT),
                    'stock_quantity' => filter_var($variant['stock_quantity'] ?? 0, FILTER_VALIDATE_INT),
                    'color_id' => filter_var($variant['color_id'] ?? 0, FILTER_VALIDATE_INT),
                    'capacity_id' => filter_var($variant['capacity_id'] ?? 0, FILTER_VALIDATE_INT),
                    'sku' => htmlspecialchars(trim($variant['sku'] ?? '')),
                    'images' => [],
                ];

                if (!$variantData[$v_idx]['price'] || !$variantData[$v_idx]['stock_quantity'] || 
                    !$variantData[$v_idx]['color_id'] || !$variantData[$v_idx]['capacity_id']) {
                    throw new \Exception('Biến thể #' . ($v_idx + 1) . ': Vui lòng điền đầy đủ các trường bắt buộc (giá, số lượng, màu sắc, dung lượng).');
                }

                foreach ($variant['images'] ?? [] as $i_idx => $image) {
                    $fileKey = "variants[{$v_idx}][images][{$i_idx}][file]";
                    $variantData[$v_idx]['images'][$i_idx] = [
                        'file' => isset($_FILES['variants']['name'][$v_idx]['images'][$i_idx]['file']) ? [
                            'name' => $_FILES['variants']['name'][$v_idx]['images'][$i_idx]['file'],
                            'type' => $_FILES['variants']['type'][$v_idx]['images'][$i_idx]['file'],
                            'tmp_name' => $_FILES['variants']['tmp_name'][$v_idx]['images'][$i_idx]['file'],
                            'error' => $_FILES['variants']['error'][$v_idx]['images'][$i_idx]['file'],
                            'size' => $_FILES['variants']['size'][$v_idx]['images'][$i_idx]['file'],
                        ] : null,
                    ];
                }
            }

            if (empty($variantData)) {
                throw new \Exception('Phải có ít nhất một biến thể sản phẩm.');
            }

            $specifications = $_POST['specs'] ?? [];
            $specData = [];
            foreach ($specifications as $s_idx => $spec) {
                $specData[$s_idx] = [
                    'name' => htmlspecialchars(trim($spec['name'] ?? '')),
                    'value' => htmlspecialchars(trim($spec['value'] ?? '')),
                ];
                if (empty($specData[$s_idx]['name']) || empty($specData[$s_idx]['value'])) {
                    unset($specData[$s_idx]);
                }
            }

            $result = $this->productModel->createProduct($productData, $variantData, $specData);

            if ($result) {
                header('Location: /admin/products?success=Sản phẩm đã được tạo thành công');
                exit;
            } else {
                throw new \Exception('Không thể tạo sản phẩm.');
            }
        } catch (\Exception $e) {
            error_log("Lỗi khi tạo sản phẩm: " . $e->getMessage());
            $error = $e->getMessage();
        }
    }

    $categories = $this->productModel->getCategories();
    $subcategories = $this->productModel->getSubcategories();
    $brands = $this->productModel->getAllBrands();
    $colors = $this->productModel->getAllColors();
    $capacities = $this->productModel->getAllCapacities();

    View::render('products/index', [
        'categories' => $categories,
        'subcategories' => $subcategories,
        'brands' => $brands,
        'colors' => $colors,
        'capacities' => $capacities,
        'error' => $error ?? null,
    ]);
}

    private function handleImageUpload($file, $subdirectory = 'default')
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = __DIR__ . '/../../img/products/' . $subdirectory . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return '/img/products/' . $subdirectory . '/' . $filename;
        }

        return null;
    }

    private function generateSlug($name)
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($name)));
    }
}