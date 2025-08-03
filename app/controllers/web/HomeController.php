<?php

namespace App\Controllers\Web;

use Core\View;

class HomeController
{
    public function index()
    {
        View::render('home', [
            'products' => [
                ['id' => 1, 'name' => 'Sản phẩm A', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 2, 'name' => 'Sản phẩm B', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 3, 'name' => 'Sản phẩm C', 'price' => 1000, 'image' => '/img/product1.webp'],
                ['id' => 4, 'name' => 'Sản phẩm D', 'price' => 1000, 'image' => '/img/product1.webp'],
            ],
            // Thêm mảng sản phẩm sale
            'saleProducts' => [
                [
                    'id' => 11,
                    'name' => 'Camera giám sát 3MP',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Camera giám sát IP 3MP 365 Selection C1Camera giám sát IP 3MP 365 Selection C1'
                ],
                [
                    'id' => 12,
                    'name' => 'Laptop Aspire',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Laptop giá tốt cuối tuần'
                ],
                [
                    'id' => 13,
                    'name' => 'Tủ lạnh mini',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tủ lạnh nhỏ gọn cho gia đình'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
                [
                    'id' => 15,
                    'name' => 'Ấm siêu tốc',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Ấm đun nước inox'
                ],
            ],

            'featuredProduct' => [
                'image' => '/img/tv-lg-nano.webp',
                'name' => 'LG Smart TV NanoCell 65 inch 4K 65NANO81TSA',
                'price' => 15490000,
            ],

            'regularProducts' => [
                [
                    'id' => 11,
                    'name' => 'Camera giám sát 3MP',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Camera giám sát IP 3MP 365 Selection C1Camera giám sát IP 3MP 365 Selection C1'
                ],
                [
                    'id' => 12,
                    'name' => 'Laptop Aspire',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Laptop giá tốt cuối tuần'
                ],
                [
                    'id' => 13,
                    'name' => 'Tủ lạnh mini',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tủ lạnh nhỏ gọn cho gia đình'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
                [
                    'id' => 15,
                    'name' => 'Ấm siêu tốc',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Ấm đun nước inox'
                ],
                [
                    'id' => 12,
                    'name' => 'Laptop Aspire',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Laptop giá tốt cuối tuần'
                ],
                [
                    'id' => 13,
                    'name' => 'Tủ lạnh mini',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tủ lạnh nhỏ gọn cho gia đình'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
            ],

            'audioProducts' => [
                [
                    'id' => 20,
                    'name' => 'Camera giám sát 3MP',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Camera giám sát IP 3MP 365 Selection C1Camera giám sát IP 3MP 365 Selection C1'
                ],
                [
                    'id' => 12,
                    'name' => 'Laptop Aspire',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Laptop giá tốt cuối tuần'
                ],
                [
                    'id' => 13,
                    'name' => 'Tủ lạnh mini',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tủ lạnh nhỏ gọn cho gia đình'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
                [
                    'id' => 14,
                    'name' => 'Tivi 32 inch',
                    'image' => '/img/product1.webp',
                    'price' => 1390000,
                    'old_price' => 2390000,
                    'discount' => 64,
                    'description' => 'Tivi giá rẻ full HD'
                ],
            ],
            'accessories' => [
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ],
                [
                    'id' => 20,
                    'name' => 'Phụ kiện Apple',
                    'image' => '/img/HAVIT-TW903.webp',
                ]
            ]
        ]);
    }
}
