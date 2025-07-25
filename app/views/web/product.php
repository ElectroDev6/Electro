<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

    <div class="banner">
        <img src="/img/anh1.jpg" alt="Banner">
    </div>

    <div class="container">
        <aside class="filter">
            <h3>Bộ lọc tìm kiếm</h3>
            <div class="filter-group">
                <h4>Hãng sản xuất</h4>
                <div class="brand-logos">
                    <a href="https://www.asus.com/vn/">
                        <div class="brand-logo-card">
                            <img src="/img/asus.jpg" alt="ASUS">
                        </div>
                    </a>
                    <a href="https://www.apple.com/vn/">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/apple.jpg" alt="Apple">
                        </div>
                    </a>
                    <a href="https://www.dell.com/vn/">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/dell.jpg" alt="Dell">
                        </div>
                    </a>
                    <a href="https://www.hp.com/vn/">
                        <div class="brand-logo-card" data-brand="HP">
                            <img src="/img/hp.jpg" alt="HP">
                        </div>
                    </a>
                    <a href="https://www.lenovo.com/vn/">
                        <div class="brand-logo-card" data-brand="Lenovo">
                            <img src="/img/lenovo.jpg" alt="Lenovo">
                        </div>
                    </a>
                    <a href="https://www.acer.com/vn-vi/">
                        <div class="brand-logo-card" data-brand="Acer">
                            <img src="/img/acer.jpg" alt="Acer">
                        </div>
                    </a>
                </div>
            </div>

            <div class="filter-group">
                <h4>Mức giá</h4>
                <label><input type="radio" name="price" value="all" checked> Tất cả</label>
                <label><input type="radio" name="price" value="25-30"> Từ 25 đến 30 triệu</label>
                <label><input type="radio" name="price" value="20-25"> Từ 20 đến 25 triệu</label>
                <label><input type="radio" name="price" value="15-20"> Từ 15 đến 20 triệu</label>
                <label><input type="radio" name="price" value="10-15"> Từ 10 đến 15 triệu</label>
                <label><input type="radio" name="price" value="duoi10"> Dưới 10 triệu</label>

                <p style="margin-top:8px; font-size:13px;">Nhập khoảng giá phù hợp với bạn:</p>
                <input type="number" id="min-price" placeholder="Từ" style="width:90px;"> ~
                <input type="number" id="max-price" placeholder="Đến" style="width:90px;">
            </div>

            <div class="filter-group">
                <h4>CPU</h4>
                <label><input type="checkbox" value="Apple M4 series"> Apple M4 series</label>
                <label><input type="checkbox" value="Apple M3 series"> Apple M3 series</label>
                <label><input type="checkbox" value="Apple M2 series"> Apple M2 series</label>
                <label><input type="checkbox" value="Apple M1 series"> Apple M1 series</label>
                <label><input type="checkbox" value="Intel Celeron"> Intel Celeron</label>
            </div>

            <div class="filter-ram">
                <h4>RAM</h4>
                <div class="brand-ram">
                    <a href="">
                        <div class="brand-logo-ram">
                            <p>4GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Apple">
                            <p>8GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Dell">
                            <p>12GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="HP">
                            <p>16GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Lenovo">
                            <p>32GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Acer">
                            <p>48GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Acer">
                            <p>64GB</p>
                        </div>
                    </a>
                </div>
                <div class="filter-group">
                    <h4>Card đồ họa</h4>
                    <label><input type="checkbox" value="NVIDIA GeForce Series"> NVIDIA GeForce Series</label>
                    <label><input type="checkbox" value="NVIDIA GeForce MX Series"> NVIDIA GeForce MX Series</label>
                    <label><input type="checkbox" value="NVIDIA GeForce RTX Series"> NVIDIA GeForce RTX Series</label>
                </div>
                <div class="filter-group">
                    <h4>Ổ cứng</h4>
                    <label><input type="checkbox" value="SSD 1TB"> SSD 1TB</label>
                    <label><input type="checkbox" value="SSD 2TB"> SSD 2TB</label>
                    <label><input type="checkbox" value="SSD 512GB"> SSD 512GB</label>
                    <label><input type="checkbox" value="SSD 256GB"> SSD 256GB</label>
                    <label><input type="checkbox" value="SSD 128GB"> SSD 128GB</label>
                </div>
                <div class="filter-group">
                    <h4>Kích thước màn hình</h4>
                    <label><input type="checkbox" value="13 inch"> Dưới 14 inch</label>
                    <label><input type="checkbox" value="14 inch"> 14 - 15 inch</label>
                    <label><input type="checkbox" value="15 inch"> 15 - 17 inch</label>
                </div>
                <div class="filter-Hz">
                    <h4>Tần số quét</h4>
                    <div class="brand-Hz">
                        <a href="">
                            <div class="brand-logo-Hz">
                                <p>60Hz</p>
                            </div>
                        </a>
                        <a href="">
                            <div class="brand-logo-Hz" data-brand="Apple">
                                <p>75Hz</p>
                            </div>
                        </a>
                        <a href="">
                            <div class="brand-logo-Hz" data-brand="Dell">
                                <p>120Hz</p>
                            </div>
                        </a>
                        <a href="">
                            <div class="brand-logo-Hz" data-brand="HP">
                                <p>144Hz</p>
                            </div>
                        </a>
                        <a href="">
                            <div class="brand-logo-Hz" data-brand="Lenovo">
                                <p>360Hz</p>
                            </div>
                        </a>
                    </div>

        </aside>
        <!-- Phần Sản Phẩm -->
        <main class="products" id="product-list">
            <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>
              <div class="product-card">
                <img src="/img/iphone223.png" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <div class="price-box">
                    <span class="old-price">34.290.000 ₫</span>
                    <div class="new-price">30.090.000 ₫</div>
                    <div class="save-price">Giảm 4.200.000 ₫</div>
                </div>
                <div class="filter-Dungluong">
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>256GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>512GB</span>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-Dungluong">
                            <span>1TB</span>
                        </div>
                    </a>
                </div>
                <button>Xem chi tiết</button>
            </div>

        </main>
    </div>

    <script src="script.js"></script>
</body>

<?php View::endSection(); ?>