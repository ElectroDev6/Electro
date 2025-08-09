<?php
namespace App\Models;
use PDO;

class OrdersModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function sortGalleryImagesRecursively(&$data)
    {
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

    public function getAllOrders(): array
    {
        $sql = "
            SELECT 
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', o.id,
                        'order_date', o.order_date,
                        'buyer_note', o.buyer_note,
                        'admin_note', o.admin_note,
                        'status', o.status,
                        'payment_method', o.payment_method,
                        'payment_date', o.payment_date,
                        'user', JSON_OBJECT(
                            'id', u.id,
                            'username', u.username,
                            'full_name', u.full_name,
                            'phone', u.phone,
                            'role', u.role,
                            'created_at', u.created_at
                        ),
                        'address', JSON_OBJECT(
                            'id', ua.id,
                            'address_line', ua.address_line,
                            'ward', ua.ward,
                            'district', ua.district,
                            'city', ua.city,
                            'created_at', ua.created_at
                        ),
                        'totals', (
                            SELECT JSON_OBJECT(
                                'shipping_fee', ot.shipping_fee,
                                'discount_amount', ot.discount_amount,
                                'total_amount', ot.total_amount
                            )
                            FROM order_totals ot
                            WHERE ot.order_id = o.id
                        ),
                        'items', (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'id', oi.id,
                                    'quantity', oi.quantity,
                                    'variant_color', JSON_OBJECT(
                                        'id', vc.id,
                                        'variant', JSON_OBJECT(
                                            'id', v.id,
                                            'capacity_group', v.capacity_group,
                                            'price', v.price,
                                            'original_price', v.original_price,
                                            'stock_quantity', v.stock_quantity,
                                            'media_url', p.media_url,
                                            'media_alt', p.media_alt,
                                            'product', JSON_OBJECT(
                                                'id', p.id,
                                                'name', p.name,
                                                'description_html', p.description_html,
                                                'create_at', p.create_at,
                                                'update_date', p.update_date,
                                                'category', JSON_OBJECT(
                                                    'id', c.id,
                                                    'name', c.name
                                                )
                                            )
                                        ),
                                        'color', JSON_OBJECT(
                                            'id', col.id,
                                            'name', col.name,
                                            'hex_code', col.hex_code,
                                            'is_active', col.is_active,
                                            'stock', v.stock_quantity,
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
                                )
                            )
                            FROM order_items oi
                            JOIN variant_colors vc ON oi.variant_color_id = vc.id
                            JOIN variants v ON vc.variant_id = v.id
                            JOIN products p ON v.product_id = p.id
                            JOIN categories c ON p.category_id = c.id
                            JOIN colors col ON vc.color_id = col.id
                            WHERE oi.order_id = o.id
                        ),
                        'timeline', (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'id', otl.id,
                                    'status', otl.status,
                                    'timestamp', otl.timestamp,
                                    'note', otl.note
                                )
                            )
                            FROM order_timeline otl
                            WHERE otl.order_id = o.id
                        )
                    )
                ) AS orders
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            LEFT JOIN user_addresses ua ON o.user_address_id = ua.id
        ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $orders = json_decode($result['orders'], true) ?: [];
            $this->sortGalleryImagesRecursively($orders);
            return $orders;
    }


    public function update($id, $data)
    {
        try {
            $set = [];
            $params = [':id' => $id];
            foreach ($data as $key => $value) {
                $set[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql = "UPDATE orders SET " . implode(', ', $set) . " WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating comment: " . $e->getMessage());
            return false;
        }
    }
}
?>