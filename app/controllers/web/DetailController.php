<?php

namespace App\Controllers\Web;

use Core\View;
use App\Models\DetailModel;

class DetailController
{
    private $detailModel;

    public function __construct(\PDO $pdo)
    {
        $this->detailModel = new DetailModel($pdo);
    }

    public function detail($productId)
    {
        $productId = (int) $productId;

        if ($productId <= 0) {
            http_response_code(400);
            echo "Invalid product ID";
            return;
        }

        $product = $this->detailModel->getProductDetail($productId);

        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            return;
        }

        // require_once BASE_PATH . '/app/views/web/detail.php';
        View::render('detail', ['product' => $product]);
    }
}
