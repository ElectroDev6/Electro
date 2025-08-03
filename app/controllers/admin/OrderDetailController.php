<?php
namespace App\Controllers\Admin;
use App\Models\OrdersModel;
use Container;
use Core\View;
    class OrderDetailController
    {
         public function index()
    {
        $pdo = Container::get('pdo');
        $orderModel = new OrdersModel($pdo);
        $orders = $orderModel->getAllOrders();
        $id = $_GET['id'] ?? null;
        $order = null;
        foreach ($orders as $o) {
            if ($o['id'] == $id) {
                $order = $o;
                break;
            }
        }
        View::render('orderDetail', [
            'orderDetail' => $order
        ]);
    }


    public function approve()
    {
        $orderId = $_POST['id'] ?? null;
        if (!$orderId) {
            header("Location: /admin/orders?error=ID không hợp lệ");
            exit;
        }
        $pdo = Container::get('pdo');
        $model = new OrdersModel($pdo);
        $result = $model->update($orderId, ['status' => 'delivering']);
        header("Location: /admin/orders?success=Đơn hàng đã được chấp nhận");
        exit;
    }

    public function cancel()
    {
         $orderId = $_POST['id'] ?? null;
        if (!$orderId) {
            header("Location: /admin/orders?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new OrdersModel($pdo);
        $result = $model->update($orderId, ['status' => 'canceled']);

        header("Location: /admin/orders?" . ($result ? "success=Đơn hàng đã bị từ chối" : "error=Lỗi khi từ chối"));
        exit;
    }

     public function complete()
    {
         $orderId = $_POST['id'] ?? null;
        if (!$orderId) {
            header("Location: /admin/orders?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new OrdersModel($pdo);
        $result = $model->update($orderId, ['status' => 'delivered']);

        header("Location: /admin/orders?" . ($result ? "success=Đơn hàng đã giao thành công" : "error=Lỗi khi từ chối"));
        exit;
    }
}