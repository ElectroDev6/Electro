<?php
namespace App\Controllers\Admin;
use App\Controllers\Admin\Orders\CreateOrderController;
use App\Controllers\Admin\Orders\UpdateOrderController;
use App\Controllers\Admin\Orders\DeleteOrderController;
use App\Controllers\Admin\Orders\ReadOrderController;

class OrdersController
{
    public function index()
    {
        $controller = new ReadOrderController();
        $controller->list();
    }
    
    
    public function detail()
    {
        $controller = new ReadOrderController();
        $controller->detail();
    }

    public function status()
    {
        $controller = new UpdateOrderController();
        $controller->handleUpdateStatus();
    }
    
}

?>