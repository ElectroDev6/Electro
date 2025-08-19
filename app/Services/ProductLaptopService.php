<?php

namespace App\Services;

use App\Models\ProductLaptopModel;

class ProductLaptopService
{
    private $productLaptopModel;
    private $cartService;
    public function __construct(\PDO $pdo)
    {
        $this->productLaptopModel = new ProductLaptopModel($pdo);
    }

    public function showAllLaptops(): array
    {
        return $this->productLaptopModel->showAllLaptops();
    }
}