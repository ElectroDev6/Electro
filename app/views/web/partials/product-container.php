<?php

use Core\View;
?>

<div class="container-main">
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Xem đã mắt, nghe đã tai</h2>
        </div>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
        <?php View::component('components.arrow-buttons') ?>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Thế giới Gaming trong tầm tay</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Đồng hồ mới nhất, bán chạy nhất</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Kết nối thông minh</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Chăm sóc cá nhân & sức khỏe</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Xây dựng ngôi nhà tiện ích</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Làm mát và làm sạch tiện nghi</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>