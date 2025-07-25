<?php

use Core\View; ?>

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
    <div class=" container-history__main">
        <div class="container-history__main-tabs">
            <button class="container-history__main-tabs__btn container-history__main-tabs__btn--active">Tất
                cả</button>
            <button class="container-history__main-tabs__btn">Chờ xác nhận</button>
            <button class="container-history__main-tabs__btn">Đang giao</button>
            <button class="container-history__main-tabs__btn">Hoàn thành</button>
        </div>

        <div class="container-history__main-orders">
            <div class="order">
                <div class="order__header">
                    <div>Mã đơn: #123456 | 20/07/2025</div>
                    <div class="order__header-status order__header-status--shipping">Đang giao</div>
                </div>
                <div class="order__body">
                    <img class="order__body-img" src="https://via.placeholder.com/80" alt="Product" />
                    <div class="order__body-info">
                        <h4 class="order__body-info__name">Máy xay sinh tố Philips HR2223</h4>
                        <p class="order__body-info__desc">Phân loại: Trắng, Số lượng: 1</p>
                    </div>
                    <div class="order__body-price">
                        <span class="order__body-price__new">1.290.000₫</span>
                        <span class="order__body-price__old">1.590.000₫</span>
                    </div>
                </div>
                <div class="order__footer">
                    <div>Tổng: 1.290.000₫</div>
                    <div class="order__footer-actions">
                        <button class="order__footer-actions__btn order__footer-actions__btn--outline">Chi
                            tiết</button>
                        <button class="order__footer-actions__btn order__footer-actions__btn--primary">Liên
                            hệ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php View::endSection(); ?>