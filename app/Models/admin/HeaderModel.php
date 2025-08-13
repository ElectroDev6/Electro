<?php
namespace App\Models\admin;

use PDO;
use PDOException;

class HeaderModel
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchAllNotificationsInfo()
{
    $sql = "
        SELECT 
            r.review_id,
            r.user_id,
            u.name AS user_name,
            r.product_id,
            p.name AS product_name,
            r.comment_text,
            r.rating,
            r.status,
            r.is_viewed,
            r.review_date
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        JOIN products p ON r.product_id = p.product_id
        WHERE r.is_viewed = 0
        ORDER BY r.review_date DESC
        LIMIT 10
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>