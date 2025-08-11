<?php

namespace App\Services;

use App\Models\ProductModel;
use PDO;

class ProductService
{
    private $productModel;
    private $cartService;

    public function __construct(\PDO $pdo, ?CartService $cartService = null)
    {
        $this->productModel = new ProductModel($pdo);
        $this->cartService = $cartService;
        // $this->pdo = $pdo;
    }

    public function getHomeProductsByCategoryId(int $subcategoryId, int $limit = 8): array
    {
        return $this->productModel->getProducts([
            'subcategory_id' => $subcategoryId,
            'limit' => 8
        ]);
    }

    public function getSaleProducts(int $limit = 8): array
    {
        return $this->productModel->getProducts([
            'is_sale' => true,
            'limit' => 8
        ]);
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        return $this->productModel->getProducts([
            'is_featured' => true,
            'limit' => 6
        ]);
    }

    public function relatedProducts(int $categoryId, int $excludeProductId, int $limit = 6): array
    {
        return $this->productModel->getProducts([
            'category_id' => $categoryId,
            'exclude_id'  => $excludeProductId,
            'limit'       => $limit
        ]);
    }


    public function getProductService(string $slug): array
    {
        return $this->productModel->getProductDetailModel($slug);
    }

    public function addToCart($skuId, $quantity, $userId, $sessionId, $color = null, $warrantyEnabled = false, $imageUrl = null)
    {
        error_log("ProductService: Processing add to cart - SKU: $skuId, Quantity: $quantity, Color: " . ($color ?? 'null') . ", Image: " . ($imageUrl ?? 'null'));
        $result = $this->cartService->addToCart($skuId, $quantity, $userId, $sessionId, $color, $warrantyEnabled, $imageUrl);
        error_log("ProductService: Add to cart result: " . json_encode($result));
        return $result;
    }
    public function getAllProduct()
    {
        return $this->productModel->getAllProducts();
    }

    public function getFilteredProducts(array $filters = []): array
    {
        return $this->productModel->getProducts($filters);
    }

    public function getBrands(array $filters = []): array
    {
        return $this->productModel->getBrands($filters);
    }

    public function getCategoryBySlug(string $slug): ?array
    {
        return $this->productModel->getCategoryBySlug($slug);
    }

    public function getSubcategories(int $category_id): array
    {
        return $this->productModel->getSubcategories($category_id);
    }

    public function addReview(int $product_id, ?int $user_id, ?int $parent_review_id, string $comment_text, int $rating = null, ?string $user_name = null, ?string $email = null): bool
    {
        return $this->productModel->addReview($product_id, $user_id, $parent_review_id, $comment_text, $rating, $user_name, $email);
    }

    public function getReviews(int $product_id): array
    {
        return $this->productModel->getReviewsByProductId($product_id);
    }
}
