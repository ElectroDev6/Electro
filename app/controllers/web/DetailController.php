<?php

namespace App\Controllers\Web;

use App\Models\Web\DetailModel;

class DetailController
{
    private $detailModel;

    public function __construct(\PDO $pdo)
    {
        $this->detailModel = new DetailModel($pdo);
    }

    public function detail()
    {
        // Lấy product_id từ URL (giả sử URL là /detail/1)
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($productId <= 0) {
            http_response_code(400);
            echo "Invalid product ID";
            return;
        }

        // Gọi model để lấy dữ liệu sản phẩm
        $product = $this->detailModel->getProductDetail($productId);

        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            return;
        }

        // Hiển thị dữ liệu (có thể thay bằng view template)
        echo json_encode($product);

        require_once BASE_PATH . '/app/views/detail.php';
    }
}
