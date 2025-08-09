<?php

use Core\View; ?>


<?php View::extend('layouts.main'); ?>

<?php View::section('content'); ?>

    <div class ="container-main">
    <section class="thankyou">
        <div class="thankyou__box">
            <h1 class="thankyou__message">ELECTRON Trân Trọng Cảm Ơn Khách Hàng</h1>
            <a href="/" class="thankyou__btn">Quay về trang chủ</a>
        </div>
    </section>
    </div>
<?php View :: endSection(); ?>
