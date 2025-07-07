<?php

namespace App\Models\Web;

use PDO;
use PDOException;


class DetailModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProductDetail(int $productId)
    {
        try {
            $sql = "SELECT 
                p.id, p.name, p.price, p.stock_quantity, p.created_at,
                c.name AS category_name, b.name AS brand_name,
                pd.description, pp.promotion_details, ppo.offer_details, pg.gift_details,
                r.rating, r.comment, pv.variant_details, pi.image_url
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            LEFT JOIN product_descriptions pd ON p.id = pd.product_id
            LEFT JOIN product_promotions pp ON p.id = pp.product_id
            LEFT JOIN product_payment_offers ppo ON p.id = ppo.product_id
            LEFT JOIN product_gifts pg ON p.id = pg.product_id
            LEFT JOIN reviews r ON p.id = r.product_id
            LEFT JOIN product_variants pv ON p.id = pv.product_id
            LEFT JOIN product_images pi ON p.id = pi.product_id
            WHERE p.id = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Xử lý lỗi (có thể log lỗi thay vì echo)
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
