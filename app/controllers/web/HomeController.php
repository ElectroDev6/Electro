<?php

namespace App\Controllers\Web;

use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\PromotionService;
use Core\View;

class HomeController
{
    private $productService;
    private $categoryService;
    private $promotionService;

    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
        $this->categoryService = new CategoryService($pdo);
        $this->promotionService = new PromotionService($pdo);
    }

    public function index()
    {

        $saleProducts = $this->productService->getSaleProducts(5);

        $iphoneProducts = $this->productService->getHomeProductsByCategoryId(1, 15);
        $featuredProducts = $this->productService->getFeaturedProducts(9);

        $categories = $this->categoryService->getAllCategories();
        // Dữ liệu tạm thời cho phụ kiện và linh kiện máy tính
        $accessories = [
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
        ];

        $computerAccessories = [
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
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

    // Xử lý yêu cầu AJAX để lấy sản phẩm sale theo ngày
    public function getSaleProductsByDate()
    {
        if (isset($_GET['date'])) {
            $selectedDate = $_GET['date'];
            $products = $this->promotionService->getSaleProductsByDate($selectedDate);
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
            exit;
        }
    }
}
