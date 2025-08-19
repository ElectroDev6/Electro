<?php

use Core\View;

View::extend('layouts.main');
View::section('page_title');
?>
Sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<?php View::component('components.scroll-to-top'); ?>

<div class="container-main">
    <div class="navigation">
        <a href="/">Trang chủ</a> /
        <a class="active" href="/products/<?php echo htmlspecialchars($categorySlug ?? ''); ?>">
            <?php echo htmlspecialchars($categorySlug ? ucfirst(str_replace('-', ' ', $categorySlug)) : 'Sản phẩm'); ?>
        </a>
        <?php if ($subcategorySlug): ?>
            / <span><?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $subcategorySlug))); ?></span>
        <?php endif; ?>
    </div>

    <div class="banner">
        <img class="banner__image" src="/img/sliders/slider-1.jpg" alt="Banner Phone">
    </div>
    <?php if (!empty($subcategories)): ?>
        <div class="use-needs">
            <h3 class="use-needs__title">Sản phẩm liên quan</h3>
            <div class="use-needs__list">
                <?php foreach ($subcategories as $sub): ?>
                    <a href="/products/<?php echo htmlspecialchars($categorySlug); ?>/<?php echo htmlspecialchars($sub['subcategory_slug']); ?>" class="use-needs__item" style="background: #fff; ?>">
                        <img src="/img/brands/<?php echo htmlspecialchars($sub['subcategory_slug']); ?>.webp" alt="<?php echo htmlspecialchars($sub['name']); ?>">
                        <p><?php echo htmlspecialchars($sub['name']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="content-layout">

        <?php
        View::component('components.filter', [
            'brands' => $brands,
            'selectedBrands' => $selectedBrands,
            'availableAttributes' => $availableAttributes,
            'selectedAttributes' => $selectedAttributes,
            'categorySlug' => $categorySlug,
            'subcategorySlug' => $subcategorySlug
        ]);
        ?>

        <main class="products" id="product-list">

            <?php if (!empty($errorMessage)): ?>
                <p style="color:red;"><?= $errorMessage ?></p>
            <?php endif; ?>

            <?php
            if (empty($products)) {
                echo '<p style="text-align:center; font-size:18px; color:#666; margin-top:200px;">Không có sản phẩm</p>';
            } else {
                View::partial('partials.product-category', ['products' => $products]);
            }
            ?>
        </main>
    </div>

    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?= $currentPage - 1 ?>" class="pagination__prev">Trang trước</a>
        <?php endif; ?>

        <?php
        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);

        if ($start > 1) {
            echo '<a href="?page=1" class="pagination__link">1</a>';
            if ($start > 2) echo '<span class="pagination__ellipsis">...</span>';
        }

        for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i == $currentPage): ?>
                <span class="pagination__link active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>" class="pagination__link"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($end < $totalPages): ?>
            <?php if ($end < $totalPages - 1) echo '<span class="pagination__ellipsis">...</span>'; ?>
            <a href="?page=<?= $totalPages ?>" class="pagination__link"><?= $totalPages ?></a>
        <?php endif; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?= $currentPage + 1 ?>" class="pagination__next">Trang sau</a>
        <?php endif; ?>
    </div>
</div>

<script>
    const mainForm = document.getElementById('mainFilter');
    if (mainForm) {
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
    }

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