<?php

namespace App\Services;

use PDO;

class WishlistService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addToWishlist(int $userId, int $productId): bool
    {
        $sql = "INSERT INTO wishlist (user_id, product_id, added_at) VALUES (:user_id, :product_id, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }
}
