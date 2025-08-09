<?php

namespace App\Controllers\Web;

use App\Services\WishlistService;
use Core\View;
use PDO;

require_once BASE_PATH . '/app/services/WishlistService.php';

class WishlistController
{
    private $wishlistService;
    public function __construct(\PDO $pdo)
    {
        $this->wishlistService = new WishlistService($pdo);
    }
    public function Wishlish()
    {
        $userId = $_SESSION['user_id'] ?? null; // hoặc Auth::id() nếu có
        $productId = $_GET['product_id'] ?? null; // hoặc lấy từ request

        if (!$userId || !$productId) {
            die('Missing user or product ID');
        }

        $this->wishlistService->addToWishlist($userId, $productId);

        $wishlist = []; // bạn có thể lấy danh sách từ DB nếu muốn




        View::render('wishlist', [
            'wishlist' => $wishlist,
        ]);
    }
}
