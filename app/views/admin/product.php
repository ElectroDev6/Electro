<?php
// PHP data remains unchanged
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/header.php';
$id = $_GET['id'] ?? null;
$product = $productDetail
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?= htmlspecialchars($product['product_name']) ?></title>
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
                                <input class="product-detail__input" type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['product_name']) ?>" placeholder="Nhập tên sản phẩm">
                            </div>
                            <div class="product-detail__form-group">
                                <label class="product-detail__label" for="productDescription">Mô tả sản phẩm (HTML)</label>
                                <textarea class="product-detail__textarea" id="productDescription" name="productDescription" rows="4" placeholder="Nhập mô tả sản phẩm"><?= htmlspecialchars($product['description_html']) ?></textarea>
                            </div>
                            <div class="product-detail__form-row">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label" for="category">Danh mục</label>
                                    <select class="product-detail__select" id="category" name="category">
                                        <option value="1" <?= $product['category']['id'] == 1 ? 'selected' : '' ?>>Điện thoại</option>
                                        <option value="2">Máy tính bảng</option>
                                        <option value="3">Laptop</option>
                                    </select>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label" for="productId">ID sản phẩm</label>
                                    <input class="product-detail__input" type="number" id="productId" name="productId" value="<?= $product['product_id'] ?>" readonly>
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
                                    <img src="<?= htmlspecialchars($product['variants'][0]['main_media']['url']) ?>" alt="<?= htmlspecialchars($product['variants'][0]['main_media']['alt_text']) ?>" class="product-detail__preview-img">
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
                                            Biến thể <?= !empty($variant['capacity_group']) ? htmlspecialchars($variant['capacity_group']) : '' ?>
                                        </h3>
                                        <div class="product-detail__form-row">
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">ID Biến thể</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['id'] ?>" readonly>
                                            </div>
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Dung lượng</label>
                                                    <input type="text" class="product-detail__input <?= empty($variant['capacity_group']) ? 'product-detaildisabled-input' : '' ?>" value="<?= !empty($variant['capacity_group']) ? htmlspecialchars($variant['capacity_group']) : 'Chưa có dung lượng' ?>" data-field="capacity">
                                            </div>
                                        </div>
                                        <div class="product-detail__form-row">
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Giá bán (VNĐ)</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['price'] ?>" data-field="price">
                                            </div>
                                            <div class="product-detail__form-group">
                                                <label class="product-detail__label">Giá gốc (VNĐ)</label>
                                                <input type="number" class="product-detail__input" value="<?= $variant['original_price'] ?>" data-field="original_price">
                                            </div>
                                        </div>
                                        <div class="product-detail__form-group">
                                            <label class="product-detail__label">Số lượng tồn kho</label>
                                            <input type="number" class="product-detail__input" value="<?= $variant['stock_quantity'] ?>" data-field="stock">
                                        </div>
                                        <!-- Colors for this variant -->
                                        <div class="product-detail__colors-manager" data-variant-id="<?= $variant['id'] ?>">
                                            <?php foreach ($variant['colors'] as $color): ?>
                                                <?php if ($color['is_active'] == 1): ?>
                                                    <div class="product-detail__color-item" data-color-id="<?= $color['id'] ?>">
                                                        <div class="product-detail__color-info">
                                                            <input type="number" class="product-detail__input product-detail__input--small" value="<?= $color['id'] ?>" readonly>
                                                            <input type="text" class="product-detail__input product-detail__input--small" value="<?= htmlspecialchars($color['name']) ?>" data-field="color_name">
                                                            <input type="color" class="product-detail__color-picker" value="<?= htmlspecialchars($color['hex_code']) ?>" data-field="hex_code">
                                                            <input type="number" class="product-detail__input product-detail__input--small" value="<?= $color['stock'] ?>" data-field="color_stock">
                                                            <input type="hidden" value="<?= $color['color_id'] ?>" data-field="color_id">
                                                            <input type="checkbox" class="product-detail__input" id="isActive_<?= $variant['id'] ?>_<?= $color['id'] ?>" name="isActive_<?= $variant['id'] ?>_<?= $color['id'] ?>" <?= $color['is_active'] ? 'checked' : '' ?> data-field="is_active">
                                                            <label for="isActive_<?= $variant['id'] ?>_<?= $color['id'] ?>">Kích hoạt</label>
                                                        </div>
                                                        <div class="product-detail__color-gallery">
                                                            <?php
                                                            // Sort gallery images by sort_order
                                                            usort($color['gallery_images'], function ($a, $b) {
                                                                return $a['sort_order'] <=> $b['sort_order'];
                                                            });
                                                            foreach ($color['gallery_images'] as $image):
                                                            ?>
                                                                <div class="product-detail__gallery-item">
                                                                    <div>
                                                                        <img src="<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($image['alt_text']) ?>" class="product-detail__color-img">
                                                                        <p><?= htmlspecialchars($image['alt_text']) ?></p>
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
                                <h1 class="product-detail__product-title" id="previewProductName"><?= htmlspecialchars($product['product_name']) ?></h1>
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
                                    $firstActiveColor = array_filter($product['variants'][0]['colors'], fn($c) => $c['is_active'] == 1)[array_key_first(array_filter($product['variants'][0]['colors'], fn($c) => $c['is_active'] == 1))];
                                    usort($firstActiveColor['gallery_images'], fn($a, $b) => $a['sort_order'] <=> $b['sort_order']);
                                    $firstImage = $firstActiveColor['gallery_images'][0];
                                    ?>
                                    <div class="product-detail__box-preview" id="box-preview"> 
                                        <img src="<?= htmlspecialchars($firstImage['url']) ?>" alt="<?= htmlspecialchars($firstImage['alt_text']) ?>" class="product-detail__main-img" id="previewMainImage">
                                    </div>
                                    <div class="product-detail__image-thumbnails" id="previewThumbnails">
                                        <!-- box click  -->
                                        <?php foreach ($firstActiveColor['gallery_images'] as $image): ?>
                                            <img src="<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($image['alt_text']) ?>" class="product-detail__thumbnail" data-src="<?= htmlspecialchars($image['url']) ?>">npm run debug_zval_dump
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="product-detail__product-info">
                                    <div class="product-detail__variant-selectors">
                                        <div class="product-detail__variant-selector product-detail__variant-hasNull">
                                            <?php if(empty($product[0]['variants']['capacity_group'])) : ?>
                                            <label class="product-detail__variant-label">Dung lượng</label>
                                            <div class="product-detail__size-options" id="previewSizeOptions">
                                                <?php foreach ($product['variants'] as $variant): ?>
                                                    <button class="product-detail__size-option" data-variant-id="<?= $variant['id'] ?>" data-price="<?= $variant['price'] ?>" data-original="<?= $variant['original_price'] ?>" data-capacity="<?= htmlspecialchars($variant['capacity_group']) ?>">
                                                        <?= htmlspecialchars($variant['capacity_group']) ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </div>
                                        <div class="product-detail__variant-selector">
                                            <label class="product-detail__variant-label">Màu sắc</label>
                                            <div class="product-detail__color-options" id="previewColorOptions">
                                                <?php foreach ($product['variants'][0]['colors'] as $color): ?>
                                                    <?php if ($color['is_active'] == 1): ?>
                                                        <button class="product-detail__color-option" data-color-id="<?= $color['id'] ?>" data-color="<?= htmlspecialchars($color['name']) ?>" style="background-color: <?= htmlspecialchars($color['hex_code']) ?>">
                                                            <?= htmlspecialchars($color['name']) ?>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-detail__price-section">
                                        <div class="product-detail__current-price" id="previewCurrentPrice"><?= number_format($product['variants'][0]['price'], 0, ',', '.') ?> đ</div>
                                        <div class="product-detail__original-price" id="previewOriginalPrice"><?= number_format($product['variants'][0]['original_price'], 0, ',', '.') ?> đ</div>
                                        <div class="product-detail__discount" id="previewDiscount">Giảm <?= round((($product['variants'][0]['original_price'] - $product['variants'][0]['price']) / $product['variants'][0]['original_price']) * 100) ?>%</div>
                                    </div>
                                    <div class="product-detail__description" id="previewDescription">
                                        <?= $product['description_html'] ?>
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
    const boxPreview = $getId('box-preview'); // Sử dụng id="box-preview" từ HTML
    let previewMainImage = $getId('previewMainImage'); // Lấy từ DOM thay vì tạo mới
    const previewThumbnails = $getId('previewThumbnails');
    const previewColorOptions = $getId('previewColorOptions');
    const previewSizeOptions = $getId('previewSizeOptions');
    const previewCurrentPrice = $getId('previewCurrentPrice');
    const previewOriginalPrice = $getId('previewOriginalPrice');
    const previewDiscount = $getId('previewDiscount');

    // Initialize product data with fallback
    let productData = <?= json_encode($product) ?> || {
        product_name: 'Product Default',
        description_html: '<p>Description Default</p>',
        variants: [{
            id: 1,
            price: 0,
            original_price: 0,
            capacity_group: 'Default',
            stock_quantity: 0,
            main_media: { url: '', alt_text: '' },
            colors: [{ id: 1, name: 'Default', hex_code: '#000000', stock: 0, is_active: 1, gallery_images: [] }]
        }]
    };
    let currentVariant = productData.variants[0];
    let currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];
    let isVideoMode = false;

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
                variant[target.dataset.field] = parseInt(target.value) || 0;
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
            const color = variant.colors.find(c => c.id === colorId);
            if (color) {
                if (target.dataset.field === 'is_active') {
                    color.is_active = target.checked ? 1 : 0;
                    if (!color.is_active && color.id === currentColor.id) {
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
                    const preview = input.closest('.product-detail__image-upload, .product-detail__color-item')
                        .querySelector('.product-detail__preview-img, .product-detail__color-img');
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

    // Variant Management
    document.querySelector('.add-variant').addEventListener('click', () => {
        const newVariant = {
            id: Math.max(...productData.variants.map(v => v.id)) + 1,
            price: 0,
            original_price: 0,
            capacity_group: '',
            stock_quantity: 0,
            main_media: { url: '', alt_text: '' },
            colors: []
        };
        productData.variants.push(newVariant);
        const variantItem = document.querySelector('.product-detail__variant-item').cloneNode(true);
        variantItem.dataset.variantId = newVariant.id;
        variantItem.querySelectorAll('input[data-field]').forEach(input => input.value = '');
        variantItem.querySelector('.product-detail__colors-manager').innerHTML = '<button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant-id="' + newVariant.id + '"><i class="fas fa-plus"></i> Thêm màu sắc</button>';
        variantItem.querySelector('.remove-variant').disabled = false;
        variantItem.querySelector('.product-detail__variant-title').textContent = 'Biến thể mới';
        document.querySelector('.product-detail__variants-manager').insertBefore(variantItem, document.querySelector('.add-variant'));
        initColorManagement(variantItem);
        updatePreviewVariants();
    });

    document.querySelectorAll('.remove-variant').forEach(button => {
        button.addEventListener('click', () => {
            if (document.querySelectorAll('.product-detail__variant-item').length > 1) {
                const variantItem = button.closest('.product-detail__variant-item');
                const variantId = parseInt(variantItem.dataset.variantId);
                productData.variants = productData.variants.filter(v => v.id !== variantId);
                variantItem.remove();
                if (currentVariant.id === variantId) {
                    currentVariant = productData.variants[0];
                    currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];
                }
                updatePreviewVariants();
            }
        });
    });

    // Color Management
    function initColorManagement(variantItem) {
        const variantId = parseInt(variantItem.dataset.variantId);
        variantItem.querySelectorAll('.add-color').forEach(button => {
            button.addEventListener('click', () => {
                const variant = productData.variants.find(v => v.id === variantId);
                const newColor = {
                    id: variant.colors.length ? Math.max(...variant.colors.map(c => c.id)) + 1 : 1,
                    name: '',
                    hex_code: '#000000',
                    stock: 0,
                    color_id: variant.colors.length + 1,
                    is_active: 1,
                    gallery_images: []
                };
                variant.colors.push(newColor);
                const colorItem = document.querySelector('.product-detail__color-item').cloneNode(true);
                colorItem.dataset.colorId = newColor.id;
                colorItem.querySelectorAll('input[data-field]').forEach(input => input.value = '');
                colorItem.querySelector('.product-detail__color-gallery').innerHTML = '';
                colorItem.querySelector('.remove-color').disabled = variant.colors.filter(c => c.is_active == 1).length === 1;
                colorItem.querySelector('.add-image').disabled = false;
                colorItem.querySelector('input[data-field="is_active"]').checked = true;
                variantItem.querySelector('.product-detail__colors-manager').insertBefore(colorItem, button);
                initImageManagement(colorItem);
                updatePreviewColors();
            });
        });

        variantItem.querySelectorAll('.remove-color').forEach(button => {
            button.addEventListener('click', () => {
                const colorItem = button.closest('.product-detail__color-item');
                const colorId = parseInt(colorItem.dataset.colorId);
                const variant = productData.variants.find(v => v.id === variantId);
                if (variant.colors.filter(c => c.is_active == 1).length > 1) {
                    variant.colors = variant.colors.filter(c => c.id !== colorId);
                    colorItem.remove();
                    if (variant.id === currentVariant.id && currentColor.id === colorId) {
                        currentColor = variant.colors.find(c => c.is_active == 1) || variant.colors[0];
                    }
                    updatePreviewColors();
                }
            });
        });
    }

    // Image Management
    function initImageManagement(colorItem) {
        colorItem.querySelectorAll('.add-image').forEach(button => {
            button.addEventListener('click', () => {
                const gallery = button.closest('.product-detail__color-item').querySelector('.product-detail__color-gallery');
                const variantItem = button.closest('.product-detail__variant-item');
                const variantId = parseInt(variantItem.dataset.variantId);
                const colorId = parseInt(button.closest('.product-detail__color-item').dataset.colorId);
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.className = 'product-detail__file-input';
                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const item = document.createElement('div');
                            item.className = 'product-detail__gallery-item';
                            item.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image" class="product-detail__color-img"><button type="button" class="product-detail__btn product-detail__btn--icon remove-image"><i class="fas fa-trash"></i></button>`;
                            gallery.appendChild(item);
                            initRemoveImage(item.querySelector('.remove-image'));
                            const variant = productData.variants.find(v => v.id === variantId);
                            const color = variant.colors.find(c => c.id === colorId);
                            if (color) {
                                color.gallery_images.push({
                                    id: color.gallery_images.length ? Math.max(...color.gallery_images.map(img => img.id)) + 1 : 1,
                                    url: e.target.result,
                                    alt_text: 'Uploaded Image',
                                    sort_order: color.gallery_images.length + 1
                                });
                                updatePreviewColors();
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
                input.click();
            });
        });

        colorItem.querySelectorAll('.remove-image').forEach(initRemoveImage);
    }

    function initRemoveImage(button) {
        button.addEventListener('click', () => {
            const galleryItem = button.closest('.product-detail__gallery-item');
            const colorItem = button.closest('.product-detail__color-item');
            const variantItem = colorItem.closest('.product-detail__variant-item');
            const variantId = parseInt(variantItem.dataset.variantId);
            const colorId = parseInt(colorItem.dataset.colorId);
            const imgSrc = galleryItem.querySelector('img').src;
            const variant = productData.variants.find(v => v.id === variantId);
            const color = variant.colors.find(c => c.id === colorId);
            if (color) {
                color.gallery_images = color.gallery_images.filter(img => img.url !== imgSrc);
                galleryItem.remove();
                if (variant.id === currentVariant.id && color.id === currentColor.id) {
                    updatePreviewColors();
                }
            }
        });
    }

    // Initialize color and image management for existing variants
    document.querySelectorAll('.product-detail__variant-item').forEach(initColorManagement);

    // Preview Variant and Color Updates
    function updatePreviewVariants() {
        previewSizeOptions.innerHTML = '';
        if (productData.variants && productData.variants.length > 0) {
            productData.variants.forEach(variant => {
                const button = document.createElement('button');
                button.className = 'product-detail__size-option';
                button.textContent = variant.capacity_group || 'Chưa biến thể dung lượng';
                button.dataset.variantId = variant.id;
                button.dataset.price = variant.price;
                button.dataset.original = variant.original_price;
                button.dataset.capacity = variant.capacity_group;
                button.addEventListener('click', updatePreview);
                previewSizeOptions.appendChild(button);
                if (variant.id === currentVariant.id) {
                    button.classList.add('product-detail__size-option--active');
                }
            });
            // Trigger initial update
            if (previewSizeOptions.firstChild) {
                previewSizeOptions.firstChild.click();
            }
        }
    }

    function updatePreviewColors() {
        previewColorOptions.innerHTML = '';
        currentVariant.colors.filter(c => c.is_active == 1).forEach(color => {
            const button = document.createElement('button');
            button.className = 'product-detail__color-option';
            button.textContent = color.name || 'Chưa đặt tên';
            button.dataset.colorId = color.id;
            button.dataset.color = color.name;
            button.style.backgroundColor = color.hex_code;
            button.addEventListener('click', updatePreview);
            previewColorOptions.appendChild(button);
            if (color.id === currentColor.id) {
                button.classList.add('product-detail__color-option--active');
            }
        });
        updatePreviewImages();
    }

    function updatePreviewImages() {
        if (currentColor.gallery_images.length > 0) {
            currentColor.gallery_images.sort((a, b) => a.sort_order - b.sort_order);
            if (!isVideoMode) {
                previewMainImage.src = currentColor.gallery_images[0].url || currentVariant.main_media.url || '';
                previewMainImage.alt = currentColor.gallery_images[0].alt_text || currentVariant.main_media.alt_text || '';
            }
            previewThumbnails.innerHTML = '';

            // Add Video Button
            const videoButton = document.createElement('button');
            videoButton.className = 'product-detail__media-button';
            videoButton.innerHTML = `
                <div class="product-detail__media-button__icon">▶️</div>
                <div class="product-detail__media-button__label">Video</div>
            `;
            videoButton.addEventListener('click', () => {
                isVideoMode = true;
                const iframe = document.createElement('iframe');
                iframe.id = 'previewMainImage'; // Reassign ID to iframe
                iframe.width = "100%";
                iframe.height = "440px";
                iframe.src = "https://www.youtube.com/embed/-iAJvsb03lM";
                iframe.title = "Mở hộp iPhone Pro và iPhone 15 Pro Max chính hãng Việt Nam - Màu Titan Tự nhiên quá xịn !!!";
                iframe.frameBorder = "0";
                iframe.allow = "accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
                iframe.referrerPolicy = "strict-origin-when-cross-origin";
                iframe.allowFullscreen = true;
                boxPreview.replaceChild(iframe, previewMainImage); // Replace with iframe
                previewMainImage = iframe; // Update reference
                updatePreviewImages(); // Refresh thumbnails
            });
            previewThumbnails.appendChild(videoButton);

            // Add Thumbnails
            currentColor.gallery_images.forEach(image => {
                const thumb = document.createElement('img');
                thumb.src = image.url;
                thumb.alt = image.alt_text;
                thumb.className = 'product-detail__thumbnail';
                thumb.dataset.src = image.url;
                thumb.addEventListener('click', () => {
                    if (isVideoMode) {
                        isVideoMode = false;
                        const newImage = document.createElement('img');
                        newImage.id = 'previewMainImage';
                        newImage.src = image.url;
                        newImage.alt = image.alt_text;
                        newImage.className = 'product-detail__main-img'; // Sử dụng class từ HTML gốc
                        boxPreview.replaceChild(newImage, previewMainImage);
                        previewMainImage = newImage; // Update reference
                    } else {
                        previewMainImage.src = image.url;
                        previewMainImage.alt = image.alt_text;
                    }
                    previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(t => t.classList.remove('product-detail__thumbnail--active'));
                    thumb.classList.add('product-detail__thumbnail--active');
                });
                previewThumbnails.appendChild(thumb);
                if (image.url === previewMainImage.src && !isVideoMode) {
                    thumb.classList.add('product-detail__thumbnail--active');
                }
            });
        } else {
            if (!isVideoMode) {
                previewMainImage.src = currentVariant.main_media.url || '';
                previewMainImage.alt = currentVariant.main_media.alt_text || '';
            }
            previewThumbnails.innerHTML = '';

            // Add Video Button when no images
            const videoButton = document.createElement('button');
            videoButton.className = 'product-detail__media-button';
            videoButton.innerHTML = `
                <div class="product-detail__media-button__icon">▶️</div>
                <div class="product-detail__media-button__label">Video</div>
            `;
            videoButton.addEventListener('click', () => {
                isVideoMode = true;
                const iframe = document.createElement('iframe');
                iframe.id = 'previewMainImage'; // Reassign ID to iframe
                iframe.width = "100%";
                iframe.height = "440px";
                iframe.src = "https://www.youtube.com/embed/-iAJvsb03lM";
                iframe.title = "Mở hộp iPhone Pro và iPhone 15 Pro Max chính hãng Việt Nam - Màu Titan Tự nhiên quá xịn !!!";
                iframe.frameBorder = "0";
                iframe.allow = "accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
                iframe.referrerPolicy = "strict-origin-when-cross-origin";
                iframe.allowFullscreen = true;
                boxPreview.replaceChild(iframe, previewMainImage); // Replace with iframe
                previewMainImage = iframe; // Update reference
            });
            previewThumbnails.appendChild(videoButton);
        }
    }

    // Update Preview
    function updatePreview(e) {
        if (e.target.classList.contains('product-detail__size-option')) {
            const variantId = parseInt(e.target.dataset.variantId);
            currentVariant = productData.variants.find(v => v.id === variantId) || currentVariant;
            previewSizeOptions.querySelectorAll('.product-detail__size-option').forEach(btn => btn.classList.remove('product-detail__size-option--active'));
            e.target.classList.add('product-detail__size-option--active');
            currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];
            updatePreviewColors();
        } else if (e.target.classList.contains('product-detail__color-option')) {
            const colorId = parseInt(e.target.dataset.colorId);
            currentColor = currentVariant.colors.find(c => c.id === colorId) || currentColor;
            previewColorOptions.querySelectorAll('.product-detail__color-option').forEach(btn => btn.classList.remove('product-detail__color-option--active'));
            e.target.classList.add('product-detail__color-option--active');
            updatePreviewImages();
        } else if (e.target.classList.contains('product-detail__thumbnail')) {
            if (isVideoMode) {
                isVideoMode = false;
                const newImage = document.createElement('img');
                newImage.id = 'previewMainImage';
                newImage.src = e.target.dataset.src;
                newImage.alt = e.target.alt;
                newImage.className = 'product-detail__main-img'; // Sử dụng class từ HTML gốc
                boxPreview.replaceChild(newImage, previewMainImage);
                previewMainImage = newImage; // Update reference
            } else {
                previewMainImage.src = e.target.dataset.src;
                previewMainImage.alt = e.target.alt;
            }
            previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(t => t.classList.remove('product-detail__thumbnail--active'));
            e.target.classList.add('product-detail__thumbnail--active');
        }

        // Update pricing
        previewCurrentPrice.textContent = formatPrice(currentVariant.price) + ' đ';
        previewOriginalPrice.textContent = formatPrice(currentVariant.original_price) + ' đ';
        previewDiscount.textContent = `Giảm ${calculateDiscount(currentVariant.price, currentVariant.original_price)}%`;
    }

    // Utility Functions
    function formatPrice(price) {
        return price ? price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0';
    }

    function calculateDiscount(current, original) {
        return original > 0 ? Math.round(((original - current) / original) * 100) : 0;
    }
    // Initialize
    updatePreviewVariants();
});
        </script>
    </main>
</body>
</html>