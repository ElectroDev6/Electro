<?php
namespace App\Controllers\Admin;
use App\Models\OrdersModel;
use Container;
use Core\View;
    class OrdersController
    {
        public function index()
        {
        $pdo = Container::get('pdo');
        $orderModel = new OrdersModel($pdo);
        $orders = $orderModel->getAllOrders();

        // Truyền dữ liệu sang view
        View::render('orders', [
            'orders' => $orders
        ]);
        }
    }