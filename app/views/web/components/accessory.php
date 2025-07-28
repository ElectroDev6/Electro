<?php
$product = $accessory ?? [];
?>

<?php if (!empty($product)): ?>
    <div class="accessory-item">
        <div class="accessory-item__image-container">
            <img src="<?= $accessory['image'] ?? '/img/No-Image-Placeholder.png' ?>" alt="<?= $accessory['name'] ?>" class="accessory-item__image" />
        </div>

        <p class="accessory-item__name"><?= $accessory['name'] ?? 'Camera giám sát IP 3MP 365 Selection C1' ?></p>
    </div>
<?php else: ?>
    <p>Không có dữ liệu phụ kiện.</p>
<?php endif; ?>