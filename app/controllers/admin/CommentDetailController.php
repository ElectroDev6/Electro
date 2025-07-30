<?php 
namespace App\Controllers\Admin;
use App\Models\CommentsModel;
use container;
use Core\View;
    class CommentDetailController {
        public function index() {
            $pdo = Container::get('pdo');
            $commentDetail = new CommentsModel($pdo);
            $comments = $commentDetail->getAllComments();
            $id = $_GET['id'] ?? null;
            $comment = null;
            foreach ($comments as $m) {
                if ($m['id'] == $id) {
                    $comment = $m;
                    break;
                }
            }
            View::render('commentDetail', [
                'comment' => $comment
            ]);
        }
    }