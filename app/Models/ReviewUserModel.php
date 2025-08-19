<?php

namespace App\Models;

use PDO;

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
        $query = "
            SELECT 
                r.review_id,
                r.user_id,
                r.product_id,
                r.user_name,
                r.email,
                r.parent_review_id,
                r.rating,
                r.comment_text,
                r.status,
                r.review_date,
                r.is_viewed,
                r.created_at,
                r.updated_at,
                u.name AS user_name_from_users_table,
                u.email AS user_email_from_users_table,
                pr.user_id AS parent_user_id,
                pr.user_name AS parent_user_name,
                pu.name AS parent_user_name_from_users_table,
                pu.email AS parent_user_email_from_users_table,
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

        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reviews ?: [];
    }


}
