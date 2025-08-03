<?php 
namespace App\Controllers\Admin;
use App\Models\UsersModel;
use Container;
use Core\View;
    class UserDetailController {
        public function index() {
            $pdo = Container::get('pdo');
            $usersModel = new UsersModel($pdo);
            $users = $usersModel->getAllUsers();
            $id = $_GET['id'] ?? null;
            $user = null;
            foreach ($users as $u) {
                if ($u['id'] == $id) {
                    $user = $u;
                    break;
                }
            }
            View::render('userDetail', [
                'user' => $user
            ]);
        }

    public function delete()
    {
        $user_id = $_POST['id'] ?? null;
        if (!$user_id) {
            header("Location: /admin/users?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new UsersModel($pdo);
        $result = $model->deleteUser($user_id);
        header("Location: /admin/users?" . ($result ? "success=User đã bị xoá" : "error=Không thể xoá user"));
        exit;
    }

    public function edit()
    {
        $id = $_POST['id'] ?? null;
        $pdo = Container::get('pdo');
        $usersModel = new UsersModel($pdo);
        if (!$id) {
            echo "Thiếu ID người dùng.";
            return;
        }

        $user = $usersModel->getUserById($id);

        if (!$user) {
            echo "Không tìm thấy người dùng.";
            return;
        }

        View::render('editUser', ['user' => $user]);
    }

    public function update() {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $role = $_POST['role'];
    $password = $_POST['password'] ?? '';
    $pdo = Container::get('pdo');
    $usersModel = new UsersModel($pdo);
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = null;
    }

    $success = $usersModel->updateUser([
        'id' => $id,
        'username' => $username,
        'email' => $email,
        'full_name' => $full_name,
        'phone' => $phone,
        'sex' => $sex,
        'role' => $role,
        'password' => $hashedPassword,
    ]);

    if ($success) {
    header("Location: /admin/users?success=Thay đổi người dùng thành công"); 
        exit;
    } else {
        echo "Cập nhật thất bại.";
    }
}


   public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            View::render('addUser');
            return;
        }

        // Lấy dữ liệu từ form có tiền tố add-user__
        $username = $_POST['add-user__username'] ?? '';
        $email = $_POST['add-user__email'] ?? '';
        $full_name = $_POST['add-user__full_name'] ?? '';
        $phone = $_POST['add-user__phone'] ?? '';
        $role = $_POST['add-user__role'] ?? 1;
        $sex = $_POST['add-user__sex'] ?? 'other';
        $password = $_POST['add-user__password'] ?? '';

        // Kiểm tra dữ liệu bắt buộc
        if (!$username || !$email || !$full_name || !$password) {
            header('Location: /admin/users?error=' . urlencode('Vui lòng điền đầy đủ thông tin'));
            exit;
        }

        // Mã hoá mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm vào database
        $pdo = Container::get('pdo');
        $usersModel = new UsersModel($pdo);
        $usersModel->insertUser([
            'username' => $username,
            'email' => $email,
            'full_name' => $full_name,
            'phone' => $phone,
            'role' => $role,
            'sex' => $sex,
            'password' => $hashedPassword,
        ]);

        // Chuyển hướng có thông báo
        header('Location: /admin/users?success=' . urlencode('Thêm người dùng thành công'));
        exit;
    }



}