<?php
$product = $regularProduct ?? [];
?>
<?php

use Core\View; ?>

<?php if (!empty($product)): ?>
    <div class="product">
        <div class="product__image-container">
            <img src="<?= $product['image'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $product['name'] ?>" class="product__image" />

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
            <div class="product__prices">
                <div class="product__price">
                    <span class="product__current-price"><?= number_format($product['price'] ?? 0, 0, ',', '.') ?> ₫</span>
                    <span class="product__old-price"><?= number_format($product['old_price'] ?? 0, 0, ',', '.') ?> ₫</span>
                    <span class="product__discount-cl">Giảm 1.000.000đ</span>
                </div>
                <span class="product__discount-r">-<?= $product['discount'] ?? '64' ?>%</span>
            </div>
        </div>

        <p class="product__name"><?= $product['name'] ?? 'Camera giám sát IP 3MP 365 Selection C1' ?></p>

        <?php View::partial('components.button-buynow', ['href' => '#', 'text' => 'Mua ngay']); ?>

    </div>
<?php else: ?>
    <p>Không có dữ liệu sản phẩm.</p>
<?php endif; ?>