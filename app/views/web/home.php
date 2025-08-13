<?php

use Core\View; ?>

<?php View::section('page_styles'); ?>

<?php View::endSection(); ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Trang chủ
<?php View::endSection(); ?>

<?php View::section('content'); ?>
<!-- Menu -->
<div class="container-main">
    <ul class="breadcrumb">
        <li class="breadcrumb__item has-submenu">
            <a href="#">Tất cả trang</a>
            <div class="mega-menu">
                <div class="mega-column">
                    <h4>Trang chủ</h4>
                    <ul>
                        <li><a href="#">Home v1</a></li>
                        <li><a href="#">Home v2</a></li>
                        <li><a href="#">Home v3</a></li>
                    </ul>
                </div>
                <div class="mega-column">
                    <h4>Trang mua sắm</h4>
                    <ul>
                        <li><a href="#">Sản phẩm dạng lưới</a></li>
                        <li><a href="#">Dạng danh sách</a></li>
                        <li><a href="#">Sidebar trái / phải</a></li>
                    </ul>
                </div>
                <div class="mega-column">
                    <h4>Trang sản phẩm</h4>
                    <ul>
                        <li><a href="#">Chi tiết sản phẩm</a></li>
                        <li><a href="#">Sản phẩm mở rộng</a></li>
                        <li><a href="#">Sidebar sản phẩm</a></li>
                    </ul>
                </div>
                <div class="mega-column">
                    <h4>Trang tài khoản</h4>
                    <ul>
                        <li><a href="#">Đăng nhập</a></li>
                        <li><a href="#">Tài khoản của tôi</a></li>
                        <li><a href="#">Theo dõi đơn hàng</a></li>
                    </ul>
                </div>
                <div class="mega-column">
                    <h4>Thông tin</h4>
                    <ul>
                        <li><a href="#">Giới thiệu Electro</a></li>
                        <li><a href="#">Chính sách vận chuyển</a></li>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="breadcrumb__item"><a href="/">Thương hiệu nổi bật</a></li>
        <li class="breadcrumb__item"><a href="/">Phong cách thịnh hành</a></li>
    </ul>
</div>

<?php View::partial('partials.slider'); ?>
<!-- Category -->

<?php View::partial('partials.category-container', ['categories' => $categories]); ?>

<?php View::partial('partials.sale-container', ['saleProducts' => $saleProducts]); ?>
<?php View::partial('partials.special-offer-container', [
    'regularProducts' => $regularProducts,
    'featuredProduct' => $featuredProduct,
]); ?>

<?php View::partial('partials.product-container', [
    'iphoneProducts' => $iphoneProducts,
    'pcProducts' => $pcProducts,
    'watchProducts' => $watchProducts,
    'airFryerProducts' => $airFryerProducts,
    'massagerProducts' => $massagerProducts,
    'airCoolerProducts' => $airCoolerProducts,
    'vacuumCleanerProducts' => $vacuumCleanerProducts
]); ?>

<?php View::partial('partials.accessory-container', [
    'accessories' => $accessories,
    'computerAccessories' => $computerAccessories
]); ?>

<div class="container-main">
    <div class="tech-news">
        <h1 class="tech-news__title">Tin công nghệ</h1>

        <div class="tech-news__container">
            <div class="tech-news__main">
                <div class="news-card news-card--large news-card--microsoft">
                    <a target="_blank" href="https://thanhnien.vn/mang-dial-up-huyen-thoai-cua-aol-dung-hoat-dong-sau-34-nam-18525081109571965.htm">
                        <img src="/img/news/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                        <div class="news-card__content">
                            <h3 class="news-card__title">Mạng dial-up huyền thoại của AOL dừng hoạt động sau 34 năm</h3>
                        </div>
                    </a>
                </div>

                <div class="news-card news-card--medium news-card--office">
                    <img src="/img/news/apple.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--windows">
                    <img src="/img/news/camera.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--samsung">
                    <img src="/img/news/camera360.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Samsung Galaxy Z Fold7 và Z Flip7 có thể đây là tên thị, đồng thời cải tiến nhờ vào các tính năng Galaxy AI</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--phone">
                    <img src="/img/news/dienthoai.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--laptop">
                    <img src="/img/news/espon.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--chip">
                    <img src="/img/news/galaxy.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>
            </div>

            <div class="tech-news__sidebar">
                <div class="sidebar-item">
                    <img src="/img/news/gool.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/intel.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/iphone17.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/mediah2.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/newphone.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/tainghe.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/tv.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/win11.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/news/3tiiphone.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php View::endSection(); ?>