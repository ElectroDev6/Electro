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

    private function sortGalleryImagesRecursively(&$data) {
        if (is_array($data)) {
            foreach ($data as &$item) {
                if (is_array($item)) {
                    if (isset($item['gallery_images']) && is_array($item['gallery_images'])) {
                        usort($item['gallery_images'], function ($a, $b) {
                            return $a['sort_order'] <=> $b['sort_order'];
                        });
                    }
                    $this->sortGalleryImagesRecursively($item);
                }
            }
        }
    }

    public function getAllProducts(): array
    {
        $sql = "SELECT 
            JSON_ARRAYAGG(
                JSON_OBJECT(
                    'product_id', p.id,
                    'product_name', p.name,
                    'description_html', p.description_html,
                    'category', JSON_OBJECT(
                        'id', c.id,
                        'name', c.name
                    ),
                    'variants', (
                        SELECT JSON_ARRAYAGG(
                            JSON_OBJECT(
                                'id', v.id,
                                'capacity_group', v.capacity_group,
                                'price', v.price,
                                'original_price', v.original_price,
                                'stock_quantity', v.stock_quantity,
                                'main_media', JSON_OBJECT(
                                    'url', v.media_url,
                                    'alt_text', v.media_alt
                                ),
                                'colors', (
                                    SELECT JSON_ARRAYAGG(
                                        JSON_OBJECT(
                                            'id', vc.id,
                                            'color_id', c2.id,
                                            'name', c2.name,
                                            'hex_code', c2.hex_code,
                                            'stock', vc.stock,
                                            'is_active', c2.is_active,
                                            'gallery_images', COALESCE(
                                                (
                                                    SELECT JSON_ARRAYAGG(
                                                        JSON_OBJECT(
                                                            'id', gci.id,
                                                            'url', gci.url,
                                                            'alt_text', gci.alt_text,
                                                            'sort_order', gci.sort_order
                                                        )
                                                    )
                                                    FROM group_color_img gci
                                                    WHERE gci.variant_color_id = vc.id
                                                ),
                                                JSON_ARRAY()
                                            )
                                        )
                                    )
                                    FROM variant_colors vc
                                    JOIN colors c2 ON vc.color_id = c2.id
                                    WHERE vc.variant_id = v.id
                                )
                            )
                        )
                        FROM variants v
                        WHERE v.product_id = p.id
                    )
                )
            ) AS products
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $products = json_decode($result['products'], true) ?: [];
        $this->sortGalleryImagesRecursively($products);
        return $products;
    }
}
