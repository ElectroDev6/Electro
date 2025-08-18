<?php
$brands = $brands ?? [];
$selectedBrands = $selectedBrands ?? [];
error_log("FilterPhone: Brands received: " . json_encode($brands));
?>
<aside class="filter">
    <h3 class="filter__heading">🔍 Bộ lọc tìm kiếm</h3>

    <form method="GET" action="/products/<?php echo htmlspecialchars($categorySlug ?? 'phone'); ?>" id="mainFilter">
        <div class="filter-group">
            <h4 class="filter-group__heading">📱 Thương hiệu</h4>
            <?php foreach ($brands as $brand): ?>
                <label class="filter-group__label">
                    <input type="checkbox" name="brand[]" value="<?php echo htmlspecialchars($brand['name']); ?>" <?php echo in_array($brand['name'], $selectedBrands) ? 'checked' : ''; ?> class="filter-group__checkbox">
                    <?php echo htmlspecialchars($brand['name']); ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">💰 Mức giá</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="all" class="filter-group__checkbox" <?php echo in_array('all', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Tất cả
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="30-40" class="filter-group__checkbox" <?php echo in_array('30-40', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Từ 30 - 40 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="25-30" class="filter-group__checkbox" <?php echo in_array('25-30', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Từ 25 - 30 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="20-25" class="filter-group__checkbox" <?php echo in_array('20-25', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Từ 20 - 25 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="15-20" class="filter-group__checkbox" <?php echo in_array('15-20', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Từ 15 - 20 triệu
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="price[]" value="duoi15" class="filter-group__checkbox" <?php echo in_array('duoi15', $_GET['price'] ?? []) ? 'checked' : ''; ?>>
                Dưới 15 triệu
            </label>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">💾 Dung lượng</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="storage[]" value="128GB" class="filter-group__checkbox" <?php echo in_array('128GB', $_GET['storage'] ?? []) ? 'checked' : ''; ?>>
                128GB
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="storage[]" value="256GB" class="filter-group__checkbox" <?php echo in_array('256GB', $_GET['storage'] ?? []) ? 'checked' : ''; ?>>
                256GB
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="storage[]" value="512GB" class="filter-group__checkbox" <?php echo in_array('512GB', $_GET['storage'] ?? []) ? 'checked' : ''; ?>>
                512GB
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="storage[]" value="1TB" class="filter-group__checkbox" <?php echo in_array('1TB', $_GET['storage'] ?? []) ? 'checked' : ''; ?>>
                1TB
            </label>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">🎨 Màu sắc</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="color[]" value="black" class="filter-group__checkbox" <?php echo in_array('black', $_GET['color'] ?? []) ? 'checked' : ''; ?>>
                Đen
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="color[]" value="white" class="filter-group__checkbox" <?php echo in_array('white', $_GET['color'] ?? []) ? 'checked' : ''; ?>>
                Trắng
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="color[]" value="blue" class="filter-group__checkbox" <?php echo in_array('blue', $_GET['color'] ?? []) ? 'checked' : ''; ?>>
                Xanh dương
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="color[]" value="purple" class="filter-group__checkbox" <?php echo in_array('purple', $_GET['color'] ?? []) ? 'checked' : ''; ?>>
                Tím
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="color[]" value="gold" class="filter-group__checkbox" <?php echo in_array('gold', $_GET['color'] ?? []) ? 'checked' : ''; ?>>
                Vàng
            </label>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">📱 Kích thước màn hình</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="screen[]" value="5.4" class="filter-group__checkbox" <?php echo in_array('5.4', $_GET['screen'] ?? []) ? 'checked' : ''; ?>>
                5.4 inch (Mini)
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="screen[]" value="6.1" class="filter-group__checkbox" <?php echo in_array('6.1', $_GET['screen'] ?? []) ? 'checked' : ''; ?>>
                6.1 inch (Standard)
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="screen[]" value="6.7" class="filter-group__checkbox" <?php echo in_array('6.7', $_GET['screen'] ?? []) ? 'checked' : ''; ?>>
                6.7 inch (Plus/Pro Max)
            </label>
        </div>

        <div class="filter-group">
            <h4 class="filter-group__heading">⚡ Tần số quét</h4>
            <label class="filter-group__label">
                <input type="checkbox" name="hz[]" value="60" class="filter-group__checkbox" <?php echo in_array('60', $_GET['hz'] ?? []) ? 'checked' : ''; ?>>
                60Hz
            </label>
            <label class="filter-group__label">
                <input type="checkbox" name="hz[]" value="120" class="filter-group__checkbox" <?php echo in_array('120', $_GET['hz'] ?? []) ? 'checked' : ''; ?>>
                120Hz
            </label>
        </div>
    </form>
</aside>