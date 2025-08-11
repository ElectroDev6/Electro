<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use Core\View;

class ProductController
{
    private $productService;
    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
    }

    public function showAll($matches = [])
    {
        $categorySlug = $matches[0] ?? 'phone'; // Mặc định là 'phone' nếu null
        $subcategorySlug = $matches[1] ?? null;
        error_log("ProductController: showAll - CategorySlug: " . ($categorySlug ?? 'null') . ", SubcategorySlug: " . ($subcategorySlug ?? 'null'));

        $filters = [
            'brand' => $_GET['brand'] ?? [],
            'limit' => 15
        ];

        $subcategories = [];
        if ($categorySlug) {
            $category = $this->productService->getCategoryBySlug($categorySlug);
            error_log("ProductController: Category found: " . json_encode($category));
            if ($category) {
                $filters['category_id'] = $category['category_id'];
                $subcategories = $this->productService->getSubcategories($category['category_id']);
            } else {
                // Redirect hoặc lỗi nếu category không tồn tại
                header('Location: /products');
                exit;
            }
        }

        if ($subcategorySlug) {
            $filters['subcategory_slug'] = $subcategorySlug;
        }

        $products = $this->productService->getFilteredProducts($filters);
        $brands = $this->productService->getBrands($filters);
        error_log("ProductController: Brands fetched: " . json_encode($brands));

        View::render('products', [
            'products' => $products,
            'brands' => $brands,
            'categorySlug' => $categorySlug,
            'subcategorySlug' => $subcategorySlug,
            'selectedBrands' => $filters['brand'],
            'subcategories' => $subcategories
        ]);
    }
}
