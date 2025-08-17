<?php

use Core\View;

?>

<div class="container-main">
    <section class="category-list category-product" style="background-color: #f3f4f6;">
        <div class="category-list__container scroll-horizontal">
            <div class="category-list__wrapper">
                <div class="category-list__items">
                    <?php for ($i = 0; $i < 4 && isset($categories[$i]); $i++): ?>
                        <a href="/products/<?php echo htmlspecialchars($categories[$i]['slug']); ?>">
                            <div class="category-list__item">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[$i]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[$i]['image']); ?>" alt="<?php echo htmlspecialchars($categories[$i]['name']); ?>" class="category-list__image" />
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if (isset($categories[4])): ?>
                    <a href="/products/<?php echo htmlspecialchars($categories[4]['slug']); ?>">
                        <div class="category-list__items">
                            <div class="category-list__item category-list__item--wide">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[4]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[4]['image']); ?>" alt="<?php echo htmlspecialchars($categories[4]['name']); ?>" class="category-list__image" />
                            </div>
                        </div>
                    </a>
                <?php endif; ?>

                <div class="category-list__items">
                    <?php for ($i = 5; $i < 9 && isset($categories[$i]); $i++): ?>
                        <a href="/products/<?php echo htmlspecialchars($categories[$i]['slug']); ?>">
                            <div class="category-list__item">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[$i]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[$i]['image']); ?>" alt="<?php echo htmlspecialchars($categories[$i]['name']); ?>" class="category-list__image" />
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- ẩn khúc này -->
            <div class="category-list__wrapper">
                <div class="category-list__items">
                    <?php for ($i = 9; $i < 13 && isset($categories[$i]); $i++): ?>
                        <a href="/products/<?php echo htmlspecialchars($categories[$i]['slug']); ?>">
                            <div class="category-list__item">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[$i]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[$i]['image']); ?>" alt="<?php echo htmlspecialchars($categories[$i]['name']); ?>" class="category-list__image" />
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if (isset($categories[13])): ?>
                    <a href="/products/<?php echo htmlspecialchars($categories[13]['slug']); ?>">
                        <div class="category-list__items">
                            <div class="category-list__item category-list__item--wide">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[13]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[13]['image']); ?>" alt="<?php echo htmlspecialchars($categories[13]['name']); ?>" class="category-list__image" />
                            </div>
                        </div>
                    </a>
                <?php endif; ?>

                <div class="category-list__items">
                    <?php for ($i = 14; $i < 18 && isset($categories[$i]); $i++): ?>
                        <a href="/products/<?php echo htmlspecialchars($categories[$i]['slug']); ?>">
                            <div class="category-list__item">
                                <p class="category-list__name"><?php echo htmlspecialchars($categories[$i]['name']); ?></p>
                                <img src="<?php echo htmlspecialchars($categories[$i]['image']); ?>" alt="<?php echo htmlspecialchars($categories[$i]['name']); ?>" class="category-list__image" />
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <?php View::component('components.arrow-buttons') ?>
    </section>
</div>