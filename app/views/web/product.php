<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<body>
    <div class="navigation">
        <a href="/">Trang chủ</a> / <a class="active" href="/product">Điện thoại</a>
    </div>
    <div class="banner">
        <img src="/img/Slide2Laptop.jpg" alt="Banner">
    </div>
    <div class="use-needs">
        <h3 class="use-needs__title">Nhu cầu sử dụng</h3>
        <div class="use-needs__list">
            <a href="/laptop-ai" class="use-needs__item" style="background-color: #ffe5e5;">
                <img src="/img/UN_Laptop_AI.png" alt="Laptop AI">
                <p>Laptop AI</p>
            </a>
            <a href="/gaming-do-hoa" class="use-needs__item" style="background-color: #fff2cc;">
                <img src="/img/UN_Gaming.png" alt="Gaming đồ họa">
                <p>Gaming đồ họa</p>
            </a>
            <a href="/van-phong" class="use-needs__item" style="background-color: #ccf2ff;">
                <img src="/img/UN_Sinhvien.png" alt="Sinh viên - Văn phòng">
                <p>Sinh viên - Văn phòng</p>
            </a>
            <a href="/mong-nhe" class="use-needs__item" style="background-color: #ede9ff;">
                <img src="/img/UN_Mongnhe.jpg" alt="Mỏng nhẹ">
                <p>Mỏng nhẹ</p>
            </a>
            <a href="/doanh-nhan" class="use-needs__item" style="background-color: #d9fbe4;">
                <img src="/img/UN_Doanhnhan.jpg" alt="Doanh nhân">
                <p>Doanh nhân</p>
            </a>
        </div>
    </div>
    <div class="container">
        <aside class="filter">
            <h3 class="filter__heading">Bộ lọc tìm kiếm</h3>
            <div class="filter-group">
                <h4 class="filter-group__heading">Hãng sản xuất</h4>
                <div class="brand-logos" id="brand-logos">
                    <a href="/product?brand=Oppo" class="brand-logos__link">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_DT_oppo.jpg" alt="Oppo" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/product?brand=Apple" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/Menu_LT_apple.jpg" alt="Apple" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/product?brand=Vivo" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/Menu_DT_vivo.jpg" alt="Dell" class="brand-logo-card__image">
                        </div>
                    </a>
                    <!-- Các hãng khác -->
                </div>
            </div>
            <form method="GET" action="/product" id="priceFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Mức giá</h4>
                    <label class="filter-group__label"> <input type="checkbox" name="price" value="all"
                            class="filter-group__radio"> Tất cả </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price" value="25-30"
                            class="filter-group__radio"> Từ 25 đến 30 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="20-25" class="filter-group__radio"> Từ 20 đến 25
                        triệu
                    </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price" value="15-20"
                            class="filter-group__radio"> Từ 15 đến 20 triệu </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="10-15" class="filter-group__radio"> Từ 10 đến 15
                        triệu
                    </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price" value="duoi10"
                            class="filter-group__radio"> Dưới 10 triệu </label>

                </div>
            </form>
            <form method="GET" action="/product" id="osFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Hệ điều hành</h4>
                    <label class="filter-group__label">
                        <input type="checkbox" name="os[]" value="IOS" class="filter-group__checkbox"> IOS
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="os[]" value="Android" class="filter-group__checkbox"> Android
                    </label>

                </div>
            </form>
            <form method="GET" action="/product" id="romFilter">
                <div class="filter-group filter-group--ram">
                    <h4 class="filter-group__heading">Dung lượng ROM</h4>
                    <div class="ram-options">
                        <a href="/product?rom=128GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">128GB</p>
                            </div>
                        </a>
                        <a href="/product?rom=256GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Apple">
                                <p class="ram-option-card__text">256GB</p>
                            </div>
                        </a>
                        <a href="/product?rom=512GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Dell">
                                <p class="ram-option-card__text">512GB</p>
                            </div>
                        </a>
                        <a href="/product?rom=1TB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="HP">
                                <p class="ram-option-card__text">1TB</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
            <form method="GET" action="/product" id="pinFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Hiệu năng và Pin</h4>
                    <label class="filter-group__label"><input type="checkbox" name="battery" value="0-3000"
                            class="filter-group__checkbox"> Dưới 3000 mah</label>
                    <label class="filter-group__label"><input type="checkbox" name="battery" value="3000-4000"
                            class="filter-group__checkbox"> Từ 3000 - 4000 mah</label>
                    <label class="filter-group__label"><input type="checkbox" name="battery" value="4000-5000"
                            class="filter-group__checkbox"> Từ 4000 - 5000 mah </label>
                    <label class="filter-group__label"><input type="checkbox" name="battery" value="5500-6000"
                            class="filter-group__checkbox"> Trên 5000 mah </label>
                </div>
            </form>
            <form method="GET" action="/product" id="ramFilter">
                <div class="filter-group filter-group--ram">
                    <h4 class="filter-group__heading">Dung lượng RAM</h4>
                    <div class="ram-options">
                        <a href="/product?ram=4GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">4GB</p>
                            </div>
                        </a>
                        <a href="/product?ram=6GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Apple">
                                <p class="ram-option-card__text">6GB</p>
                            </div>
                        </a>
                        <a href="/product?ram=8GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Dell">
                                <p class="ram-option-card__text">8GB</p>
                            </div>
                        </a>
                        <a href="/product?ram=16GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="HP">
                                <p class="ram-option-card__text">16GB</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
            <form method="GET" action="/product" id="screenFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Kích thước màn hình</h4>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="5-6.5"
                            class="filter-group__checkbox"> Từ 5 - 6.5 inch</label>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="6.5-6.8"
                            class="filter-group__checkbox"> Từ 6.5 - 6.8 inch</label>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="6.8-"
                            class="filter-group__checkbox"> Trên 6.8 inch</label>
                </div>
            </form>
            <form method="GET" action="/product">
                <div class="filter-group filter-group--refresh-rate">
                    <h4 class="filter-group__heading">Tần số quét</h4>
                    <div class="refresh-rate-options">
                        <a href="/product?hz=60" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">60Hz</p>
                            </div>
                        </a>
                        <a href="/product?hz=90" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="Apple">
                                <p class="refresh-rate-option-card__text">90Hz</p>
                            </div>
                        </a>
                        <a href="/product?hz=120" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="Dell">
                                <p class="refresh-rate-option-card__text">120Hz</p>
                            </div>
                        </a>
                        <a href="/product?hz=144" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="HP">
                                <p class="refresh-rate-option-card__text">144Hz</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Phần sản phẩm -->
        <!-- <main class="products" id="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-brand="<?= $product['brand'] ?>" data-price="<?= $product['price'] ?>"
                    data-rom="<?= $product['rom'] ?>" data-ram="<?= $product['ram'] ?>" data-os="<?= $product['os'] ?>"
                    data-battery="<?= $product['battery'] ?>" data-screen="<?= $product['screen'] ?>">

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
                        <span class="product-card__old-price"><?= number_format($product['old_price'], 0, ',', '.') ?>
                            ₫</span>
                        <div class="product-card__new-price"><?= number_format($product['price'], 0, ',', '.') ?> ₫</div>
                        <div class="product-card__save-price">Giảm
                            <?= number_format($product['old_price'] - $product['price'], 0, ',', '.') ?> ₫
                        </div>
                    </div>

                    <div class="product-card__storage-options">
                        <?php foreach ($product['rom'] as $romOption): ?>
                            <div class="product-card__storage-card"><span><?= $romOption ?></span></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>

                    <button class="product-card__button">Xem chi tiết</button>
                </div>
            <?php endforeach; ?>
        </main> -->
        <?php View::partial('partials.product-container', ['iphoneProducts' => $iphoneProducts]); ?>


    </div>
    <div class="pagination">
        <a href="?page=1" class="pagination__link">1</a>
        <a href="?page=2" class="pagination__link">2</a>
        <a href="?page=3" class="pagination__link">3</a>
        <span class="pagination__ellipsis">...</span>
        <a href="?page=10" class="pagination__link">10</a>
        <a href="?page=2" class="pagination__next">Trang sau</a>
    </div>

</body>
<script>
    // Tự động gửi form khi thay đổi
    const form = document.getElementById('osFilter'); //Hệ điều hành
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');

    const priceForm = document.getElementById('priceFilter'); //Mức giá
    const radios = priceForm.querySelectorAll('input[type="checkbox"]');

    const pinForm = document.getElementById('pinFilter'); //Dung lượng pin
    const PinForm = pinForm.querySelectorAll('input[type="checkbox"]');

    const screenForm = document.getElementById('screenFilter'); //Kích thước màn hình
    const screenCheckboxes = screenForm.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(cb => { //Hệ điều hành
        cb.addEventListener('change', () => {
            form.submit();
        });
    });
    radios.forEach(radio => { //Mức giá
        radio.addEventListener('change', () => {
            priceForm.submit();
        });
    });
    PinForm.forEach(pin => { //Dung lượng pin
        pin.addEventListener('change', () => {
            pinForm.submit();
        });
    });
    screenCheckboxes.forEach(screen => { //Kích thước màn hình
        screen.addEventListener('change', () => {
            screenForm.submit();
        });
    });
</script>


<?php View::endSection(); ?>