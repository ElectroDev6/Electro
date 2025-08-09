<?php

namespace App\Controllers\Web;

use Core\View;

class HistoryController
{
    public function showHistory()
    {
        // Lấy trạng thái đơn hàng từ URL 
        $status = $_GET['status'] ?? 'all';

        // Dữ liệu giả 
        $allOrders = [
            [
                'id' => 'DH001',
                'date' => '2025-07-28',
                'status' => 'Chờ xác nhận',
                'status_class' => 'cho-xac-nhan',
                'total' => '1.200.000đ',
                'product' => [
                    'name' => 'Điện thoại iPhone 13',
                    'desc' => '128GB, Màu Đen',
                    'price_new' => '1.200.000đ',
                    'price_old' => '1.500.000đ',
                    'image' => 'https://cdn.tgdd.vn/Products/Images/42/228737/iphone-13-den-1.jpg'
                ]
            ],
            [
                'id' => 'DH002',
                'date' => '2025-07-27',
                'status' => 'Hoàn thành',
                'status_class' => 'hoan-thanh',
                'total' => '900.000đ',
                'product' => [
                    'name' => 'Tai nghe AirPods Pro',
                    'desc' => 'Chống ồn, Mới 100%',
                    'price_new' => '900.000đ',
                    'price_old' => '1.100.000đ',
                    'image' => 'https://cdn.tgdd.vn/Products/Images/54/228737/airpods-pro.jpg'
                ]
            ],
            [
                'id' => 'DH003',
                'date' => '2025-07-26',
                'status' => 'Đang giao',
                'status_class' => 'dang-giao',
                'total' => '2.000.000đ',
                'product' => [
                    'name' => 'Laptop ASUS VivoBook',
                    'desc' => 'Core i5, 512GB SSD',
                    'price_new' => '2.000.000đ',
                    'price_old' => '2.400.000đ',
                    'image' => 'https://cdn.tgdd.vn/Products/Images/44/228737/asus-vivobook.jpg'
                ]
            ]
        ];

        // Lọc đơn hàng 
        if ($status === 'all') {
            $filteredOrders = $allOrders;
        } else {
            $filteredOrders = array_filter($allOrders, function ($order) use ($status) {
                return $order['status_class'] === $status;
            });
        }

        // Render giao diện 
        View::render('history', [
            'orders' => $filteredOrders,
            'status' => $status
        ]);
    }
}
