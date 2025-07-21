<?php

namespace App\Models;

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
            // Lấy thông tin cơ bản của sản phẩm
            $sql = "SELECT 
                p.product_id, 
                p.name, 
                p.created_at,
                c.type AS category_name, 
                b.name AS brand_name,
                b.description AS brand_description,
                b.logo_url AS brand_logo
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            LEFT JOIN brands b ON p.brand_id = b.brand_id
            WHERE p.product_id = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return null;
            }

            // Lấy thông tin variants (giá, màu, dung lượng, tồn kho)
            $product['variants'] = $this->getProductVariants($productId);

            // Lấy hình ảnh sản phẩm
            $product['images'] = $this->getProductImages($productId);

            // Lấy mô tả sản phẩm
            $product['descriptions'] = $this->getProductDescriptions($productId);

            // Lấy thông số kỹ thuật
            $product['specifications'] = $this->getProductSpecifications($productId);

            // Lấy thông tin khuyến mãi
            $product['promotions'] = $this->getProductPromotions($productId);

            // Lấy thông tin bảo hành
            $product['warranty'] = $this->getProductWarranty($productId);

            // Lấy đánh giá
            $product['reviews'] = $this->getProductReviews($productId);

            // Lấy thông tin giá và tồn kho từ variant đầu tiên (hoặc variant mặc định)
            if (!empty($product['variants'])) {
                $defaultVariant = $product['variants'][0];
                $product['price'] = $defaultVariant['final_price'];
                $product['original_price'] = $defaultVariant['original_price'];
                $product['stock_quantity'] = $defaultVariant['stock_quantity'];
                $product['discount_percentage'] = $defaultVariant['discount_percentage'];
            }

            // Lấy hình ảnh đầu tiên làm hình đại diện
            if (!empty($product['images'])) {
                $product['image_url'] = $product['images'][0]['url'];
            }

            return $product;
        } catch (PDOException $e) {
            error_log("Error in getProductDetail: " . $e->getMessage());
            return null;
        }
    }

    private function getProductVariants(int $productId): array
    {
        try {
            $sql = "SELECT 
                pv.variant_id,
                pv.original_price,
                pv.discount_percentage,
                pv.stock_quantity,
                pv.is_available,
                c.name AS color_name,
                c.hex_code AS color_hex,
                so.capacity AS storage_capacity,
                CASE 
                    WHEN pv.discount_percentage > 0 THEN 
                        pv.original_price * (1 - pv.discount_percentage / 100)
                    ELSE pv.original_price
                END AS final_price
            FROM product_variants pv
            LEFT JOIN colors c ON pv.color_id = c.color_id
            LEFT JOIN storage_options so ON pv.storage_id = so.storage_id
            WHERE pv.product_id = :product_id
            ORDER BY pv.variant_id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductVariants: " . $e->getMessage());
            return [];
        }
    }

    private function getProductImages(int $productId): array
    {
        try {
            $sql = "SELECT 
                media_id,
                url,
                alt_text,
                media_type,
                display_order
            FROM product_media
            WHERE product_id = :product_id
            ORDER BY display_order";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductImages: " . $e->getMessage());
            return [];
        }
    }

    private function getProductDescriptions(int $productId): array
    {
        try {
            $sql = "SELECT 
                pd.title,
                pd.display_order,
                pdc.content_text,
                pdc.content_order
            FROM product_descriptions pd
            LEFT JOIN product_description_content pdc ON pd.product_description_id = pdc.product_description_id
            WHERE pd.product_id = :product_id
            ORDER BY pd.display_order, pdc.content_order";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductDescriptions: " . $e->getMessage());
            return [];
        }
    }

    private function getProductSpecifications(int $productId): array
    {
        try {
            $sql = "SELECT 
                spec_group,
                spec_name,
                spec_value,
                display_order
            FROM product_specifications
            WHERE product_id = :product_id
            ORDER BY display_order";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductSpecifications: " . $e->getMessage());
            return [];
        }
    }

    private function getProductPromotions(int $productId): array
    {
        try {
            $sql = "SELECT 
                name,
                description,
                promotion_type,
                discount_value,
                start_date,
                end_date,
                is_active,
                terms_conditions
            FROM product_promotions
            WHERE product_id = :product_id 
            AND is_active = 1
            AND start_date <= NOW() 
            AND end_date >= NOW()
            ORDER BY start_date DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductPromotions: " . $e->getMessage());
            return [];
        }
    }

    private function getProductWarranty(int $productId): array
    {
        try {
            $sql = "SELECT 
                name,
                description,
                original_price,
                current_price,
                duration_months,
                coverage
            FROM warranty
            WHERE product_id = :product_id
            ORDER BY duration_months";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductWarranty: " . $e->getMessage());
            return [];
        }
    }

    private function getProductReviews(int $productId): array
    {
        try {
            $sql = "SELECT 
                r.review_id,
                r.rating,
                r.title,
                r.review_content,
                r.is_verified_purchase,
                r.helpful_count,
                r.created_at,
                u.username
            FROM reviews r
            LEFT JOIN users u ON r.user_id = u.user_id
            WHERE r.product_id = :product_id 
            AND r.status = 'approved'
            ORDER BY r.created_at DESC
            LIMIT 10";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getProductReviews: " . $e->getMessage());
            return [];
        }
    }

    // Thêm method để lấy thống kê đánh giá
    public function getProductRatingStats(int $productId): array
    {
        try {
            $sql = "SELECT 
                COUNT(*) as total_reviews,
                AVG(rating) as average_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
            FROM reviews
            WHERE product_id = :product_id 
            AND status = 'approved'";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Error in getProductRatingStats: " . $e->getMessage());
            return [];
        }
    }
}
