<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm yêu thích
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<body>
    <form action="/wishlist/add" method="post">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button type="submit">💖 Thêm vào yêu thích</button>
    </form>

</body>

</html>