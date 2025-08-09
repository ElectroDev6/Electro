<?php
namespace App\Models\admin;

use PDO;

class OrdersModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllOrders($filters = [], $limit = 8, $offset = 0): array
    {
        try {
            // Xây dựng câu truy vấn cơ bản
            $query = "
                SELECT o.*, c.code as coupon_code, p.payment_method, p.status as payment_status,
                       (SELECT SUM(oi.quantity * oi.price) FROM order_items oi WHERE oi.order_id = o.order_id) as calculated_total
                FROM orders o
                LEFT JOIN coupons c ON o.coupon_id = c.coupon_id
                LEFT JOIN (
                    SELECT p1.*
                    FROM payments p1
                    INNER JOIN (
                        SELECT order_id, MAX(payment_id) as max_payment_id
                        FROM payments
                        GROUP BY order_id
                    ) p2 ON p1.order_id = p2.order_id AND p1.payment_id = p2.max_payment_id
                ) p ON o.order_id = p.order_id
                WHERE 1=1
            ";
            $params = [];

            // Thêm bộ lọc nếu có
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

            // Sắp xếp và phân trang
            $query .= " ORDER BY o.created_at DESC LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)$limit;
            $params[':offset'] = (int)$offset;

            // Thực thi truy vấn
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $key => $value) {
                if ($key === ':limit' || $key === ':offset') {
                    $stmt->bindValue($key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Kiểm tra và cập nhật total_price nếu cần
            foreach ($orders as &$order) {
                if ($order['calculated_total'] !== null && $order['calculated_total'] != $order['total_price']) {
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
            $stmt = $this->pdo->prepare("
                SELECT 
                    o.*, c.code AS coupon_code, u.name AS username, u.phone_number, u.email,
                    CONCAT(ua.address_line1, ', ', ua.ward_commune, ', ', ua.district, ', ', ua.province_city) AS full_address,
                    p.payment_method, p.status AS payment_status,
                    GROUP_CONCAT(CONCAT(oi.quantity, ' x ', s.sku_code, ' (@', oi.price, 'đ)') SEPARATOR ', ') AS order_items,
                    COALESCE((SELECT SUM(oi2.quantity * oi2.price) FROM order_items oi2 WHERE oi2.order_id = o.order_id), 0) AS calculated_total
                FROM orders o
                LEFT JOIN coupons c ON o.coupon_id = c.coupon_id
                LEFT JOIN users u ON o.user_id = u.user_id
                LEFT JOIN user_address ua ON o.user_address_id = ua.user_address_id
                LEFT JOIN (
                    SELECT p1.*
                    FROM payments p1
                    INNER JOIN (
                        SELECT order_id, MAX(payment_id) AS max_payment_id
                        FROM payments
                        GROUP BY order_id
                    ) p2 ON p1.order_id = p2.order_id AND p1.payment_id = p2.max_payment_id
                ) p ON o.order_id = p.order_id
                LEFT JOIN order_items oi ON o.order_id = oi.order_id
                LEFT JOIN skus s ON oi.sku_id = s.sku_id
                WHERE o.order_id = :order_id
                GROUP BY o.order_id, c.code, u.name, u.phone_number, u.email, ua.address_line1, ua.ward_commune, ua.district, ua.province_city, p.payment_method, p.status
            ");
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($order) {
                if ($order['calculated_total'] != $order['total_price']) {
                    $this->pdo->prepare("UPDATE orders SET total_price = :total WHERE order_id = :order_id")
                        ->execute([':total' => $order['calculated_total'], ':order_id' => $order_id]);
                    $order['total_price'] = $order['calculated_total'];
                }
            }
            return $order ?: null;
        } catch (\PDOException $e) {
            error_log("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
            return null;
        }
    }

    public function getTotalOrders(array $filters = []): int
    {
        try {
            // Xây dựng câu truy vấn đếm
            $query = "SELECT COUNT(*) FROM orders WHERE 1=1";
            $params = [];

            // Thêm bộ lọc nếu có
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

            // Thực thi truy vấn
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

    public function updateStatus(int $order_id, string $status): bool
    {
        try {
            // Cập nhật trạng thái mà không cập nhật updated_at
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