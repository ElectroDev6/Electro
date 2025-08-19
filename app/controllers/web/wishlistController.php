<?php

namespace App\Controllers\Web;

use Core\View;
use App\Services\WishlistService;

class WishlistController
{
    private WishlistService $wishlistService;

    public function __construct(\PDO $pdo)
    {
        $this->wishlistService = new WishlistService($pdo);
    }

    public function showWishlist()
    {
        $userId = $_SESSION['user_id'] ?? 1; // giả lập user login
        $wishlist = $this->wishlistService->getUserWishlist($userId);

        View::render('wishlist', [
            'wishlist' => $wishlist,
            'user' => $_SESSION['user'] ?? []
        ]);
    }

    public function removeProduct()
    {
        $userId = $_SESSION['user_id'] ?? 1;
        $productId = $_POST['product_id'] ?? null;

        if ($productId) {
            $this->wishlistService->removeProduct($userId, (int)$productId);
        }

        header("Location: /wishlist");
        exit;
    }

    public function uploadAvatar()
    {
        $userId = $_SESSION['user_id'] ?? 1;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $this->wishlistService->updateUserAvatar($userId, $_FILES);
        }

        header("Location: /wishlist");
        exit;
    }
}
