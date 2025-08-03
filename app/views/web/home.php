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
<div class="container-main">
    <section class="category-list category-product" style="background-color: #f3f4f6;">
        <div class="category-list__container scroll-horizontal">
            <div class="category-list__wrapper">
                <div class="category-list__items">
                    <div class="category-list__item">
                        <p class="category-list__name">Điện thoại</p>
                        <img src="/img/category/phone_cate.webp" alt="Điện thoại" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Máy tính bảng</p>
                        <img src="/img/category/may_tinh_bang_cate.webp" alt="Máy tính bảng" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Laptop</p>
                        <img src="/img/category/laptop_cate.webp" alt="Laptop" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Phụ kiện</p>
                        <img src="/img/category/phu_kien_cate.webp" alt="Phụ kiện" class="category-list__image" />
                    </div>
                </div>

                <div class="category-list__items">
                    <div class="category-list__item category-list__item--wide">
                        <p class="category-list__name">Tivi</p>
                        <img src="/img/category/tivi_cate.webp" alt="Tivi" class="category-list__image" />
                    </div>
                </div>

                <div class="category-list__items">
                    <div class="category-list__item">
                        <p class="category-list__name">Tủ lạnh</p>
                        <img src="/img/category/tu_lanh_cate.webp" alt="Tủ lạnh" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Điện gia dụng</p>
                        <img src="/img/category/dien_gia_dung_cate.webp" alt="Điện gia dụng" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">SIM</p>
                        <img src="/img/category/sim_cate.webp" alt="SIM" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Quạt điều hòa</p>
                        <img src="/img/category/dieu_hoa_cate.webp" alt="Quạt điều hòa" class="category-list__image" />
                    </div>
                </div>
            </div>
            <!-- ẩn khúc này -->
            <div class="category-list__wrapper">
                <div class="category-list__items">
                    <div class="category-list__item">
                        <p class="category-list__name">Điện thoại</p>
                        <img src="/img/category/phone_cate.webp" alt="Điện thoại" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Máy tính bảng</p>
                        <img src="/img/category/may_tinh_bang_cate.webp" alt="Máy tính bảng" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Laptop</p>
                        <img src="/img/category/laptop_cate.webp" alt="Laptop" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Phụ kiện</p>
                        <img src="/img/category/phu_kien_cate.webp" alt="Phụ kiện" class="category-list__image" />
                    </div>
                </div>

                <div class="category-list__items">
                    <div class="category-list__item category-list__item--wide">
                        <p class="category-list__name">Tivi</p>
                        <img src="/img/category/tivi_cate.webp" alt="Tivi" class="category-list__image" />
                    </div>
                </div>

                <div class="category-list__items">
                    <div class="category-list__item">
                        <p class="category-list__name">Tủ lạnh</p>
                        <img src="/img/category/tu_lanh_cate.webp" alt="Tủ lạnh" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Điện gia dụng</p>
                        <img src="/img/category/dien_gia_dung_cate.webp" alt="Điện gia dụng" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">SIM</p>
                        <img src="/img/category/sim_cate.webp" alt="SIM" class="category-list__image" />
                    </div>

                    <div class="category-list__item">
                        <p class="category-list__name">Quạt điều hòa</p>
                        <img src="/img/category/dieu_hoa_cate.webp" alt="Quạt điều hòa" class="category-list__image" />
                    </div>
                </div>
            </div>
        </div>
        <?php View::component('components.arrow-buttons') ?>
    </section>
</div>

<?php View::partial('partials.sale-container', ['saleProducts' => $saleProducts]); ?>
<?php View::partial('partials.special-offer-container', [
    'regularProducts' => $regularProducts,
    'featuredProduct' => $featuredProduct,
]); ?>

<?php View::partial('partials.product-container', ['audioProducts' => $audioProducts]); ?>
<?php View::partial('partials.accessory-container', ['accessories' => $accessories]); ?>

<div class="container-main">
    <div class="tech-news">
        <h1 class="tech-news__title">Tin công nghệ</h1>

        <div class="tech-news__container">
            <div class="tech-news__main">
                <div class="news-card news-card--large news-card--microsoft">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--office">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--windows">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--samsung">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Samsung Galaxy Z Fold7 và Z Flip7 có thể đây là tên thị, đồng thời cải tiến nhờ vào các tính năng Galaxy AI</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--phone">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--laptop">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>

                <div class="news-card news-card--medium news-card--chip">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="news-card__image">
                    <div class="news-card__content">
                        <h3 class="news-card__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h3>
                    </div>
                </div>
            </div>

            <div class="tech-news__sidebar">
                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>

                <div class="sidebar-item">
                    <img src="/img/bao-hiem-allianz-life-hack.webp" alt="News image" class="sidebar-item__image-s">
                    <div class="sidebar-item__content">
                        <h4 class="sidebar-item__title">Microsoft đưa ra thêm lý do nên nâng cấp lên Windows 11 24H2</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php View::endSection(); ?>