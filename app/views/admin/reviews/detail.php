<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Review #<?php echo htmlspecialchars($review['review_id']); ?></title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>

<body>
    <!-- <?php
    echo '<pre>';
    print_r($review);
    echo '</pre>';
    ?> -->
    <?php echo $htmlHeader; ?>
    <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
    <div class="notification notification--success show" id="success-notification">
        <p id="success-message"><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
    <div class="notification notification--error" id="error-notification">
        <p id="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="review-detail">
            <div class="review-detail__header">
                <h1 class="review-detail__title">Chi tiết Review #<?php echo htmlspecialchars($review['review_id']); ?>
                </h1>
                <p class="review-detail__subtitle">Quản lý và xử lý đánh giá sản phẩm</p>
            </div>
            <div class="review-detail__breadcrumb">
                <a href="/admin/reviews" class="review-detail__breadcrumb-link">← Quay lại danh sách / Chi tiết Review
                    #<?php echo htmlspecialchars($review['review_id']); ?></a>
            </div>
            <div class="review-detail__content">
                <div class="review-detail__main">
                    <div class="review-detail__user-section">
                        <div class="review-detail__user-info">
                            <div class="review-detail__user-avatar">
                                <img src="<?php echo htmlspecialchars($review['user_avatar'] ?? '/img/avatar/default-avatar.jpg'); ?>"
                                    alt="Avatar" class="reviews__user-avatar">
                            </div>
                            <div class="review-detail__user-details">
                                <h3 class="review-detail__user-name">
                                    <?php echo htmlspecialchars($review['user_name']); ?></h3>
                                <p class="review-detail__user-meta">Khách hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="review-detail__stats">
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Đánh giá</span>
                            <div class="review-detail__rating">
                                <div class="review-detail__stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span
                                        class="review-detail__star <?php echo $i <= $review['rating'] ? 'review-detail__star--filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <span
                                    class="review-detail__rating-text"><?php echo htmlspecialchars($review['rating']); ?>/5</span>
                            </div>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Ngày tạo</span>
                            <span
                                class="review-detail__stat-value"><?php echo date('d/m/Y H:i', strtotime($review['review_date'])); ?></span>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Trạng thái</span>
                            <span
                                class="review-detail__stat-value review-detail__status review-detail__status--<?php echo strtolower(htmlspecialchars($review['status'])); ?>">
                                <?php 
                                    $statusText = [
                                        'pending' => 'Đang chờ xử lý',
                                        'active' => 'Đã chấp nhận',
                                        'inactive' => 'Đã từ chối'
                                    ];
                                    echo htmlspecialchars($statusText[strtolower($review['status'])] ?? ucfirst($review['status']));
                                    ?>
                            </span>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">ID Review</span>
                            <span
                                class="review-detail__stat-value">#<?php echo htmlspecialchars($review['review_id']); ?></span>
                        </div>
                    </div>
                    <div class="review-detail__product-section">
                        <h2 class="review-detail__section-title">Thông tin sản phẩm</h2>
                        <div class="review-detail__product-info">
                            <div class="review-detail__product-image">
                                <div class="review-detail__product-placeholder">📱</div>
                            </div>
                            <div class="review-detail__product-details">
                                <h3 class="review-detail__product-name">
                                    <?php echo htmlspecialchars($review['product_name']); ?></h3>
                                <p class="review-detail__product-price">
                                    <?php echo number_format($review['base_price'], 0, ',', '.') . ' VNĐ'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="review-detail__review-section">
                        <h2 class="review-detail__section-title">Nội dung đánh giá</h2>
                        <div class="review-detail__review-content">
                            <p class="review-detail__content--text">
                                <?php echo htmlspecialchars($review['comment_text']) ?></p>
                        </div>
                        <div class="review-detail__reply-section">
                            <a class="reply-link reply-trigger"
                                data-target="reply-form-main-<?php echo $review['review_id']?>">
                                Trả lời
                            </a>
                            <div id="reply-form-main-<?php echo $review['review_id']?>" class="reply-form"
                                style="display: none;">
                                <form action="/admin/reviews/reply" method="POST">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <input type="hidden" name="product_id"
                                        value="<?php echo htmlspecialchars($review['product_id']); ?>">
                                    <input type="hidden" name="parent_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <textarea name="comment_text" class="reply-form__textarea"
                                        placeholder="Nhập phản hồi của bạn..." required></textarea>
                                    <div class="reply-form__actions">
                                        <button type="button" class="reply-btn reply-btn--secondary reply-form__cancel"
                                            data-target="reply-form-main-<?php echo $review['review_id']?>">Hủy</button>
                                        <button type="submit" class="reply-btn">Gửi phản hồi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="review-detail__review-section">
                        <h2 class="review-detail__section-title">Phản hồi</h2>
                        <?php if (!empty($review['replies'])): ?>
                        <?php
                            function displayReplies($replies, $depth = 0, $reviewData = []) {
                                if (empty($replies)) return;
                                $marginLeft = ($depth === 0) ? 0 : (($depth === 1) ? 10 : 15);
                                $containerClass = 'review-detail__review-content review-detail__reply';
                                $containerStyle = "margin-left: {$marginLeft}px;";
                                if ($depth >= 3) {
                                    $containerStyle .= " border: 0; padding: 0; margin-top: 0; margin-left: 0;";
                                }
                                foreach ($replies as $index => $reply): ?>
                        <div class="<?php echo $containerClass; ?>" style="<?php echo $containerStyle; ?>">
                            <div class="review-detail__user-info">
                                <div class="review-detail__user-avatar">
                                    <img src="<?php echo htmlspecialchars($reply['user_avatar'] ?? '/img/avatar/default-avatar.jpg'); ?>"
                                        alt="Avatar" class="reviews__user-avatar">
                                </div>
                                <div class="review-detail__user-details">
                                    <h3 class="review-detail__user-name">
                                        <?php echo htmlspecialchars($reply['user_name'] ?? 'N/A'); ?></h3>
                                    <p class="review-detail__user-meta">
                                        Phản hồi vào
                                        <?php echo date('d/m/Y H:i', strtotime($reply['review_date'] ?? 'now')); ?>
                                    </p>
                                </div>
                            </div>
                            <p class="review-detail__content--text">
                                <?php echo htmlspecialchars($reply['comment_text'] ?? 'N/A')?></p>
                            <?php if (isset($reply['rating']) && !empty($reply['rating'])): ?>
                            <div class="review-detail__rating" style="margin-top: 5px;">
                                <div class="review-detail__stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span
                                        class="review-detail__star <?php echo $i <= $reply['rating'] ? 'review-detail__star--filled' : ''; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <span
                                    class="review-detail__rating-text"><?php echo htmlspecialchars($reply['rating']); ?>/5</span>
                            </div>
                            <?php endif; ?>
                            <div class="review-detail__reply-section">
                                <a class="reply-link reply-trigger"
                                    data-target="reply-form-<?php echo $reply['review_id']; ?>-<?php echo $depth; ?>">
                                    Trả lời
                                </a>
                                <div id="reply-form-<?php echo $reply['review_id']; ?>-<?php echo $depth; ?>"
                                    class="reply-form" style="display: none;">
                                    <form action="/admin/reviews/reply" method="POST">
                                        <input type="hidden" name="review_id"
                                            value="<?php echo htmlspecialchars($reviewData['review_id'] ?? ''); ?>">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo htmlspecialchars($reviewData['product_id'] ?? ''); ?>">
                                        <input type="hidden" name="parent_id"
                                            value="<?php echo htmlspecialchars($reply['review_id'] ?? ''); ?>">
                                        <input type="hidden" name="reply_depth" value="<?php echo $depth + 1; ?>">
                                        <textarea name="comment_text" class="reply-form__textarea"
                                            placeholder="Nhập phản hồi của bạn..." required></textarea>
                                        <div class="reply-form__actions">
                                            <button type="button"
                                                class="reply-btn reply-btn--secondary reply-form__cancel"
                                                data-target="reply-form-<?php echo $reply['review_id']; ?>-<?php echo $depth; ?>">Hủy</button>
                                            <button type="submit" class="reply-btn">Gửi phản hồi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php if (!empty($reply['replies'])): ?>
                            <?php displayReplies($reply['replies'], $depth + 1, $reviewData); ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach;
                            }
                            displayReplies($review['replies'], 0, $review);
                            ?>
                        <?php else: ?>
                        <p>Chưa có phản hồi nào.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="review-detail__sidebar">
                    <div class="review-detail__actions-section">
                        <h3 class="review-detail__actions-title">Hành động</h3>
                        <div class="review-detail__actions">
                            <div class="review-detail__actions-row">
                                <?php if ($review['status'] === 'pending'): ?>
                                <!-- Form cho Chấp nhận -->
                                <form action="/admin/reviews/update-status" method="POST" class="review-detail__form">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--accept"
                                        onclick="return confirm('Bạn có chắc chắn chấp nhận đánh giá này không?');">
                                        <i class="fas fa-check"></i> Chấp nhận
                                    </button>
                                </form>
                                <!-- Form cho Từ chối -->
                                <form action="/admin/reviews/update-status" method="POST" class="review-detail__form">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <input type="hidden" name="status" value="inactive">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--reject"
                                        onclick="return confirm('Bạn có chắc chắn từ chối đánh giá này không?');">
                                        <i class="fas fa-times"></i> Từ chối
                                    </button>
                                </form>
                                <!-- Form cho Xóa -->
                                <form action="/admin/reviews/delete" method="POST" class="review-detail__form">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                                <?php elseif ($review['status'] === 'active'): ?>
                                <!-- Form cho Xóa -->
                                <form action="/admin/reviews/delete" method="POST" class="review-detail__form">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                                <?php elseif ($review['status'] === 'inactive'): ?>
                                <!-- Form cho Khôi phục -->
                                <form action="/admin/reviews/update-status" method="POST" class="review-detail__form">
                                    <input type="hidden" name="review_id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--restore"
                                        onclick="return confirm('Bạn có chắc muốn khôi phục đánh giá này không?');">
                                        <i class="fas fa-undo"></i> Khôi phục
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <div class="review-detail__actions-row">
                                <!-- Form cho Chỉnh sửa -->
                                <form action="/admin/reviews/edit" method="GET" class="review-detail__form">
                                    <input type="hidden" name="id"
                                        value="<?php echo htmlspecialchars($review['review_id']); ?>">
                                    <button type="submit"
                                        class="review-detail__action-btn review-detail__action-btn--edit">
                                        <i class="fas fa-edit"></i> Chỉnh sửa
                                    </button>
                                </form>
                                <!-- Nút Quay lại -->
                                <button class="review-detail__action-btn review-detail__action-btn--back"
                                    onclick="window.location.href='/admin/reviews'">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="review-detail__activity-section">
                        <h3 class="review-detail__sidebar-title">Lịch sử hoạt động</h3>
                        <div class="review-detail__activity-list">
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">📋</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Review được tạo</p>
                                    <span
                                        class="review-detail__activity-time"><?php echo date('d/m/Y H:i', strtotime($review['created_at'])); ?></span>
                                </div>
                            </div>
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">👤</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Admin xem chi tiết</p>
                                    <span class="review-detail__activity-time"><?php echo date('d/m/Y H:i'); ?></span>
                                </div>
                            </div>
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">📋</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Cập nhật trạng thái</p>
                                    <span class="review-detail__activity-time">
                                        <?php echo date('d/m/Y H:i', strtotime($review['updated_at'])); ?> -
                                        <span
                                            class="review-detail__status review-detail__status--<?php echo strtolower(htmlspecialchars($review['status'])); ?>">
                                            <?php 
                                        $statusText = [
                                            'pending' => 'Đang chờ xử lý',
                                            'active' => 'Đã chấp nhận',
                                            'inactive' => 'Đã từ chối'
                                        ];
                                        echo htmlspecialchars($statusText[strtolower($review['status'])] ?? ucfirst($review['status']));
                                        ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-detail__info-section">
                        <h3 class="review-detail__sidebar-title">Thông tin thêm</h3>
                        <div class="review-detail__info-list">
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">IP Address:</span>
                                <span class="review-detail__info-value">N/A</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Thiết bị:</span>
                                <span class="review-detail__info-value">N/A</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Trình duyệt:</span>
                                <span class="review-detail__info-value">N/A</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Địa chỉ:</span>
                                <span class="review-detail__info-value">N/A</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
    <script type="module" src="/admin-ui/js/pages/review-detail.js"></script>
</body>

</html>