<?php

use Core\View;

View::extend('layouts.main');
View::section('page_title');
?>
Sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<div class="container-main">
    <div class="navigation">
        <a href="/">Trang chủ</a> /
        <a class="active" href="/products/<?php echo htmlspecialchars($categorySlug ?? 'phone'); ?>">
            <?php echo htmlspecialchars($categorySlug ? ucfirst(str_replace('-', ' ', $categorySlug)) : 'Phone'); ?>
        </a>
    </div>

    <div class="banner">
        <img class="banner__image" src="/img/sliders/slider-1.jpg" alt="Banner Phone">
    </div>

    <div class="use-needs">
        <h3 class="use-needs__title">Nhu cầu sử dụng</h3>
        <div class="use-needs__list">
            <a href="/products/iphone-pro-max" class="use-needs__item" style="background: linear-gradient(135deg, #ffe5e5, #ffcccc);">
                <img src="/img/products/thumbnails/iphone/iphone-13-den-0.webp" alt="iPhone Pro Max">
                <p>iPhone Pro Max</p>
            </a>
            <a href="/products/iphone-pro" class="use-needs__item" style="background: linear-gradient(135deg, #fff2cc, #ffe066);">
                <img src="/img/products/thumbnails/iphone/iphone-13-den-0.webp" alt="iPhone Pro">
                <p>iPhone Pro</p>
            </a>
            <a href="/products/iphone-standard" class="use-needs__item" style="background: linear-gradient(135deg, #ccf2ff, #66d9ff);">
                <img src="/img/products/thumbnails/iphone/iphone-13-den-0.webp" alt="iPhone Standard">
                <p>iPhone Standard</p>
            </a>
            <a href="/products/iphone-mini" class="use-needs__item" style="background: linear-gradient(135deg, #ede9ff, #d6ccff);">
                <img src="/img/products/thumbnails/iphone/iphone-13-den-0.webp" alt="iPhone Mini">
                <p>iPhone Mini</p>
            </a>
            <a href="/products/iphone-se" class="use-needs__item" style="background: linear-gradient(135deg, #d9fbe4, #99f5b3);">
                <img src="/img/products/thumbnails/iphone/iphone-13-den-0.webp" alt="iPhone SE">
                <p>iPhone SE</p>
            </a>
        </div>
    </div>

    <div class="content-layout">
        <?php
        error_log("Products View: Brands before component: " . json_encode($brands));
        View::component('components.filter-phone', ['brands' => $brands, 'selectedBrands' => $selectedBrands]);
        ?>
        <main class="products" id="product-list">
            <?php View::partial('partials.product-category', ['products' => $products]); ?>
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
            mainForm.querySelectorAll('input[type="checkbox"]:checked').forEach(checkedCb => {
                params.append(checkedCb.name, checkedCb.value);
            });
            console.log("Filter applied: " + params.toString());
            window.location.search = '?' + params.toString();
        });
    });

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

    document.querySelectorAll('.product-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
</script>

<?php View::endSection(); ?>