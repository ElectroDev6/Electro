<?php

use Core\View;
?>

<div class="slider">
    <div class="container-main">
        <div class="slider__container">
            <div class="slider__item active">
                <div class="slider__content">
                    <h2 class="slider__title">THE NEW STANDARD</h2>
                    <p class="slider__description">Chuẩn mực mới cho đồng hồ thông minh</p>
                    <div class="slider__price">Từ <strong>$749<sup>99</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay']); ?>
                </div>
                <img class="slider__image" src="/img/sliders/watch1.png" alt="Smartwatch 1">
            </div>

            <div class="slider__item">
                <div class="slider__content">
                    <h2 class="slider__title">FRESH DESIGN</h2>
                    <p class="slider__description">Phong cách phù hợp với cuộc sống của bạn</p>
                    <div class="slider__price">Từ <strong>$659<sup>00</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay']); ?>
                </div>
                <img class="slider__image" src="/img/sliders/watch2.png" alt="Smartwatch 2">
            </div>

            <div class="slider__item">
                <div class="slider__content">
                    <h2 class="slider__title">FRESH DESIGN</h2>
                    <p class="slider__description">Phong cách phù hợp với cuộc sống của bạn</p>
                    <div class="slider__price">Từ <strong>$659<sup>00</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay']); ?>
                </div>
                <img class="slider__image" src="/img/sliders/watch3.png" alt="Smartwatch 3">
            </div>

            <div class="slider__dots">
                <span class="slider__dot active" data-index="0"></span>
                <span class="slider__dot" data-index="1"></span>
                <span class="slider__dot" data-index="2"></span>
            </div>
        </div>
        <?php View::partial('partials.category-menu'); ?>
    </div>
</div>