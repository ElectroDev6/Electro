<?php
namespace App\Models\admin;
use PDO;

class ReviewsModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllReviews(array $filters, int $limit, int $offset): array
    {
        $sql = "SELECT r.*, u.name AS user_name, u.avatar_url AS user_avatar, p.name AS product_name
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                JOIN products p ON r.product_id = p.product_id 
                WHERE r.parent_review_id IS NULL";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE :search OR p.name LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['rating'])) {
            $sql .= " AND r.rating = :rating";
            $params[':rating'] = $filters['rating'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND r.status = :status";
            $params[':status'] = $filters['status'];
        }
        if (!empty($filters['date_range'])) {
            if ($filters['date_range'] === 'last_7_days') {
                $sql .= " AND r.review_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            } elseif ($filters['date_range'] === 'last_30_days') {
                $sql .= " AND r.review_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            }
        }

        $sql .= " ORDER BY r.review_date DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalReviews(array $filters): int
    {
        $sql = "SELECT COUNT(*) 
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                JOIN products p ON r.product_id = p.product_id 
                WHERE r.parent_review_id IS NULL";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE :search OR p.name LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }
        if (!empty($filters['rating'])) {
            $sql .= " AND r.rating = :rating";
            $params[':rating'] = $filters['rating'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND r.status = :status";
            $params[':status'] = $filters['status'];
        }
        if (!empty($filters['date_range'])) {
            if ($filters['date_range'] === 'last_7_days') {
                $sql .= " AND r.review_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            } elseif ($filters['date_range'] === 'last_30_days') {
                $sql .= " AND r.review_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
            }
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getReviewWithReplies(int $id)
    {
        $sql = "SELECT r.*, u.name AS user_name, u.avatar_url AS user_avatar, p.product_id, p.name AS product_name, u.role, 
                    s.price, vi.image_set AS product_image
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                JOIN products p ON r.product_id = p.product_id 
                LEFT JOIN skus s ON p.product_id = s.product_id AND s.is_default = 1
                LEFT JOIN variant_images vi ON s.sku_id = vi.sku_id AND vi.is_default = 1
                WHERE r.review_id = :id AND r.parent_review_id IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$review) {
            return null;
        }
        
        $review['replies'] = $this->getNestedReplies($id);
        return $review;
    }

    private function getNestedReplies(int $parentId): array
    {
        $sql = "SELECT r.*, u.name AS user_name, u.avatar_url AS user_avatar, p.product_id, p.name AS product_name, u.role,
                    s.price, vi.image_set AS product_image
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                LEFT JOIN products p ON r.product_id = p.product_id 
                LEFT JOIN skus s ON p.product_id = s.product_id AND s.is_default = 1
                LEFT JOIN variant_images vi ON s.sku_id = vi.sku_id AND vi.is_default = 1
                WHERE r.parent_review_id = :parent_id 
                ORDER BY r.review_date ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':parent_id', $parentId, PDO::PARAM_INT);
        $stmt->execute();
        $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($replies as &$reply) {
            $reply['replies'] = $this->getNestedReplies($reply['review_id']);
        }

        return $replies;
    }

    public function createReplyReview($userId, $productId, $parentId, $commentText)
    {
        $sql = "INSERT INTO reviews (user_id, product_id, parent_review_id, comment_text, status, review_date, created_at, updated_at) 
                VALUES (:user_id, :product_id, :parent_review_id, :comment_text, 'approved', NOW(), NOW(), NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':parent_review_id', $parentId, is_null($parentId) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':comment_text', $commentText);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function updateReviewStatus(int $reviewId, string $status)
    {
        $sql = "UPDATE reviews SET status = :status, updated_at = NOW() WHERE review_id = :review_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':review_id', $reviewId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteReview(int $reviewId)
    {
        $sql = "DELETE FROM reviews WHERE review_id = :review_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':review_id', $reviewId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getReviewById(int $reviewId)
    {
        $sql = "SELECT * FROM reviews WHERE review_id = :review_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':review_id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateViewed($id)
    {
        $stmt = $this->pdo->prepare("UPDATE reviews SET is_viewed = 1 WHERE review_id = ?");
        return $stmt->execute([$id]);
    }


}