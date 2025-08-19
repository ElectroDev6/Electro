<?php
$brands = $brands ?? [];
$selectedBrands = $selectedBrands ?? [];
$availableAttributes = $availableAttributes ?? [];
$selectedAttributes = $selectedAttributes ?? [];
error_log("Filter: Brands received: " . json_encode($brands));
?>
<aside class="filter">
    <h3 class="filter__heading">🔍 Bộ lọc tìm kiếm</h3>

    <form method="GET" action="/products/<?= htmlspecialchars($categorySlug ?? 'phone') ?>/<?= $subcategorySlug ? htmlspecialchars($subcategorySlug) : '' ?>" id="mainFilter">
        <div class="filter-group">
            <h4 class="filter-group__heading">📱 Thương hiệu</h4>
            <?php foreach ($brands as $brand): ?>
                <label class="filter-group__label">
                    <input type="checkbox" name="brand[]" value="<?= htmlspecialchars($brand['name']) ?>" <?= in_array($brand['name'], $selectedBrands) ? 'checked' : '' ?> class="filter-group__checkbox">
                    <?= htmlspecialchars($brand['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">💰 Mức giá</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="all" class="filter-group__checkbox" <?= in_array('all', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Tất cả
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="30-40" class="filter-group__checkbox" <?= in_array('30-40', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Từ 30 - 40 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="25-30" class="filter-group__checkbox" <?= in_array('25-30', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Từ 25 - 30 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="20-25" class="filter-group__checkbox" <?= in_array('20-25', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Từ 20 - 25 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="15-20" class="filter-group__checkbox" <?= in_array('15-20', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Từ 15 - 20 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="duoi15" class="filter-group__checkbox" <?= in_array('duoi15', $_GET['price'] ?? []) ? 'checked' : '' ?>>
                Dưới 15 triệu
            </label>
        </div>

        <!-- Dynamic attribute filters -->
        <?php foreach ($availableAttributes as $attr): ?>
            <div class="filter-group">
                <h4 class="filter-group__heading"><?= htmlspecialchars($attr['name']) ?></h4>
                <?php foreach ($attr['options'] as $option): ?>
                    <label class="filter-group__label">
                        <input type="checkbox" name="attr_<?= $attr['attribute_id'] ?>[]" value="<?= htmlspecialchars($option['value']) ?>" <?= isset($selectedAttributes[$attr['attribute_id']]) && in_array($option['value'], $selectedAttributes[$attr['attribute_id']]) ? 'checked' : '' ?> class="filter-group__checkbox">
                        <?= htmlspecialchars($option['value']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </form>
</aside>