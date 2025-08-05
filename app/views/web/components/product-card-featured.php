<?php
$product = $featuredProduct ?? [];
?>

<div class="product-featured">
    <img src="<?= $product['default_url'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $product['name'] ?>" class="product-featured__image" />

    <h3 class="product-featured__name"><?= $product['name'] ?? '' ?></h3>
    <p class="product-featured__price"><?= number_format($product['price_discount'] ?? 0, 0, ',', '.') ?> ₫</p>

    <p class="product-featured__note">Nhanh lên! Ưu đãi kết thúc vào:</p>

    <div class="product-featured__countdown">
        <div class="time-box"><span>23</span>
            <p>Giờ</p>
        </div>
        <div class="time-box"><span>42</span>
            <p>Phút</p>
        </div>
        <div class="time-box"><span>12</span>
            <p>Giây</p>
        </div>
    </div>
</div>