<?php

namespace App\Services;

use PDO;
use App\Models\ReviewUserModel;

class ReviewUserService
{
    private ReviewUserModel $reviewUserModel;

    public function __construct(PDO $pdo)
    {
        $this->reviewUserModel = new ReviewUserModel($pdo);
    }

    public function getReviewUser(?int $userId) {
        if ($userId === null) {
            return [];
        }
        return $this->reviewUserModel->getReviewUser($userId);
    }
}
