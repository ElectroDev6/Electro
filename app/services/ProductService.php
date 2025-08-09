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

    public function getHomeProductsByCategoryId(int $categoryId, int $limit = 8): array
    {
        return $this->productModel->getProducts([
            'category_id' => 1,
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

    public function addToCart($skuId, $quantity = 1, $userId = null, $sessionId = null)
    {
        error_log("ProductService: Processing SKU ID: $skuId, Quantity: $quantity");
        if (!$this->cartService) {
            error_log("ProductService: CartService not initialized");
            return ['success' => false, 'message' => 'Dịch vụ giỏ hàng chưa được khởi tạo.'];
        }
        $result = $this->cartService->addToCart($skuId, $quantity, $userId, $sessionId);
        error_log("ProductService: Add to cart result for SKU $skuId: " . json_encode($result));
        return $result;
    }
    public function getAllProduct()
    {
        return $this->productModel->getAllProducts();
    }
}
