<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Trang chủ
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<?php View::partial('partials.slider'); ?>

<h3>Sản phẩm nổi bật</h3>
<div class="product">
    <div class="product__list">
        <?php foreach ($products as $product): ?>
            <?php View::partial('components.product-card', ['product' => $product]); ?>
        <?php endforeach; ?>
    </div>
</div>

<?php View::endSection(); ?>