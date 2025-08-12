<?php
namespace App\Controllers\Admin\Orders;

use App\Models\admin\OrdersModel;
use Container;
use Core\View;

class UpdateOrderController
{
    private OrdersModel $model;
    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new OrdersModel($pdo);
    }
   public function handleUpdateStatus()
    {
        $order_id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;
        // exit;
        if (!$order_id || !$status) {
            View::render('orders/detail', [
                'error' => 'Invalid order ID or status.'
            ]);
            return;
        }
        $result = $this->model->updateStatus($order_id, $status);
        if ($result) {
            header('Location: /admin/orders?success=' . urlencode('Cập nhật trạng thái đơn hàng thành công.'));
            exit;
        } else {
            View::render('orders/detail', [
                'error' => 'Failed to update order status.'
            ]);
        }
    }

}
