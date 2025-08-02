<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<?php
echo '<pre>';
print_r($product);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?= htmlspecialchars($product['product_name'] ?? '') ?></title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="product-detail">
            <div class="product-detail__container">
                <!-- Admin Form Section -->
                <div class="product-detail__admin-panel" id="adminForm" style="display: none;">
                    <form class="product-detail__admin-form" id="productForm">
                        <!-- Basic Info Section -->
                        <section class="product-detail__admin-section">
                            <h2 class="product-detail__admin-section-title">
                                <i class="fas fa-info-circle"></i> Thông tin cơ bản
                            </h2>
                            <div class="product-detail__form-group">
                                <label class="product-detail__label" for="productName">Tên sản phẩm</label>
                                <input class="product-detail__input" type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" placeholder="Nhập tên sản phẩm">
                            </div>
                            <div class="product-detail__form-group">
                                <label class="product-detail__label" for="productDescription">Mô tả sản phẩm (HTML)</label>
                                <textarea class="product-detail__textarea" id="productDescription" name="productDescription" rows="4" placeholder="Nhập mô tả sản phẩm"><?= htmlspecialchars($product['description_html'] ?? '') ?></textarea>
                            </div>
                            <div class="product-detail__form-row">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label" for="category">Danh mục</label>
                                    <select class="product-detail__select" id="category" name="category">
                                        <option value="1" <?= ($product['category_id'] ?? 0) == 1 ? 'selected' : '' ?>>Điện thoại</option>
                                        <option value="2" <?= ($product['category_id'] ?? 0) == 2 ? 'selected' : '' ?>>Máy tính bảng</option>
                                        <option value="3" <?= ($product['category_id'] ?? 0) == 3 ? 'selected' : '' ?>>Laptop</option>
                                    </select>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label" for="productId">ID sản phẩm</label>
                                    <input class="product-detail__input" type="number" id="productId" name="productId" value="<?= $product['product_id'] ?? '' ?>" readonly>
                                </div>
                            </div>
                        </section>

                        <!-- Main Image Section -->
                        <section class="product-detail__admin-section">
                            <h2 class="product-detail__admin-section-title">
                                <i class="fas fa-image"></i> Ảnh chính sản phẩm
                            </h2>
                            <div class="product-detail__image-upload">
                                <div class="product-detail__image-preview">
                                    <img src="<?= htmlspecialchars($product['variants'][0]['main_media']['url'] ?? '') ?>" alt="<?= htmlspecialchars($product['variants'][0]['main_media']['alt_text'] ?? '') ?>" class="product-detail__preview-img">
                                    <div class="product-detail__image-overlay">
                                        <button type="button" class="product-detail__btn product-detail__btn--icon edit-image">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="product-detail__upload-controls">
                                    <input type="file" id="mainImage" name="mainImage" accept="image/*" class="product-detail__file-input">
                                    <label for="mainImage" class="product-detail__btn product-detail__btn--outline">
                                        <i class="fas fa-upload"></i> Chọn ảnh mới
                                    </label>
                                    <p class="product-detail__upload-hint">JPG, PNG tối đa 5MB</p>
                                </div>
                            </div>
                        </section>

                        <!-- Variants Section -->
                        <section class="product-detail__admin-section">
                            <h2 class="product-detail__admin-section-title">
                                <i class="fas fa-layer-group"></i> Biến thể sản phẩm
                            </h2>
                            <div class="product-detail__variants-manager">
                                <?php foreach ($product['variants'] as $index => $variant): ?>
                                    <div class="product-detail__variant-item" data-variant-id="<?= $variant['id'] ?>">
                                        <h3 class="product-detail__variant-title">
                                            Biến thể <?= htmlspecialchars($variant['capacity_group'] ?? 'Chưa có dung lượng') ?>
                                        </h3>
                                        <div class="product-detail__form-row">
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">ID Biến thể</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['id'] ?? '' ?>" readonly>
                                            </div>
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Dung lượng</label>
                                                <input type="text" class="product-detail__input" value="<?= htmlspecialchars($variant['capacity_group'] ?? '') ?>" data-field="capacity">
                                            </div>
                                        </div>
                                        <div class="product-detail__form-row">
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Giá bán (VNĐ)</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['price'] ?? 0 ?>" data-field="price">
                                            </div>
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Giá gốc (VNĐ)</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['original_price'] ?? 0 ?>" data-field="original_price">
                                            </div>
                                        </div>
                                        <div class="product-detail__form-group">
                                            <label class="product-detail__label">Số lượng tồn kho</label>
                                            <input type="number" class="product-detail__input" value="<?= $variant['stock_quantity'] ?? 0 ?>" data-field="stock">
                                        </div>
                                        <!-- Colors for this variant -->
                                        <div class="product-detail__colors-manager" data-variant-id="<?= $variant['id'] ?>">
                                            <?php foreach ($variant['colors'] as $color): ?>
                                                <?php if ($color['is_active'] == 1): ?>
                                                    <div class="product-detail__color-item" data-color-id="<?= $color['color_id'] ?>">
                                                        <div class="product-detail__color-info">
                                                            <input type="number" class="product-detail__input product-detail__input--small" value="<?= $color['color_id'] ?? '' ?>" readonly>
                                                            <input type="text" class="product-detail__input product-detail__input--small" value="<?= htmlspecialchars($color['color_name'] ?? '') ?>" data-field="color_name">
                                                            <input type="color" class="product-detail__color-picker" value="<?= htmlspecialchars($color['hex_code'] ?? '#000000') ?>" data-field="hex_code">
                                                            <input type="number" class="product-detail__input product-detail__input--small" value="<?= $color['stock_quantity'] ?? 0 ?>" data-field="color_stock">
                                                            <input type="hidden" value="<?= $color['color_id'] ?? '' ?>" data-field="color_id">
                                                            <input type="checkbox" class="product-detail__input" id="isActive_<?= $variant['id'] ?>_<?= $color['color_id'] ?>" name="isActive_<?= $variant['id'] ?>_<?= $color['color_id'] ?>" <?= $color['is_active'] ? 'checked' : '' ?> data-field="is_active">
                                                            <label for="isActive_<?= $variant['id'] ?>_<?= $color['color_id'] ?>">Kích hoạt</label>
                                                        </div>
                                                        <div class="product-detail__color-gallery">
                                                            <?php
                                                            usort($color['images'], fn($a, $b) => $a['sort_order'] <=> $b['sort_order']);
                                                            foreach ($color['images'] as $image):
                                                            ?>
                                                                <div class="product-detail__gallery-item">
                                                                    <div>
                                                                        <img src="<?= htmlspecialchars($image['gallery_image_url'] ?? '') ?>" alt="<?= htmlspecialchars($image['gallery_image_alt'] ?? '') ?>" class="product-detail__color-img">
                                                                        <p><?= htmlspecialchars($image['gallery_image_alt'] ?? '') ?></p>
                                                                    </div>
                                                                    <button type="button" class="product-detail__btn product-detail__btn--icon remove-image">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="product-detail__btn product-detail__btn--outline add-image">
                                                                <i class="fas fa-plus"></i> Thêm ảnh
                                                            </button>
                                                            <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-color" <?= count(array_filter($variant['colors'], fn($c) => $c['is_active'] == 1)) === 1 ? 'disabled' : '' ?>>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant-id="<?= $variant['id'] ?>">
                                                <i class="fas fa-plus"></i> Thêm màu sắc
                                            </button>
                                        </div>
                                        <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-variant" <?= $index === 0 ? 'disabled' : '' ?>>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                                <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                                    <i class="fas fa-plus"></i> Thêm biến thể
                                </button>
                            </div>
                        </section>
                    </form>
                </div>

                <!-- Preview Section -->
                <div class="product-detail__preview-panel" id="previewPanel">
                    <div class="product-detail__preview-header">
                        <h2 class="product-detail__preview-title">
                            <i class="fas fa-eye"></i> Xem trước giao diện
                        </h2>
                        <div class="product-detail__admin-actions">
                            <button class="product-detail__btn product-detail__btn--secondary" id="editToggle">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </button>
                            <button class="product-detail__btn product-detail__btn--primary" id="saveProduct" disabled>
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </div>
                    <div class="product-detail__preview-content">
                        <div class="product-detail__product-view">
                            <div class="product-detail__product-header">
                                <h1 class="product-detail__product-title" id="previewProductName"><?= htmlspecialchars($product['product_name'] ?? '') ?></h1>
                                <div class="product-detail__product-rating">
                                    <div class="product-detail__stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="product-detail__rating-text">4.8</span>
                                    <span class="product-detail__review-count">125</span>
                                    <span class="product-detail__sold-count">Đã bán 2k</span>
                                </div>
                            </div>
                            <div class="product-detail__product-content">
                                <div class="product-detail__product-image">
                                    <?php
                                    // Get first active color's first image
                                    $firstVariant = $product['variants'][0] ?? null;
                                    $firstActiveColor = $firstVariant && !empty($firstVariant['colors'])
                                        ? array_filter($firstVariant['colors'], fn($c) => $c['is_active'] == 1)[array_key_first(array_filter($firstVariant['colors'], fn($c) => $c['is_active'] == 1))] ?? $firstVariant['colors'][0]
                                        : null;
                                    $firstImage = $firstActiveColor && !empty($firstActiveColor['images'])
                                        ? (usort($firstActiveColor['images'], fn($a, $b) => $a['sort_order'] <=> $b['sort_order']) ? $firstActiveColor['images'][0] : $firstActiveColor['images'][0])
                                        : ($firstVariant['main_media'] ?? ['url' => '', 'alt_text' => '']);
                                    ?>
                                    <div class="product-detail__box-preview" id="box-preview">
                                        <img src="<?= htmlspecialchars($firstImage['gallery_image_url'] ?? $firstImage['url'] ?? '') ?>" alt="<?= htmlspecialchars($firstImage['gallery_image_alt'] ?? $firstImage['alt_text'] ?? '') ?>" class="product-detail__main-img" id="previewMainImage">
                                    </div>
                                    <div class="product-detail__image-thumbnails" id="previewThumbnails">
                                        <?php if ($firstActiveColor && !empty($firstActiveColor['images'])): ?>
                                            <?php foreach ($firstActiveColor['images'] as $image): ?>
                                                <img src="<?= htmlspecialchars($image['gallery_image_url'] ?? '') ?>" alt="<?= htmlspecialchars($image['gallery_image_alt'] ?? '') ?>" class="product-detail__thumbnail" data-src="<?= htmlspecialchars($image['gallery_image_url'] ?? '') ?>">
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-detail__product-info">
                                    <div class="product-detail__variant-selectors">
                                        <div class="product-detail__variant-selector">
                                            <?php
$hasCapacityGroup = false;
foreach ($product['variants'] as $variant) {
    if (!empty($variant['capacity_group'])) {
        $hasCapacityGroup = true;
        break;
    }
}

if ($hasCapacityGroup):
?>
    <label class="product-detail__variant-label">Dung lượng</label>
    <div class="product-detail__size-options" id="previewSizeOptions">
        <?php
        $seenCapacities = [];
        foreach ($product['variants'] as $variant):
            if (!in_array($variant['capacity_group'], $seenCapacities)):
                $seenCapacities[] = $variant['capacity_group'];
        ?>
            <button class="product-detail__size-option"
                    data-variant-id="<?= $variant['id'] ?>"
                    data-price="<?= $variant['price'] ?>"
                    data-original="<?= $variant['original_price'] ?>"
                    data-capacity="<?= htmlspecialchars($variant['capacity_group'] ?? '') ?>">
                <?= htmlspecialchars($variant['capacity_group'] ?? 'Chưa có dung lượng') ?>
            </button>
        <?php endif; endforeach; ?>
    </div>
<?php endif; ?>

                                        </div>
                                        <div class="product-detail__variant-selector">
                                            <label class="product-detail__variant-label">Màu sắc</label>
                                            <div class="product-detail__color-options" id="previewColorOptions">
                                                <?php foreach ($product['variants'][0]['colors'] as $color): ?>
                                                    <?php if ($color['is_active'] == 1): ?>
                                                        <button class="product-detail__color-option" data-color-id="<?= $color['color_id'] ?>" data-color="<?= htmlspecialchars($color['color_name'] ?? '') ?>" style="background-color: <?= htmlspecialchars($color['hex_code'] ?? '#000000') ?>">
                                                            <?= htmlspecialchars($color['color_name'] ?? '') ?>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-detail__price-section">
                                        <div class="product-detail__current-price" id="previewCurrentPrice"><?= number_format($product['variants'][0]['price'] ?? 0, 0, ',', '.') ?> đ</div>
                                        <div class="product-detail__original-price" id="previewOriginalPrice"><?= number_format($product['variants'][0]['original_price'] ?? 0, 0, ',', '.') ?> đ</div>
                                        <div class="product-detail__discount" id="previewDiscount">
                                            <?php
                                            $price = $product['variants'][0]['price'] ?? 0;
                                            $original = $product['variants'][0]['original_price'] ?? 0;
                                            echo $original > $price ? 'Giảm ' . round((($original - $price) / $original) * 100) . '%' : '';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product-detail__description" id="previewDescription">
                                        <?= htmlspecialchars($product['description_html'] ?? '') ?>
                                    </div>
                                    <div class="product-detail__features">
                                        <h3 class="product-detail__features-title">Chính sách sản phẩm</h3>
                                        <div class="product-detail__feature-list">
                                            <div class="product-detail__feature">
                                                <i class="fas fa-shipping-fast product-detail__feature-icon"></i>
                                                <span>Hàng chính hãng - Bảo hành 36 tháng</span>
                                            </div>
                                            <div class="product-detail__feature">
                                                <i class="fas fa-truck product-detail__feature-icon"></i>
                                                <span>Miễn phí vận chuyển - Giao hàng 30 phút</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-detail__specs">
                                        <h3 class="product-detail__specs-title">Thông số kỹ thuật</h3>
                                        <div class="product-detail__specs-grid">
                                            <div class="product-detail__spec">
                                                <i class="fas fa-microchip product-detail__spec-icon"></i>
                                                <div class="product-detail__spec-content">
                                                    <span class="product-detail__spec-label">Chip xử lý</span>
                                                    <span class="product-detail__spec-value">A17 Pro</span>
                                                </div>
                                            </div>
                                            <div class="product-detail__spec">
                                                <i class="fas fa-mobile-alt product-detail__spec-icon"></i>
                                                <div class="product-detail__spec-content">
                                                    <span class="product-detail__spec-label">Kích thước màn hình</span>
                                                    <span class="product-detail__spec-value">6.7 inch</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const $getId = document.getElementById.bind(document);
            const editToggle = $getId('editToggle');
            const saveProduct = $getId('saveProduct');
            const adminForm = $getId('adminForm');
            const previewPanel = $getId('previewPanel');
            const productForm = $getId('productForm');
            const previewProductName = $getId('previewProductName');
            const previewDescription = $getId('previewDescription');
            const previewMainImage = $getId('previewMainImage');
            const previewThumbnails = $getId('previewThumbnails');
            const previewColorOptions = $getId('previewColorOptions');
            const previewSizeOptions = $getId('previewSizeOptions');
            const previewCurrentPrice = $getId('previewCurrentPrice');
            const previewOriginalPrice = $getId('previewOriginalPrice');
            const previewDiscount = $getId('previewDiscount');

            let productData = <?= json_encode($product, JSON_UNESCAPED_SLASHES) ?>;
            let currentVariant = productData.variants[0];
            let currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];

            // Toggle Edit Form
            editToggle.addEventListener('click', () => {
                const isHidden = adminForm.style.display === 'none';
                adminForm.style.display = isHidden ? 'block' : 'none';
                previewPanel.classList.toggle('product-detail__preview-panel--small', isHidden);
                editToggle.innerHTML = isHidden ? '<i class="fas fa-eye"></i> Ẩn form' : '<i class="fas fa-edit"></i> Chỉnh sửa';
                saveProduct.disabled = !isHidden;
            });

            // Real-time Preview Updates
            productForm.addEventListener('input', (e) => {
                const target = e.target;
                if (target.name === 'productName') {
                    previewProductName.textContent = target.value;
                    productData.product_name = target.value;
                }
                if (target.name === 'productDescription') {
                    if(pre)
                    previewDescription.innerHTML = target.value;
                    productData.description_html = target.value;
                }
                if (target.dataset.field === 'capacity') {
                    const variantItem = target.closest('.product-detail__variant-item');
                    const variantId = parseInt(variantItem.dataset.variantId);
                    const variant = productData.variants.find(v => v.id === variantId);
                    if (variant) variant.capacity_group = target.value;
                    updatePreviewVariants();
                }
                if (target.dataset.field === 'price' || target.dataset.field === 'original_price' || target.dataset.field === 'stock') {
                    const variantItem = target.closest('.product-detail__variant-item');
                    const variantId = parseInt(variantItem.dataset.variantId);
                    const variant = productData.variants.find(v => v.id === variantId);
                    if (variant) {
                        variant[target.dataset.field] = parseFloat(target.value) || 0;
                        if (variant.id === currentVariant.id) {
                            updatePreview({ target: previewSizeOptions.querySelector(`[data-variant-id="${variantId}"]`) });
                        }
                    }
                }
                if (target.dataset.field === 'color_name' || target.dataset.field === 'hex_code' || target.dataset.field === 'color_stock' || target.dataset.field === 'is_active') {
                    const colorItem = target.closest('.product-detail__color-item');
                    const variantItem = colorItem.closest('.product-detail__variant-item');
                    const variantId = parseInt(variantItem.dataset.variantId);
                    const colorId = parseInt(colorItem.dataset.colorId);
                    const variant = productData.variants.find(v => v.id === variantId);
                    const color = variant.colors.find(c => c.color_id === colorId);
                    if (color) {
                        if (target.dataset.field === 'is_active') {
                            color.is_active = target.checked ? 1 : 0;
                            if (!color.is_active && color.color_id === currentColor.color_id) {
                                currentColor = variant.colors.find(c => c.is_active == 1) || variant.colors[0];
                            }
                        } else {
                            color[target.dataset.field] = target.dataset.field === 'color_stock' ? parseInt(target.value) || 0 : target.value;
                        }
                        if (variant.id === currentVariant.id) {
                            updatePreviewColors();
                        }
                    }
                }
            });

            // Image Upload Handler
            document.querySelectorAll('.product-detail__file-input').forEach(input => {
                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const preview = input.closest('.product-detail__image-upload').querySelector('.product-detail__preview-img');
                            if (preview) preview.src = e.target.result;
                            if (input.id === 'mainImage') {
                                previewMainImage.src = e.target.result;
                                currentVariant.main_media.url = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            // Update Preview
            function updatePreview(e) {
                if (e.target.classList.contains('product-detail__size-option')) {
                    const variantId = parseInt(e.target.dataset.variantId);
                    currentVariant = productData.variants.find(v => v.id === variantId) || currentVariant;
                    currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];
                    previewSizeOptions.querySelectorAll('.product-detail__size-option').forEach(btn => btn.classList.remove('product-detail__size-option--active'));
                    e.target.classList.add('product-detail__size-option--active');
                    previewCurrentPrice.textContent = `${Number(currentVariant.price).toLocaleString('vi-VN')} đ`;
                    previewOriginalPrice.textContent = `${Number(currentVariant.original_price).toLocaleString('vi-VN')} đ`;
                    previewDiscount.textContent = currentVariant.original_price > currentVariant.price
                        ? `Giảm ${Math.round(((currentVariant.original_price - currentVariant.price) / currentVariant.original_price) * 100)}%`
                        : '';
                    updatePreviewColors();
                }
                if (e.target.classList.contains('product-detail__color-option')) {
                    const colorId = parseInt(e.target.dataset.colorId);
                    currentColor = currentVariant.colors.find(c => c.color_id === colorId) || currentColor;
                    previewColorOptions.querySelectorAll('.product-detail__color-option').forEach(btn => btn.classList.remove('product-detail__color-option--active'));
                    e.target.classList.add('product-detail__color-option--active');
                    updatePreviewImages();
                }
            }

            function updatePreviewColors() {
                previewColorOptions.innerHTML = '';
                currentVariant.colors.filter(c => c.is_active == 1).forEach(color => {
                    const button = document.createElement('button');
                    button.className = 'product-detail__color-option';
                    button.textContent = color.color_name || 'Chưa đặt tên';
                    button.dataset.colorId = color.color_id;
                    button.dataset.color = color.color_name;
                    button.style.backgroundColor = color.hex_code;
                    button.addEventListener('click', updatePreview);
                    previewColorOptions.appendChild(button);
                    if (color.color_id === currentColor.color_id) {
                        button.classList.add('product-detail__color-option--active');
                    }
                });
                updatePreviewImages();
            }

            function updatePreviewImages() {
                if (currentColor && currentColor.images && currentColor.images.length > 0) {
                    currentColor.images.sort((a, b) => a.sort_order - b.sort_order);
                    previewMainImage.src = currentColor.images[0].gallery_image_url || currentVariant.main_media.url;
                    previewMainImage.alt = currentColor.images[0].gallery_image_alt || currentVariant.main_media.alt_text;
                    previewThumbnails.innerHTML = '';
                    currentColor.images.forEach(image => {
                        const thumb = document.createElement('img');
                        thumb.src = image.gallery_image_url;
                        thumb.alt = image.gallery_image_alt;
                        thumb.className = 'product-detail__thumbnail';
                        thumb.dataset.src = image.gallery_image_url;
                        thumb.addEventListener('click', () => {
                            previewMainImage.src = image.gallery_image_url;
                            previewMainImage.alt = image.gallery_image_alt;
                            previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(t => t.classList.remove('product-detail__thumbnail--active'));
                            thumb.classList.add('product-detail__thumbnail--active');
                        });
                        previewThumbnails.appendChild(thumb);
                        if (image.gallery_image_url === previewMainImage.src) {
                            thumb.classList.add('product-detail__thumbnail--active');
                        }
                    });
                } else {
                    previewMainImage.src = currentVariant.main_media.url || '';
                    previewMainImage.alt = currentVariant.main_media.alt_text || '';
                    previewThumbnails.innerHTML = '';
                }
            }

            function updatePreviewVariants() {
                if(!previewSizeOptions) return;
                previewSizeOptions.innerHTML = '';
                const seenCapacities = new Set();
                productData.variants.forEach(variant => {
                    const capacity = variant.capacity_group || 'Chưa có dung lượng';
                    if (!seenCapacities.has(capacity)) {
                        seenCapacities.add(capacity);
                        const button = document.createElement('button');
                        button.className = 'product-detail__size-option';
                        button.textContent = capacity;
                        button.dataset.variantId = variant.id;
                        button.dataset.price = variant.price;
                        button.dataset.original = variant.original_price;
                        button.dataset.capacity = capacity;
                        button.addEventListener('click', updatePreview);
                        previewSizeOptions.appendChild(button);
                        if (variant.id === currentVariant.id) {
                            button.classList.add('product-detail__size-option--active');
                        }
                    }
                });
            }

            // Initialize preview
            updatePreviewVariants();
            updatePreviewColors();
            updatePreviewImages();

            // Initialize event listeners for thumbnails
            previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(thumb => {
                thumb.addEventListener('click', () => {
                    previewMainImage.src = thumb.dataset.src;
                    previewMainImage.alt = thumb.alt;
                    previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(t => t.classList.remove('product-detail__thumbnail--active'));
                    thumb.classList.add('product-detail__thumbnail--active');
                });
            });
        });
    </script>
</body>
</html>