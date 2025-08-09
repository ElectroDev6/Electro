<?php

namespace App\Controllers\Web;


use Core\View;

class ProductLaptopController
{
    public function productLaptop()
    {
        $productslaptop = [
            [
                'name' => 'HP 14s',
                'price' => 30090000,
                'old_price' => 34290000,
                'ram' => '8GB',
                'brand' => 'HP',
                'screen' => '13',
                'battery' => 5000,
                'os' => 'Window',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce Series',
                'hard_drive' => 'SSD 512GB',
                'image' => '/img/DM_laptop.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Hp_245_g10',
                'price' => 27000000,
                'old_price' => 29900000,
                'rom' => ['128GB', '256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'HP',
                'screen' => '14',
                'battery' => 4000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce Series',
                'hard_drive' => 'SSD 512GB',
                'image' => '/img/SP_LT_hp_245_g10_.png',
                'Hz' => '90'
            ],
            [
                'name' => 'Hp_victus_gaming_16',
                'price' => 15000000,
                'old_price' => 18000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '4GB',
                'brand' => 'HP',
                'screen' => '15',
                'battery' => 3500,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce Series',
                'hard_drive' => 'SSD 1TB',
                'image' => '/img/SP_LT_hp_victus_gaming_16.png',
                'Hz' => '60'
            ],
            [
                'name' => 'Acer_aspire_lite_14',
                'price' => 20000000,
                'old_price' => 22000000,
                'rom' => ['128GB', '256GB'],
                'ram' => '8GB',
                'brand' => 'Acer',
                'screen' => '16',
                'battery' => 4500,
                'os' => 'IOS',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce Series',
                'hard_drive' => 'SSD 512GB',
                'image' => '/img/SP_LT_acer_aspire_lite_14.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Acer_Aspire_Lite_15',
                'price' => 35000000,
                'old_price' => 40000000,
                'rom' => ['128GB', '256GB', '512GB'],
                'ram' => '32GB',
                'brand' => 'Acer',
                'screen' => '13',
                'battery' => 6000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce MX Series',
                'hard_drive' => 'SSD 256GB',
                'image' => '/img/SP_LT_Acer_Aspire_Lite.png',
                'Hz' => '90'
            ],
            [
                'name' => 'Acer-aspire-7-gaming-a715',
                'price' => 22000000,
                'old_price' => 25000000,
                'rom' => ['128GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Acer',
                'screen' => '14',
                'battery' => 4800,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'hard_drive' => 'SSD 1TB',
                'card' => 'NVIDIA GeForce MX Series',
                'image' => '/img/SP_LT_acer-aspire-7-gaming-a715.png',
                'Hz' => '60'
            ],
            [
                'name' => 'Asus_vivobook',
                'price' => 22000000,
                'old_price' => 25000000,
                'rom' => ['1TB'],
                'ram' => '16GB',
                'brand' => 'Asus',
                'screen' => '15',
                'battery' => 4800,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce MX Series',
                'hard_drive' => 'SSD 256GB',
                'image' => '/img/SP_LT_Asus_vivobook.jpg',
                'Hz' => '60'
            ],
            [
                'name' => 'Dell_g15_5530_gray',
                'price' => 30000000,
                'old_price' => 35000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '8GB',
                'brand' => 'Dell',
                'screen' => '16',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce RTX Series',
                'hard_drive' => 'SSD 256GB',
                'image' => '/img/SP_LT_dell_g15_5530_gray_.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Dell_inspiron',
                'price' => 28000000,
                'old_price' => 32000000,
                'rom' => ['128GB', '256GB'],
                'ram' => '64GB',
                'brand' => 'Dell',
                'screen' => '13',
                'battery' => 4500,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce MX Series',
                'hard_drive' => 'SSD 128GB',
                'image' => '/img/SP_LT_dell_inspiron.jpg',
                'Hz' => '90'
            ],
            [
                'name' => 'Dell_inspiron_15_3525',
                'price' => 40000000,
                'old_price' => 45000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '64GB',
                'brand' => 'Dell',
                'screen' => '14',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce RTX Series',
                'hard_drive' => 'SSD 128GB',
                'image' => '/img/SP_LT_dell_inspiron.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Lenovo_Gaming_LOQ',
                'price' => 50000000,
                'old_price' => 55000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '64GB',
                'brand' => 'Lenovo',
                'screen' => '15',
                'battery' => 6000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce RTX Series',
                'image' => '/img/SP_LT_Lenovo_Gaming_LOQ.jpg',
                'Hz' => '90'
            ],
            [
                'name' => 'Lenovo_ideapad_slim',
                'price' => 25000000,
                'old_price' => 28000000,
                'rom' => ['128GB', '256GB'],
                'ram' => '8GB',
                'brand' => 'Lenovo',
                'screen' => '16',
                'battery' => 4000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce RTX Series',
                'hard_drive' => 'SSD 128GB',
                'image' => '/img/SP_LT_lenovo_ideapad_slim.jpg',
                'Hz' => '60'
            ],
            [
                'name' => 'Lenovo_ideapad_slim_3',
                'price' => 32000000,
                'old_price' => 36000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Lenovo',
                'screen' => '13',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'card' => 'NVIDIA GeForce RTX Series',
                'hard_drive' => 'SSD 512GB',
                'image' => '/img/SP_LT_lenovo_ideapad.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Macbook_air_13_m4_2025',
                'price' => 32000000,
                'old_price' => 36000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Apple',
                'screen' => '14',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Apple M4 series',
                'card' => 'Apple M4 GPU',
                'hard_drive' => 'SSD 1TB',
                'image' => '/img/SP_LT_macbook_air_13_m4_2025.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Macbook_pro_14_m4_space',
                'price' => 32000000,
                'old_price' => 36000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Apple',
                'screen' => '14',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Apple M3 series',
                'card' => 'Apple M4 GPU',
                'hard_drive' => 'SSD 1TB',
                'image' => '/img/SP_LT_macbook_pro_14_m4_space.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Macbook-air-m2-2022',
                'price' => 32000000,
                'old_price' => 36000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Apple',
                'screen' => '14',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Apple M2 series',
                'card' => 'Apple M4 GPU',
                'hard_drive' => 'SSD 1TB',
                'image' => '/img/SP_LT_macbook_air_13_m4_2025.png',
                'Hz' => '120'
            ],
            [
                'name' => 'Msi_modern',
                'price' => 32000000,
                'old_price' => 36000000,
                'rom' => ['256GB', '512GB'],
                'ram' => '16GB',
                'brand' => 'Msi',
                'screen' => '15',
                'battery' => 5000,
                'os' => 'Android',
                'cpu' => 'Intel Celeron',
                'hard_drive' => 'SSD 1TB',
                'card' => 'NVIDIA GeForce RTX Series',
                'image' => '/img/SP_LT_msi_modern.png',
                'Hz' => '120'
            ],

            // Thêm sản phẩm khác tại đây
        ];
        // Lấy filter từ query string
        $brand = $_GET['brand'] ?? 'all';
        $priceRange = $_GET['price'] ?? 'all';
        $Cpu = $_GET['cpu'] ?? 'all';
        $Ram = $_GET['ram'] ?? 'all';
        $Card = $_GET['card'] ?? 'all';
        $hard_drive = $_GET['hard_drive'] ?? 'all';
        $battery = $_GET['battery'] ?? 'all';
        $screen = $_GET['screen'] ?? 'all';
        $Hz = $_GET['hz'] ?? 'all';


        if ($brand !== 'all') {
            // Lọc danh sách brand
            $productslaptop = array_filter($productslaptop, function ($product) use ($brand) {
                return $product['brand'] === $brand;
            });
        }

        if ($priceRange !== 'all') {
            [$min, $max] = explode('-', $priceRange);
            $minPrice = (int) $min * 1000000;
            $maxPrice = (int) $max * 1000000;
            // Lọc danh sách theo khoảng giá
            $productslaptop = array_filter($productslaptop, function ($product) use ($minPrice, $maxPrice) {
                return $product['price'] >= $minPrice && $product['price'] <= $maxPrice;
            });
        }
        if ($Cpu !== 'all') {
            // Lọc danh sách theo CPU
            $productslaptop = array_filter($productslaptop, function ($product) use ($Cpu) {
                return $product['cpu'] === $Cpu;
            });
        }

        if ($Ram !== 'all') {
            // Lọc danh sách theo Ram
            $productslaptop = array_filter($productslaptop, function ($product) use ($Ram) {
                return $product['ram'] === $Ram;
            });
        }
       if ($Card !== 'all') {
            // Lọc danh sách theo Card
            $productslaptop = array_filter($productslaptop, function ($product) use ($Card) {
                return $product['card'] === $Card;
            });
        }
        if ($hard_drive !== 'all') {
            // Lọc danh sách theo Hard Drive
            $productslaptop = array_filter($productslaptop, function ($product) use ($hard_drive) {
                return $product['hard_drive'] === $hard_drive;
            });
        }
        if ($battery !== 'all' && strpos($battery, '-') !== false) { // Lọc theo Pin
            [$minBattery, $maxBattery] = explode('-', $battery);
            $minBattery = (int) $minBattery;
            $maxBattery = (int) $maxBattery;
            $productslaptop = array_filter($productslaptop, function ($product) use ($minBattery, $maxBattery) {
                return $product['battery'] >= $minBattery && $product['battery'] <= $maxBattery;
            });
        }
        
        if ($screen !== 'all' && strpos($screen, '-') !== false) { // Lọc theo màn hình
            [$minScreen, $maxScreen] = explode('-', $screen);
            $minScreen = (float) $minScreen;
            $maxScreen = (float) $maxScreen;
            $productslaptop = array_filter($productslaptop, function ($product) use ($minScreen, $maxScreen) {
                return $product['screen'] >= $minScreen && $product['screen'] <= $maxScreen;
            });
        }
        if ($Hz !== 'all') {
            // Lọc danh sách theo Hz
            $productslaptop = array_filter($productslaptop, function ($product) use ($Hz) {
                return $product['Hz'] === $Hz;
            });
        }
        View::render('productlaptop', ['products' => $productslaptop]);
    }
}

