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
}
