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

        $iphoneProducts = $this->productService->getHomeProductsByCategoryId(101, 15);
        $pcProducts = $this->productService->getHomeProductsByCategoryId(401, 15);
        $watchProducts = $this->productService->getHomeProductsByCategoryId(1607, 15);
        $tefalProducts = $this->productService->getHomeProductsByCategoryId(701, 15);
        $massagerProducts = $this->productService->getHomeProductsByCategoryId(1403, 15);
        $airCoolerProducts = $this->productService->getHomeProductsByCategoryId(803, 15);
        $vacuumCleanerProducts = $this->productService->getHomeProductsByCategoryId(801, 15);

        // echo '<pre>';
        // print_r($airCoolerProducts);
        // echo '</pre>';
        // exit;
        $featuredProducts = $this->productService->getFeaturedProducts(9);

        $categories = $this->categoryService->getAllCategories();

        // Dữ liệu tạm thời cho phụ kiện và linh kiện máy tính
        $accessories = [
            ['name' => 'Phụ kiện Apple', 'image' => 'cap-sac-hub.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cardmanhinh.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'casepc.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'cpu.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'dan-man-hinh-iphone-15.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'gaming-gear-play-staytion.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'mainboard.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'nguonmaytinh.webp'],
        ];

        $computerAccessories = [
            ['name' => 'Phụ kiện Apple', 'image' => 'ocung.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'op-bao-da-sam-sung-s24.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'pc-rap.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'pin-du-phong-20000-mah.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'pk-apple-cap-sac.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'pk-apple-tai-nghe.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'pk-may-tinh-laptop-camera.webp'],
            ['name' => 'Phụ kiện Apple', 'image' => 'ram.webp'],
        ];

        $featuredProduct = $featuredProducts[0] ?? null;
        $regularProducts = array_slice($featuredProducts, 1);

        View::render('home', [
            'iphoneProducts' => $iphoneProducts,
            'pcProducts' => $pcProducts,
            'watchProducts' => $watchProducts,
            'tefalProducts' => $tefalProducts,
            'massagerProducts' => $massagerProducts,
            'airCoolerProducts' => $airCoolerProducts,
            'vacuumCleanerProducts' => $vacuumCleanerProducts,
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
