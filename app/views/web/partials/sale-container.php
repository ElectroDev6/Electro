<?php

use Core\View;
?>

<div class="container-main">
    <section class="sale category-product">
        <div class="sale__header">
            <h2 class="sale__title">HOT SALE CUỐI TUẦN</h2>
            <div class="sale__countdown-container">
                <div class="sale__countdown">
                    <div class="sale__date">Đang diễn ra 22/07</div>
                    <div class="sale__timer">Kết thúc trong: <span class="sale__time">02 : 34 : 33</span></div>
                </div>
                <div class="sale__dates">
                    <div class="sale__day">23/07 <span>Sắp diễn ra</span></div>
                    <div class="sale__day">24/07 <span>Sắp diễn ra</span></div>
                    <div class="sale__day">25/07 <span>Sắp diễn ra</span></div>
                </div>
            </div>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="sale__list scroll-horizontal">
            <?php foreach ($saleProducts as $saleProduct): ?>
                <?php View::partial('components.product-card-sale', ['saleProduct' => $saleProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>