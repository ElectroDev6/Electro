<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<?php View::component('components.scroll-to-top'); ?>

<div class="container-main">
    <div class="container-history">
        <!-- Sidebar -->
        <?php View::component('components.profile-sidebar'); ?>

        <!-- Main content -->
        <div class="container-history__main">
            <!-- Tabs -->
            <div class="container-history__main-tabs">
                <a href="/history?status=all"
                    class="container-history__main-tabs__btn <?= $status === 'all' ? 'container-history__main-tabs__btn--active' : '' ?>">Tất cả</a>
                <a href="/history?status=dang-xu-ly" class="container-history__main-tabs__btn <?= $status === 'dang-xu-ly' ? 'container-history__main-tabs__btn--active' : '' ?>">Đang xử lý</a></a>
                <a href="/history?status=cho-xac-nhan"
                    class="container-history__main-tabs__btn <?= $status === 'cho-xac-nhan' ? 'container-history__main-tabs__btn--active' : '' ?>">Chờ xác nhận</a>
                <a href="/history?status=dang-giao"
                    class="container-history__main-tabs__btn <?= $status === 'dang-giao' ? 'container-history__main-tabs__btn--active' : '' ?>">Đang giao</a>
                <a href="/history?status=hoan-thanh"
                    class="container-history__main-tabs__btn <?= $status === 'hoan-thanh' ? 'container-history__main-tabs__btn--active' : '' ?>">Hoàn thành</a>
            </div>

            <!-- Orders -->
            <div class="container-history__main-orders">
                <?php if (empty($orders)): ?>
                    <p>Không có đơn hàng nào.</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order">
                            <div class="order__header">
                                <div><strong>Mã đơn:</strong> <?= htmlspecialchars($order['order_code']) ?></div>
                                <div><strong>Ngày:</strong> <?= htmlspecialchars($order['formatted_date']) ?></div>
                                <div class="order__header-status"><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status_text']) ?></div>
                            </div>

                            <div class="order__body">
                                <img src="/img/products/default/<?= htmlspecialchars($order['product_image'] ?? '/path/to/default-image.jpg') ?>"
                                    alt="Ảnh sản phẩm"
                                    class="order__body-img">

                                <div class="order__body-info">
                                    <div class="order__body-info__name"><?= htmlspecialchars($order['product_name']) ?></div>
                                    <div class="order__body-info__desc">Số lượng: <?= htmlspecialchars($order['quantity']) ?></div>
                                </div>

                                <div class="order__body-price">
                                    <div class="order__body-price__new"><?= number_format($order['item_price'], 0, ',', '.') ?> VNĐ</div>
                                </div>
                            </div>

                            <div class="order__footer">
                                <div><strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</div>
                                <div class="order__footer-actions">
                                    <button class="order__footer-actions__btn order__footer-actions__btn--primary">Mua lại</button>
                                    <a href="/order/<?= htmlspecialchars($order['order_id']) ?>"
                                        class="order__footer-actions__btn">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?php View::endSection(); ?>