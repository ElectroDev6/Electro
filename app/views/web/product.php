<!-- Trang sản phẩm Iphone -->
<?php
use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('page_title'); ?>
Sản phẩm
<?php View::endSection(); ?>
<?php View::section('content'); ?>

<body>
     <?php echo '<pre>';
    print_r($products);
    echo '</pre>';
    ?>
    Phần dung lươợng
    <?php echo '<pre>';
    print_r($storage);
    echo '</pre>';
    ?> 
    <div class="navigation">
        <a href="/">Trang chủ</a> / <a class="active" href="/products/iphone">Điện thoại</a>
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
                    <a href="/products/iphone?brand=Oppo" class="brand-logos__link" data-brand="Oppo">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_DT_oppo.jpg" alt="Oppo" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/products/iphone?brand=Apple" class="brand-logos__link" data-brand="Apple">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_LT_apple.jpg" alt="Apple" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/products/iphone?brand=Vivo" class="brand-logos__link" data-brand="Vivo">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_DT_vivo.jpg" alt="Vivo" class="brand-logo-card__image">
                        </div>
                    </a>
                </div>
            </div>

            <form method="GET" action="/product" id="mainFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Mức giá</h4>
                    <label class="filter-group__label"> <input type="checkbox" name="price[]" value="all"
                            <?= in_array('all', $priceRange) ? 'checked' : '' ?> class="filter-group__radio"> Tất cả
                    </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price[]" value="25-30"
                            <?= in_array('25-30', $priceRange) ? 'checked' : '' ?> class="filter-group__radio"> Từ 25
                        đến 30 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price[]" value="20-25" <?= in_array('20-25', $priceRange) ? 'checked' : '' ?> class="filter-group__radio"> Từ 20 đến 25
                        triệu
                    </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price[]" value="15-20"
                            <?= in_array('15-20', $priceRange) ? 'checked' : '' ?> class="filter-group__radio"> Từ 15
                        đến 20 triệu </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price[]" value="10-15" <?= in_array('10-15', $priceRange) ? 'checked' : '' ?> class="filter-group__radio"> Từ 10 đến 15
                        triệu
                    </label>
                    <label class="filter-group__label"> <input type="checkbox" name="price[]" value="duoi10"
                            class="filter-group__radio"> Dưới 10 triệu </label>
                </div>

                <!-- <div class="filter-group">
                    <h4 class="filter-group__heading">Hệ điều hành</h4>
                    <label class="filter-group__label">
                        <input type="checkbox" name="operating_system[]" value="IOS" 
                         class="filter-group__checkbox"> IOS
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="operating_system[]" value="Android" 
                        class="filter-group__checkbox">
                        Android
                    </label>

                </div> -->

                <div class="filter-group filter-group--ram">
                    <h4 class="filter-group__heading">Dung lượng</h4>
                    <div class="ram-options">
                        <a href="/products/iphone?storage=128GB" <?= in_array('128GB', $storage) ? 'checked' : '' ?>
                            class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">128GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=256GB" <?= in_array('256GB', $storage) ? 'checked' : '' ?>
                            class="ram-options__link">
                            <div class="ram-option-card" data-brand="Apple">
                                <p class="ram-option-card__text">256GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=512GB" <?= in_array('512GB', $storage) ? 'checked' : '' ?>
                            class="ram-options__link">
                            <div class="ram-option-card" data-brand="Dell">
                                <p class="ram-option-card__text">512GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=1TB" <?= in_array('1TB', $storage) ? 'checked' : '' ?>
                            class="ram-options__link">
                            <div class="ram-option-card" data-brand="HP">
                                <p class="ram-option-card__text">1TB</p>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- <div class="filter-group">

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
          
                </div> -->

                <!-- <div class="filter-group filter-group--ram">
                        <h4 class="filter-group__heading">Dung lượng RAM</h4>
                        <div class="ram-options">
                            <a href="/products/iphone?ram=4GB" class="ram-options__link">
                                <div class="ram-option-card">
                                    <p class="ram-option-card__text">4GB</p>
                                </div>
                            </a>
                            <a href="/products/iphone?ram=6GB" class="ram-options__link">
                                <div class="ram-option-card" data-brand="Apple">
                                    <p class="ram-option-card__text">6GB</p>
                                </div>
                            </a>
                            <a href="/products/iphone?ram=8GB" class="ram-options__link">
                                <div class="ram-option-card" data-brand="Dell">
                                    <p class="ram-option-card__text">8GB</p>
                                </div>
                            </a>
                            <a href="/products/iphone?ram=16GB" class="ram-options__link">
                                <div class="ram-option-card" data-brand="HP">
                                    <p class="ram-option-card__text">16GB</p>
                                </div>
                            </a>
                        </div>
                    </div> -->

                <div class="filter-group">
                    <h4 class="filter-group__heading">Kích thước màn hình</h4>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="5-6.5"
                            class="filter-group__checkbox"> Từ 5 - 6.5 inch</label>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="6.5-6.8"
                            class="filter-group__checkbox"> Từ 6.5 - 6.8 inch</label>
                    <label class="filter-group__label"><input type="checkbox" name="screen" value="6.8-"
                            class="filter-group__checkbox"> Trên 6.8 inch</label>
                </div>

                <div class="filter-group filter-group--refresh-rate">
                    <h4 class="filter-group__heading">Tần số quét</h4>
                    <div class="refresh-rate-options">
                        <a href="/products/iphone?hz=60" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">60Hz</p>
                            </div>
                        </a>
                        <a href="/products/iphone?hz=90" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="Apple">
                                <p class="refresh-rate-option-card__text">90Hz</p>
                            </div>
                        </a>
                        <a href="/products/iphone?hz=120" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="Dell">
                                <p class="refresh-rate-option-card__text">120Hz</p>
                            </div>
                        </a>
                        <a href="/products/iphone?hz=144" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" data-brand="HP">
                                <p class="refresh-rate-option-card__text">144Hz</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Phần sản phẩm -->
        <main class="products" id="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">

                    <div class="product-card__feature">
                        <div class="product-card__feature-icon">
                            <img src="https://cdn2.fptshop.com.vn/svg/screen_6_9_0bc42d6b8c.svg" alt="6.9 inch" />
                        </div>
                        <div class="product-card__feature-text">Màn hình cực lớn<br> inch</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_nutcamera.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">Camera siêu nét</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/DT_vienmanhinh.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">Viền màn hình<br>siêu mỏng</div>
                    </div>

                    <img src="<?= $product['default_url'] ?>" alt="<?= $product['name'] ?>" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name"><?= $product['name']; ?></h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price"><?= number_format($product['price_original'], 0, ',', '.') ?>
                            ₫</span>
                        <div class="product-card__new-price"><?= number_format($product['price_discount'], 0, ',', '.') ?> ₫
                        </div>
                        <div class="product-card__save-price">Giảm
                            <?= number_format($product['price_original'] - $product['price_discount'], 0, ',', '.') ?> ₫
                        </div>
                    </div>

                    <!-- <div class="product-card__storage-options">
                        <div class="product-card__storage-card">
                            <span><?= htmlspecialchars($product['storage']) ?></span>
                        </div>
                    </div>


                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div> -->

                    <button class="product-card__button">Xem chi tiết</button>
                </div>
            <?php endforeach; ?>
        </main>

    </div>
    <div class="pagination">
        <a href="?page=1" class="pagination__link">1</a>
        <a href="/products/laptops" class="pagination__link">2</a>
        <a href="?page=3" class="pagination__link">3</a>
        <span class="pagination__ellipsis">...</span>
        <a href="?page=10" class="pagination__link">10</a>
        <a href="?page=2" class="pagination__next">Trang sau</a>
    </div>

</body>
<script>
    const mainForm = document.getElementById('mainFilter');
    const allCheckboxes = mainForm.querySelectorAll('input[type="checkbox"]');

    allCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            // Lấy các params hiện có từ URL
            const params = new URLSearchParams(window.location.search);

            // Xóa hết giá trị cũ của filter hiện tại
            params.delete(cb.name);

            // Lấy tất cả checkbox đang check có cùng name
            mainForm.querySelectorAll(`input[name="${cb.name}"]:checked`).forEach(checkedCb => {
                params.append(checkedCb.name, checkedCb.value);
            });

            // Reload với URL mới (giữ các filter khác)
            window.location.search = params.toString();
        });
    });


</script>
<?php View::endSection(); ?>