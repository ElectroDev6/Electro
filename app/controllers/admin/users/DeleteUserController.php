<?php
namespace App\Controllers\Admin\Users;

use App\Models\admin\UsersModel;
use Container;
use Core\View;

class DeleteUserController
{
    private UsersModel $model;
    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new UsersModel($pdo);
    }

    public function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ.";
            return;
        }

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? 'Unknown';

        if (!$id || !is_numeric($id)) {
            $this->renderUserList('ID user không hợp lệ');
            return;
        }

        $activeOrders = $this->model->getUserActiveOrders($id);
       if ($activeOrders > 0) {
            $_SESSION['error'] = 'Người dùng này đang có đơn hàng chưa hoàn tất, không thể xóa.';
            $_SESSION['error_user_id'] = $id;
            header('Location: /admin/users');
            exit;
        }


        if ($this->model->deleteUser($id)) {
            $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                ? (int)$_GET['page']
                : 1;
            header('Location: /admin/users?page=' . $page . '&success=' . urlencode('Đã xóa người dùng ' . $name . ' thành công'));
            exit;
        }
    }

    private function renderUserList($error = null)
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $role = isset($_GET['role']) ? $_GET['role'] : '';
        $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
        $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 8;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        $filters = [];
        if ($search !== '') $filters['search'] = $search;
        if ($role !== '') $filters['role'] = $role;
        if ($gender !== '') $filters['gender'] = $gender;
        $offset = ($page - 1) * $limit;
        try {
            $users = $this->model->getAllUsers($filters, $limit, $offset);
            $totalUsers = $this->model->getTotalUsers($filters);
            $totalPages = ceil($totalUsers / $limit);
        } catch (Exception $e) {
            error_log("Error in renderUserList - " . $e->getMessage());
            $users = [];
            $totalUsers = 0;
            $totalPages = 0;
        }
        View::render('users/index', [
            'error' => $error,
            'users' => $users,
            'totalUsers' => $totalUsers,
            'page' => $page,
            'usersPerPage' => $limit,
            'totalPages' => $totalPages,
            'search' => $search,
            'role' => $role,
            'gender' => $gender,
            'limit' => $limit
        ]);
    }

}