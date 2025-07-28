<?php

use Core\View;
?>

<div class="slider">
    <div class="container-main">
        <div class="slider__container">
            <div class="slider__item active">
                <div class="slider__content">
                    <h2 class="slider__title">THE NEW STANDARD</h2>
                    <p class="slider__description">Under favorable smartwatches</p>
                    <div class="slider__price">From <strong>$749<sup>99</sup></strong></div>
                    <a href="#" class="slider__btn">Start Buying</a>
                </div>
                <img class="slider__image" src="/img/watch1.png" alt="Smartwatch 1">
            </div>

            <div class="slider__item">
                <div class="slider__content">
                    <h2 class="slider__title">FRESH DESIGN</h2>
                    <p class="slider__description">Style that fits your life</p>
                    <div class="slider__price">From <strong>$659<sup>00</sup></strong></div>
                    <a href="#" class="slider__btn">Shop Now</a>
                </div>
                <img class="slider__image" src="/img/watch2.png" alt="Smartwatch 2">
            </div>

            <div class="slider__dots">
                <span class="slider__dot active" data-index="0"></span>
                <span class="slider__dot" data-index="1"></span>
            </div>
        </div>
        <?php View::partial('partials.category-menu'); ?>
    </div>
</div>

<script src="/js/slider.js"></script>
<script src="/js/category-menu.js"></script>