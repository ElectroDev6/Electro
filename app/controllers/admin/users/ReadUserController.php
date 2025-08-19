<?php 
namespace App\Controllers\Admin\Users;
use App\Models\admin\UsersModel;
use Container;
use Core\View;

class ReadUserController
{
    private UsersModel $model;
    
    public function __construct() {
        $pdo = Container::get('pdo');
        $this->model = new UsersModel($pdo);
    }
    
    public function list()
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

    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/users');
            exit;
        }
        $user = $this->model->getUserById($id);
        if (!$user) {
            header('Location: /admin/users');
            exit;
        }
        View::render('users/detail', ['user' => $user]);
    }

    public function currentUser() {
        header('Content-Type: application/json');
        $user_id = $_SESSION['user_id'];
        try {
            if (!$this->model) {
                throw new Exception('Model not initialized');
            }
            if (!$user_id) {
                throw new Exception('Chưa đăng nhập');
            }
            $result = $this->model->getCurrentUser($user_id);
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'user' => $result
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Không tìm thấy người dùng'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Lỗi server: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}
?>