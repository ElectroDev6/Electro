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
    
    public function list() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $role = isset($_GET['role']) ? $_GET['role'] : '';
        $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
        $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 8;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $filters = [];
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        if (!empty($role)) {
            $filters['role'] = $role;
        }
        if (!empty($gender)) {
            $filters['gender'] = $gender;
        }
        $offset = ($page - 1) * $limit;
        try {
            $users = $this->model->getAllUsers($filters, $limit, $offset);
            $totalUsers = $this->model->getTotalUsers($filters);
            $totalPages = ceil($totalUsers / $limit);
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
            
        } catch (Exception $e) {
            error_log("Error in ReadUserController::list - " . $e->getMessage());
            View::render('users/index', [
                'users' => [],
                'totalUsers' => 0,
                'page' => 1,
                'usersPerPage' => $limit,
                'totalPages' => 0,
                'search' => $search,
                'role' => $role,
                'gender' => $gender,
                'limit' => $limit
            ]);
        }
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
}
?>