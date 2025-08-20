<?php

namespace App\Services;

use PDO;
use App\Models\HistoryModel;

class HistoryService
{
    private $historyModel;

    public function __construct(PDO $pdo)
    {
        $this->historyModel = new HistoryModel($pdo);
    }

    public function getUserOrders(int $userId, ?string $status = null): array
    {
        if ($userId <= 0) {
            return [];
        }

        // Lấy danh sách đơn hàng từ model
        $orders = $this->historyModel->getOrdersByUser($userId, $status);

        // Format dữ liệu để hiển thị
        foreach ($orders as &$order) {
            $order['formatted_date'] = date('d/m/Y H:i', strtotime($order['created_at']));
            $order['status_text'] = $this->getStatusText($order['status']);
        }

        return $orders;
    }

    private function getStatusText(string $status): string
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang xử lý',
            'paid' => 'Đã thanh toán',
            'shipped' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy'
        ];

        return $statusMap[$status] ?? 'Không xác định';
    }
}
