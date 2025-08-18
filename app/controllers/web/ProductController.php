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
        $priceRange = $_GET['price'] ?? [];
        $brand = $_GET['brand'] ?? 'all';
        // $operating_system = $_GET['operating_system'] ?? [];
        $storage = $_GET['storage'] ?? [];
        // $battery = $_GET['battery'] ?? 'all';
        // $Ram = $_GET['ram'] ?? 'all';
        // $screen = $_GET['screen'] ?? 'all';
        // $Hz = $_GET['hz'] ?? 'all';


        // Filter logic giữ nguyên (chỉ thay $products là dữ liệu DB thật)
        if (!is_array($priceRange)) {
            $priceRange = [$priceRange];
        }
        if (!empty($priceRange)) {
            $products = array_filter($products, function ($p) use ($priceRange) {
                foreach ($priceRange as $range) {
                    if ($range === 'all') {
                        return true;
                    }
                    [$min, $max] = explode('-', $range);
                    $minPrice = (int) $min * 1000000;
                    $maxPrice = (int) $max * 1000000;
                    if ($p['price_discount'] >= $minPrice && $p['price_discount'] <= $maxPrice) {
                        return true;
                    }
                }
                return false;
            });
        }

        if ($brand !== 'all') { // Lọc theo hãng
            $products = array_filter($products, function ($product) use ($brand) {
                return strtolower($product['brand_name']) === strtolower($brand);
            });
        }

        //Lọc theo hệ điều hành
        // if (!is_array($operating_system)) {
        //     $operating_system = [$operating_system];
        // }
        // if (!empty($operating_system)) {
        //     $operating_system = array_map('strtolower', $operating_system);
        //     $products = array_filter($products, function ($product) use ($operating_system) {
        //         return in_array(strtolower($product['operating_system']), $operating_system);
        //     });
        // }

        // if (!empty($osFilters)) {
        //     $products = array_filter($products, function ($product) use ($osFilters) {
        //         return in_array($product['os'], $osFilters);
        //     });
        // }
        //Dung lượng
        if (!is_array($storage)) {
            $storage = [$storage];
        }
        if (!empty($storage)) {
            $products = array_filter($products, function ($p) use ($storage) {
                return in_array($p['storage'], $storage);
            });
        }

        // if ($battery !== 'all' && strpos($battery, '-') !== false) { // Lọc theo Pin
        //     [$minBattery, $maxBattery] = explode('-', $battery);
        //     $minBattery = (int) $minBattery;
        //     $maxBattery = (int) $maxBattery;
        //     $products = array_filter($products, function ($product) use ($minBattery, $maxBattery) {
        //         return $product['battery'] >= $minBattery && $product['battery'] <= $maxBattery;
        //     });
        // }
        // if ($Ram !== 'all') {
        //     // Lọc danh sách theo Ram
        //     $products = array_filter($products, function ($product) use ($Ram) {
        //         return $product['ram'] === $Ram;
        //     });
        // }

        // if ($screen !== 'all' && strpos($screen, '-') !== false) { // Lọc theo màn hình
        //     [$minScreen, $maxScreen] = explode('-', $screen);
        //     $minScreen = (float) $minScreen;
        //     $maxScreen = (float) $maxScreen;
        //     $products = array_filter($products, function ($product) use ($minScreen, $maxScreen) {
        //         return $product['screen'] >= $minScreen && $product['screen'] <= $maxScreen;
        //     });
        // }

        // if ($Hz !== 'all') {
        //     // Lọc danh sách theo Hz
        //     $products = array_filter($products, function ($product) use ($Hz) {
        //         return $product['Hz'] === $Hz;
        //     });
        // }

        View::render('product', [
            'products' => $products,
            'storage' => $storage,
            'priceRange' => $priceRange
        ]);

    }
}
