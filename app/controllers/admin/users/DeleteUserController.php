<?php
namespace App\Controllers\Admin\Users;

use App\Models\admin\UsersModel;
use Container;
use Core\View;

class DeleteUserController
{
    public static function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ.";
            return;
        }
        $model = new UsersModel(Container::get('pdo'));
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? 'Unknown';
        if (!$id || !is_numeric($id)) {
            View::render('users/index', [
                'error' => 'ID user không hợp lệ',
                'users' => $model->fetchAllUsers(8, 0), // Fetch first 8 users
                'totalUsers' => $model->getTotalUsers(),
                'page' => 1,
                'usersPerPage' => 8
            ]);
            return;
        }
        $success = $model->deleteUser($id);
        if ($success) {
            $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
            header('Location: /admin/users?page=' . $page . '&success=' . urlencode('Đã xóa người dùng ' . $name . ' thành công'));
            exit;
        }
        View::render('users/index', [
            'error' => 'Không thể xóa người dùng',
            'users' => $model->fetchAllUsers(8, 0),
            'totalUsers' => $model->getTotalUsers(),
            'page' => 1,
            'usersPerPage' => 8
        ]);
    }
}