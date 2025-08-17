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

    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
        $this->categoryService = new CategoryService($pdo);
    }

    public function index()
    {
        $subcategoryIds = [101, 401, 1607, 701, 1403, 803, 801]; // iPhone, PC, watch, air fryer, massager, air cooler, vacuum cleaner
        $limitPerCategory = 15;
        $totalLimit = $limitPerCategory * count($subcategoryIds);
        $allProducts = $this->productService->getHomeProductsByCategoryIds($subcategoryIds, $totalLimit);
        // Phân loại sản phẩm theo subcategory_id

        $iphoneProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 101);
        $pcProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 401);
        $watchProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 1607);
        $airFryerProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 701);
        $massagerProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 1403);
        $airCoolerProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 803);
        $vacuumCleanerProducts = array_filter($allProducts, fn($product) => $product['subcategory_id'] == 801);

        $saleData = $this->productService->getSaleProducts(10);
        $saleStatus = $saleData['status'];
        $saleProducts = $saleData['products'];

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
        // echo '<pre>';
        // print_r($featuredProduct);
        // echo '</pre>';
        // exit();
        $regularProducts = array_slice($featuredProducts, 1);

        View::render('home', [
            'iphoneProducts' => $iphoneProducts,
            'pcProducts' => $pcProducts,
            'watchProducts' => $watchProducts,
            'airFryerProducts' => $airFryerProducts,
            'massagerProducts' => $massagerProducts,
            'airCoolerProducts' => $airCoolerProducts,
            'vacuumCleanerProducts' => $vacuumCleanerProducts,
            'saleProducts' => $saleProducts,
            'saleStatus' => $saleStatus,
            'featuredProduct' => $featuredProduct,
            'regularProducts' => $regularProducts,
            'categories' => $categories,
            'accessories' => $accessories,
            'computerAccessories' => $computerAccessories
        ]);
    }
}
