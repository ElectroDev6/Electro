<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm Laptop
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<body>

    <div class="banner">
        <img src="/img/Slide1Laptop.webp" alt="Banner">
    </div>

    <div class="container">
        <aside class="filter">
            <h3 class="filter__heading">Bộ lọc tìm kiếm</h3>
            <div class="filter-group">
                <h4 class="filter-group__heading">Hãng sản xuất</h4>
                <div class="brand-logos">
                    <a href="https://www.asus.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_LT_asus.jpg" alt="ASUS" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.apple.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/Menu_LT_apple.jpg" alt="Apple" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.dell.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/Menu_LT_dell.jpg" alt="Dell" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.hp.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="HP">
                            <img src="/img/Menu_LT_hp.jpg" alt="HP" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.lenovo.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Lenovo">
                            <img src="/img/Menu_LT_lenovo.jpg" alt="Lenovo" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.acer.com/vn-vi/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Acer">
                            <img src="/img/Menu_LT_acer.jpg" alt="Acer" class="brand-logo-card__image">
                        </div>
                    </a>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-group__heading">Mức giá</h4>
                <label class="filter-group__label"><input type="radio" name="price" value="all" checked
                        class="filter-group__radio"> Tất cả</label>
                <label class="filter-group__label"><input type="radio" name="price" value="25-30"
                        class="filter-group__radio"> Từ 25 đến 30 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="20-25"
                        class="filter-group__radio"> Từ 20 đến 25 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="15-20"
                        class="filter-group__radio"> Từ 15 đến 20 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="10-15"
                        class="filter-group__radio"> Từ 10 đến 15 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="duoi10"
                        class="filter-group__radio"> Dưới 10 triệu</label>

                <p class="filter-group__price-prompt">Nhập khoảng giá phù hợp với bạn:</p>
                <input type="number" id="min-price" placeholder="Từ" class="filter-group__price-input"> ~
                <input type="number" id="max-price" placeholder="Đến" class="filter-group__price-input">
            </div>

            <div class="filter-group">
                <h4 class="filter-group__heading">CPU</h4>
                <label class="filter-group__label"><input type="checkbox" value="Apple M4 series"
                        class="filter-group__checkbox"> Apple M4 series</label>
                <label class="filter-group__label"><input type="checkbox" value="Apple M3 series"
                        class="filter-group__checkbox"> Apple M3 series</label>
                <label class="filter-group__label"><input type="checkbox" value="Apple M2 series"
                        class="filter-group__checkbox"> Apple M2 series</label>
                <label class="filter-group__label"><input type="checkbox" value="Apple M1 series"
                        class="filter-group__checkbox"> Apple M1 series</label>
                <label class="filter-group__label"><input type="checkbox" value="Intel Celeron"
                        class="filter-group__checkbox"> Intel Celeron</label>
            </div>

            <div class="filter-group filter-group--ram">
                <h4 class="filter-group__heading">RAM</h4>
                <div class="ram-options">
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card">
                            <p class="ram-option-card__text">4GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Apple">
                            <p class="ram-option-card__text">8GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Dell">
                            <p class="ram-option-card__text">12GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="HP">
                            <p class="ram-option-card__text">16GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Lenovo">
                            <p class="ram-option-card__text">32GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Acer">
                            <p class="ram-option-card__text">48GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Acer">
                            <p class="ram-option-card__text">64GB</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-group__heading">Card đồ họa</h4>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce Series"
                        class="filter-group__checkbox"> NVIDIA GeForce Series</label>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce MX Series"
                        class="filter-group__checkbox"> NVIDIA GeForce MX Series</label>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce RTX Series"
                        class="filter-group__checkbox"> NVIDIA GeForce RTX Series</label>
            </div>
            <div class="filter-group">
                <h4 class="filter-group__heading">Ổ cứng</h4>
                <label class="filter-group__label"><input type="checkbox" value="SSD 1TB"
                        class="filter-group__checkbox"> SSD 1TB</label>
                <label class="filter-group__label"><input type="checkbox" value="SSD 2TB"
                        class="filter-group__checkbox"> SSD 2TB</label>
                <label class="filter-group__label"><input type="checkbox" value="SSD 512GB"
                        class="filter-group__checkbox"> SSD 512GB</label>
                <label class="filter-group__label"><input type="checkbox" value="SSD 256GB"
                        class="filter-group__checkbox"> SSD 256GB</label>
                <label class="filter-group__label"><input type="checkbox" value="SSD 128GB"
                        class="filter-group__checkbox"> SSD 128GB</label>
            </div>
            <div class="filter-group">
                <h4 class="filter-group__heading">Kích thước màn hình</h4>
                <label class="filter-group__label"><input type="checkbox" value="13 inch"
                        class="filter-group__checkbox"> Dưới 14 inch</label>
                <label class="filter-group__label"><input type="checkbox" value="14 inch"
                        class="filter-group__checkbox"> 14 - 15 inch</label>
                <label class="filter-group__label"><input type="checkbox" value="15 inch"
                        class="filter-group__checkbox"> 15 - 17 inch</label>
            </div>
            <div class="filter-group filter-group--refresh-rate">
                <h4 class="filter-group__heading">Tần số quét</h4>
                <div class="refresh-rate-options">
                    <a href="" class="refresh-rate-options__link">
                        <div class="refresh-rate-option-card">
                            <p class="refresh-rate-option-card__text">60Hz</p>
                        </div>
                    </a>
                    <a href="" class="refresh-rate-options__link">
                        <div class="refresh-rate-option-card" data-brand="Apple">
                            <p class="refresh-rate-option-card__text">75Hz</p>
                        </div>
                    </a>
                    <a href="" class="refresh-rate-options__link">
                        <div class="refresh-rate-option-card" data-brand="Dell">
                            <p class="refresh-rate-option-card__text">120Hz</p>
                        </div>
                    </a>
                    <a href="" class="refresh-rate-options__link">
                        <div class="refresh-rate-option-card" data-brand="HP">
                            <p class="refresh-rate-option-card__text">144Hz</p>
                        </div>
                    </a>
                    <a href="" class="refresh-rate-options__link">
                        <div class="refresh-rate-option-card" data-brand="Lenovo">
                            <p class="refresh-rate-option-card__text">360Hz</p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>
            <!-- Phần sản phẩm -->
            <main class="products" id="product-list">
                <div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div><div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div><div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div><div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div><div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div><div class="product-card">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">

                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt <br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="Mặt trời" />
                        </div>
                        <div class="product-card__feature-text">Màn hình chóng chói
                        </div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">
                            Viền màn hình <br> siêu mỏng
                        </div>
                    </div>
                    <img src="/img/DM_laptop.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
            </main>
        <script src="script.js"></script>
</body>
<?php View::endSection(); ?>