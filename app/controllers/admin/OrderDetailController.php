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
}