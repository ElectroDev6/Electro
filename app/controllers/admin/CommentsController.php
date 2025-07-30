<?php
namespace App\Controllers\Admin;
use App\Models\CommentsModel;
use Container;
use Core\View;

class CommentsController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $commentsModel = new CommentsModel($pdo);
        $comments = $commentsModel->getAllComments();

        View::render('comments', [
            'comments' => $comments
        ]);
    }
}
?>