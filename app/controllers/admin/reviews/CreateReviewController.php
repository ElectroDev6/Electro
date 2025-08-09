<?php
namespace App\Controllers\Admin\Reviews;

use App\Models\admin\ReviewsModel;
use App\Models\admin\UsersModel;
use Container;
use Core\View;

class CreateReviewController
{
    private ReviewsModel $model;

    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new ReviewsModel($pdo);
    }

    public function index()
    {
        $reviews = $this->model->fetchAllReviews();
        View::render('reviews/create');
    }

    public function handleRepliesReview()
    {
        $reviewId = $_POST['review_id'] ?? null;
        $parentId = $_POST['parent_id'] ?? null;
        $userId = 32;
        $comment_text = $_POST['comment_text'] ?? '';
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
        // echo "Parent ID: $parentId, User ID: $userId, Comment: $comment_text, Product ID: $productId";
        // exit;
        if(!empty($comment_text) && !empty($userId) && !empty($productId)) {
            $this->model->createReplyReview($userId, $productId, $parentId, $comment_text);
            header('Location: /admin/reviews/detail?id=' . $reviewId);
            exit;
        } else {
            echo "Error: Missing required fields.";
        }
    }


}
?>