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
        $categorySlug = $params['matches']['categorySlug'] ?? 'phone'; // Sử dụng key 'categorySlug'
        $subcategorySlug = $params['matches']['subcategorySlug'] ?? null; // Sử dụng key 'subcategorySlug'

        $filters = [
            'brand' => $params['query']['brand'] ?? [],
            'limit' => 15
        ];

        $category = $this->productService->getCategoryBySlug($categorySlug);

        if ($category) {
            $filters['category_id'] = $category['category_id'];
        } else {
            header('Location: /products');
            exit;
        }

        if ($subcategorySlug) {
            $filters['subcategory_slug'] = $subcategorySlug;
        }

        $products = $this->productService->getFilteredProducts($filters);
        echo '<pre>';
        print_r($products);
        echo '</pre>';
        exit;
        $brands = $this->productService->getBrands($filters);

        View::render('products', [
            'products' => $products,
            'brands' => $brands,
            'categorySlug' => $categorySlug,
            'subcategorySlug' => $subcategorySlug,
            'selectedBrands' => $filters['brand'],
            'subcategories' => $this->productService->getSubcategories($category['category_id'])
        ]);
    }
}
