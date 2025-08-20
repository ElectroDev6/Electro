<?php
$product = $featuredProduct ?? [];
?>

<div class="product-featured"
    data-end-date="<?= $product['end_date'] ?? '' ?>">

    <img class="lazy" data-src="/img/products/default/<?= $product['default_image'] ?? '/img/No-Image-Placeholder.png' ?>"
        alt="<?= $product['name'] ?>"
        class="product-featured__image" />

    <h3 class="product-featured__name"><?= $product['name'] ?? '' ?></h3>
    <p class="product-featured__price">
        <?= number_format($product['price_discount'] ?? 0, 0, ',', '.') ?> ₫
    </p>

    <p class="product-featured__note">Nhanh lên! Ưu đãi kết thúc vào:</p>

    <div class="product-featured__countdown">
        <div class="time-box"><span class="days">00</span>
            <p>Ngày</p>
        </div>
        <div class="time-box"><span class="hours">00</span>
            <p>Giờ</p>
        </div>
        <div class="time-box"><span class="minutes">00</span>
            <p>Phút</p>
        </div>
        <div class="time-box"><span class="seconds">00</span>
            <p>Giây</p>
        </div>
    </div>
</div>