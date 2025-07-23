<?php extend('layout.main'); ?>

<?php section('hero_section'); ?>
<div class="hero-section">
    <?php partial('partials.slider');
    ?>
</div>
<?php endSection(); ?>

<?php section('content'); ?>
<section>
    <h3>Sản phẩm nổi bật</h3>
    <p>Đây là danh sách các sản phẩm bán chạy nhất của chúng tôi.</p>
    <ul>
        <li><a href="/products/1">Sản phẩm A</a></li>
        <li><a href="/products/2">Sản phẩm B</a></li>
    </ul>
</section>
<?php endSection(); ?>