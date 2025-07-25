<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/pagination.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Đơn hàng #001</title>
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
                <h1 class="page__title">Chi tiết Comments #001</h1>
                <a href="#" class="comment-detail__back-link">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại danh sách / Chi tiết Comments #001
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
                                    <span class="comment-detail__avatar-text">Đ</span>
                                </div>
                                <div class="comment-detail__user-details">
                                    <h3 class="comment-detail__username">Nguyễn Văn Đức</h3>
                                    <div class="comment-detail__meta">
                                        <span class="comment-detail__timestamp">15/07/2025 14:30</span>
                                        <span class="comment-detail__device">iPhone 14 Pro Max</span>
                                        <span class="comment-detail__status comment-detail__status--online">online</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment-detail__comment-content">
                                <p>Sản phẩm rất tuyệt vời, chất lượng tốt, giao hàng nhanh. Tôi rất hài lòng về sản phẩm này. Mình mua đi để chơi thử xem thế nào chứ thật ra cũng không tin lắm, nhưng mà về thật trải nghiệm thì nó rất ok thế. Sẽ tiếp tục ủng hộ thêm về sản phẩm mình đi sau này để mua 2 shop này. Mình hẹn các bạn lần tới cho bản thêm 2 shop này. Mình hẹn các đây, camera chụp hình rất tốt. Sẽ giới thiệu cho bạn bè mua 2 shop này.</p>
                            </div>

                            <div class="comment-detail__actions">
                                <button class="comment-detail__action-btn comment-detail__action-btn--like">
                                    <i class="far fa-thumbs-up"></i>
                                    <span>15</span>
                                </button>
                                <button class="comment-detail__action-btn">
                                    Phản hồi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Section -->
                    <div class="comment-detail__reply-section">
                        <h4 class="comment-detail__reply-title">Phản hồi (4)</h4>
                        
                        <div class="comment-detail__reply-form">
                            <label class="comment-detail__form-label">Phản hồi với tư cách</label>
                            <select class="comment-detail__select">
                                <option>Admin shop</option>
                            </select>
                            
                            <label class="comment-detail__form-label">Nội dung phản hồi</label>
                            <textarea class="comment-detail__textarea" placeholder="Nhập nội dung phản hồi..."></textarea>
                            
                            <div class="comment-detail__form-actions">
                                <button class="comment-detail__btn comment-detail__btn--primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Gửi phản hồi
                                </button>
                                <button class="comment-detail__btn comment-detail__btn--secondary">
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>
                            </div>
                        </div>

                        <!-- Replies List -->
                        <div class="comment-detail__replies-list">
                            <!-- Admin Reply -->
                            <div class="comment-detail__reply">
                                <div class="comment-detail__reply-avatar">
                                    <span class="comment-detail__avatar-text">A</span>
                                </div>
                                <div class="comment-detail__reply-content">
                                    <div class="comment-detail__reply-header">
                                        <span class="comment-detail__reply-username">AdminShop</span>
                                        <span class="comment-detail__reply-badge">ADMIN</span>
                                        <span class="comment-detail__reply-timestamp">15/07/2025 14:30</span>
                                    </div>
                                    <p class="comment-detail__reply-text">Cám ơn bạn đã tin tưởng và mua sắm tại shop. Chúng tôi rất vui khi bạn hài lòng với sản phẩm. Nếu có bất kỳ vấn đề gì, hãy liên hệ với chúng tôi nhé!</p>
                                    <div class="comment-detail__reply-actions">
                                        <span class="comment-detail__reply-like">15 💗</span>
                                        <button class="comment-detail__reply-btn">Phản hồi</button>
                                        <div class="comment-detail__reply-form-inline">
                                            <textarea class="comment-detail__inline-textarea" placeholder="Viết bình luận của bạn..."></textarea>
                                            <div class="comment-detail__inline-actions">
                                                <button class="comment-detail__inline-btn comment-detail__inline-btn--primary">
                                                    <i class="fas fa-paper-plane"></i>
                                                    Gửi phản hồi
                                                </button>
                                                <button class="comment-detail__inline-btn comment-detail__inline-btn--secondary">
                                                    <i class="fas fa-times"></i>
                                                    Hủy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Reply -->
                            <div class="comment-detail__reply">
                                <div class="comment-detail__reply-avatar">
                                    <span class="comment-detail__avatar-text">Đ</span>
                                </div>
                                <div class="comment-detail__reply-content">
                                    <div class="comment-detail__reply-header">
                                        <span class="comment-detail__reply-username">Nguyễn Văn Đức</span>
                                        <span class="comment-detail__reply-timestamp">15/07/2025 14:30</span>
                                    </div>
                                    <p class="comment-detail__reply-text">Shop khác hỗ trợ tốt, sẽ tiếp tục ủng hộ. Có thể lấy vài thêm và phụ kiện cho thêm sô thông tin?</p>
                                    <div class="comment-detail__actions">
                                        <button class="comment-detail__action-btn comment-detail__action-btn--like">
                                            <i class="far fa-thumbs-up"></i>
                                            <span>15</span>
                                        </button>
                                        <button class="comment-detail__action-btn">
                                            Phản hồi
                                        </button>
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Nested Reply -->
                            <div class="comment-detail__reply comment-detail__reply--nested">
                                <div class="comment-detail__reply-avatar">
                                    <span class="comment-detail__avatar-text">A</span>
                                </div>
                                <div class="comment-detail__reply-content">
                                    <div class="comment-detail__reply-header">
                                        <span class="comment-detail__reply-username">AdminShop</span>
                                        <span class="comment-detail__reply-badge">ADMIN</span>
                                        <span class="comment-detail__reply-timestamp">15/07/2025 14:30</span>
                                    </div>
                                    <p class="comment-detail__reply-text">@Nguyễn Văn Đức Chắc bạn chưng tôi sở của mua tận kiếm chịt lượng cho iPhone 14 Pro Max. Bạn có thể theo dõi chúng tôi để cập nhật các sàn phẩm mới.</p>
                                </div>
                            </div>

                            <!-- Another Admin Reply -->
                            <div class="comment-detail__reply">
                                <div class="comment-detail__reply-avatar">
                                    <span class="comment-detail__avatar-text">A</span>
                                </div>
                                <div class="comment-detail__reply-content">
                                    <div class="comment-detail__reply-header">
                                        <span class="comment-detail__reply-username">AdminShop</span>
                                        <span class="comment-detail__reply-badge">ADMIN</span>
                                        <span class="comment-detail__reply-timestamp">15/07/2025 14:30</span>
                                    </div>
                                    <p class="comment-detail__reply-text">Cám ơn bạn đã tin tưởng và mua sắm tại shop. Chúng tôi rất vui khi bạn hài lòng với sản phẩm. Nếu có bất kỳ vấn đề gì, hãy liên hệ với chúng tôi nhé!</p>
                                </div>
                            </div>

                            <!-- Final Admin Reply -->
                            <div class="comment-detail__reply">
                                <div class="comment-detail__reply-avatar">
                                    <span class="comment-detail__avatar-text">A</span>
                                </div>
                                <div class="comment-detail__reply-content">
                                    <div class="comment-detail__reply-header">
                                        <span class="comment-detail__reply-username">AdminShop</span>
                                        <span class="comment-detail__reply-timestamp">15/07/2025 14:30</span>
                                    </div>
                                    <p class="comment-detail__reply-text">Cám ơn bạn đã tin tưởng và mua sắm tại shop. Chúng tôi rất vui khi bạn hài lòng với sản phẩm. Nếu có bất kỳ vấn đề gì, hãy liên hệ với chúng tôi nhé!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="comment-detail__sidebar">
                    <!-- Actions -->
                    <div class="comment-detail__actions-panel">
                        <h4 class="comment-detail__panel-title">Hành động</h4>
                        <div class="comment-detail__action-buttons">
                            <button class="comment-detail__action-button comment-detail__action-button--approve">
                                ✓ Chấp nhận
                            </button>
                            <button class="comment-detail__action-button comment-detail__action-button--reject">
                                ✗ Từ chối
                            </button>
                            <button class="comment-detail__action-button comment-detail__action-button--hide">
                               ✎ Chỉnh sửa
                            </button>
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
                                    <div class="comment-detail__activity-time">15/07/2025 14:30</div>
                                </div>
                            </div>
                            <div class="comment-detail__activity-item">
                                <div class="comment-detail__activity-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="comment-detail__activity-content">
                                    <div class="comment-detail__activity-title">Admin xem chi tiết</div>
                                    <div class="comment-detail__activity-time">15/07/2025 14:30</div>
                                </div>
                            </div>
                            <div class="comment-detail__activity-item">
                                <div class="comment-detail__activity-icon">
                                    <i class="fas fa-question"></i>
                                </div>
                                <div class="comment-detail__activity-content">
                                    <div class="comment-detail__activity-title">Hiện tại</div>
                                    <div class="comment-detail__activity-time">Đang chờ xử lý</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="comment-detail__info-panel">
                        <h4 class="comment-detail__panel-title">Thông tin thêm</h4>
                        <div class="comment-detail__info-list">
                            <div class="comment-detail__info-item">
                                <span class="comment-detail__info-label">IP Address:</span>
                                <span class="comment-detail__info-value">192.168.1.100</span>
                            </div>
                            <div class="comment-detail__info-item">
                                <span class="comment-detail__info-label">Thiết bị:</span>
                                <span class="comment-detail__info-value">iPhone 14 Pro</span>
                            </div>
                            <div class="comment-detail__info-item">
                                <span class="comment-detail__info-label">Trình duyệt:</span>
                                <span class="comment-detail__info-value">Safari 16.0</span>
                            </div>
                            <div class="comment-detail__info-item">
                                <span class="comment-detail__info-label">Địa chỉ:</span>
                                <span class="comment-detail__info-value">TP. Hồ Chí Minh</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</body>
</html>