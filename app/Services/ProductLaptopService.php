<?php

namespace App\Services;

use App\Models\ProductLaptopModel;

class ProductLaptopService
{
    private $productLaptopModel;
    private $cartService;
    public function __construct(\PDO $pdo, ?CartService $cartService = null)
    {
        $this->productLaptopModel = new ProductLaptopModel($pdo);
        $this->cartService = $cartService;
    }

    public function showAllLaptops(): array
    {
        return $this->productLaptopModel->showAllLaptops();
    }
}