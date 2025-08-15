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
    public function getWishlistByUser(int $userId): array
{
    $sql = "
        SELECT p.*
        FROM wishlist w
        JOIN products p ON w.product_id = p.id
        WHERE w.user_id = :user_id
        ORDER BY w.added_at DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
