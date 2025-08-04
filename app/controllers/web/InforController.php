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

        error_log("InforController: Successfully loaded profile for user_id: $userId");
        View::render('profile', ['user' => $user]);
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
