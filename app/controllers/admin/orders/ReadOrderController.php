<?php
namespace App\Controllers\Admin\Orders;

use App\Models\admin\OrdersModel;
use Container;
use Core\View;

class ReadOrderController
{
    private OrdersModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new OrdersModel($pdo);
    }

    public function list()
    {
        try {
            $filters = [
                'status' => $_GET['status'] ?? '',
                'order_code' => $_GET['search'] ?? '',
                'created_at' => $_GET['date'] ?? ''
            ];
            $limit = 8;
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $offset = ($page - 1) * $limit;

            $orders = $this->model->getAllOrders($filters, $limit, $offset);
            $totalOrders = $this->model->getTotalOrders($filters);
            $totalPages = ceil($totalOrders / $limit);

            View::render('orders/index', [
                'orders' => $orders,
                'title' => 'Danh sách đơn hàng',
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalOrders' => $totalOrders
            ]);
        } catch (\Exception $e) {
            error_log("Lỗi khi lấy danh sách đơn hàng: " . $e->getMessage());
        }
    }

    public function detail()
{
    try {
        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($order_id <= 0) {
            throw new \Exception("ID đơn hàng không hợp lệ.");
        }
        $order = $this->model->getOrderById($order_id);
        View::render('orders/detail', [
            'order' => $order
        ]);
    } catch (\Exception $e) {
        error_log("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
        // Chuyển hướng đến trang danh sách đơn hàng với thông báo lỗi
        header("Location: /orders?error=" . urlencode($e->getMessage()));
        exit;
    }
}
}