<?php

use Core\View; ?>

<?php View::section('page_styles'); ?>

<?php View::endSection(); ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm yêu thích
<?php View::endSection(); ?>

<div>
    <form action="/wishlist/add" method="post">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

    </form>
</div>
<?php View::endSection(); ?>