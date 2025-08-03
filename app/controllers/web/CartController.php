<?php

namespace App\Controllers\Web;

use App\Services\CartService;
use Core\View;

class CartController
{
    private $cartService;

    public function __construct(\PDO $pdo)
    {
        $this->cartService = new CartService($pdo); // Truyền $pdo vào CartService
    }

    public function showCart()
    {
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
        error_log("CartController: UserID: " . ($userId ?? 'null') . ", SessionID: $sessionId");
        $cart = $this->cartService->getCart($userId, $sessionId);

        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // exit;

        View::render('cart', ['cart' => $cart]);
    }
}
