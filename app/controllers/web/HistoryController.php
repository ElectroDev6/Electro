<?php

namespace App\Controllers\Web;

use Core\View;
use App\Services\HistoryService;

class HistoryController
{
    private $historyService;

    public function __construct(\PDO $pdo)
    {
        $this->historyService = new HistoryService($pdo);
    }

    public function showHistory()
    {
        // Lấy tham số status từ query string, mặc định là 'all'
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';

        // Map status từ URL sang status trong database
        $statusMap = [
            'all' => null,
            'cho-xac-nhan' => 'pending',
            'dang-xu-ly' => 'processing',
            'dang-giao' => 'shipped',
            'hoan-thanh' => 'completed'
        ];

        $dbStatus = isset($statusMap[$status]) ? $statusMap[$status] : null;

        // Lấy danh sách đơn hàng từ service
        $orders = $this->historyService->getUserOrders($_SESSION['user_id'] ?? 0, $dbStatus);

        // Render giao diện
        View::render('history', [
            'orders' => $orders,
            'status' => $status
        ]);
    }
}
