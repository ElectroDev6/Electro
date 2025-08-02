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
        <div class="page">
            <!-- Header -->
            <div class="page__header">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb__link">← Quay lại danh sách / Chi tiết đơn hàng #001</a>
                </div>
                <div class="page__title-section">
                    <h1 class="page__title">Chi tiết đơn hàng #001</h1>
                    <div class="page__actions">
                        <button class="btn btn--success">Xác nhận</button>
                        <button class="btn btn--danger">Từ chối</button>
                        <button class="btn btn--warning">Chỉnh sửa</button>
                        <button class="btn btn--secondary">← Quay lại</button>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="page__content">
                <div class="content">
                    <div class="content__main">
                        <!-- Order Information Section -->
                        <section class="info-section">
                            <div class="info-section__grid">
                                <div class="info-card">
                                    <h3 class="info-card__title">Thông tin đơn hàng</h3>
                                    <div class="info-card__content">
                                        <div class="info-row">
                                            <span class="info-row__label">Mã đơn hàng</span>
                                            <span class="info-row__value">#001</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Ngày tạo đơn</span>
                                            <span class="info-row__value">16:10:00 24/4/2024</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Cập nhật lần cuối</span>
                                            <span class="info-row__value">16:10:00 24/4/2024</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Trạng thái đơn hàng</span>
                                            <span class="info-row__value">Đã giao 16:10:00 24/4/2024</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-card">
                                    <h3 class="info-card__title">Thông tin khách hàng</h3>
                                    <div class="info-card__content">
                                        <div class="info-row">
                                            <span class="info-row__label">Tên khách hàng</span>
                                            <span class="info-row__value">Nguyễn Văn Nam</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Số điện thoại</span>
                                            <span class="info-row__value">0344567890</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Email</span>
                                            <span class="info-row__value">hai@gmail.com</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Địa chỉ giao hàng</span>
                                            <span class="info-row__value">123 Nguyễn Văn Linh, Quận 7, TP.HCM</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-card">
                                    <h3 class="info-card__title">Thông tin thanh toán</h3>
                                    <div class="info-card__content">
                                        <div class="info-row">
                                            <span class="info-row__label">Phương thức thanh toán</span>
                                            <span class="info-row__value">COD</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Trạng thái thanh toán</span>
                                            <span class="info-row__value">Đã thanh toán</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Trạng thái liên thông</span>
                                            <span class="info-row__value">Đã đồng bộ</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-row__label">Tổng tiền</span>
                                            <span class="info-row__value">80,000 đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Products Section -->
                        <section class="products-section">
                            <h3 class="products-section__title">Sản phẩm đã đặt</h3>
                            <div class="products-table">
                                <div class="products-table__header">
                                    <div class="products-table__cell products-table__cell--product">Sản phẩm</div>
                                    <div class="products-table__cell products-table__cell--category">Danh mục</div>
                                    <div class="products-table__cell products-table__cell--quantity">Số lượng</div>
                                    <div class="products-table__cell products-table__cell--unit-price">Đơn giá</div>
                                    <div class="products-table__cell products-table__cell--total">Thành tiền</div>
                                </div>
                                <div class="products-table__row">
                                    <div class="products-table__cell products-table__cell--product">
                                        <div class="product-item">
                                             <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                                            <span class="product-item__name">iPhone<br>Premier</span>
                                        </div>
                                    </div>
                                    <div class="products-table__cell products-table__cell--category">Smartphone</div>
                                    <div class="products-table__cell products-table__cell--quantity">20 cái</div>
                                    <div class="products-table__cell products-table__cell--unit-price">2</div>
                                    <div class="products-table__cell products-table__cell--total">40,000 đ</div>
                                </div>
                                <div class="products-table__row">
                                    <div class="products-table__cell products-table__cell--product">
                                        <div class="product-item">
                                             <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                                            <span class="product-item__name">iPhone<br>Premier</span>
                                        </div>
                                    </div>
                                    <div class="products-table__cell products-table__cell--category">Smartphone</div>
                                    <div class="products-table__cell products-table__cell--quantity">20 cái</div>
                                    <div class="products-table__cell products-table__cell--unit-price">2</div>
                                    <div class="products-table__cell products-table__cell--total">40,000 đ</div>
                                </div>
                            </div>
                            
                            <div class="order-summary">
                                <div class="order-summary__row">
                                    <span class="order-summary__label">Tạm tính:</span>
                                    <span class="order-summary__value">80,000 đ</span>
                                </div>
                                <div class="order-summary__row">
                                    <span class="order-summary__label">Giảm giá:</span>
                                    <span class="order-summary__value">~0 đ</span>
                                </div>
                                <div class="order-summary__row">
                                    <span class="order-summary__label">Phí vận chuyển:</span>
                                    <span class="order-summary__value">10,000đ</span>
                                </div>
                                <div class="order-summary__row order-summary__row--total">
                                    <span class="order-summary__label">Tổng cộng:</span>
                                    <span class="order-summary__value">90,000đ</span>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <aside class="content__sidebar">
                        <div class="order-sidebar">
                            <div class="order-sidebar__section">
                                <h3 class="order-sidebar__title">Hành động</h3>
                                <div class="action-buttons">
                                    <button class="action-btn action-btn--success">
                                        <span class="action-btn__icon">✓</span>
                                        <div class="action-btn__content">
                                            <div class="action-btn__title">Đơn hàng được tạo</div>
                                            <div class="action-btn__time">15/07/2025 14:30</div>
                                        </div>
                                    </button>
                                    <button class="action-btn action-btn--warning">
                                        <span class="action-btn__icon">👤</span>
                                        <div class="action-btn__content">
                                            <div class="action-btn__title">Admin xem chi tiết</div>
                                            <div class="action-btn__time">15/07/2025 14:30</div>
                                        </div>
                                    </button>
                                    <button class="action-btn action-btn--info">
                                        <span class="action-btn__icon">👁</span>
                                        <div class="action-btn__content">
                                            <div class="action-btn__title">Hiển thị</div>
                                            <div class="action-btn__time">Đã duyệt</div>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <div class="order-sidebar__section">
                                <h3 class="order-sidebar__title">Lịch sử hoạt động</h3>
                                <div class="activity-list">
                                    <div class="activity-item">
                                        <span class="activity-item__icon">📄</span>
                                        <div class="activity-item__content">
                                            <div class="activity-item__title">Đơn hàng được tạo</div>
                                            <div class="activity-item__time">15/07/2025 14:30</div>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <span class="activity-item__icon">👤</span>
                                        <div class="activity-item__content">
                                            <div class="activity-item__title">Admin xem chi tiết</div>
                                            <div class="activity-item__time">15/07/2025 14:30</div>
                                        </div>
                                    </div>
                                    <div class="activity-item">
                                        <span class="activity-item__icon">👁</span>
                                        <div class="activity-item__content">
                                            <div class="activity-item__title">Hiển thị</div>
                                            <div class="activity-item__time">Đã duyệt</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="order-sidebar__section">
                                <h3 class="order-sidebar__title">Thông tin thêm</h3>
                                <div class="additional-info">
                                    <div class="additional-info__item">
                                        <span class="additional-info__label">IP Address:</span>
                                        <span class="additional-info__value">192.168.1.100</span>
                                    </div>
                                    <div class="additional-info__item">
                                        <span class="additional-info__label">Thiết bị:</span>
                                        <span class="additional-info__value">iPhone 14 Pro</span>
                                    </div>
                                    <div class="additional-info__item">
                                        <span class="additional-info__label">Trình duyệt:</span>
                                        <span class="additional-info__value">Safari 16.0</span>
                                    </div>
                                    <div class="additional-info__item">
                                        <span class="additional-info__label">Địa chỉ:</span>
                                        <span class="additional-info__value">TP. Hồ Chí Minh</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            </div>
    </main>

</body>
</html>