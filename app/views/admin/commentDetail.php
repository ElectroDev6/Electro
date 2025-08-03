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
    <title>Chi tiết Bình luận #<?php echo str_pad($comment['id'], 3, '0', STR_PAD_LEFT); ?></title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="comment-detail">
            <div class="comment-detail__container">
                <!-- Header -->
                <div class="comment-detail__header">
                    <h1 class="page__title">Chi tiết Bình luận #<?php $comment['id']?></h1>
                    <a href="/admin/comments" class="comment-detail__back-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại danh sách / Chi tiết Bình luận #<?php echo $comment['id']?>
                    </a>
                </div>

                <div class="comment-detail__content">
                    <!-- Main Content -->
                    <div class="comment-detail__main">
                        <!-- Main Comment -->
                        <div class="comment-detail__main-comment">
                            <div class="comment-detail__comment-card">
                                <div class="comment-detail__user-info">
                                    <div class="comment-detail__avatar">
                                        <span class="comment-detail__avatar-text"><?php echo strtoupper(substr($comment['user']['full_name'] ?? 'N/A', 0, 1)); ?></span>
                                    </div>
                                    <div class="comment-detail__user-details">
                                        <h3 class="comment-detail__username"><?php echo htmlspecialchars($comment['user']['full_name'] ?? 'N/A'); ?></h3>
                                        <div class="comment-detail__meta">
                                            <span class="comment-detail__timestamp"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></span>
                                            <span class="comment-detail__device"><?php echo htmlspecialchars($comment['product']['name'] ?? 'N/A'); ?></span>
                                            <span class="comment-detail__status comment-detail__status--<?php echo $comment['status']; ?>">
                                                <?php
                                                $statusMap = [
                                                    'pending' => 'Chờ duyệt',
                                                    'approved' => 'Đã duyệt',
                                                    'rejected' => 'Từ chối'
                                                ];
                                                echo htmlspecialchars($statusMap[$comment['status']] ?? ucfirst($comment['status']));
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="comment-detail__comment-content">
                                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                </div>

                                <div class="comment-detail__actions">
                                    <button class="comment-detail__action-btn comment-detail__action-btn--like">
                                        <i class="far fa-thumbs-up"></i>
                                        <span><?php echo $comment['likes']; ?></span>
                                    </button>
                                    <button class="comment-detail__action-btn" onclick="showMainReplyForm()">
                                        Phản hồi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reply Section -->
                        <div class="comment-detail__reply-section">
                            <?php $totalReplies = countAllReplies($comment['replies']); ?>
                            <h4 class="comment-detail__reply-title">Phản hồi (<?php echo $totalReplies; ?>)</h4>
                            <div class="comment-detail__reply-form" id="main-reply-form" style="display: none;">
                                <label class="comment-detail__form-label">Phản hồi với tư cách</label>
                                <select class="comment-detail__select">
                                    <option>Admin shop</option>
                                </select>
                                <label class="comment-detail__form-label">Nội dung phản hồi</label>
                       <form id="main-reply-form" method="POST" action="/admin/commentDetail/reply?id=<?php echo $comment['id'] ?>">
                        <textarea class="comment-detail__textarea" id="main-reply-content" name="main-reply-content" placeholder="Nhập nội dung phản hồi..."></textarea>
                        <div class="comment-detail__form-actions">
                            <button type="submit" class="comment-detail__btn comment-detail__btn--primary">
                                Gửi phản hồi
                            </button>
                            <button type="button" class="comment-detail__btn comment-detail__btn--secondary" onclick="hideMainReplyForm()">
                                <i class="fas fa-times"></i>
                                Hủy
                            </button>
                        </div>
                    </form>
                            </div>

                            <!-- Replies List -->
                            <div class="comment-detail__replies-list">
                                <?php if (!empty($comment['replies'])): ?>
                                    <?php renderReplies($comment['replies']); ?>
                                <?php else: ?>
                                    <p class="comment-detail__no-replies">Chưa có phản hồi nào.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="comment-detail__sidebar">
                        <!-- Actions -->
                        <div class="comment-detail__actions-panel">
                        <div class="comment-detail__actions-panel">
                            <h4 class="comment-detail__panel-title">Hành động</h4>
                            <div class="comment-detail__action-buttons">

                                <?php if ($comment['status'] !== 'approved'): ?>
                                <form action="/admin/comments/approve" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $comment['id']; ?>">
                                    <button type="submit" class="comment-detail__action-button comment-detail__action-button--approve"
                                            onclick="return confirm('Bạn có chắc muốn chấp nhận bình luận này không?')">
                                        ✓ Chấp nhận
                                    </button>
                                </form>

                                <?php endif; ?>
                                <?php if ($comment['status'] === 'approved'): ?>
                                    <button class="comment-detail__action-button comment-detail__action-button--hide" 
                                            data-comment-id="<?= $comment['id']; ?>">
                                        👁️‍🗨️ Ẩn
                                    </button>
                                <?php elseif ($comment['status'] !== 'rejected'): ?>
                                    <form action="/admin/comments/reject" method="POST" style="display: inline">
                                        <input type="hidden" name="id" value="<?= $comment['id']; ?>">
                                        <button type="submit" class="comment-detail__action-button comment-detail__action-button--reject"
                                                onclick="return confirm('Bạn có chắc muốn từ chối bình luận này không?')">
                                            ✗ Từ chối
                                        </button>
                                    </form>
                                <?php endif; ?>
                                    <a href="/admin/comments/edit?id=<?php echo $comment['id']; ?>" class="comment-detail__action-button comment-detail__action-button--edit" data-comment-id="<?php echo $comment['id']; ?>">
                                    ✎ Chỉnh sửa
                                </a>
                                <form action="/admin/comments/delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                                 <button class="comment-detail__btn comment-detail__btn--delete" type=submit>
                                    Xóa
                                </button>
                            </form>
                            </div>
                        </div>

                        <!-- Comment Statistics -->
                        <div class="comment-detail__stats-panel">
                            <h4 class="comment-detail__panel-title">Thống kê</h4>
                            <div class="comment-detail__stats-list">
                                <div class="comment-detail__stat-item">
                                    <span class="comment-detail__stat-label">Tổng phản hồi:</span>
                                    <span class="comment-detail__stat-value"><?php echo $totalReplies; ?></span>
                                </div>
                                <div class="comment-detail__stat-item">
                                    <span class="comment-detail__stat-label">Lượt thích:</span>
                                    <span class="comment-detail__stat-value"><?php echo $comment['likes']; ?></span>
                                </div>
                                <div class="comment-detail__stat-item">
                                    <span class="comment-detail__stat-label">Trạng thái:</span>
                                    <span class="comment-detail__stat-value"><?php echo $statusMap[$comment['status']] ?? ucfirst($comment['status']); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Log -->
                        <div class="comment-detail__activity-panel">
                            <h4 class="comment-detail__panel-title">Lịch sử hoạt động</h4>
                            <div class="comment-detail__activity-list">
                                <div class="comment-detail__activity-item">
                                    <div class="comment-detail__activity-icon">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                    <div class="comment-detail__activity-content">
                                        <div class="comment-detail__activity-title">Bình luận được tạo</div>
                                        <div class="comment-detail__activity-time"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></div>
                                    </div>
                                </div>
                                <div class="comment-detail__activity-item">
                                    <div class="comment-detail__activity-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="comment-detail__activity-content">
                                        <div class="comment-detail__activity-title">Admin xem chi tiết</div>
                                        <div class="comment-detail__activity-time"><?php echo date('d/m/Y H:i', time()); ?></div>
                                    </div>
                                </div>
                                <div class="comment-detail__activity-item">
                                    <div class="comment-detail__activity-icon">
                                        <i class="fas fa-question"></i>
                                    </div>
                                    <div class="comment-detail__activity-content">
                                        <div class="comment-detail__activity-title">Hiện tại</div>
                                        <div class="comment-detail__activity-time"><?php echo $statusMap[$comment['status']] ?? ucfirst($comment['status']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="comment-detail__info-panel">
                            <h4 class="comment-detail__panel-title">Thông tin thêm</h4>
                            <div class="comment-detail__info-list">
                                <div class="comment-detail__info-item">
                                    <span class="comment-detail__info-label">User ID:</span>
                                    <span class="comment-detail__info-value"><?php echo $comment['user']['id']; ?></span>
                                </div>
                                <div class="comment-detail__info-item">
                                    <span class="comment-detail__info-label">Email:</span>
                                    <span class="comment-detail__info-value"><?php echo htmlspecialchars($comment['user']['username'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="comment-detail__info-item">
                                    <span class="comment-detail__info-label">Phone:</span>
                                    <span class="comment-detail__info-value"><?php echo htmlspecialchars($comment['user']['phone'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="comment-detail__info-item">
                                    <span class="comment-detail__info-label">Sản phẩm:</span>
                                    <span class="comment-detail__info-value"><?php echo htmlspecialchars($comment['product']['name'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="comment-detail__info-item">
                                    <span class="comment-detail__info-label">Danh mục:</span>
                                    <span class="comment-detail__info-value"><?php echo htmlspecialchars($comment['product']['category']['name'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($successMessage)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php endif; ?>
        <script type="module" src="/admin-ui/js/pages/comment-detail.js"></script>
    </main>
</body>
</html>

<?php
function renderReplies(array $replies, int $depth = 0) {
    if (empty($replies)) {
        return;
    }
    
    foreach ($replies as $reply) {
        $nestedClass = $depth > 0 ? ' comment-detail__reply--nested' : '';
        $marginLeft = $depth * 20;
        ?>
        <div class="comment-detail__reply<?php echo $nestedClass; ?>" style="margin-left: <?php echo $marginLeft; ?>px;">
            <div class="comment-detail__reply-avatar">
                <span class="comment-detail__avatar-text"><?php echo strtoupper(substr($reply['user']['full_name'] ?? 'N/A', 0, 1)); ?></span>
            </div>
            <div class="comment-detail__reply-content">
                <div class="comment-detail__reply-header">
                    <span class="comment-detail__reply-username"><?php echo htmlspecialchars($reply['user']['full_name'] ?? 'N/A'); ?></span>
                    <?php if (isset($reply['user']['role']) && $reply['user']['role'] === 'admin'): ?>
                        <span class="comment-detail__reply-badge">ADMIN</span>
                    <?php endif; ?>
                    <span class="comment-detail__reply-timestamp"><?php echo date('d/m/Y H:i', strtotime($reply['created_at'])); ?></span>
                </div>
                <p class="comment-detail__reply-text"><?php echo htmlspecialchars($reply['content']); ?></p>
                <div class="comment-detail__reply-actions">
                    <span class="comment-detail__reply-like"><?php echo $reply['likes'] ?? 0; ?> 💗</span>
                    <button class="comment-detail__reply-btn" data-reply-to="<?php echo $reply['id']; ?>">Phản hồi</button>
                    <div class="comment-detail__reply-form-inline" id="reply-form-<?php echo $reply['id']; ?>" style="display: none;">
                        <textarea class="comment-detail__inline-textarea" placeholder="Viết bình luận của bạn..." data-parent-id="<?php echo $reply['id']; ?>"></textarea>
                        <div class="comment-detail__inline-actions">
                            <button class="comment-detail__inline-btn comment-detail__inline-btn--primary" data-parent-id="<?php echo $reply['id']; ?>">
                                <i class="fas fa-paper-plane"></i>
                                Gửi phản hồi
                            </button>
                            <button class="comment-detail__inline-btn comment-detail__inline-btn--secondary" onclick="hideReplyForm(<?php echo $reply['id']; ?>)">
                                <i class="fas fa-times"></i>
                                Hủy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        // Render nested replies nếu có - SỬ DỤNG ĐÚNG CẤU TRÚC NESTED
        if (!empty($reply['replies'])) {
            renderReplies($reply['replies'], $depth + 1);
        }
        ?>
        <?php
    }
}

// Hàm đếm tổng số replies (bao gồm cả nested)
function countAllReplies(array $replies): int {
    $count = count($replies);
    foreach ($replies as $reply) {
        if (!empty($reply['replies'])) {
            $count += countAllReplies($reply['replies']);
        }
    }
    return $count;
}
?>