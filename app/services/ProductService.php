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
    }

    public function getHomeProductsByCategoryIds(array $subcategoryIds, int $limit): array
    {
        return $this->productModel->getProducts([
            'subcategory_ids' => $subcategoryIds,
            'limit' => $limit
        ]);
    }

    public function getDefaultSkuByProductId(int $productId): ?array
    {
        return $this->productModel->getDefaultSkuByProductId($productId);
    }

    public function getSaleProducts(int $limit): array
    {
        // Lấy sản phẩm sale hôm nay
        $saleProducts = $this->productModel->getProducts([
            'is_sale' => true,
            'sale_mode' => 'today',
            'limit' => $limit
        ]);

        if (!empty($saleProducts)) {
            return [
                'status' => 'today',
                'products' => $saleProducts
            ];
        }

        // Nếu không có sale hôm nay, lấy sale của ngày mai
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $saleProducts = $this->productModel->getProducts([
            'is_sale' => true,
            'sale_mode' => 'custom',
            'date' => $tomorrow,
            'limit' => $limit
        ]);

        if (!empty($saleProducts)) {
            return [
                'status' => 'upcoming',
                'products' => $saleProducts
            ];
        }

        // Không có sale
        return [
            'status' => 'none',
            'products' => []
        ];
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        return $this->productModel->getProducts([
            'is_featured' => true,
            'limit' => $limit
        ]);
    }

    public function getProductDetail(string $slug): array
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

    public function relatedProducts(int $subcategory_id, int $excludeProductId, int $limit): array
    {
        return $this->productModel->getProducts([
            'subcategory_id' => $subcategory_id,
            'exclude_id'  => $excludeProductId,
            'limit'       => $limit
        ]);
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

    public function addReview(int $product_id, int $user_id, ?int $parent_review_id, string $comment_text): bool
    {
        return $this->productModel->addReview($product_id, $user_id, $parent_review_id, $comment_text);
    }

    public function getReviews(int $product_id): array
    {
        return $this->productModel->getReviewsByProductId($product_id);
    }

    public function getLastInsertId()
    {
        return $this->productModel->getLastInsertId();
    }

    public function getUserById($id)
    {
        return $this->productModel->getUserById($id);
    }
}
