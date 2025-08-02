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
        <div class="container-history__main-tabs">
            <a href="?status=all"
                class="container-history__main-tabs__btn <?= $status === 'all' ? 'container-history__main-tabs__btn--active' : '' ?>">Tất
                cả</a>
            <a href="?status=cho-xac-nhan"
                class="container-history__main-tabs__btn <?= $status === 'cho-xac-nhan' ? 'container-history__main-tabs__btn--active' : '' ?>">Chờ
                xác nhận</a>
            <a href="?status=dang-giao"
                class="container-history__main-tabs__btn <?= $status === 'dang-giao' ? 'container-history__main-tabs__btn--active' : '' ?>">Đang
                giao</a>
            <a href="?status=hoan-thanh"
                class="container-history__main-tabs__btn <?= $status === 'hoan-thanh' ? 'container-history__main-tabs__btn--active' : '' ?>">Hoàn
                thành</a>
        </div>

        <div class="container-history__main-orders">
            <?php if (empty($orders)): ?>
            <p>Không có đơn hàng nào.</p>
            <?php else: ?>
            <?php foreach ($orders as $order): ?>
            <div class="order">
                <div class="order__header">
                    <div>Mã đơn: <?= $order['id'] ?> | <?= $order['date'] ?></div>
                    <div class="order__header-status order__header-status--<?= $order['status_class'] ?>">
                        <?= $order['status'] ?>
                    </div>
                </div>
                <div class="order__body">
                    <img class="order__body-img" src="<?= $order['product']['image'] ?>" alt="Product" />
                    <div class="order__body-info">
                        <h4 class="order__body-info__name"><?= $order['product']['name'] ?></h4>
                        <p class="order__body-info__desc"><?= $order['product']['desc'] ?></p>
                    </div>
                    <div class="order__body-price">
                        <span class="order__body-price__new"><?= $order['product']['price_new'] ?></span>
                        <span class="order__body-price__old"><?= $order['product']['price_old'] ?></span>
                    </div>
                </div>
                <div class="order__footer">
                    <div>Tổng: <?= $order['total'] ?></div>
                    <div class="order__footer-actions">
                        <button class="order__footer-actions__btn order__footer-actions__btn--outline">Chi tiết</button>
                        <button class="order__footer-actions__btn order__footer-actions__btn--primary">Liên hệ</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php View::endSection(); ?>