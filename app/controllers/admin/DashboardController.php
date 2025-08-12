<?php
namespace App\Controllers\Admin;

use Core\View;
use PDO;

class DashboardController
{
    private $db;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'electro_db';
        $user = 'root';
        $pass = '0971621814duc';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Kết nối thất bại: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $data = [];

        // Doanh thu theo danh mục (dựa trên tất cả orders, không chỉ paid)
        $stmt = $this->db->query("
            SELECT c.name AS category, 
                   COALESCE(SUM(oi.quantity * oi.price), 0) AS revenue, 
                   DATE_FORMAT(o.created_at, '%Y-%m-%d') AS created_at
            FROM categories c
            LEFT JOIN subcategories sc ON c.category_id = sc.category_id
            LEFT JOIN products p ON sc.subcategory_id = p.subcategory_id
            LEFT JOIN skus s ON p.product_id = s.product_id
            LEFT JOIN order_items oi ON s.sku_id = oi.sku_id
            LEFT JOIN orders o ON oi.order_id = o.order_id
            GROUP BY c.category_id, c.name, DATE_FORMAT(o.created_at, '%Y-%m-%d')
            ORDER BY created_at DESC
        ");
        $data['categoryRevenue'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Xu hướng đơn hàng - 7 ngày gần nhất (dựa trên tất cả orders)
        $stmt = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS date, 
                   COUNT(*) AS order_count, 
                   COALESCE(SUM(total_price), 0) AS total_revenue
            FROM orders
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d')
            ORDER BY date ASC
        ");
        $orderTrendData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['orderTrend'] = $this->fillMissingDates($orderTrendData, 7);

        // Phương thức thanh toán (dựa trên tất cả payments)
        $stmt = $this->db->query("
            SELECT payment_method, COUNT(*) AS count
            FROM payments
            GROUP BY payment_method
            ORDER BY count DESC
        ");
        $data['paymentMethods'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Payment Methods Data: " . print_r($data['paymentMethods'], true));

        // Tăng trưởng người dùng - 7 ngày gần nhất
        $stmt = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS date, 
                   COUNT(*) AS user_count
            FROM users
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
            GROUP BY DATE_FORMAT(created_at, '%Y-%m-%d')
            ORDER BY date ASC
        ");
        $userGrowthData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['userGrowth'] = $this->fillMissingDates($userGrowthData, 7);

        // Top sản phẩm bán chạy (dựa trên tất cả orders)
        $stmt = $this->db->query("
            SELECT 
                p.name AS product_name, 
                c.name AS category_name, 
                COALESCE(SUM(oi.quantity), 0) AS sold, 
                COALESCE(SUM(oi.quantity * oi.price), 0) AS revenue,
                p.product_id
            FROM products p
            LEFT JOIN subcategories sc ON p.subcategory_id = sc.subcategory_id
            LEFT JOIN categories c ON sc.category_id = c.category_id
            LEFT JOIN skus s ON p.product_id = s.product_id
            LEFT JOIN order_items oi ON s.sku_id = oi.sku_id
            LEFT JOIN orders o ON oi.order_id = o.order_id
            GROUP BY p.product_id, p.name, c.name
            ORDER BY sold DESC, p.product_id DESC
            LIMIT 10
        ");
        $data['topProducts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Danh sách đơn hàng gần đây (tất cả orders)
        $stmt = $this->db->query("
            SELECT 
                o.order_id, 
                o.created_at, 
                o.total_price, 
                o.status,
                COALESCE(u.name, 'Khách vãng lai') AS user_name
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.user_id
            ORDER BY o.created_at DESC
            LIMIT 15
        ");
        $data['recentOrders'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Thống kê tổng quan (dựa trên tất cả orders)
        $stmt = $this->db->query("SELECT COALESCE(SUM(total_price), 0) FROM orders");
        $data['totalRevenue'] = $stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        $data['newCustomers'] = $stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        $data['activeProducts'] = $stmt->fetchColumn();
        $stmt = $this->db->query("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()");
        $data['todaySales'] = $stmt->fetchColumn();

        // Danh sách tháng cho dropdown
        $stmt = $this->db->query("
            SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m') AS month 
            FROM orders 
            WHERE created_at IS NOT NULL
            UNION 
            SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m') AS month 
            FROM users 
            WHERE created_at IS NOT NULL
            ORDER BY month DESC
        ");
        $data['months'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

        View::render('dashboard', $data);
    }

    /**
     * Điền dữ liệu cho các ngày bị thiếu
     */
    private function fillMissingDates($data, $days = 7)
    {
        $result = [];
        $dataByDate = [];
        
        // Tạo array với key là date
        foreach ($data as $item) {
            $dataByDate[$item['date']] = $item;
        }
        
        // Tạo dữ liệu cho n ngày gần nhất
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            
            if (isset($dataByDate[$date])) {
                $result[] = $dataByDate[$date];
            } else {
                // Tạo dữ liệu mặc định cho ngày bị thiếu
                $result[] = [
                    'date' => $date,
                    'order_count' => 0,
                    'total_revenue' => 0,
                    'user_count' => 0
                ];
            }
        }
        
        return $result;
    }

    // Thêm method để debug payment methods
    public function debugPaymentMethods()
    {
        // Kiểm tra dữ liệu trong bảng payments
        $stmt = $this->db->query("
            SELECT p.*, o.status, o.created_at as order_date
            FROM payments p
            JOIN orders o ON p.order_id = o.order_id
            ORDER BY o.created_at DESC
            LIMIT 20
        ");
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<pre>";
        echo "Raw Payment Data:\n";
        print_r($payments);
        
        // Kiểm tra distinct payment methods
        $stmt = $this->db->query("
            SELECT DISTINCT p.payment_method, COUNT(*) as total_count
            FROM payments p
            JOIN orders o ON p.order_id = o.order_id
            GROUP BY p.payment_method
        ");
        $methods = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "\nDistinct Payment Methods:\n";
        print_r($methods);
        echo "</pre>";
    }
}
?>