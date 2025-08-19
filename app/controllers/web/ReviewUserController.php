<?php

namespace App\Controllers\Web;

use App\Services\ReviewUserService;

class ReviewUserController
{
    private ReviewUserService $reviewUserService;
    private ?int $userId;

    public function __construct(\PDO $pdo) {
        $this->reviewUserService = new ReviewUserService($pdo);
        $this->userId = $_SESSION['user_id'] ?? null;
    }

    public function reviewUser()
    {   
        $data = $this->reviewUserService->getReviewUser($this->userId);

        // Trả JSON thay vì HTML
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            "success" => true,
            "reviews" => $data,
            "userCurrent"=>$this->userId,
        ]);
        exit;
    }
}
