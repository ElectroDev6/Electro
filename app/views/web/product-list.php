<?php if (empty($products)): ?>
    <p>Không tìm thấy sản phẩm phù hợp.</p>
<?php else: ?>
    <?php foreach ($products as $product): ?>
        <div class="product-card" 
             data-brand="<?= $product['brand'] ?>" 
             data-price="<?= $product['price'] ?>"
             data-rom="<?= $product['rom'] ?>" 
             data-ram="<?= $product['ram'] ?>" 
             data-os="<?= $product['os'] ?>"
             data-battery="<?= $product['battery'] ?>" 
             data-screen="<?= $product['screen'] ?>">

            <div class="product-card__feature">
                <div class="product-card__feature-icon">
                    <img src="https://cdn2.fptshop.com.vn/svg/screen_6_9_0bc42d6b8c.svg" alt="6.9 inch" />
                </div>
                <div class="product-card__feature-text">Màn hình cực lớn<br> <?= $product['screen'] ?> inch</div>
                <div class="product-card__feature-icon">
                    <img src="/img/DT_nutcamera.svg" alt="">
                </div>
                <div class="product-card__feature-text">Camera siêu nét</div>
                <div class="product-card__feature-icon">
                    <img src="/img/DT_vienmanhinh.svg" alt="">
                </div>
                <div class="product-card__feature-text">Viền màn hình<br>siêu mỏng</div>
            </div>

            <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-card__image">
            <p class="product-card__promo">Trả góp 0%</p>
            <h4 class="product-card__name"><?= $product['name']; ?></h4>

            <div class="product-card__price-box">
                <span class="product-card__old-price"><?= number_format($product['old_price'], 0, ',', '.') ?> ₫</span>
                <div class="product-card__new-price"><?= number_format($product['price'], 0, ',', '.') ?> ₫</div>
                <div class="product-card__save-price">Giảm <?= number_format($product['old_price'] - $product['price'], 0, ',', '.') ?> ₫</div>
            </div>

            <div class="product-card__storage-options">
                <?php 
                    $roms = explode(',', $product['rom']);
                    foreach ($roms as $romOption): ?>
                    <div class="product-card__storage-card"><span><?= trim($romOption) ?></span></div>
                <?php endforeach; ?>
            </div>

            <div class="product-card__color-options">
                <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                <div class="product-card__color-swatch" style="background-color: #000000;"></div>
            </div>

            <a href="/product-detail.php?id=<?= $product['id'] ?>" class="product-card__button">Xem chi tiết</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
