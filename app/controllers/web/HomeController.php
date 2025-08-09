<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use App\Services\CategoryService;
use Core\View;

class HomeController
{
    private $productService;
    private $categoryService;

    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo); // Không cần truyền CartService ở đây
        $this->categoryService = new CategoryService($pdo);
    }

    public function index()
    {
        $iphoneProducts = $this->productService->getHomeProductsByCategoryId(1, 15);
        $saleProducts = $this->productService->getSaleProducts(5);
        $featuredProducts = $this->productService->getFeaturedProducts(9);
        $categories = $this->categoryService->getAllCategories();
        // Dữ liệu tạm thời cho phụ kiện và linh kiện máy tính
        $accessories = [
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory1.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory2.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory3.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory4.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory5.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory6.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory7.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/accessory8.png'],
        ];

        $computerAccessories = [
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer1.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer2.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer3.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer4.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer5.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer6.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer7.png'],
            ['name' => 'Phụ kiện Apple', 'image' => '/img/placeholder/computer8.png'],
        ];

        $featuredProduct = $featuredProducts[0] ?? null;
        $regularProducts = array_slice($featuredProducts, 1);

        View::render('home', [
            'iphoneProducts' => $iphoneProducts,
            'saleProducts' => $saleProducts,
            'featuredProduct' => $featuredProduct,
            'regularProducts' => $regularProducts,
            'categories' => $categories,
            'accessories' => $accessories,
            'computerAccessories' => $computerAccessories
        ]);
    }
}
