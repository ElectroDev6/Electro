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
                    <a href="/productlaptop?brand=Asus" class="brand-logos__link">
                        <div class="brand-logo-card">
                            <img src="/img/Menu_LT_asus.jpg" alt="ASUS" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/productlaptop?brand=Apple" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/Menu_LT_apple.jpg" alt="Apple" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/productlaptop?brand=Dell" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/Menu_LT_dell.jpg" alt="Dell" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/productlaptop?brand=HP" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="HP">
                            <img src="/img/Menu_LT_hp.jpg" alt="HP" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/productlaptop?brand=Lenovo" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Lenovo">
                            <img src="/img/Menu_LT_lenovo.jpg" alt="Lenovo" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="/productlaptop?brand=Acer" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Acer">
                            <img src="/img/Menu_LT_acer.jpg" alt="Acer" class="brand-logo-card__image">
                        </div>
                    </a>
                </div>
            </div>
            <form method="GET" action="/productlaptop" id="priceFilter">
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
            <form method="GET" action="/productlaptop" id="cpuFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">CPU</h4>
                    <label class="filter-group__label"><input type="checkbox" value="Apple M4 series" name="cpu"
                            class="filter-group__checkbox"> Apple M4 series</label>
                    <label class="filter-group__label"><input type="checkbox" value="Apple M3 series" name="cpu"
                            class="filter-group__checkbox"> Apple M3 series</label>
                    <label class="filter-group__label"><input type="checkbox" value="Apple M2 series" name="cpu"
                            class="filter-group__checkbox"> Apple M2 series</label>
                    <label class="filter-group__label"><input type="checkbox" value="Apple M1 series" name="cpu"
                            class="filter-group__checkbox"> Apple M1 series</label>
                    <label class="filter-group__label"><input type="checkbox" value="Intel Celeron" name="cpu"
                            class="filter-group__checkbox"> Intel Celeron</label>

                </div>
            </form>
            <form method="GEt" action="/productlaptop" id="ramFilter">
                <div class="filter-group filter-group--ram">
                    <h4 class="filter-group__heading">RAM</h4>
                    <div class="ram-options">
                        <a href="/productlaptop?ram=4GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">4GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=8GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Apple">
                                <p class="ram-option-card__text">8GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=12GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Dell">
                                <p class="ram-option-card__text">12GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=16GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="HP">
                                <p class="ram-option-card__text">16GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=32GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Lenovo">
                                <p class="ram-option-card__text">32GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=48GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Acer">
                                <p class="ram-option-card__text">48GB</p>
                            </div>
                        </a>
                        <a href="/productlaptop?ram=64GB" class="ram-options__link">
                            <div class="ram-option-card" data-brand="Acer">
                                <p class="ram-option-card__text">64GB</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
            <form method="GET" action="/productlaptop" id="cardFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Card đồ họa</h4>
                    <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce Series" name="card"
                            class="filter-group__checkbox"> NVIDIA GeForce Series</label>
                    <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce MX Series"
                            name="card" class="filter-group__checkbox"> NVIDIA GeForce MX Series</label>
                    <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce RTX Series"
                            name="card" class="filter-group__checkbox"> NVIDIA GeForce RTX Series</label>
                    <label class="filter-group__label"><input type="checkbox" value="Apple M4 GPU" name="card"
                            class="filter-group__checkbox"> Apple M4 GPU</label>
                </div>
            </form>
            <form method="GET" action="/productlaptop" id="hdFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Ổ cứng</h4>
                    <label class="filter-group__label"><input type="checkbox" value="SSD 1TB" name="hard_drive"
                            class="filter-group__checkbox"> SSD 1TB</label>
                    <label class="filter-group__label"><input type="checkbox" value="SSD 2TB" name="hard_drive"
                            class="filter-group__checkbox"> SSD 2TB</label>
                    <label class="filter-group__label"><input type="checkbox" value="SSD 512GB" name="hard_drive"
                            class="filter-group__checkbox"> SSD 512GB</label>
                    <label class="filter-group__label"><input type="checkbox" value="SSD 256GB" name="hard_drive"
                            class="filter-group__checkbox"> SSD 256GB</label>
                    <label class="filter-group__label"><input type="checkbox" value="SSD 128GB" name="hard_drive"
                            class="filter-group__checkbox"> SSD 128GB</label>
                </div>
            </form>
            <form method="GET" action="/productlaptop" id="screenFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">Kích thước màn hình</h4>
                    <label class="filter-group__label"><input type="checkbox" value="14" name="screen"
                            class="filter-group__checkbox"> Dưới 14 inch</label>
                    <label class="filter-group__label"><input type="checkbox" value="14-15" name="screen"
                            class="filter-group__checkbox"> 14 - 15 inch</label>
                    <label class="filter-group__label"><input type="checkbox" value="15-17" name="screen"
                            class="filter-group__checkbox"> 15 - 17 inch</label>
                </div>
            </form>
            <form method="GET" action="/product">
                <div class="filter-group filter-group--refresh-rate">
                    <h4 class="filter-group__heading">Tần số quét</h4>
                    <div class="refresh-rate-options">
                        <a href="/productlaptop?hz=60" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">60Hz</p>
                            </div>
                        </a>
                        <a href="/productlaptop?hz=75" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" >
                                <p class="refresh-rate-option-card__text">75Hz</p>
                            </div>
                        </a>
                        <a href="/productlaptop?hz=120" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">120Hz</p>
                            </div>
                        </a>
                        <a href="/productlaptop?hz=144" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">144Hz</p>
                            </div>
                        </a>
                        <a href="/productlaptop?hz=360" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card" >
                                <p class="refresh-rate-option-card__text">360Hz</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </aside>
        <!-- Phần sản phẩm -->
        <main class="products" id="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-brand="<?= $product['brand'] ?>" data-price="<?= $product['price'] ?>"
                    data-ram="<?= $product['ram'] ?>" data-os="<?= $product['os'] ?>"
                    data-battery="<?= $product['battery'] ?>" data-screen="<?= $product['screen'] ?>">
                    <!-- Icon bên phải sản phẩm -->
                    <div class="product-card__feature">
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_nutgatcamera.svg" alt="Nút gạt tắt camera" />
                        </div>
                        <div class="product-card__feature-text">Nút gạt tắt<br> camera</div>
                        <div class="product-card__feature-icon">
                            <img src="/img/LT_mattroi.svg" alt="">
                        </div>
                        <div class="product-card__feature-text">Màn hình chống chói</div>
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
                    <button class="product-card__button">Xem chi tiết</button>
                </div>

            <?php endforeach; ?>
        </main>
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
    const cpuForm = document.getElementById('cpuFilter');
    const cpuCheckboxes = cpuForm.querySelectorAll('input[type="checkbox"]');

    const priceForm = document.getElementById('priceFilter');//Mức giá
    const radios = priceForm.querySelectorAll('input[type="checkbox"]');

    const ramForm = document.getElementById('ramFilter');//Ram
    const ramCheckboxes = ramForm.querySelectorAll('input[type="checkbox"]');

    const cardForm = document.getElementById('cardFilter');//Card đồ họa
    const cardCheckboxes = cardForm.querySelectorAll('input[type="checkbox"]');

    const hdForm = document.getElementById('hdFilter');// ổ cứng
    const hdCheckboxes = hdForm.querySelectorAll('input[type="checkbox"]');

    const screenForm = document.getElementById('screenFilter');//Kích thước màn hình
    const screenCheckboxes = screenForm.querySelectorAll('input[type="checkbox"]');

    radios.forEach(radio => {//Mức giá
        radio.addEventListener('change', () => {
            priceForm.submit();
        });
    });

    cpuCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            console.log('Đã chọn CPU:', cb.value); // ← kiểm tra có log không
            cpuForm.submit();
        });
    });
    ramCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            console.log('Đã chọn RAM:', cb.value); // ← kiểm tra có log không
            ramForm.submit();
        });
    });
    cardCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            console.log('Đã chọn Card:', cb.value); // ← kiểm tra có log không
            cardForm.submit();
        });
    });
    hdCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            console.log('Đã chọn Card:', cb.value); // ← kiểm tra có log không
            hdForm.submit();
        });
    });
    screenCheckboxes.forEach(screen => {//Kích thước màn hình
        screen.addEventListener('change', () => {
            screenForm.submit();
        });
    });
</script>

<?php View::endSection(); ?>