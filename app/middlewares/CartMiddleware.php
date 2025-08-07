<?php

namespace App\Middlewares;

class CartMiddleware
{
    public static function validateQuantity($quantity)
    {
        if (!is_numeric($quantity) || $quantity < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'Số lượng không hợp lệ']);
            exit;
        }
    }

    public static function validateProductId($productId)
    {
        if (!is_numeric($productId) || $productId < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'ID sản phẩm không hợp lệ']);
            exit;
        }
    }

    public static function validateSkuId($skuId)
    {
        if (!is_numeric($skuId) || $skuId < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'SKU không hợp lệ']);
            exit;
        }
    }

    public static function ensureSession()
    {
        if (!session_id()) {
            session_start();
        }

        if (empty($_SESSION['user_id']) && empty(session_id())) {
            http_response_code(401);
            echo json_encode(['error' => 'Phiên làm việc không hợp lệ hoặc đã hết hạn']);
            exit;
        }
    }
}
