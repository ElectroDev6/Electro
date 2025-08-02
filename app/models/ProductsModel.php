<?php
namespace App\Models;
use PDO;

class ProductsModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProducts() {
        try {
            $sql = "SELECT 
                p.id AS product_id,
                p.name AS 'Tên',
                c.name AS 'Danh mục',
                CONCAT(FORMAT(v.price, 0), 'đ') AS 'Giá',
                v.stock_quantity AS 'Số lượng',
                p.media_url AS 'media_url',
                p.media_alt AS 'media_alt'
            FROM 
                products p
                INNER JOIN categories c ON p.category_id = c.id
                LEFT JOIN variants v ON p.id = v.product_id
                AND v.id = (
                    SELECT MIN(id) 
                    FROM variants 
                    WHERE product_id = p.id
                )
            WHERE 
                v.id IS NOT NULL OR p.id IS NOT NULL
            ORDER BY 
                p.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to fetch products');
        }
    }

    public function getProductById($id)
    {
        try {
            // Lấy thông tin sản phẩm cơ bản
            $sql = "
                SELECT 
                    p.id AS product_id,
                    p.name AS product_name,
                    p.description_html,
                    c.id AS category_id,
                    c.name AS category_name
                FROM 
                    products p
                    INNER JOIN categories c ON p.category_id = c.id
                WHERE 
                    p.id = :id
                LIMIT 1
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return [];
            }

            // Lấy các biến thể sản phẩm
            $sql = "SELECT * FROM variants WHERE product_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($variants as &$variant) {
                // Lấy màu sắc của biến thể
                $sql = "
                    SELECT 
                        col.id AS color_id,
                        col.name AS color_name,
                        col.hex_code,
                        col.is_active,
                        vc.id AS variant_color_id
                    FROM 
                        variant_colors vc
                        JOIN colors col ON vc.color_id = col.id
                    WHERE 
                        vc.variant_id = :variant_id
                ";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':variant_id', $variant['id'], PDO::PARAM_INT);
                $stmt->execute();
                $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($colors as &$color) {
                    // Lấy ảnh của từng màu sắc
                    $sql = "
                        SELECT 
                            gci.url AS gallery_image_url,
                            gci.alt_text AS gallery_image_alt,
                            gci.sort_order
                        FROM 
                            group_color_img gci
                        WHERE 
                            gci.variant_color_id = :variant_color_id
                        ORDER BY gci.sort_order ASC
                    ";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindValue(':variant_color_id', $color['variant_color_id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $color['images'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $variant['colors'] = $colors;
            }
            $product['variants'] = $variants;

            return $product;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to fetch product by ID');
        }
    }

}   
