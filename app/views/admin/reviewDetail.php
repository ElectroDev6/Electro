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
        <div class="review-detail">
            <!-- Header -->
                <div class="review-detail__header">
                <h1 class="review-detail__title">Chi tiết Review</h1>
                <p class="review-detail__subtitle">Quản lý và xử lý đánh giá sản phẩm</p>
            </div>

            <!-- Breadcrumb -->
            <div class="review-detail__breadcrumb">
                <a href="#" class="review-detail__breadcrumb-link">← Quay lại danh sách / Chi tiết Review #001</a>
            </div>

            <!-- Main Content -->
            <div class="review-detail__content">
                <!-- Left Column -->
                <div class="review-detail__main">
                    <!-- User Info -->
                    <div class="review-detail__user-section">
                        <div class="review-detail__user-info">
                            <div class="review-detail__user-avatar">
                                <span class="review-detail__user-initial">D</span>
                            </div>
                            <div class="review-detail__user-details">
                                <h3 class="review-detail__user-name">Nguyễn Văn Đức</h3>
                                <p class="review-detail__user-meta">Khách hàng VIP • Đã mua 15 sản phẩm</p>
                            </div>
                        </div>
                        
                    </div>

                    <!-- Review Stats -->
                    <div class="review-detail__stats">
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Đánh giá</span>
                            <div class="review-detail__rating">
                                <div class="review-detail__stars">
                                    <span class="review-detail__star review-detail__star--filled">★</span>
                                    <span class="review-detail__star review-detail__star--filled">★</span>
                                    <span class="review-detail__star review-detail__star--filled">★</span>
                                    <span class="review-detail__star review-detail__star--filled">★</span>
                                    <span class="review-detail__star review-detail__star--filled">★</span>
                                </div>
                                <span class="review-detail__rating-text">5/5</span>
                            </div>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Ngày tạo</span>
                            <span class="review-detail__stat-value review-detail__stat-value--date">15/07/2025 14:30</span>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">Trạng thái</span>
                            <span class="review-detail__stat-value review-detail__stat-value--status">Đang xử lý</span>
                        </div>
                        <div class="review-detail__stat-item">
                            <span class="review-detail__stat-label">ID Review</span>
                            <span class="review-detail__stat-value">#001</span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="review-detail__product-section">
                        <h2 class="review-detail__section-title">Thông tin sản phẩm</h2>
                        <div class="review-detail__product-info">
                            <div class="review-detail__product-image">
                                <div class="review-detail__product-placeholder">📱</div>
                            </div>
                            <div class="review-detail__product-details">
                                <h3 class="review-detail__product-name">iPhone 14 Pro Max</h3>
                                <p class="review-detail__product-price">32.990.000 VNĐ</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Content -->
                    <div class="review-detail__review-section">
                        <h2 class="review-detail__section-title">Nội dung đánh giá</h2>
                        <div class="review-detail__review-content">
                            <p>Sản phẩm rất tuyệt vời, chất lượng tốt, giá cả hợp lý, tôi rất hài lòng với sản phẩm này và sẽ giới thiệu cho bạn bè. Camera chụp hình đẹp lắm, đặc biệt là màn hình có độ phân giải cao, pin trâu, sử dụng cả ngày mượt mà. Camera chụp hình rất đẹp, tôi thấy hài lòng không thích thể gì. Đặc biệt là khi chụp ảnh vào ban đêm cũng rất sáng và đẹp đây, tôi thấy hài lòng không thích thế với."</p>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="review-detail__sidebar">
                    <!-- Actions Section -->
                    <div class="review-detail__actions-section">
                        <h3 class="review-detail__actions-title">Hành động</h3>
                        <div class="review-detail__actions">
                            <div class="review-detail__actions-row">
                                <button class="review-detail__action-btn review-detail__action-btn--accept">✓ Chấp nhận</button>
                                <button class="review-detail__action-btn review-detail__action-btn--reject">✕ Từ chối</button>
                            </div>
                            <div class="review-detail__actions-row">
                                <button class="review-detail__action-btn review-detail__action-btn--edit">✎ Chỉnh sửa</button>
                                <button class="review-detail__action-btn review-detail__action-btn--back">← Quay lại</button>
                            </div>
                        </div>
                    </div>

                    <!-- Activity History -->
                    <div class="review-detail__activity-section">
                        <h3 class="review-detail__sidebar-title">Lịch sử hoạt động</h3>
                        <div class="review-detail__activity-list">
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">📋</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Review được tạo</p>
                                    <span class="review-detail__activity-time">15/07/2025 14:30</span>
                                </div>
                            </div>
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">👤</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Admin xem chi tiết</p>
                                    <span class="review-detail__activity-time">15/07/2025 14:30</span>
                                </div>
                            </div>
                            <div class="review-detail__activity-item">
                                <div class="review-detail__activity-icon">📋</div>
                                <div class="review-detail__activity-content">
                                    <p class="review-detail__activity-text">Hiện tại</p>
                                    <span class="review-detail__activity-time">Đang chờ xử lý</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="review-detail__info-section">
                        <h3 class="review-detail__sidebar-title">Thông tin thêm</h3>
                        <div class="review-detail__info-list">
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">IP Address:</span>
                                <span class="review-detail__info-value">192.168.1.100</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Thiết bị:</span>
                                <span class="review-detail__info-value">iPhone 14 Pro</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Trình duyệt:</span>
                                <span class="review-detail__info-value">Safari 16.0</span>
                            </div>
                            <div class="review-detail__info-item">
                                <span class="review-detail__info-label">Địa chỉ:</span>
                                <span class="review-detail__info-value">TP. Hồ Chí Minh</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </main>
</body>
</html>