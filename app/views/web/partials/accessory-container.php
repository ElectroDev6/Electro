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
                <?php View::partial('components.accessory', ['accessory' => $accessory]); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="accessory">
        <div class="accessory__header">
            <h2 class="accessory__title">Linh kiện máy tính</h2>
        </div>

        <div class="accessory__list">
            <?php foreach ($accessories as $accessory): ?>
                <?php View::partial('components.accessory', ['accessory' => $accessory]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>