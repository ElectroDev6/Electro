<?php

use Core\View; ?>

<div class="product__card">
    <a href="/detail/<?= View::e($product['id']) ?>">
        <img src="<?= View::e($product['image']) ?>" alt="<?= View::e($product['name']) ?>">
        <p class="product-card__name"><?= View::e($product['name']) ?></p>
        <p class="product-card__price"><?= View::e($product['price']) ?>đ</p>
    </a>
</div>