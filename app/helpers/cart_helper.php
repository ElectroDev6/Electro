<?php

use App\Services\CartService;

$pdo = \Container::get('pdo');

if (!function_exists('get_cart_count')) {
    function get_cart_count($pdo): int
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        $cartService = new CartService($pdo);
        return $cartService->getCartItemCount($userId, $sessionId);
    }
}
