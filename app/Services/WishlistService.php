<?php

namespace App\Services;

use App\Models\WishlistModel;

class WishlistService
{
    private WishlistModel $wishlistModel;

    public function __construct(\PDO $pdo)
    {
        $this->wishlistModel = new WishlistModel($pdo);
    }

    public function getUserWishlist(int $userId): array
    {
        return $this->wishlistModel->getWishlistByUser($userId);
    }

    public function removeProduct(int $userId, int $productId): bool
    {
        return $this->wishlistModel->removeFromWishlist($userId, $productId);
    }

    public function updateUserAvatar(int $userId, array $file): bool
    {
        return $this->wishlistModel->updateUserAvatar($userId, $file);
    }

    public function toggleWishlist(int $userId, int $productId): array
    {
        // Kiểm tra sản phẩm đã có trong wishlist chưa
        $isInWishlist = $this->wishlistModel->isProductInWishlist($userId, $productId);

        if ($isInWishlist) {
            // Xóa khỏi wishlist
            $success = $this->wishlistModel->removeFromWishlist($userId, $productId);
            return [
                'success' => $success,
                'message' => $success ? 'Đã xóa sản phẩm khỏi wishlist.' : 'Không thể xóa sản phẩm khỏi wishlist.'
            ];
        } else {
            // Thêm vào wishlist
            $success = $this->wishlistModel->addToWishlist($userId, $productId);
            return [
                'success' => $success,
                'message' => $success ? 'Đã thêm sản phẩm vào wishlist.' : 'Không thể thêm sản phẩm vào wishlist.'
            ];
        }
    }

    // Hàm để check khi render view
    public function isProductInWishlist(int $userId, int $productId): bool
    {
        return $this->wishlistModel->isProductInWishlist($userId, $productId);
    }
}
