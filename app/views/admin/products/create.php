<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';

// Initialize default variant and color for the form
$default_variants = [
    [
        'capacity_group' => '',
        'price' => '',
        'original_price' => '',
        'stock_quantity' => '',
        'colors' => [
            [
                'color_id' => '',
                'stock_quantity' => '',
                'is_active' => true,
                'images' => [
                    ['file' => '', 'gallery_image_alt' => '', 'sort_order' => 0]
                ]
            ]
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo sản phẩm mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <style>
        .product-detail__admin-panel { padding: 20px; }
        .product-detail__admin-section { margin-bottom: 20px; }
        .product-detail__admin-section-title { font-size: 1.5em; margin-bottom: 10px; }
        .product-detail__form-group { margin-bottom: 15px; }
        .product-detail__label { display: block; margin-bottom: 5px; }
        .product-detail__input, .product-detail__textarea, .product-detail__select { width: 100%; padding: 8px; }
        .product-detail__textarea { height: 100px; }
        .product-detail__form-row { display: flex; gap: 20px; }
        .product-detail__variant-item, .product-detail__color-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; }
        .product-detail__btn { padding: 10px 15px; margin: 5px; }
        .product-detail__btn--primary { background: #28a745; color: white; }
        .product-detail__btn--outline { border: 1px solid #ddd; }
        .product-detail__image-preview img { max-width: 200px; margin-top: 10px; }
    </style>
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="product-detail__admin-panel">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form class="product-detail__admin-form" action="/admin/products/handleCreate" method="POST" enctype="multipart/form-data">
                <!-- Basic Info Section -->
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title">
                        <i class="fas fa-info-circle"></i> Thông tin cơ bản
                    </h2>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productName">Tên sản phẩm</label>
                        <input class="product-detail__input" type="text" id="productName" name="product_name" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productDescription">Mô tả sản phẩm (HTML)</label>
                        <textarea class="product-detail__textarea" id="productDescription" name="description_html" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="category">Danh mục</label>
                        <select class="product-detail__select" id="category" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </section>

                <!-- Main Image Section -->
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title">
                        <i class="fas fa-image"></i> Ảnh chính sản phẩm
                    </h2>
                    <div class="product-detail__form-group">
                        <input type="file" id="mainImage" name="main_image" accept="image/*" class="product-detail__input" required>
                        <input type="text" class="product-detail__input" name="media_alt" placeholder="Mô tả ảnh chính" required>
                    </div>
                </section>

                <!-- Variants Section -->
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title">
                        <i class="fas fa-layer-group"></i> Biến thể sản phẩm
                    </h2>
                    <div class="product-detail__variants-manager">
                        <?php foreach ($default_variants as $v_idx => $variant): ?>
                            <div class="product-detail__variant-item">
                                <h3 class="product-detail__variant-title">Biến thể <?php echo $v_idx + 1; ?></h3>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Dung lượng</label>
                                    <input type="text" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][capacity_group]" placeholder="Nhập dung lượng" required>
                                </div>
                                <div class="product-detail__form-row">
                                    <div class="product-detail__form-group">
                                        <label class="product-detail__label">Giá bán (VNĐ)</label>
                                        <input type="number" step="0.01" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][price]" placeholder="Nhập giá bán" required>
                                    </div>
                                    <div class="product-detail__form-group">
                                        <label class="product-detail__label">Giá gốc (VNĐ)</label>
                                        <input type="number" step="0.01" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][original_price]" placeholder="Nhập giá gốc" required>
                                    </div>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Số lượng tồn kho</label>
                                    <input type="number" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][stock_quantity]" placeholder="Nhập số lượng tồn kho" required>
                                </div>
                                <!-- Colors for this variant -->
                                <div class="product-detail__colors-manager">
                                    <?php foreach ($variant['colors'] as $c_idx => $color): ?>
                                        <div class="product-detail__color-item">
                                            <div class="product-detail__form-row">
                                                <div class="product-detail__form-group">
                                                    <label class="product-detail__label">Màu sắc</label>
                                                    <select class="product-detail__select" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][color_id]" required>
                                                        <option value="">Chọn màu</option>
                                                        <?php foreach ($colors as $c): ?>
                                                            <option value="<?php echo htmlspecialchars($c['id']); ?>">
                                                                <?php echo htmlspecialchars($c['name']) . ' (' . $c['hex_code'] . ')'; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="product-detail__form-group">
                                                    <label class="product-detail__label">Số lượng</label>
                                                    <input type="number" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][stock_quantity]" placeholder="Số lượng" required>
                                                </div>
                                            </div>
                                            <div class="product-detail__form-group">
                                                <input type="checkbox" id="isActive_<?php echo $v_idx; ?>_<?php echo $c_idx; ?>" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][is_active]" value="1" <?php echo $color['is_active'] ? 'checked' : ''; ?>>
                                                <label for="isActive_<?php echo $v_idx; ?>_<?php echo $c_idx; ?>">Kích hoạt</label>
                                            </div>
                                            <!-- Images for this color -->
                                            <div class="product-detail__color-gallery">
                                                <?php foreach ($color['images'] as $i_idx => $image): ?>
                                                    <div class="product-detail__form-group">
                                                        <label class="product-detail__label">Ảnh màu</label>
                                                        <input type="file" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][file]" accept="image/*" class="product-detail__input">
                                                        <input type="text" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][gallery_image_alt]" placeholder="Mô tả ảnh" value="<?php echo htmlspecialchars($image['gallery_image_alt']); ?>">
                                                        <input type="hidden" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][sort_order]" value="<?php echo $i_idx; ?>">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <button type="button" class="product-detail__btn product-detail__btn--outline add-image" data-variant="<?php echo $v_idx; ?>" data-color="<?php echo $c_idx; ?>">
                                                <i class="fas fa-plus"></i> Thêm ảnh
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                    <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant="<?php echo $v_idx; ?>">
                                        <i class="fas fa-plus"></i> Thêm màu
                                    </button>
                                </div>
                                <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                                    <i class="fas fa-plus"></i> Thêm biến thể
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
                <button type="submit" class="product-detail__btn product-detail__btn--primary">
                    <i class="fas fa-save"></i> Tạo sản phẩm
                </button>
            </form>
        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.product-detail__admin-form');
    const variantsManager = document.querySelector('.product-detail__variants-manager');

    // Xử lý sự kiện "Thêm biến thể" bằng event delegation
    variantsManager.addEventListener('click', function(e) {
        if (e.target.closest('.add-variant')) {
            const variantItems = document.querySelectorAll('.product-detail__variant-item');
            const variantIdx = variantItems.length;
            const newVariant = `
                <div class="product-detail__variant-item">
                    <h3 class="product-detail__variant-title">Biến thể ${variantIdx + 1}</h3>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Dung lượng</label>
                        <input type="text" class="product-detail__input" name="variants[${variantIdx}][capacity_group]" placeholder="Nhập dung lượng" required>
                    </div>
                    <div class="product-detail__form-row">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Giá bán (VNĐ)</label>
                            <input type="number" step="0.01" class="product-detail__input" name="variants[${variantIdx}][price]" placeholder="Nhập giá bán" required>
                        </div>
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Giá gốc (VNĐ)</label>
                            <input type="number" step="0.01" class="product-detail__input" name="variants[${variantIdx}][original_price]" placeholder="Nhập giá gốc" required>
                        </div>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Số lượng tồn kho</label>
                        <input type="number" class="product-detail__input" name="variants[${variantIdx}][stock_quantity]" placeholder="Nhập số lượng tồn kho" required>
                    </div>
                    <div class="product-detail__colors-manager">
                        <div class="product-detail__color-item">
                            <div class="product-detail__form-row">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Màu sắc</label>
                                    <select class="product-detail__select" name="variants[${variantIdx}][colors][0][color_id]" required>
                                        <option value="">Chọn màu</option>
                                        <?php foreach ($colors as $c): ?>
                                            <option value="<?php echo htmlspecialchars($c['id']); ?>">
                                                <?php echo htmlspecialchars($c['name']) . ' (' . $c['hex_code'] . ')'; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Số lượng</label>
                                    <input type="number" class="product-detail__input" name="variants[${variantIdx}][colors][0][stock_quantity]" placeholder="Số lượng" required>
                                </div>
                            </div>
                            <div class="product-detail__form-group">
                                <input type="checkbox" id="isActive_${variantIdx}_0" name="variants[${variantIdx}][colors][0][is_active]" value="1" checked>
                                <label for="isActive_${variantIdx}_0">Kích hoạt</label>
                            </div>
                            <div class="product-detail__color-gallery">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Ảnh màu</label>
                                    <input type="file" name="variants[${variantIdx}][colors][0][images][0][file]" accept="image/*" class="product-detail__input">
                                    <input type="text" class="product-detail__input" name="variants[${variantIdx}][colors][0][images][0][gallery_image_alt]" placeholder="Mô tả ảnh">
                                    <input type="hidden" name="variants[${variantIdx}][colors][0][images][0][sort_order]" value="0">
                                </div>
                            </div>
                            <button type="button" class="product-detail__btn product-detail__btn--outline add-image" data-variant="${variantIdx}" data-color="0">
                                <i class="fas fa-plus"></i> Thêm ảnh
                            </button>
                        </div>
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant="${variantIdx}">
                            <i class="fas fa-plus"></i> Thêm màu
                        </button>
                    </div>
                    <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                        <i class="fas fa-plus"></i> Thêm biến thể
                    </button>
                </div>
            `;
            variantsManager.insertAdjacentHTML('beforeend', newVariant);
        }
    });

    // Xử lý sự kiện "Thêm màu" bằng event delegation
    variantsManager.addEventListener('click', function(e) {
        if (e.target.closest('.add-color')) {
            const btn = e.target.closest('.add-color');
            const variantIdx = btn.dataset.variant;
            const colorItems = btn.closest('.product-detail__colors-manager').querySelectorAll('.product-detail__color-item');
            const colorIdx = colorItems.length;
            const newColor = `
                <div class="product-detail__color-item">
                    <div class="product-detail__form-row">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Màu sắc</label>
                            <select class="product-detail__select" name="variants[${variantIdx}][colors][${colorIdx}][color_id]" required>
                                <option value="">Chọn màu</option>
                                <?php foreach ($colors as $c): ?>
                                    <option value="<?php echo htmlspecialchars($c['id']); ?>">
                                        <?php echo htmlspecialchars($c['name']) . ' (' . $c['hex_code'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Số lượng</label>
                            <input type="number" class="product-detail__input" name="variants[${variantIdx}][colors][${colorIdx}][stock_quantity]" placeholder="Số lượng" required>
                        </div>
                    </div>
                    <div class="product-detail__form-group">
                        <input type="checkbox" id="isActive_${variantIdx}_${colorIdx}" name="variants[${variantIdx}][colors][${colorIdx}][is_active]" value="1" checked>
                        <label for="isActive_${variantIdx}_${colorIdx}">Kích hoạt</label>
                    </div>
                    <div class="product-detail__color-gallery">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Ảnh màu</label>
                            <input type="file" name="variants[${variantIdx}][colors][${colorIdx}][images][0][file]" accept="image/*" class="product-detail__input">
                            <input type="text" class="product-detail__input" name="variants[${variantIdx}][colors][${colorIdx}][images][0][gallery_image_alt]" placeholder="Mô tả ảnh">
                            <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][0][sort_order]" value="0">
                        </div>
                    </div>
                    <button type="button" class="product-detail__btn product-detail__btn--outline add-image" data-variant="${variantIdx}" data-color="${colorIdx}">
                        <i class="fas fa-plus"></i> Thêm ảnh
                    </button>
                </div>
            `;
            btn.insertAdjacentHTML('beforebegin', newColor);
        }
    });

    // Xử lý sự kiện "Thêm ảnh" bằng event delegation
    variantsManager.addEventListener('click', function(e) {
        if (e.target.closest('.add-image')) {
            const btn = e.target.closest('.add-image');
            const variantIdx = btn.dataset.variant;
            const colorIdx = btn.dataset.color;
            const gallery = btn.closest('.product-detail__color-item').querySelector('.product-detail__color-gallery');
            const imageIdx = gallery.querySelectorAll('.product-detail__form-group').length;
            const newImage = `
                <div class="product-detail__form-group">
                    <label class="product-detail__label">Ảnh màu</label>
                    <input type="file" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][file]" accept="image/*" class="product-detail__input">
                    <input type="text" class="product-detail__input" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][gallery_image_alt]" placeholder="Mô tả ảnh">
                    <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][sort_order]" value="${imageIdx}">
                </div>
            `;
            btn.insertAdjacentHTML('beforebegin', newImage);
        }
    });

    // Xác thực form trước khi gửi
    form.addEventListener('submit', function(e) {
        const fileInputs = form.querySelectorAll('input[type="file"]');
        let hasFiles = false;
        fileInputs.forEach(input => {
            if (input.files.length > 0) hasFiles = true;
        });
        if (!hasFiles) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một ảnh (ảnh chính hoặc ảnh biến thể) trước khi gửi.');
        }
    });
});
    </script>
</body>
</html>