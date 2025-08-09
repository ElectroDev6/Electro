<?php
namespace App\Controllers\Admin;

use App\Models\CommentsModel;
use Container;
use Core\View;

class CommentDetailController
{
    public function index()
    {
        $pdo = Container::get('pdo');
        $commentDetail = new CommentsModel($pdo);
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /admin/comments?error=ID bình luận không hợp lệ");
            exit;
        }
        $comments = $commentDetail->getAllComments();
        $comment = null;
        foreach ($comments as $m) {
            if ($m['id'] == $id) {
                $comment = $m;
                break;
            }
        }

        if (!$comment) {
            header("Location: /admin/comments?error=Bình luận không tồn tại");
            exit;
        }

        View::render('commentDetail', [
            'comment' => $comment,
        ]);
    }

    public function approve()
    {
        $commentId = $_POST['id'] ?? null;
        if (!$commentId || !is_numeric($commentId)) {
            header("Location: /admin/comments?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new CommentsModel($pdo);
        $result = $model->update($commentId, ['status' => 'approved']);

        header("Location: /admin/comments?" . ($result ? "success=Bình luận đã được chấp nhận" : "error=Lỗi khi chấp nhận"));
        exit;
    }

    public function reject()
    {
        $commentId = $_POST['id'] ?? null;
        if (!$commentId || !is_numeric($commentId)) {
            header("Location: /admin/comments?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new CommentsModel($pdo);
        $result = $model->update($commentId, ['status' => 'rejected']);

        header("Location: /admin/comments?" . ($result ? "success=Bình luận đã bị từ chối" : "error=Lỗi khi từ chối"));
        exit;
    }

    public function delete()
    {
        $commentId = $_POST['id'] ?? null;
        if (!$commentId || !is_numeric($commentId)) {
            header("Location: /admin/comments?error=ID không hợp lệ");
            exit;
        }

        $pdo = Container::get('pdo');
        $model = new CommentsModel($pdo);
        $result = $model->deleteComment($commentId);

        header("Location: /admin/comments?" . ($result ? "success=Bình luận đã bị xoá" : "error=Không thể xoá bình luận"));
        exit;
    }

   public function edit()
{
    $pdo = Container::get('pdo');
    $model = new CommentsModel($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /admin/comments?error=ID không hợp lệ");
            exit;
        }

        $comments = $model->getAllComments();
        $comment = null;
        foreach ($comments as $m) {
            if ($m['id'] == $id) {
                $comment = $m;
                break;
            }
        }

        if (!$comment) {
            header("Location: /admin/comments?error=Bình luận không tồn tại");
            exit;
        }

        View::render('editComment', ['comment' => $comment]);
        return;
    }

    // Xử lý POST (submit form)
    $id = $_POST['id'] ?? null;
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'pending';

    if (!$id || $content === '') {
        header("Location: /admin/comments/edit?id=$id&error=Dữ liệu không hợp lệ");
        exit;
    }

    $result = $model->update($id, [
        'content' => $content,
        'status' => $status
    ]);

    header("Location: /admin/comments?" . ($result ? "success=Cập nhật thành công" : "error=Cập nhật thất bại"));
    exit;
}


    public function reply()
    {
        $pdo = Container::get('pdo');
        $model = new CommentsModel($pdo);
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: /admin/comments?error=ID bình luận không hợp lệ");
            exit;
        }

        $comments = $model->getAllComments();
        $comment = null;
        foreach ($comments as $m) {
            if ($m['id'] == $id) {
                $comment = $m;
                break;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = trim($_POST['main-reply-content'] ?? '');
            if (!$content) {
                header("Location: /admin/commentDetail?id=$id&error=Nội dung phản hồi không được để trống");
                exit;
            }

            $result = $model->createCommentReply([
                'product_id' => $comment['product_id'],
                'user_id' => 1,
                'cmt_replie' => $comment['id'],
                'content' => $content,
                'likes' => 0,
                'status' => 'approved',
                'hidden_comment' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header("Location: /admin/commentDetail?id=$id&" . ($result ? "success=Đã phản hồi bình luận" : "error=Phản hồi thất bại"));
            exit;
        }
    }
}
