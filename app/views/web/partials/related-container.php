<?php

use Core\View;
?>

<div class="container-main">
    <section class="category-product">
        <div class="category-product__header">
            <h2 class="category-product__title">Có thể bạn cũng thích</h2>
        </div>
        <?php View::component('components.arrow-buttons') ?>
        <div class="category-product__list scroll-horizontal">
            <?php foreach ($audioProducts as $audioProduct): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $audioProduct]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>