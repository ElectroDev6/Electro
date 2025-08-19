<?php
namespace App\Models\Admin;

use PDO;
use PDOException;

class NotificationsModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getNotificationBell()
    {
        try {
            $query = "
                SELECT r.*, p.name AS product_name, u.name AS user_name
                FROM reviews r
                LEFT JOIN products p ON r.product_id = p.product_id
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE r.parent_review_id IS NULL
                ORDER BY r.review_date DESC
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            throw new \Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
        }
    }

    public function getNotificationMessage($user_id)
    {
        try {
            // Kiểm tra tham số user_id
            if (empty($user_id)) {
                return [];
            }

            // Bước 1: Lấy các review_id của review gốc do user_id tạo
            $parentQuery = "
                SELECT review_id
                FROM reviews
                WHERE user_id = :user_id AND parent_review_id IS NULL
            ";
            $parentStmt = $this->pdo->prepare($parentQuery);
            $parentStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $parentStmt->execute();
            $parentReviews = $parentStmt->fetchAll(PDO::FETCH_COLUMN, 0); // Lấy cột review_id

            if (empty($parentReviews)) {
                return [];
            }

            // Bước 2: Lấy các review phản hồi dựa trên parent_review_id
            $placeholders = implode(',', array_fill(0, count($parentReviews), '?'));
            $query = "
                SELECT r.*, p.name AS product_name, u.name AS user_name
                FROM reviews r
                LEFT JOIN products p ON r.product_id = p.product_id
                LEFT JOIN users u ON r.user_id = u.user_id
                WHERE r.parent_review_id IN ($placeholders)
                ORDER BY r.review_date DESC
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($parentReviews);
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            throw new \Exception('Lỗi truy vấn cơ sở dữ liệu: ' . $e->getMessage());
        }
    }

}