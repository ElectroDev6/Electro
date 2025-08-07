<?php
namespace App\Models\admin;
use PDO;

class ProductsModel 
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

   public function fetchAllProducts()
{
    try {
        $sql = "SELECT 
            p.product_id,
            p.name AS product_name,
            p.description,
            p.base_price,
            p.slug,
            p.is_featured,
            p.created_at,
            p.updated_at,
            b.name AS brand_name,
            b.logo_url AS brand_logo_url,
            s.name AS subcategory_name,
            c.name AS category_name,
            c.image AS category_image,
            c.slug AS category_slug,
            first_sku.sku_id,
            first_sku.sku_code,
            first_sku.price AS sku_price,
            first_sku.stock_quantity,
            first_sku.is_active,
            vi.image_id,
            vi.default_url,
            vi.thumbnail_url,
            vi.gallery_url
        FROM products p
        LEFT JOIN brands b ON p.brand_id = b.brand_id
        LEFT JOIN subcategories s ON p.subcategory_id = s.subcategory_id
        LEFT JOIN categories c ON s.category_id = c.category_id
        LEFT JOIN (
            SELECT sk.*, 
                   ROW_NUMBER() OVER (PARTITION BY sk.product_id ORDER BY sk.sku_id) as rn
            FROM skus sk
        ) first_sku ON p.product_id = first_sku.product_id AND first_sku.rn = 1
        LEFT JOIN variant_images vi ON first_sku.sku_id = vi.sku_id AND vi.is_default = 1
        ORDER BY p.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } catch (PDOException $e) {
        error_log("Lỗi khi lấy danh sách sản phẩm: " . $e->getMessage());
        return [
            'products' => [],
        ];
    }
}
}
