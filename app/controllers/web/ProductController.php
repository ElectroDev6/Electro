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

    public function showAll($params = [])
    {
        // Dynamic segment từ URL
        $categorySlug = $params['matches'][0] ?? 'phone';
        $subcategorySlug = $params['matches'][1] ?? null;

        // Query params (?brand=asus&brand=dell)
        $filters = [
            'brand' => $params['query']['brand'] ?? [],
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

    public function searchProducts()
    {
        $keyword = $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? '';

        $products = $this->productService->searchProducts($keyword, $category);
        View::render('products', ['products' => $products, 'keyword' => $keyword, 'category' => $category]);
    }
}
