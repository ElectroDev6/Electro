<?php

namespace App\Models;

class WishlistModel
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy wishlist kèm hình ảnh mặc định
    public function getWishlistByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                w.product_id,
                p.name AS product_name,
                s.sku_id,
                p.slug,
                vi.image_set AS image_url,
                w.added_at
            FROM wishlist w
            JOIN products p ON w.product_id = p.product_id
            JOIN skus s ON p.product_id = s.product_id AND s.is_default = 1
            JOIN variant_images vi ON s.sku_id = vi.sku_id AND vi.is_default = 1
            WHERE w.user_id = :user_id
            ORDER BY w.added_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function removeFromWishlist(int $userId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM wishlist
            WHERE user_id = :user_id AND product_id = :product_id
        ");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function updateUserAvatar(int $userId, array $file): bool
    {
        if (!isset($file['avatar']) || $file['avatar']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $fileTmp = $file['avatar']['tmp_name'];
        $fileName = basename($file['avatar']['name']);
        $uploadDir = 'img/avatars/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($fileTmp, $targetPath)) return false;

        $stmt = $this->pdo->prepare("
            UPDATE users
            SET avatar_url = :avatar_url
            WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':avatar_url' => $targetPath,
            ':user_id' => $userId
        ]);
    }

    public function isProductInWishlist(int $userId, int $productId): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 1
                FROM wishlist
                WHERE user_id = :user_id AND product_id = :product_id
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId
            ]);
            return $stmt->fetch() !== false;
        } catch (\Exception $e) {
            error_log("WishlistModel: Error in isProductInWishlist - UserID: $userId, ProductID: $productId, Error: " . $e->getMessage());
            return false;
        }
    }

    public function addToWishlist(int $userId, int $productId): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO wishlist (user_id, product_id, added_at)
                VALUES (:user_id, :product_id, NOW())
            ");
            return $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId
            ]);
        } catch (\Exception $e) {
            error_log("WishlistModel: Error in addToWishlist - UserID: $userId, ProductID: $productId, Error: " . $e->getMessage());
            return false;
        }
    }
}
