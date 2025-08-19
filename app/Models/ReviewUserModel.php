<?php

namespace App\Models;

use PDO;
use PDOException;

class ReviewUserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getReviewUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        if ($stmt->fetchColumn() == 0) {
            return []; 
        }

        try {
            $query = "
                SELECT 
                    r.review_id,
                    r.user_id,
                    r.product_id,
                    r.parent_review_id,
                    r.rating,
                    r.comment_text,
                    r.status,
                    r.review_date,
                    r.is_viewed,
                    r.created_at,
                    r.updated_at,
                    u.name AS user_name,
                    u.email AS user_email,
                    pr.user_id AS parent_user_id,
                    pu.name AS parent_user_name,
                    pu.email AS parent_user_email,
                    p.name AS product_name,
                    p.slug AS product_slug
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.user_id
                LEFT JOIN reviews pr ON r.parent_review_id = pr.review_id
                LEFT JOIN users pu ON pr.user_id = pu.user_id
                LEFT JOIN products p ON r.product_id = p.product_id
                WHERE r.user_id = :userId OR pr.user_id = :userId
                ORDER BY r.review_date DESC
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error in getReviewUser: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
    }
}