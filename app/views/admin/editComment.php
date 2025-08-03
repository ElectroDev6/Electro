<?php
namespace App\Views;
include dirname(__DIR__) . '/admin/partials/header.php';
include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Bình Luận</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        
        <div class="comment-detail">
            <div class="comment-detail__header">
                <h1 class="comment-detail__title">Chi Tiết Bình Luận</h1>
                <div class="comment-detail__actions">
                   <form action="/admin/comments/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                 <button class="comment-detail__btn comment-detail__btn--delete" type=submit>
                                    Xóa
                                </button>
                            </form>
                </div>
            </div>

            <div class="comment-detail__content">
                <!-- Main Comment Info -->
               <form method="POST" action="/admin/comments/editComment">
                <input type="hidden" name="id" value="<?= htmlspecialchars($comment['id']) ?>">
                    <div class="comment-detail__field comment-detail__field--readonly">
                        <label class="comment-detail__label">ID:</label>
                        <span class="comment-detail__value">#<?= $comment['id'] ?></span>
                        <small class="comment-detail__note">Không thể chỉnh sửa</small>
                    </div>

                    <div class="comment-detail__field comment-detail__field--required comment-detail__field--editable">
                        <label class="comment-detail__label">Nội Dung:</label>
                        <textarea name="content" class="comment-detail__textarea" rows="4" maxlength="1000"><?= htmlspecialchars($comment['content']) ?></textarea>
                        <div class="comment-detail__char-count">0/1000 ký tự</div>
                    </div>

                    <div class="comment-detail__field comment-detail__field--required comment-detail__field--editable">
                        <label class="comment-detail__label">Trạng Thái:</label>
                        <select name="status" class="comment-detail__select comment-detail__status">
                            <option value="pending" <?= $comment['status'] === 'pending' ? 'selected' : '' ?>>Chờ Duyệt</option>
                            <option value="approved" <?= $comment['status'] === 'approved' ? 'selected' : '' ?>>Đã Duyệt</option>
                            <option value="rejected" <?= $comment['status'] === 'rejected' ? 'selected' : '' ?>>Bị Từ Chối</option>
                            <option value="hidden" <?= $comment['status'] === 'hidden' ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>

                    <div class="comment-detail__form-actions">
                        <button type="submit" class="comment-detail__btn comment-detail__btn--primary">Lưu Thay Đổi</button>
                        <button type="button" class="comment-detail__btn comment-detail__btn--secondary" onclick="history.back()">Quay Lại</button>
                        <button type="button" class="comment-detail__btn comment-detail__btn--warning">Lịch Sử Thay Đổi</button>
                        <button type="button" class="comment-detail__btn comment-detail__btn--danger">Block User</button>
                    </div>
                </form>


                <!-- Additional Info -->
                <div class="comment-detail__sidebar">
                    <div class="comment-detail__card">
                        <h3 class="comment-detail__card-title">Thông Tin Người Dùng</h3>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Username:</label>
                            <span class="comment-detail__value"><?= isset($comment['user']['username']) ? htmlspecialchars($comment['user']['username']) : 'N/A' ?></span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Tên Đầy Đủ:</label>
                            <span class="comment-detail__value"><?= isset($comment['user']['full_name']) ? htmlspecialchars($comment['user']['full_name']) : 'N/A' ?></span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Số Điện Thoại:</label>
                            <span class="comment-detail__value"><?= isset($comment['user']['phone']) ? htmlspecialchars($comment['user']['phone']) : 'N/A' ?></span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Vai Trò:</label>
                            <span class="comment-detail__value">
                                <?php 
                                if (isset($comment['user']['role'])) {
                                    echo $comment['user']['role'] == '0' ? 'Quản trị viên' : ($comment['user']['role'] == '1' ? 'Người dùng' : 'Unknown');
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Tham Gia:</label>
                            <span class="comment-detail__value">
                                <?= isset($comment['user']['created_at']) ? date('d/m/Y H:i', strtotime($comment['user']['created_at'])) : 'N/A' ?>
                            </span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Địa Chỉ:</label>
                            <span class="comment-detail__value">
                                <?php 
                                $address_parts = [];
                                if (isset($comment['user']['address_line'])) $address_parts[] = $comment['user']['address_line'];
                                if (isset($comment['user']['ward'])) $address_parts[] = $comment['user']['ward'];
                                if (isset($comment['user']['district'])) $address_parts[] = $comment['user']['district'];
                                if (isset($comment['user']['city'])) $address_parts[] = $comment['user']['city'];
                                echo !empty($address_parts) ? implode(', ', $address_parts) : 'N/A';
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="comment-detail__card">
                        <h3 class="comment-detail__card-title">Thông Tin Sản Phẩm</h3>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Tên Sản Phẩm:</label>
                            <span class="comment-detail__value"><?= isset($comment['product']['name']) ? htmlspecialchars($comment['product']['name']) : 'N/A' ?></span>
                        </div>
                    </div>

                    <div class="comment-detail__card">
                        <h3 class="comment-detail__card-title">Thống Kê</h3>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Lượt Thích:</label>
                            <span class="comment-detail__value comment-detail__likes">
                                <i class="fas fa-heart"></i> <?= isset($comment['likes']) ? $comment['likes'] : 0 ?>
                            </span>
                        </div>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Phản Hồi:</label>
                            <span class="comment-detail__value"><?= isset($comment['replies']) ? count($comment['replies']) : 0 ?> phản hồi</span>
                        </div>
                        <?php if (isset($comment['cmt_replie']) && $comment['cmt_replie'] > 0): ?>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Phản hồi cho:</label>
                            <span class="comment-detail__value">Comment #<?= $comment['cmt_replie'] ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="comment-detail__field comment-detail__field--readonly">
                            <label class="comment-detail__label">Ngày Tạo:</label>
                            <span class="comment-detail__value">
                                <?= isset($comment['created_at']) ? date('d/m/Y H:i', strtotime($comment['created_at'])) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies Section -->
            <?php if (isset($comment['replies']) && !empty($comment['replies'])): ?>
            <div class="comment-detail__replies">
                <h3 class="comment-detail__replies-title">Phản Hồi (<?= count($comment['replies']) ?>)</h3>
                
                <?php foreach ($comment['replies'] as $reply): ?>
                <div class="comment-detail__reply">
                    <div class="comment-detail__reply-header">
                        <span class="comment-detail__reply-author"><?= htmlspecialchars($reply['user']['full_name'] ?? $reply['user']['username'] ?? 'Unknown') ?></span>
                        <span class="comment-detail__reply-date"><?= date('d/m/Y H:i', strtotime($reply['created_at'])) ?></span>
                    </div>
                    <div class="comment-detail__reply-content">
                        <?= htmlspecialchars($reply['content']) ?>
                    </div>
                    <div class="comment-detail__reply-actions">
                        <button class="comment-detail__reply-btn">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="comment-detail__reply-btn comment-detail__reply-btn--delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Change History Modal (Hidden by default) -->
            <div class="comment-detail__modal" id="history-modal" style="display: none;">
                <div class="comment-detail__modal-content">
                    <div class="comment-detail__modal-header">
                        <h3>Lịch Sử Thay Đổi</h3>
                        <button class="comment-detail__modal-close">&times;</button>
                    </div>
                    <div class="comment-detail__modal-body">
                        <div class="comment-detail__history-item">
                            <div class="comment-detail__history-date"><?= isset($comment['created_at']) ? date('d/m/Y H:i', strtotime($comment['created_at'])) : 'N/A' ?></div>
                            <div class="comment-detail__history-user">User: <?= htmlspecialchars($comment['user']['full_name'] ?? $comment['user']['username'] ?? 'Unknown') ?></div>
                            <div class="comment-detail__history-action">Tạo bình luận</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>