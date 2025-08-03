<?php
$product = $saleProduct ?? [];
?>

<?php

use Core\View; ?>

<div class="product">
    <a href="/product/<?= $product['slug'] ?>" class="product__link">
        <div class="product__badge">
            <img style="width: 25px;" src="/icons/sale-tag-for-online-shops.svg" alt="">
        </div>
        <div class="product__image-container">
            <img src="<?= $product['default_url'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $product['name'] ?>" class="product__image" />

            <ul class="product__features">
                <div class="product__feature">
                    <img src="/icons/NFC.svg" alt="">
                    <li class="product__feature">Độ phân giải 3MP</li>
                </div>
                <div class="product__feature">
                    <img src="/icons/ic_battery_charge.svg" alt="">
                    <li class="product__feature">Độ phân giải 3MP</li>
                </div>
                <div class="product__feature">
                    <img src="/icons/ic_cam.svg" alt="">
                    <li class="product__feature">Độ phân giải 3MP</li>
                </div>
            </ul>
        </div>

        <div class="product__prices-container">
            <div class="product__status">
                <img src="/icons/lightning.svg" alt="icon lightning">
                Còn 5/5 suất
            </div>
            <div class="product__prices">
                <div class="product__price">
                    <span class="product__current-price"><?= number_format($product['price_discount'] ?? 0, 0, ',', '.') ?> ₫</span>
                    <span class="product__old-price"><?= number_format($product['price_original'] ?? 0, 0, ',', '.') ?> ₫</span>
                </div>
                <span class="product__discount">
                    <?php if (!empty($product['discount'])): ?>
                        -<?= $product['discount'] ?>%
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <p class="product__name"><?= $product['name'] ?? 'Camera giám sát IP 3MP 365 Selection C1' ?></p>

        <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay']); ?>
    </a>
</div>