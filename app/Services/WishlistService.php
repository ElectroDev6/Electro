<?php
namespace App\Services;

use App\Models\WishlistModel;

class WishlistService {
    private WishlistModel $wishlistModel;

    public function __construct(\PDO $pdo) {
        $this->wishlistModel = new WishlistModel($pdo);
    }

    public function getUserWishlist(int $userId): array {
        return $this->wishlistModel->getWishlistByUser($userId);
    }

    public function removeProduct(int $userId, int $productId): bool {
        return $this->wishlistModel->removeFromWishlist($userId, $productId);
    }

    public function updateUserAvatar(int $userId, array $file): bool {
        return $this->wishlistModel->updateUserAvatar($userId, $file);
    }
}