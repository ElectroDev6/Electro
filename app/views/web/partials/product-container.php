<?php

use Core\View;

?>

<div class="container-main">
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Thế Giới Iphone</h2>
        </div>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($iphoneProducts as $iphoneProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $iphoneProduct]); ?>
            <?php endforeach; ?>
        </div>
        <?php View::component('components.arrow-buttons') ?>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Dàn PC Khủng</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($pcProducts as $pcProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $pcProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Đồng hồ</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($watchProducts as $watchProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $watchProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Đồ gia dụng</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($tefalProducts as $tefalProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $tefalProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Chăm sóc cá nhân & sức khỏe</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($massagerProducts as $massagerProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $massagerProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Xây dựng ngôi nhà tiện ích</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($airCoolerProducts as $airCoolerProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $airCoolerProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Làm mát và làm sạch tiện nghi</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($vacuumCleanerProducts as $vacuumCleanerProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $vacuumCleanerProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>