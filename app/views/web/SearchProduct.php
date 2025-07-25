<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán Laptop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="banner">
        <img src="/img/anh1.jpg" alt="Banner">
    </div>

    <div class="container">
        <aside class="filter">
            <h3 class="filter__heading">Bộ lọc tìm kiếm</h3>
            <div class="filter-group">
                <h4 class="filter-group__heading">Hãng sản xuất</h4>
                <div class="brand-logos">
                    <a href="https://www.asus.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card">
                            <img src="/img/Samsung.jpg" alt="Samsung" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.apple.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/apple.jpg" alt="Apple" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.dell.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/xiaomi.jpg" alt="Xiaomi" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.hp.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="HP">
                            <img src="/img/realme.jpg" alt="realme" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.lenovo.com/vn/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Lenovo">
                            <img src="/img/vivo.jpg" alt="vivo" class="brand-logo-card__image">
                        </div>
                    </a>
                    <a href="https://www.acer.com/vn-vi/" class="brand-logos__link">
                        <div class="brand-logo-card" data-brand="Acer">
                            <img src="/img/oppo.jpg" alt="oppo" class="brand-logo-card__image">
                        </div>
                    </a>
                </div>
            </div>

            <div class="filter-group">
                <h4 class="filter-group__heading">Mức giá</h4>
                <label class="filter-group__label"><input type="radio" name="price" value="all" checked class="filter-group__radio"> Tất cả</label>
                <label class="filter-group__label"><input type="radio" name="price" value="25-30" class="filter-group__radio"> Từ 25 đến 30 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="20-25" class="filter-group__radio"> Từ 20 đến 25 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="15-20" class="filter-group__radio"> Từ 15 đến 20 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="10-15" class="filter-group__radio"> Từ 10 đến 15 triệu</label>
                <label class="filter-group__label"><input type="radio" name="price" value="duoi10" class="filter-group__radio"> Dưới 10 triệu</label>

                <p class="filter-group__price-prompt">Nhập khoảng giá phù hợp với bạn:</p>
                <input type="number" id="min-price" placeholder="Từ" class="filter-group__price-input"> ~
                <input type="number" id="max-price" placeholder="Đến" class="filter-group__price-input">
            </div>

            <div class="filter-group">
                <h4 class="filter-group__heading">Hệ điều hành</h4>
                <label class="filter-group__label"><input type="checkbox" value="Apple M4 series" class="filter-group__checkbox"> IOS</label>
                <label class="filter-group__label"><input type="checkbox" value="Apple M3 series" class="filter-group__checkbox"> Android</label>
            </div>

            <div class="filter-group filter-group--ram">
                <h4 class="filter-group__heading">Dung lượng ROM</h4>
                <div class="ram-options">
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card">
                            <p class="ram-option-card__text">128GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Apple">
                            <p class="ram-option-card__text">256GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Dell">
                            <p class="ram-option-card__text">512GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="HP">
                            <p class="ram-option-card__text">1TB</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="filter-group">
                <h4 class="filter-group__heading">Hiệu năng và Pin</h4>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce Series" class="filter-group__checkbox"> Dưới 3000 mah</label>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce MX Series" class="filter-group__checkbox"> Từ 3000 - 4000 mah</label>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce RTX Series" class="filter-group__checkbox"> Từ 4000 - 5000 mah </label>
                <label class="filter-group__label"><input type="checkbox" value="NVIDIA GeForce RTX Series" class="filter-group__checkbox"> Trên 5000 mah </label>
            </div>
            <div class="filter-group filter-group--ram">
                <h4 class="filter-group__heading">Dung lượng RAM</h4>
                <div class="ram-options">
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card">
                            <p class="ram-option-card__text">4GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Apple">
                            <p class="ram-option-card__text">6GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="Dell">
                            <p class="ram-option-card__text">8GB</p>
                        </div>
                    </a>
                    <a href="" class="ram-options__link">
                        <div class="ram-option-card" data-brand="HP">
                            <p class="ram-option-card__text">16GB</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="filter-group">
                <h4 class="filter-group__heading">Kích thước màn hình</h4>
                <label class="filter-group__label"><input type="checkbox" value="13 inch" class="filter-group__checkbox"> Từ 5 - 6.5 inch</label>
                <label class="filter-group__label"><input type="checkbox" value="14 inch" class="filter-group__checkbox"> Từ 6.5 - 6.8 inch</label>
                <label class="filter-group__label"><input type="checkbox" value="15 inch" class="filter-group__checkbox"> Trên 6.8 inch</label>
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
                            <p class="refresh-rate-option-card__text">90Hz</p>
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
                </div>
            </div>

        </aside>
        <!-- Phần danh mục -->
        <div class="content-wrapper">
            <div class="category-tabs">
                <button class="category-tabs__button category-tabs__button--active">
                    <img src="/img/Icon All.svg" alt="Tất cả">
                    <span>Tất cả</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/iphone223.png" alt="Điện thoại">
                    <span>Điện thoại</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/laptop.png" alt="Laptop">
                    <span>Laptop</span>
                </button>
                <button class="category-tabs__button">
                    <img src="/img/tainghe.png" alt="Phụ kiện">
                    <span>Phụ kiện</span>
                </button>
            </div>
            <!-- Phần sản phẩm -->
            <main class="products" id="product-list">
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>
                <div class="product-card">
                    <img src="/img/iphone223.png" alt="Sản phẩm 1" class="product-card__image">
                    <p class="product-card__promo">Trả góp 0%</p>
                    <h4 class="product-card__name">Tên sản phẩm Laptop A</h4>
                    <div class="product-card__price-box">
                        <span class="product-card__old-price">34.290.000 ₫</span>
                        <div class="product-card__new-price">30.090.000 ₫</div>
                        <div class="product-card__save-price">Giảm 4.200.000 ₫</div>
                    </div>
                    <div class="product-card__storage-options">
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">256GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">512GB</span>
                            </div>
                        </a>
                        <a href="" class="product-card__storage-link">
                            <div class="product-card__storage-card">
                                <span class="product-card__storage-text">1TB</span>
                            </div>
                        </a>
                    </div>
                    <div class="product-card__color-options">
                        <div class="product-card__color-swatch" style="background-color: #e0e0e0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #c0c0c0;"></div>
                        <div class="product-card__color-swatch" style="background-color: #d2b48c;"></div>
                        <div class="product-card__color-swatch" style="background-color: #000000;"></div>
                    </div>
                    <button class="product-card__button">Xem chi tiết</button>
                </div>

            </main>
        </div>
        <script src="script.js"></script>
</body>

</html>