<?php

namespace App\Controllers\Web;

use App\Services\ProfileService;
use App\Models\ProfileModel;
use Core\View;

class InforController
{
    private $profileService;

    public function __construct(\PDO $pdo)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $profileModel = new ProfileModel($pdo);
    $this->profileService = new ProfileService($profileModel);
}

   public function showProfile()
{
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        error_log("InforController: No user_id in session, redirecting to /login");
        header('Location: /login');
        exit;
    }

    $user = $this->profileService->getUserProfile($userId);

    if (!$user) {
        error_log("InforController: No user profile found for user_id: $userId");
        View::render('profile', ['error' => 'Không tìm thấy thông tin người dùng']);
        return;
    }

    $successMessage = null;
    if (isset($_GET['updated']) && $_GET['updated'] == 1) {
        $successMessage = 'Cập nhật thông tin thành công.';
    }

    error_log("InforController: Successfully loaded profile for user_id: $userId");
    View::render('profile', [
        'user' => $user,
        'success' => $successMessage
    ]);
}
    public function saveProfile()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header('Location: /login');
        exit;
    }

    // Lấy dữ liệu từ form POST (cả profile và address)
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'phone_number' => trim($_POST['phone_number'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'gender' => $_POST['gender'] ?? null,
        'dob_day' => $_POST['dob_day'] ?? null,
        'dob_month' => $_POST['dob_month'] ?? null,
        'dob_year' => $_POST['dob_year'] ?? null,
        'province_city' => trim($_POST['province_city'] ?? ''),
        'district' => trim($_POST['district'] ?? ''),
        'ward_commune' => trim($_POST['ward_commune'] ?? ''),
        'address_line1' => trim($_POST['address_line1'] ?? ''),
    ];

    // Kiểm tra dữ liệu bắt buộc cơ bản
    if (empty($data['name']) || empty($data['phone_number']) || empty($data['email']) ||
        empty($data['province_city']) || empty($data['district']) || empty($data['ward_commune']) || empty($data['address_line1'])) {
        View::render('profile', [
            'user' => $this->profileService->getUserProfile($userId),
            'error' => 'Vui lòng điền đầy đủ thông tin cá nhân và địa chỉ.'
        ]);
        return;
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    View::render('profile', [
        'user' => $this->profileService->getUserProfile($userId),
        'error' => 'Email không hợp lệ.'
    ]);
    return;
}
    // Cập nhật thông tin cá nhân
    $resultProfile = $this->profileService->updateUserProfile($userId, $data);

    // Cập nhật địa chỉ
    $resultAddress = $this->profileService->updateUserAddress($userId, $data);

    if ($resultProfile && $resultAddress) {
        View::render('profile', [
            'user' => $this->profileService->getUserProfile($userId),
            'success' => 'Cập nhật thông tin thành công.'
        ]);
    } else {
        View::render('profile', [
            'user' => $this->profileService->getUserProfile($userId),
            'error' => 'Cập nhật thất bại. Vui lòng thử lại.'
        ]);
    }
}

    public function logout()
    {
        session_start();
        session_unset(); // Xóa tất cả session variables
        session_destroy(); // Hủy session
        header('Location: /login');
        exit;
    }
}