<?php
namespace App\Controllers\Admin\Reviews;

use App\Models\admin\ReviewsModel;
use Container;
use Core\View;

class DeleteReviewController
{
    public static function handle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ.";
            return;
        }
        $model = new ReviewsModel(Container::get('pdo'));
        $reviewId = $_POST['review_id'] ?? null;
        if (!$reviewId) {
            View::render('reviews/index', [
                'error' => 'ID đánh giá không hợp lệ',
                'reviews' => $model->fetchAllReviews()
            ]);
            return;
        }
        $success = $model->deleteReview($reviewId);
        if ($success) {
            header('Location: /admin/reviews?success=Đã xoá đánh giá thành công');
            exit;
        }
        View::render('reviews/index', [
            'error' => 'Không thể xoá đánh giá',
            'reviews' => $model->fetchAllReviews()
        ]);
    }
}
