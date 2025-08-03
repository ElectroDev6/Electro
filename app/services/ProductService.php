<?php

namespace App\Services;

use App\Models\ProductModel;

class ProductService
{
    private $productModel;

    public function __construct(\PDO $pdo)
    {
        $this->productModel = new ProductModel($pdo);
    }

    public function getHomeProductsByCategoryId(int $categoryId, int $limit = 8): array
    {
        return $this->productModel->getHomeProductsByCategoryId($categoryId, $limit);
    }

    public function getSaleProducts(int $limit = 8): array
    {
        return $this->productModel->getSaleProducts($limit);
    }

    public function getFeaturedProducts(int $limit = 6): array
    {
        return $this->productModel->getFeaturedProducts($limit);
    }


    public function getProductService(string $slug): array
    {
        $productModel = new ProductModel(\Container::get('pdo'));
        return $productModel->getProductDetailModel($slug);
    }
}
