<?php

namespace App\Models\admin;

use PDO;
use PDOException;

class OrdersModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllOrders(array $filters = [], int $limit = 8, int $offset = 0): array
    {
        try {
            $query = "
                SELECT o.order_id, o.order_code, o.status, o.total_price, o.created_at,
                       COALESCE(c.code, 'N/A') AS coupon_code, COALESCE(p.payment_method, 'N/A') AS payment_method,
                       COALESCE(p.status, 'N/A') AS payment_status,
                       COALESCE((SELECT SUM(oi.quantity * oi.price) FROM order_items oi WHERE oi.order_id = o.order_id), 0) AS calculated_total
                FROM orders o
                LEFT JOIN coupons c ON o.coupon_id = c.coupon_id
                LEFT JOIN (
                    SELECT p1.order_id, p1.payment_method, p1.status
                    FROM payments p1
                    INNER JOIN (
                        SELECT order_id, MAX(payment_id) AS max_payment_id
                        FROM payments
                        GROUP BY order_id
                    ) p2 ON p1.order_id = p2.order_id AND p1.payment_id = p2.max_payment_id
                ) p ON o.order_id = p.order_id
                WHERE 1=1
            ";
            $params = [];

            if (!empty($filters['status'])) {
                $query .= " AND o.status = :status";
                $params[':status'] = $filters['status'];
            }
            if (!empty($filters['order_code'])) {
                $query .= " AND o.order_code LIKE :order_code";
                $params[':order_code'] = '%' . $filters['order_code'] . '%';
            }
            if (!empty($filters['created_at'])) {
                $query .= " AND DATE(o.created_at) = :created_at";
                $params[':created_at'] = $filters['created_at'];
            }

            $query .= " ORDER BY o.created_at DESC LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)$limit;
            $params[':offset'] = (int)$offset;

            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orders as &$order) {
                if ($order['calculated_total'] !== null && abs($order['calculated_total'] - $order['total_price']) > 0.01) {
                    $updateStmt = $this->pdo->prepare("UPDATE orders SET total_price = :total WHERE order_id = :order_id");
                    $updateStmt->execute([':total' => $order['calculated_total'], ':order_id' => $order['order_id']]);
                    $order['total_price'] = $order['calculated_total'];
                }
            }
            unset($order);

            return $orders;
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderById(int $order_id): ?array
    {
        try {
            $sql = "
                SELECT 
                    o.order_id,
                    o.order_code,
                    o.status,
                    o.total_price,
                    o.created_at,
                    o.updated_at,
                    u.name AS username,
                    u.phone_number,
                    u.email,
                    CONCAT(ua.address, ', ', ua.ward_commune, ', ', ua.district, ', ', ua.province_city) AS full_address,
                    p.payment_method,
                    p.status AS payment_status,
                    c.code AS coupon_code,
                    c.discount_percent AS coupon_discount
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.user_id
                LEFT JOIN user_address ua ON o.user_address_id = ua.user_address_id
                LEFT JOIN payments p ON o.order_id = p.order_id
                LEFT JOIN coupons c ON o.coupon_id = c.coupon_id
                WHERE o.order_id = :order_id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['order_id' => $order_id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$order) {
                return null;
            }
            $sql_items = "
                SELECT 
                    oi.quantity,
                    oi.price,
                    p.name AS product_name,
                    s.sku_code,
                    b.name AS brand_name,
                    vi.image_set AS image_path
                FROM order_items oi
                JOIN skus s ON oi.sku_id = s.sku_id
                JOIN products p ON s.product_id = p.product_id
                JOIN brands b ON p.brand_id = b.brand_id
                LEFT JOIN variant_images vi ON s.sku_id = vi.sku_id AND vi.is_default = 1
                WHERE oi.order_id = :order_id
            ";

            $stmt_items = $this->pdo->prepare($sql_items);
            $stmt_items->execute(['order_id' => $order_id]);
            $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

            // Gán danh sách sản phẩm vào mảng đơn hàng
            $order['order_items'] = $order_items;

            // Tính toán tổng tiền tạm tính
            $subtotal = 0;
            foreach ($order_items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $order['calculated_total'] = $subtotal;

            // Tính toán tổng tiền sau giảm giá
            $discountAmount = 0;
            if (!empty($order['coupon_discount'])) {
                $discountAmount = $subtotal * ($order['coupon_discount'] / 100);
            }
            $order['discounted_total'] = $subtotal - $discountAmount;

            return $order;
        } catch (PDOException $e) {
            // Xử lý lỗi nếu cần, ở đây trả về null để đơn giản
            return null;
        }
    }

    public function getTotalOrders(array $filters = []): int
    {
        try {
            $query = "SELECT COUNT(*) FROM orders WHERE 1=1";
            $params = [];

            if (!empty($filters['status'])) {
                $query .= " AND status = :status";
                $params[':status'] = $filters['status'];
            }
            if (!empty($filters['order_code'])) {
                $query .= " AND order_code LIKE :order_code";
                $params[':order_code'] = '%' . trim($filters['order_code']) . '%';
            }
            if (!empty($filters['created_at'])) {
                $query .= " AND DATE(created_at) = :created_at";
                $params[':created_at'] = date('Y-m-d', strtotime($filters['created_at']));
            }

            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy tổng số đơn hàng: " . $e->getMessage());
            return 0;
        }
    }

    public function updateStatus(int $order_id, string $status)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Lỗi khi cập nhật trạng thái đơn hàng: " . $e->getMessage());
            return false;
        }
    }
}
