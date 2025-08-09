<!-- Trang sản phẩm Iphone -->
<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<div class="container-main">
    <div class="navigation">
        <a href="/">Trang chủ</a> / <a class="active" href="/products/iphone">iPhone</a>
    </div>

    <div class="banner">
        <img src="/img/Slide2Laptop.jpg" alt="Banner iPhone">
    </div>

    <div class="use-needs">
        <h3 class="use-needs__title">Nhu cầu sử dụng iPhone</h3>
        <div class="use-needs__list">
            <a href="/iphone-pro-max" class="use-needs__item" style="background: linear-gradient(135deg, #ffe5e5, #ffcccc);">
                <img src="/img/UN_Laptop_AI.png" alt="iPhone Pro Max">
                <p>iPhone Pro Max</p>
            </a>
            <a href="/iphone-pro" class="use-needs__item" style="background: linear-gradient(135deg, #fff2cc, #ffe066);">
                <img src="/img/UN_Gaming.png" alt="iPhone Pro">
                <p>iPhone Pro</p>
            </a>
            <a href="/iphone-standard" class="use-needs__item" style="background: linear-gradient(135deg, #ccf2ff, #66d9ff);">
                <img src="/img/UN_Sinhvien.png" alt="iPhone Standard">
                <p>iPhone Standard</p>
            </a>
            <a href="/iphone-mini" class="use-needs__item" style="background: linear-gradient(135deg, #ede9ff, #d6ccff);">
                <img src="/img/UN_Mongnhe.jpg" alt="iPhone Mini">
                <p>iPhone Mini</p>
            </a>
            <a href="/iphone-se" class="use-needs__item" style="background: linear-gradient(135deg, #d9fbe4, #99f5b3);">
                <img src="/img/UN_Doanhnhan.jpg" alt="iPhone SE">
                <p>iPhone SE</p>
            </a>
        </div>
    </div>

    <div class="content-layout">
        <aside class="filter">
            <h3 class="filter__heading">🔍 Bộ lọc tìm kiếm</h3>

            <form method="GET" action="/products/iphone" id="mainFilter">
                <div class="filter-group">
                    <h4 class="filter-group__heading">📱 Dòng iPhone</h4>
                    <div class="brand-logos" id="brand-logos">
                        <a href="/products/iphone?series=iPhone15" class="brand-logos__link">
                            <div class="brand-logo-card">
                                <img src="/img/Menu_DT_oppo.jpg" alt="iPhone 15">
                                <p style="font-size: 11px; margin-top: 5px;">iPhone 15</p>
                            </div>
                        </a>
                        <a href="/products/iphone?series=iPhone14" class="brand-logos__link">
                            <div class="brand-logo-card">
                                <img src="/img/Menu_LT_apple.jpg" alt="iPhone 14">
                                <p style="font-size: 11px; margin-top: 5px;">iPhone 14</p>
                            </div>
                        </a>
                        <a href="/products/iphone?series=iPhone13" class="brand-logos__link">
                            <div class="brand-logo-card">
                                <img src="/img/Menu_DT_vivo.jpg" alt="iPhone 13">
                                <p style="font-size: 11px; margin-top: 5px;">iPhone 13</p>
                            </div>
                        </a>
                        <a href="/products/iphone?series=iPhoneSE" class="brand-logos__link">
                            <div class="brand-logo-card">
                                <img src="/img/Menu_LT_apple.jpg" alt="iPhone SE">
                                <p style="font-size: 11px; margin-top: 5px;">iPhone SE</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="filter-group">
                    <h4 class="filter-group__heading">💰 Mức giá</h4>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="all" class="filter-group__radio">
                        Tất cả
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="30-40" class="filter-group__radio">
                        Từ 30 - 40 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="25-30" class="filter-group__radio">
                        Từ 25 - 30 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="20-25" class="filter-group__radio">
                        Từ 20 - 25 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="15-20" class="filter-group__radio">
                        Từ 15 - 20 triệu
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="price" value="duoi15" class="filter-group__radio">
                        Dưới 15 triệu
                    </label>
                </div>

                <div class="filter-group filter-group--ram">
                    <h4 class="filter-group__heading">💾 Dung lượng</h4>
                    <div class="ram-options">
                        <a href="/products/iphone?storage=128GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">128GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=256GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">256GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=512GB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">512GB</p>
                            </div>
                        </a>
                        <a href="/products/iphone?storage=1TB" class="ram-options__link">
                            <div class="ram-option-card">
                                <p class="ram-option-card__text">1TB</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="filter-group">
                    <h4 class="filter-group__heading">🎨 Màu sắc</h4>
                    <label class="filter-group__label">
                        <input type="checkbox" name="color[]" value="black" class="filter-group__checkbox">
                        Đen
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="color[]" value="white" class="filter-group__checkbox">
                        Trắng
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="color[]" value="blue" class="filter-group__checkbox">
                        Xanh dương
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="color[]" value="purple" class="filter-group__checkbox">
                        Tím
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="color[]" value="gold" class="filter-group__checkbox">
                        Vàng
                    </label>
                </div>

                <div class="filter-group">
                    <h4 class="filter-group__heading">📱 Kích thước màn hình</h4>
                    <label class="filter-group__label">
                        <input type="checkbox" name="screen" value="5.4" class="filter-group__checkbox">
                        5.4 inch (Mini)
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="screen" value="6.1" class="filter-group__checkbox">
                        6.1 inch (Standard)
                    </label>
                    <label class="filter-group__label">
                        <input type="checkbox" name="screen" value="6.7" class="filter-group__checkbox">
                        6.7 inch (Plus/Pro Max)
                    </label>
                </div>

                <div class="filter-group filter-group--refresh-rate">
                    <h4 class="filter-group__heading">⚡ Tần số quét</h4>
                    <div class="refresh-rate-options">
                        <a href="/products/iphone?hz=60" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">60Hz</p>
                            </div>
                        </a>
                        <a href="/products/iphone?hz=120" class="refresh-rate-options__link">
                            <div class="refresh-rate-option-card">
                                <p class="refresh-rate-option-card__text">120Hz</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </aside>

        <main class="products" id="product-list">
            <!-- Sample product cards -->
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
</div>

<script>
    const mainForm = document.getElementById('mainFilter');
    const allCheckboxes = mainForm.querySelectorAll('input[type="checkbox"]');

    allCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const params = new URLSearchParams();

            // Duyệt tất cả checkbox đã được check trong form
            mainForm.querySelectorAll('input[type="checkbox"]:checked').forEach(checkedCb => {
                params.append(checkedCb.name, checkedCb.value);
            });

            // Tạo URL mới chứa filter và chuyển trang
            window.location.search = '?' + params.toString();
        });
    });

    // Animation cho product cards khi scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Apply animation to product cards
    document.querySelectorAll('.product-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
</script>

<?php View::endSection(); ?>