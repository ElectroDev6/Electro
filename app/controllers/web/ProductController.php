<?php

namespace App\Controllers\Web;

use Core\View;

class ProductController
{
    public function showAll()
    {
        $products = [
            [
                'name' => 'iPhone 16 Pro Max',
                'price' => 30090000,
                'old_price' => 34290000,
                'rom' => ['128GB', '256GB', '512GB'],
                'ram' => '8GB',
                'brand' => 'Apple',
                'screen' => '6.8',
                'battery' => 5000,
                'os' => 'IOS',
                'image' => '/img/SP_DT_iphone.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Vivo Y03',
                'price' => 27000000,
                'old_price' => 29900000,
                'rom' => ['128GB', '256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Vivo',
                'screen' => '6.5',
                'battery' => 4000,
                'os' => 'Android',
                'image' => '/img/SP_DT_Vivo.png',
                'Hz' => '90'
            ],
            [
                'name' => 'OPPO A5i Pro',
                'price' => 15000000,
                'old_price' => 18000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '4GB',
                'brand' => 'Oppo',
                'screen' => '5',
                'battery' => 3500,
                'os' => 'Android',
                'image' => '/img/SP_DT_Oppo.png',
                'Hz' => '60'
            ],
            [
                'name' => 'iPhone 16 Pro Max',
                'price' => 20000000,
                'old_price' => 22000000,
                'rom' => ['128GB', '256GB'],
                'ram' => '8GB',
                'brand' => 'Apple',
                'screen' => '6.5',
                'battery' => 4500,
                'os' => 'IOS',
                'image' => '/img/SP_DT_iphone.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Vivo Y03',
                'price' => 35000000,
                'old_price' => 40000000,
                'rom' => ['128GB', '256GB', '512GB'],
                'ram' => '32GB',
                'brand' => 'Vivo',
                'screen' => '6.8',
                'battery' => 6000,
                'os' => 'Android',
                'image' => '/img/SP_DT_Vivo.png',
                'Hz' => '90'
            ],
            [
                'name' => 'OPPO A5i Pro',
                'price' => 22000000,
                'old_price' => 25000000,
                'rom' => ['128GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Oppo',
                'screen' => '6.5',
                'battery' => 4800,
                'os' => 'Android',
                'image' => '/img/SP_DT_Oppo.png',
                'Hz' => '60'
            ],
            [
                'name' => 'OPPO A5i Pro',
                'price' => 22000000,
                'old_price' => 25000000,
                'rom' => ['1TB'],
                'ram' => '16GB',
                'brand' => 'Oppo',
                'screen' => '6.5',
                'battery' => 4800,
                'os' => 'Android',
                'image' => '/img/SP_DT_Oppo.png',
                'Hz' => '60'
            ],

            // Thêm sản phẩm khác tại đây
        ];
        // Lấy filter từ query string
        $priceRange = $_GET['price'] ?? 'all';
        $brand = $_GET['brand'] ?? 'all';
        $osFilters = $_GET['os'] ?? [];
        $Rom = $_GET['rom'] ?? 'all';
        $battery = $_GET['battery'] ?? 'all';
        $Ram = $_GET['ram'] ?? 'all';
        $screen = $_GET['screen'] ?? 'all';
        $Hz = $_GET['hz'] ?? 'all';

        if ($priceRange !== 'all') {
            [$min, $max] = explode('-', $priceRange);
            $minPrice = (int) $min * 1000000;
            $maxPrice = (int) $max * 1000000;
            // Lọc danh sách theo khoảng giá
            $products = array_filter($products, function ($product) use ($minPrice, $maxPrice) {
                return $product['price'] >= $minPrice && $product['price'] <= $maxPrice;
            });
        }

        if ($brand !== 'all') {
            // Lọc danh sách brand
            $products = array_filter($products, function ($product) use ($brand) {
                return $product['brand'] === $brand;
            });
        }
        if (!empty($osFilters)) {
            $products = array_filter($products, function ($product) use ($osFilters) {
                return in_array($product['os'], $osFilters);
            });
        }
        if ($Rom !== 'all') {
            // Lọc danh sách theo Rom
            $products = array_filter($products, function ($product) use ($Rom) {
                return in_array($Rom, $product['rom']);
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

        View::render('product', ['products' => $products]);
    }
}
