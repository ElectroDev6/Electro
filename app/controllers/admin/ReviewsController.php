<?php
namespace App\Controllers\Admin;
use App\Controllers\Admin\Reviews\CreateReviewController;
use App\Controllers\Admin\Reviews\UpdateReviewController;
use App\Controllers\Admin\Reviews\DeleteReviewController;
use App\Controllers\Admin\Reviews\ReadReviewController;

class ReviewsController
{
    public function index()
    {
        $controller = new ReadReviewController();
        $controller->list();
    }

    public function create()
    {
        $controller = new CreateReviewController();
        $controller->index();
    }

    public function handleCreate()
    {
        $controller = new CreateReviewController();
        $controller->handleCreate();
    }

     public function handleRepl()
    {
        $controller = new CreateReviewController();
        $controller->handleRepliesReview();
    }

    public function detail()
    {
        $controller = new ReadReviewController();
        $controller->detail();
    }

    public function updateStatus()
    {
        $controller = new UpdateReviewController();
        $controller->handleUpdateStatus();
    }

    public function handleUpdate()
    {
        $controller = new UpdateReviewController();
        $controller->handle();
    }

    public function delete()
    {
        DeleteReviewController::handle();
    }
}

?>