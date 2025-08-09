<?php
namespace App\Controllers\Admin\Users;

use App\Models\admin\UsersModel;
use Container;
use Core\View;

class CreateUserController
{
    private UsersModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new UsersModel($pdo);
    }

    public function index()
    {
        $users = $this->model->getAllUsers();
        View::render('users/create');
    }
    public function handleCreate()
    {
        // Retrieve form data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone_number = trim($_POST['phone_number'] ?? '');
        $gender = $_POST['gender'] ?? '';
        $birth_date = $_POST['birth_date'] ?? '';
        $role = $_POST['role'] ?? '';
        $is_active = $_POST['is_active'] ?? '';
        $password = trim($_POST['password'] ?? ''); // Raw password from form
        $avatar_url = $_FILES['avatar_url'] ?? null;

        $errors = [];

        // Validation
        if (empty($name)) {
            $errors['name'] = 'Vui lòng nhập họ và tên.';
        }
        if (empty($email)) {
            $errors['email'] = 'Vui lòng nhập email.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif ($this->model->userExistsByEmail($email)) {
            $errors['email'] = 'Email đã tồn tại.';
        }
        if (!empty($phone_number) && !preg_match('/^[0-9]{10,11}$/', $phone_number)) {
            $errors['phone_number'] = 'Số điện thoại không hợp lệ (10-11 số).';
        }
        if (empty($gender)) {
            $errors['gender'] = 'Vui lòng chọn giới tính.';
        }
        if (empty($birth_date)) {
            $errors['birth_date'] = 'Vui lòng chọn ngày sinh.';
        }
        if (empty($role)) {
            $errors['role'] = 'Vui lòng chọn vai trò.';
        }
        if (empty($is_active)) {
            $errors['is_active'] = 'Vui lòng chọn trạng thái.';
        }
        if (empty($password)) {
            $errors['password'] = 'Vui lòng nhập mật khẩu.';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if (!empty($errors)) {
            View::render('users/create', [
                'errors' => $errors,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phone_number,
                'gender' => $gender,
                'birth_date' => $birth_date,
                'role' => $role,
                'is_active' => $is_active,
                'password' => $password,
            ]);
            return;
        }

        $avatarPathForDB = null;
        if ($avatar_url && $avatar_url['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            if (!in_array($avatar_url['type'], $allowedTypes) || $avatar_url['size'] > $maxSize) {
                $errors['avatar_url'] = 'Định dạng ảnh không hợp lệ hoặc kích thước vượt quá 5MB';
                View::render('users/create', [
                    'errors' => $errors,
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'gender' => $gender,
                    'birth_date' => $birth_date,
                    'role' => $role,
                    'is_active' => $is_active,
                    'password' => $password,
                ]);
                return;
            }
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/img/avatar/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                $errors['avatar_url'] = 'Không thể tạo thư mục upload';
                View::render('users/create', [
                    'errors' => $errors,
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'gender' => $gender,
                    'birth_date' => $birth_date,
                    'role' => $role,
                    'is_active' => $is_active,
                    'password' => $password,
                ]);
                return;
            }

            $filename = $avatar_url['name']; // Add unique prefix
            $targetPath = $uploadDir . $filename;

            if (!move_uploaded_file($avatar_url['tmp_name'], $targetPath)) {
                $errors['avatar_url'] = 'Không thể upload ảnh';
                View::render('users/create', [
                    'errors' => $errors,
                    'name' => $name,
                    'email' => $email,
                    'phone_number' => $phone_number,
                    'gender' => $gender,
                    'birth_date' => $birth_date,
                    'role' => $role,
                    'is_active' => $is_active,
                    'password' => $password,
                ]);
                return;
            }

            $avatarPathForDB = '/img/avatar/' . $filename;
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $userData = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number ?: null,
            'gender' => $gender,
            'birth_date' => $birth_date,
            'role' => $role,
            'is_active' => (int)$is_active,
            'password_hash' => $password_hash,
            'avatar_url' => $avatarPathForDB,
            'created_at' => date('Y-m-d H:i:s'), // Set current timestamp
            'updated_at' => date('Y-m-d H:i:s'), // Set current timestamp
        ];

        $id = $this->model->createUser($userData);

        if ($id) {
            header('Location: /admin/users/detail?id=' . $id . '&success=' . urlencode('Tạo mới người dùng thành công'));
            exit;
        }

        View::render('users/create', [
            'error' => 'Không thể tạo người dùng.',
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'gender' => $gender,
            'birth_date' => $birth_date,
            'role' => $role,
            'is_active' => $is_active,
            'password' => $password,
        ]);
    }
}
?>