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
    <style>
        .comment-detail__reply--nested {
            border-left: 2px solid #e1e5e9;
            background-color: #f8f9fa;
        }
        .comment-detail__reply-form-inline {
            margin-top: 10px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .comment-detail__inline-textarea {
            width: 100%;
            min-height: 60px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
            resize: vertical;
        }
        .comment-detail__inline-actions {
            margin-top: 8px;
            display: flex;
            gap: 8px;
        }
        .comment-detail__inline-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .comment-detail__inline-btn--primary {
            background-color: #007bff;
            color: white;
        }
        .comment-detail__inline-btn--secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Debug: Uncomment to view $comment data -->
    <?php if (isset($_GET['debug'])): ?>
    <div style="background: #f8f9fa; padding: 20px; margin: 20px; border-radius: 8px;">
        <h3>Debug Data:</h3>
        <pre style="max-height: 400px; overflow-y: auto; background: white; padding: 15px; border-radius: 4px;">
<?php echo json_encode($comment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>
        </pre>
    </div>
    <?php endif; ?>
    
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="comment-detail">
            <div class="comment-detail__container">
                <!-- Header -->
                <div class="comment-detail__header">
                    <h1 class="page__title">Chi tiết Bình luận #<?php echo str_pad($comment['id'], 3, '0', STR_PAD_LEFT); ?></h1>
                    <a href="/admin/comments" class="comment-detail__back-link">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại danh sách / Chi tiết Bình luận #<?php echo str_pad($comment['id'], 3, '0', STR_PAD_LEFT); ?>
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
                                <textarea class="comment-detail__textarea" id="main-reply-content" placeholder="Nhập nội dung phản hồi..."></textarea>
                                
                                <div class="comment-detail__form-actions">
                                    <button class="comment-detail__btn comment-detail__btn--primary" onclick="submitMainReply()">
                                        <i class="fas fa-paper-plane"></i>
                                        Gửi phản hồi
                                    </button>
                                    <button class="comment-detail__btn comment-detail__btn--secondary" onclick="hideMainReplyForm()">
                                        <i class="fas fa-times"></i>
                                        Hủy
                                    </button>
                                </div>
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
                            <h4 class="comment-detail__panel-title">Hành động</h4>
                            <div class="comment-detail__action-buttons">
                                <?php if ($comment['status'] !== 'approved'): ?>
                                    <button class="comment-detail__action-button comment-detail__action-button--approve" data-comment-id="<?php echo $comment['id']; ?>">
                                        ✓ Chấp nhận
                                    </button>
                                <?php endif; ?>
                                <?php if ($comment['status'] !== 'rejected'): ?>
                                    <button class="comment-detail__action-button comment-detail__action-button--reject" data-comment-id="<?php echo $comment['id']; ?>">
                                        ✗ Từ chối
                                    </button>
                                <?php endif; ?>
                                <button class="comment-detail__action-button comment-detail__action-button--edit" data-comment-id="<?php echo $comment['id']; ?>">
                                    ✎ Chỉnh sửa
                                </button>
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
    </main>

    <script>
        // Show/Hide main reply form
        function showMainReplyForm() {
            document.getElementById('main-reply-form').style.display = 'block';
        }

        function hideMainReplyForm() {
            document.getElementById('main-reply-form').style.display = 'none';
            document.getElementById('main-reply-content').value = '';
        }

        // Show/Hide inline reply forms
        function showReplyForm(replyId) {
            document.getElementById('reply-form-' + replyId).style.display = 'block';
        }

        function hideReplyForm(replyId) {
            document.getElementById('reply-form-' + replyId).style.display = 'none';
            const textarea = document.querySelector('#reply-form-' + replyId + ' textarea');
            if (textarea) textarea.value = '';
        }

        // Submit main reply
        function submitMainReply() {
            const content = document.getElementById('main-reply-content').value.trim();
            if (!content) {
                alert('Vui lòng nhập nội dung phản hồi!');
                return;
            }
            console.log('Submitting main reply:', {
                parent_id: <?php echo $comment['id']; ?>,
                content: content
            });
            hideMainReplyForm();
            alert('Phản hồi đã được gửi!');
        }

        // Handle reply button clicks
        document.addEventListener('DOMContentLoaded', function() {
            // Handle reply buttons
            document.querySelectorAll('.comment-detail__reply-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const replyId = this.getAttribute('data-reply-to');
                    showReplyForm(replyId);
                });
            });

            // Handle inline reply submissions
            document.querySelectorAll('.comment-detail__inline-btn--primary').forEach(button => {
                button.addEventListener('click', function() {
                    const parentId = this.getAttribute('data-parent-id');
                    const textarea = document.querySelector(`textarea[data-parent-id="${parentId}"]`);
                    const content = textarea.value.trim();

                    if (!content) {
                        alert('Vui lòng nhập nội dung phản hồi!');
                        return;
                    }

                    // TODO: Implement AJAX call to submit nested reply
                    console.log('Submitting nested reply:', {
                        parent_id: parentId,
                        content: content
                    });

                    // For now, just hide the form
                    hideReplyForm(parentId);
                    alert('Phản hồi đã được gửi!');
                });
            });
        });
    </script>
</body>
</html>

<?php
// Hàm đệ quy để render nested replies - FIXED VERSION
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