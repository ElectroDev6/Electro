<?php

use Core\View;
?>

<div class="slider">
    <div class="container-main">
        <div class="slider__container">
            <!-- Slider Item 1: Nồi chiên không dầu -->
            <div class="slider__item active">
                <div class="slider__content">
                    <h2 class="slider__title">NỒI CHIÊN KHÔNG DẦU</h2>
                    <p class="slider__description">Chiên rán nhanh, ít dầu mỡ, an toàn cho sức khỏe</p>
                    <div class="slider__price">Từ <strong>$149<sup>99</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay',  'productId' => 31]); ?>
                </div>
                <img class="slider__image" src="/img/sliders/fryer.png" alt="Nồi chiên không dầu">
            </div>

            <!-- Slider Item 2: Thùng PC -->
            <div class="slider__item">
                <div class="slider__content">
                    <h2 class="slider__title">THÙNG PC</h2>
                    <p class="slider__description">Case PC hiện đại, tối ưu luồng gió và tiện nghi lắp ráp</p>
                    <div class="slider__price">Từ <strong>$99<sup>99</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay',  'productId' => 15]); ?>
                </div>
                <img class="slider__image" src="/img/sliders/pc-case.png" alt="Thùng PC">
            </div>

            <!-- Slider Item 3: Máy Massee -->
            <div class="slider__item">
                <div class="slider__content">
                    <h2 class="slider__title">MÁY MASSAGE</h2>
                    <p class="slider__description">Thư giãn, giảm đau mỏi với công nghệ hiện đại</p>
                    <div class="slider__price">Từ <strong>$199<sup>99</sup></strong></div>
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay',  'productId' => 36]); ?>
                </div>
                <img class="slider__image" src="/img/sliders/massage.png" alt="Máy massage">
            </div>

            <!-- Slider Dots -->
            <div class="slider__dots">
                <span class="slider__dot active" data-index="0"></span>
                <span class="slider__dot" data-index="1"></span>
                <span class="slider__dot" data-index="2"></span>
            </div>
        </div>
        <?php View::partial('partials.category-menu'); ?>
    </div>
</div>