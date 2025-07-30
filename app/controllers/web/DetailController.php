<?php

namespace App\Controllers\Web;

use Core\View;
use App\Models\DetailModel;

class DetailController
{
    // private $detailModel;

    // public function __construct(\PDO $pdo)
    // {
    //     $this->detailModel = new DetailModel($pdo);
    // }

    public function showDetail($productId)
    {
        View::render(
            'detail',
            [
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
                ]
            ]
        );
    }

    // public function showDetail($productId)
    // {
    //     $productId = (int) $productId;

    //     if ($productId <= 0) {
    //         http_response_code(400);
    //         echo "Invalid product ID";
    //         return;
    //     }

    //     $product = $this->detailModel->getProductDetail($productId);

    //     if (!$product) {
    //         http_response_code(404);
    //         echo "Product not found";
    //         return;
    //     }

    //     // require_once BASE_PATH . '/app/views/web/detail.php';
    //     View::render('detail', ['product' => $product]);
    // }
}
