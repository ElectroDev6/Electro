<?php

use Core\View;
?>

<div class="container-main">
    <section class="accessory">
        <div class="accessory__header">
            <h2 class="accessory__title">Phụ kiện</h2>
        </div>

        <div class="accessory__list">
            <?php foreach ($accessories as $accessory): ?>
                <div class="accessory-item">
                    <div class="accessory-item__image-container">
                        <img src="<?= $accessory['image'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $accessory['name'] ?>" class="accessory-item__image" />
                    </div>

                    <p class="accessory-item__name"><?= $accessory['name'] ?? 'Camera giám sát IP 3MP 365 Selection C1' ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="accessory">
        <div class="accessory__header">
            <h2 class="accessory__title">Linh kiện máy tính</h2>
        </div>

        <div class="accessory__list">
            <?php foreach ($computerAccessories as $computerAcc): ?>
                <div class="accessory-item">
                    <div class="accessory-item__image-container">
                        <img src="<?= $computerAcc['image'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $computerAcc['name'] ?>" class="accessory-item__image" />
                    </div>

                    <p class="accessory-item__name"><?= $computerAcc['name'] ?? 'Camera giám sát IP 3MP 365 Selection C1' ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>