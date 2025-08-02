<?php use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<div class="container-history">
    <!-- Sidebar -->
    <div class="container-history__sidebar">
        <div class="container-history__sidebar-avatar">
            <img class="container-history__sidebar-avatar__img"
                src="https://i.pinimg.com/1200x/57/bb/f5/57bbf563a06ca4704171f1bbd0bd52b3.jpg" alt="Avatar">
            <h3 class="container-history__sidebar-avatar__name">Trần Văn A</h3>
            <p class="container-history__sidebar-avatar__role">Khách hàng</p>
        </div>
        <ul class="container-history__sidebar-menu">
            <li class="container-history__sidebar-menu__item">Đơn hàng của tôi</li>
            <li class="container-history__sidebar-menu__item">Thông tin bảo hành</li>
            <li class="container-history__sidebar-menu__item">Địa chỉ nhận hàng</li>
            <li class="container-history__sidebar-menu__item">Lịch sử mua hàng</li>
            <li class="container-history__sidebar-menu__item">Đăng xuất</li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="container-history__main">
        <!-- Tabs -->
        <div class="container-history__main-tabs">
            <a href="/history?status=all"
                class="container-history__main-tabs__btn <?= $status === 'all' ? 'container-history__main-tabs__btn--active' : '' ?>">Tất
                cả</a>
            <a href="/history?status=cho-xac-nhan"
                class="container-history__main-tabs__btn <?= $status === 'cho-xac-nhan' ? 'container-history__main-tabs__btn--active' : '' ?>">Chờ
                xác nhận</a>
            <a href="/history?status=dang-giao"
                class="container-history__main-tabs__btn <?= $status === 'dang-giao' ? 'container-history__main-tabs__btn--active' : '' ?>">Đang
                giao</a>
            <a href="/history?status=hoan-thanh"
                class="container-history__main-tabs__btn <?= $status === 'hoan-thanh' ? 'container-history__main-tabs__btn--active' : '' ?>">Hoàn
                thành</a>
        </div>

        <!-- Orders -->
        <div class="container-history__main-orders">
            <?php foreach ($orders as $order): ?>
            <div class="order">
                <div class="order__header">
                    <div><strong>Mã đơn:</strong> <?= $order['id'] ?></div>
                    <div><strong>Ngày:</strong> <?= $order['date'] ?></div>
                    <div class="order__header-status"><strong>Trạng thái:</strong> <?= $order['status'] ?></div>
                </div>

                <div class="order__body">
                    <img src="<?= $order['product']['image'] ?>" alt="Ảnh sản phẩm" class="order__body-img">

                    <div class="order__body-info">
                        <div class="order__body-info__name"><?= $order['product']['name'] ?></div>
                        <div class="order__body-info__desc"><?= $order['product']['desc'] ?></div>
                    </div>

                    <div class="order__body-price">
                        <div class="order__body-price__new"><?= $order['product']['price_new'] ?></div>
                        <div class="order__body-price__old"><?= $order['product']['price_old'] ?></div>
                    </div>
                </div>

                <div class="order__footer">
                    <div><strong>Tổng tiền:</strong> <?= $order['total'] ?></div>
                    <div class="order__footer-actions">
                        <button class="order__footer-actions__btn order__footer-actions__btn--primary">Mua lại</button>
                        <!-- Có thể thêm nút "Hủy" hoặc "Xem chi tiết" -->
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php View::endSection(); ?>