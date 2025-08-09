<?php

namespace App\Controllers\Web;
use App\Services\ProductService;
use Core\View;

class ProductController
{
    private $productService;
    public function __construct(\PDO $pdo)
    {
        $this->productService = new ProductService($pdo);
    }
    public function showAll()
    {


        $products = $this->productService->getAllProduct();
        if (!is_array($products)) {
            $products = [];
        }

        // Lấy filter từ query string
        // Các filter giữ nguyên như bạn đang có:
        $priceRange = $_GET['price'] ?? 'all';
        $brand = $_GET['brand'] ?? 'all';
        $operating_system = $_GET['operating_system'] ?? [];
        $storage = $_GET['storage'] ?? 'all';
        $battery = $_GET['battery'] ?? 'all';
        $Ram = $_GET['ram'] ?? 'all';
        $screen = $_GET['screen'] ?? 'all';
        $Hz = $_GET['hz'] ?? 'all';


        // Filter logic giữ nguyên (chỉ thay $products là dữ liệu DB thật)
        if ($priceRange !== 'all') {
            [$min, $max] = explode('-', $priceRange);
            $minPrice = (int) $min * 1000000;
            $maxPrice = (int) $max * 1000000;
            $products = array_filter($products, fn($p) => $p['price_discount'] >= $minPrice && $p['price_discount'] <= $maxPrice);

        }


        if ($brand !== 'all') {
            $products = array_filter($products, function ($product) use ($brand) {
                return strtolower($product['brand_name']) === strtolower($brand);
            });
        }
        if (!empty($operating_system)) {
            $operating_system = array_map('strtolower', $operating_system);
            $products = array_filter($products, function ($product) use ($operating_system) {
                return in_array(strtolower($product['operating_system']), $operating_system);
            });
        }
        if (!empty($osFilters)) {
            $products = array_filter($products, function ($product) use ($osFilters) {
                return in_array($product['os'], $osFilters);
            });
        }
        if ($storage !== 'all') {
            $products = array_filter($products, function ($product) use ($storage) {
                return $product['storage'] === $storage;
            });
        }

        if ($battery !== 'all' && strpos($battery, '-') !== false) { // Lọc theo Pin
            [$minBattery, $maxBattery] = explode('-', $battery);
            $minBattery = (int) $minBattery;
            $maxBattery = (int) $maxBattery;
            $products = array_filter($products, function ($product) use ($minBattery, $maxBattery) {
                return $product['battery'] >= $minBattery && $product['battery'] <= $maxBattery;
            });
        }
        if ($Ram !== 'all') {
            // Lọc danh sách theo Ram
            $products = array_filter($products, function ($product) use ($Ram) {
                return $product['ram'] === $Ram;
            });
        }
        if ($screen !== 'all' && strpos($screen, '-') !== false) { // Lọc theo màn hình
            [$minScreen, $maxScreen] = explode('-', $screen);
            $minScreen = (float) $minScreen;
            $maxScreen = (float) $maxScreen;
            $products = array_filter($products, function ($product) use ($minScreen, $maxScreen) {
                return $product['screen'] >= $minScreen && $product['screen'] <= $maxScreen;
            });
        }
        if ($Hz !== 'all') {
            // Lọc danh sách theo Hz
            $products = array_filter($products, function ($product) use ($Hz) {
                return $product['Hz'] === $Hz;
            });
        }

        View::render('product', [
            'products' => $products,
            'storage' => $storage
        ]);

    }
}
