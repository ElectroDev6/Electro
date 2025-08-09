<?php
namespace App\Controllers\Admin\Reviews;

use App\Models\admin\ReviewsModel;
use Container;
use Core\View;

class UpdateReviewController
{
    private ReviewsModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new ReviewsModel($pdo);
    }
   public function handleUpdateStatus()
    {
        $reviewId = $_POST['review_id'] ?? null;
        $status = $_POST['status'] ?? null;
        // echo "Review ID: $reviewId, Status: $status";
        // exit;
        if (!$reviewId || !$status) {
            View::render('reviews/detail', [
                'error' => 'Invalid review ID or status.'
            ]);
            return;
        }
        $result = $this->model->updateReviewStatus($reviewId, $status);
        if ($result) {
            header('Location: /admin/reviews/detail?id=' . $reviewId . '&success=' . urlencode('Cập nhật trạng thái đánh giá thành công.'));
            exit;
        } else {
            View::render('reviews/detail', [
                'error' => 'Failed to update review status.'
            ]);
        }
    }

}
