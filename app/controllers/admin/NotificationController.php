<?php
namespace App\Controllers\Admin;

use App\Models\Admin\NotificationsModel;
use Core\View;
use Container;

class NotificationController
{
    private NotificationsModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new NotificationsModel($pdo);
    }

    public function index()
    {
        header('Content-Type: application/json');
        try {
            $user_id = $_SESSION['user_id'];
            $data = $this->model->getNotificationBell();
            $data2 = $this->model->getNotificationMessage($user_id);
            echo json_encode([
                'success' => true,
                'data' => $data ?: [],
                'data2' => $data2?: [],
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}