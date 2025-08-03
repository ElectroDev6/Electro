<?php

use Core\View;
?>

<div class="container-main">
    <section class="offer">
        <div class="offer__header">
            <h2 class="offer__title">ƯU ĐÃI ĐẶC BIỆT</h2>
        </div>

        <div class="offer__wrapper">
            <div class="offer__featured">
                <?php View::partial('components.product-card-featured', ['featuredProduct' => $featuredProduct]); ?>
            </div>

            <div class="offer__list">
                <?php foreach ($regularProducts as $regularProduct): ?>
                    <?php View::partial('components.product-card', ['regularProduct' => $regularProduct]); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>