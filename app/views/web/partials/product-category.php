<?php

use Core\View;
?>

<div class="container-main">
    <section class="category-product">
        <div class="category-product__list category-change-layout scroll-horizontal">
            <?php foreach ($products as $item): ?>
                <?php View::partial('components.product-card', ['regularProduct' => $item]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>