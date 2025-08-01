<?php

namespace App\Models;

class Product
{

    public static function getById(int $id): ?array
    {
        $products = [
            1 => ['name' => 'Sản phẩm A', 'image' => '/img/product1.webp', 'color' => 'Trắng', 'price_current' => 100000000, 'price_original' => 1500],
            2 => ['name' => 'Sản phẩm B', 'image' => '/img/product1.webp', 'color' => 'Đen', 'price_current' => 1000, 'price_original' => 1500],
            3 => ['name' => 'Sản phẩm C', 'image' => '/img/product1.webp', 'color' => 'Xám', 'price_current' => 1000, 'price_original' => 1500],
            4 => ['name' => 'Sản phẩm D', 'image' => '/img/product1.webp', 'color' => 'Xanh', 'price_current' => 1000, 'price_original' => 1500],
        ];
        return $products[$id] ?? null;
    }
}
