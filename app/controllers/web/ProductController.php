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

        $query = $params['query'] ?? [];
        $page = max(1, (int) ($query['page'] ?? 1));
        $limit = 15;

        $filters = [
            'brand' => (array) ($query['brand'] ?? []),
            'price' => (array) ($query['price'] ?? []),
            'attributes' => [],
            'page' => $page,
            'limit' => $limit
        ];

        // Collect dynamic attribute filters from query params
        foreach ($query as $key => $value) {
            if (str_starts_with($key, 'attr_') && is_array($value)) {
                $attrId = (int) substr($key, 5);
                $filters['attributes'][$attrId] = $value;
            }
        }

        $category = $this->productService->getCategoryBySlug($categorySlug);

        if ($category) {
            $filters['category_id'] = $category['category_id'];
        } else {
            header('Location: /products');
            exit;
        }

        $subcategory = null;
        if ($subcategorySlug) {
            $subcategory = $this->productService->getSubcategoryBySlug($subcategorySlug);
            if ($subcategory) {
                $filters['subcategory_id'] = $subcategory['subcategory_id'];
            } else {
                header('Location: /products/' . $categorySlug);
                exit;
            }
        }
        $products = $this->productService->getFilteredProducts($filters);
        $totalProducts = $this->productService->getFilteredProductsCount($filters);
        $totalPages = ceil($totalProducts / $limit);

        $brands = $this->productService->getBrands($filters);
        $availableAttributes = $this->productService->getAvailableAttributes($filters);
        $subcategories = $this->productService->getSubcategories($category['category_id']);

        View::render('products', [
            'products' => $products,
            'brands' => $brands,
            'availableAttributes' => $availableAttributes,
            'categorySlug' => $categorySlug,
            'subcategorySlug' => $subcategorySlug,
            'selectedBrands' => $filters['brand'],
            'selectedAttributes' => $filters['attributes'],
            'subcategories' => $subcategories,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
