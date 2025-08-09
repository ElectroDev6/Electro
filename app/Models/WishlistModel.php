<?php

namespace App\Models;

use PDO;

class ProductModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Lấy danh sách sản phẩm trong wishlist của người dùng.
     *
     * @param int $userId ID của người dùng.
     * @param int $limit Giới hạn số lượng sản phẩm trả về.
     * @return array Mảng các sản phẩm trong wishlist.
     */
    public function getWishListProductsByUserId(int $userId, int $limit = 8, int $page = 1): array
    {
        $offset = ($page - 1) * $limit;

        $sql = "
        SELECT ...
        FROM wishlist w
        JOIN products p ON w.product_id = p.product_ids
        ...
        WHERE w.user_id = :user_id
        LIMIT :limit OFFSET :offset
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
