<?php

namespace App\Controllers\Web;

use Core\View;

class ProductLaptopController
{

    public function showAllLaptops()
    {

        $products = [
            [
                'name' => 'MacBook Air 13" M1 2020',
                'brand_name' => 'Apple',
                'price_original' => 30000000,
                'price_discount' => 27000000,
                'image' => '/img/MacBook Air 13 inch M1 2020.png',
                'operating_system' => 'MacOS',
                'cpu' => 'Apple M4 series',
                'storage' => 'SSD 512GB',
                'battery' => 10,
                'ram' => '16GB',
                'screen' => 14,
                'Hz' => '60Hz'
            ],
            [
                'name' => 'Dell XPS 15',
                'brand_name' => 'Dell',
                'price_original' => 20000000,
                'price_discount' => 18000000,
                'image' => '/img/MacBook Air 15 inch M2 2023.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M4 series',
                'storage' => 'SSD 256GB',
                'battery' => 8,
                'ram' => '8GB',
                'screen' => 15.6,
                'Hz' => '120Hz'
            ],
            [
                'name' => 'HP Spectre x360',
                'brand_name' => 'HP',
                'price_original' => 22000000,
                'price_discount' => 19800000,
                'image' => '/img/MacBook Air 15 inch M2 2023.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M3 series',
                'storage' => 'SSD 512GB',
                'battery' => 9,
                'ram' => '16GB',
                'screen' => 14,
                'Hz' => '144Hz'
            ],
            [
                'name' => 'Asus ROG Zephyrus G15',
                'brand_name' => 'Asus',
                'price_original' => 25000000,
                'price_discount' => 22500000,
                'image' => '/img/Macbook Air M2 13 inch 2022.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M3 series',
                'storage' => 'SSD 1TB',
                'battery' => 12,
                'ram' => '32GB',
                'screen' => 15.6,
                'Hz' => '165Hz'
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'brand_name' => 'Lenovo',
                'price_original' => 18000000,
                'price_discount' => 16200000,
                'image' => '/img/MacBook Pro 14 M4 2024.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M2 series',
                'storage' => 'SSD 512GB',
                'battery' => 7,
                'ram' => '8GB',
                'screen' => 13,
                'Hz' => '60Hz'
            ],
            [
                'name' => 'MSI Raider GE76',
                'brand_name' => 'MSI',
                'price_original' => 28000000,
                'price_discount' => 25200000,
                'image' => '/img/MacBook Pro 16 M4 Max 2024.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M2 series',
                'storage' => 'SSD 1TB',
                'battery' => 9,
                'ram' => '32GB',
                'screen' => 17,
                'Hz' => '240Hz'
            ],
            [
                'name' => 'Acer Aspire 7',
                'brand_name' => 'Acer',
                'price_original' => 16000000,
                'price_discount' => 14400000,
                'image' => '/img/MacBook Air 13 inch M1 2020.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M1 series',
                'storage' => 'SSD 256GB',
                'battery' => 8,
                'ram' => '8GB',
                'screen' => 15.6,
                'Hz' => '75Hz'
            ],
            [
                'name' => 'Microsoft Surface Laptop 5',
                'brand_name' => 'Microsoft Surface',
                'price_original' => 32000000,
                'price_discount' => 28800000,
                'image' => '/img/MacBook Pro 16 M4 Max 2024.png',
                'operating_system' => 'Windows',
                'cpu' => 'Apple M1 series',
                'storage' => 'SSD 512GB',
                'battery' => 13,
                'ram' => '16GB',
                'screen' => 13.5,
                'Hz' => '120Hz'
            ]
        ];




        // Lấy filter từ query string
        // Các filter giữ nguyên như bạn đang có:
        $priceRange = $_GET['price'] ?? [];
        $brand = $_GET['brand'] ?? 'all';
        $operating_system = $_GET['operating_system'] ?? [];
        $storage = $_GET['storage'] ?? [];
        $battery = $_GET['battery'] ?? 'all';
        $Ram = $_GET['ram'] ?? [];
        $screen = $_GET['screen'] ?? [];
        $Hz = $_GET['hz'] ?? [];
        $cpu = $_GET['cpu'] ?? [];


        // Filter logic giữ nguyên (chỉ thay $products là dữ liệu DB thật)
        if (!is_array($priceRange)) { //Theo Mức giá
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

        if ($brand !== 'all') { // Thương hiệu
            $products = array_filter($products, function ($product) use ($brand) {
                return strtolower($product['brand_name']) === strtolower($brand);
            });
        }

        if (!empty($operating_system)) { // Hệ điều hành
            $operating_system = array_map('strtolower', $operating_system);
            $products = array_filter($products, function ($product) use ($operating_system) {
                return in_array(strtolower($product['operating_system']), $operating_system);
            });
        }
        if (!is_array($storage)) { // Lọc theo dung lượng
            $storage = [$storage];
        }
        if (!empty($storage) && $storage[0] !== 'all') {
            $products = array_filter($products, function ($product) use ($storage) {
                return in_array($product['storage'], $storage);
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
        if (!is_array($Ram)) {//Lọc theo Ram
            $Ram = [$Ram];
        }
        if (!empty($Ram)) {
            $products = array_filter($products, function ($product) use ($Ram) {
                return in_array($product['ram'], $Ram);
            });
        }
        if (!is_array($screen)) {//Lọc theo màn hình
            $screen = [$screen];
        }
        if (!empty($screen) && $screen[0] !== 'all') {
            $products = array_filter($products, function ($product) use ($screen) {
                foreach ($screen as $range) {
                    [$min, $max] = explode('-', $range);
                    $min = (float) $min;
                    $max = (float) $max;
                    if ($product['screen'] >= $min && $product['screen'] <= $max) {
                        return true;
                    }
                }
                return false;
            });
        }

        if (!is_array($Hz)) {//Lọc theo Hz
            $Hz = [$Hz];
        }
        if (!empty($Hz)) {
            $products = array_filter($products, function ($product) use ($Hz) {
                return in_array($product['Hz'], $Hz);
            });
        }

        if (!is_array($cpu)) {// Lọc theo Cpu
            $cpu = [$cpu];
        }
        if (!empty($cpu)) {
            $products = array_filter($products, function ($product) use ($cpu) {
                return in_array($product['cpu'], $cpu); // so sánh nguyên bản
            });
        }
        View::render('productlaptop', [
            'products' => $products,
            'storage' => $storage,
            'priceRange' => $priceRange,
            'cpu' => $cpu,
            'ram' => $Ram,
            'screen' => $screen,
            'Hz' => $Hz
        ]);

    }
}
