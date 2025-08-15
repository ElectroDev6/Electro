<?php

namespace App\Controllers\Web;

use App\Services\WishlistService;
use Core\View;

require_once BASE_PATH . '/app/services/WishlistService.php';

class WishlistController
{
    private $wishlistService;
    public function __construct(\PDO $pdo)
    {
        $this->wishlistService = new WishlistService($pdo);
    }
    public function wishlist()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $productId = $_REQUEST['product_id'] ?? null; // lấy cả GET và POST

        if (!$userId || !$productId) {
            die('Missing user or product ID');
        }


        $this->wishlistService->addToWishlist($userId, $productId);

        // Lấy danh sách wishlist từ DB
        $wishlist = $this->wishlistService->getWishlistByUser($userId);

        View::render('wishlist', [
            'wishlist' => $wishlist,
        ]); 
    }

}
