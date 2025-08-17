<?php

use Core\View; ?>
<div class="container-main">
    <section class="sale category-product">
        <div class="sale__header">
            <h2 class="sale__title">HOT SALE</h2>
            <div class="sale__countdown-container">
                <div class="sale__countdown">
                    <?php if (!empty($saleProducts) && $saleStatus === 'today'): ?>
                        <div class="sale__date">Đang diễn ra <?= date('d/m', strtotime($saleProducts[0]['start_date'])) ?></div>
                        <div class="sale__timer">Kết thúc trong: <span class="sale__time" data-end="<?= $saleProducts[0]['end_date'] ?>"></span></div>
                    <?php elseif (!empty($saleProducts) && $saleStatus === 'upcoming'): ?>
                        <div class="sale__date">Sắp diễn ra <?= date('d/m', strtotime($saleProducts[0]['start_date'])) ?></div>
                        <div class="sale__timer">Bắt đầu sau: <span class="sale__time" data-start="<?= $saleProducts[0]['start_date'] ?>"></span></div>
                    <?php else: ?>
                        <div class="sale__date">Hôm nay không có sản phẩm sale</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="sale__list scroll-horizontal">
            <?php foreach ($saleProducts as $item): ?>
                <?php View::partial('components.product-card-sale', ['saleProduct' => $item]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>