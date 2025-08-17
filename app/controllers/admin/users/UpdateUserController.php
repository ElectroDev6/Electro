<?php

namespace App\Controllers\Admin\Users;

use App\Models\admin\UsersModel;
use Container;
use Core\View;

class UpdateUserController
{
    private UsersModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new UsersModel($pdo);
    }

    public function index()
    {
        $id = $_GET['id'];
        $user = $this->model->getUserById($id);
        View::render('users/update', [
            'user' => $user,
        ]);
    }

    public function handle()
    {
        $user_id = $_POST['user_id'] ?? null;
        if (!$user_id) {
            header('Location: /admin/users/index?id=' . urlencode($user_id ?? '') . '&error=' . urlencode('ID người dùng không hợp lệ.'));
            exit;
        }

        $userData = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone_number' => trim($_POST['phone_number'] ?? ''),
            'gender' => $_POST['gender'] ?? '',
            'role' => $_POST['role'] ?? '',
            'is_active' => $_POST['is_active'] ?? '',
            'dob_day' => $_POST['dob_day'] ?? null,
            'dob_month' => $_POST['dob_month'] ?? null,
            'dob_year' => $_POST['dob_year'] ?? null,
        ];

        $addressData = [
            'address' => trim($_POST['address'] ?? ''),
            'ward_commune' => trim($_POST['ward_commune'] ?? ''),
            'district' => trim($_POST['district'] ?? ''),
            'province_city' => trim($_POST['province_city'] ?? ''),
        ];

        $errors = [];

        // Xác thực
        if (empty($userData['name'])) {
            $errors['name'] = 'Vui lòng nhập họ và tên.';
        }
        if (empty($userData['email']) || !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif ($this->model->userExistsByEmail($userData['email'], $user_id)) {
            $errors['email'] = 'Email đã tồn tại.';
        }
        if (!empty($userData['phone_number']) && !preg_match('/^[0-9]{10,11}$/', $userData['phone_number'])) {
            $errors['phone_number'] = 'Số điện thoại phải là 10-11 chữ số.';
        }
        if (!in_array($userData['gender'], ['male', 'female', 'other'])) {
            $errors['gender'] = 'Vui lòng chọn giới tính.';
        }
        if (!in_array($userData['role'], ['user', 'admin'])) {
            $errors['role'] = 'Vui lòng chọn vai trò.';
        }
        if (!in_array($userData['is_active'], ['0', '1'])) {
            $errors['is_active'] = 'Vui lòng chọn trạng thái.';
        }

        // Xác thực địa chỉ
        if (empty($addressData['address'])) {
            $errors['address'] = 'Vui lòng nhập địa chỉ chi tiết.';
        }
        if (empty($addressData['ward_commune'])) {
            $errors['ward_commune'] = 'Vui lòng chọn phường/xã.';
        }
        if (empty($addressData['district'])) {
            $errors['district'] = 'Vui lòng chọn quận/huyện.';
        }
        if (empty($addressData['province_city'])) {
            $errors['province_city'] = 'Vui lòng chọn tỉnh/thành phố.';
        }

        // Xử lý tải lên avatar
        $oldAvatarPath = $this->model->getUserById($user_id)['avatar_url'] ?? null;
        $avatarPathForDB = $oldAvatarPath;
        if (isset($_FILES['avatar_url']) && $_FILES['avatar_url']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            if (in_array($_FILES['avatar_url']['type'], $allowedTypes) && $_FILES['avatar_url']['size'] <= $maxSize) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/img/avatar/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $filename = basename($_FILES['avatar_url']['name']);
                $targetPath = $uploadDir . $filename;
                if (move_uploaded_file($_FILES['avatar_url']['tmp_name'], $targetPath)) {
                    $avatarPathForDB = '/img/avatar/' . $filename;
                    if (!empty($oldAvatarPath) && file_exists($_SERVER['DOCUMENT_ROOT'] . $oldAvatarPath) && $oldAvatarPath !== $avatarPathForDB) {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $oldAvatarPath);
                    }
                } else {
                    $errors['avatar_url'] = 'Lỗi khi tải lên ảnh đại diện.';
                }
            } else {
                $errors['avatar_url'] = 'File ảnh không hợp lệ hoặc vượt quá 5MB.';
            }
        }

        // Nếu có lỗi, chuyển hướng về trang chi tiết
        if (!empty($errors)) {
            $errorMessages = http_build_query($errors);
            header('Location: /admin/users/detail?id=' . urlencode($user_id) . '&error=' . urlencode('Vui lòng nhập đầy đủ thông tin') . '&' . $errorMessages);
            exit;
        }

        // Gán avatar vào userData
        $userData['avatar_url'] = $avatarPathForDB;

        // Cập nhật dữ liệu
        if ($this->model->updateUser($user_id, $userData) && $this->model->updateAddress($user_id, $addressData)) {
            header('Location: /admin/users/detail?id=' . urlencode($user_id) . '&success=' . urlencode('Sửa người dùng thành công'));
        } else {
            header('Location: /admin/users/detail?id=' . urlencode($user_id) . '&error=' . urlencode('Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.'));
        }
        exit;
    }

    public function toggleLock()
    {
        $user_id = (int) ($_POST['user_id'] ?? 0);
        if (!$user_id) {
            header('Location: /admin/users?error=' . urlencode('ID người dùng không hợp lệ.'));
            exit;
        }

        $this->model->toggleUserLock($user_id);
        header('Location: /admin/users?success=' . urlencode('Đã cập nhật trạng thái người dùng thành công.'));
        exit;
    }
}