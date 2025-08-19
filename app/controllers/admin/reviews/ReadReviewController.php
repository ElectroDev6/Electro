<?php
namespace App\Controllers\Admin\Reviews;
use App\Models\admin\ReviewsModel;
use App\Models\admin\UsersModel;
use Container;
use Core\View;

class ReadReviewController
{
    private ReviewsModel $model;
    private UsersModel $usersModel;
    public function __construct()
    {
        $pdo = Container::get('pdo');
        $this->model = new ReviewsModel($pdo);
        $this->usersModel = new UsersModel($pdo);
    }

    public function list()
    {
        // Sanitize and validate inputs
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $rating = isset($_GET['rating']) && is_numeric($_GET['rating']) && $_GET['rating'] >= 1 && $_GET['rating'] <= 5 ? (int)$_GET['rating'] : '';
        $status = isset($_GET['status']) && in_array($_GET['status'], ['approved', 'pending', 'rejected']) ? $_GET['status'] : '';
        $date_range = isset($_GET['date_range']) && in_array($_GET['date_range'], ['', 'last_7_days', 'last_30_days']) ? $_GET['date_range'] : '';
        $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? max(1, (int)$_GET['limit']) : 8;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        // Build filters array
        $filters = [];
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        if (!empty($rating)) {
            $filters['rating'] = $rating;
        }
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        if (!empty($date_range)) {
            $filters['date_range'] = $date_range;
        }

        $offset = ($page - 1) * $limit;
        try {
            $reviews = $this->model->getAllReviews($filters, $limit, $offset);
            $totalReviews = $this->model->getTotalReviews($filters);
            $totalPages = ceil($totalReviews / $limit);

            View::render('reviews/index', [
                'reviews' => $reviews,
                'totalReviews' => $totalReviews,
                'page' => $page,
                'reviewsPerPage' => $limit,
                'totalPages' => $totalPages,
                'search' => $search,
                'rating' => $rating,
                'status' => $status,
                'date_range' => $date_range,
                'limit' => $limit
            ]);
        } catch (Exception $e) {
            error_log("Error in ReadReviewController::list - " . $e->getMessage());
            View::render('reviews/index', [
                'reviews' => [],
                'totalReviews' => 0,
                'page' => 1,
                'reviewsPerPage' => $limit,
                'totalPages' => 1,
                'error' => 'An error occurred while fetching reviews.'
            ]);
        }
    }
       public function detail()
        {
            $id = $_GET['id'] ?? null;
            $userId = $_SESSION['user_id'] ?? null;

            if (!$id) {
                header('Location: /admin/reviews');
                exit;
            }
            $this->model->updateViewed($id);
            $user = $this->usersModel->getUserById($userId);

            // Lấy review kèm reply
            $review = $this->model->getReviewWithReplies($id);

            if (!$review) {
                header('Location: /admin/reviews');
                exit;
            }

            View::render('reviews/detail', [
                'review' => $review,
                'user'   => $user
            ]);
        }

}