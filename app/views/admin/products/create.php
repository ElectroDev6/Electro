<?php
// PHP data remains unchanged
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo sản phẩm mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="product-detail__admin-panel" id="adminForm">
            <form class="product-detail__admin-form" id="productForm" action="process_create.php" method="POST" enctype="multipart/form-data">
                <!-- Basic Info Section -->
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title">
                        <i class="fas fa-info-circle"></i> Thông tin cơ bản
                    </h2>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productName">Tên sản phẩm</label>
                        <input class="product-detail__input" type="text" id="productName" name="productName" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productDescription">Mô tả sản phẩm (HTML)</label>
                        <textarea class="product-detail__textarea" id="productDescription" name="productDescription" rows="4" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>
                    <div class="product-detail__form-row">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label" for="category">Danh mục</label>
                            <select class="product-detail__select" id="category" name="category" required>
                                <option value="1">Điện thoại</option>
                                <option value="2">Máy tính bảng</option>
                                <option value="3">Laptop</option>
                            </select>
                        </div>
                        <div class="product-detail__form-group">
                            <label class="product-detail__label" for="productId">ID sản phẩm</label>
                            <input class="product-detail__input" type="number" id="productId" name="productId" readonly>
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
                            <img src="" alt="Preview" class="product-detail__preview-img" style="display: none;">
                            <div class="product-detail__image-overlay">
                                <button type="button" class="product-detail__btn product-detail__btn--icon edit-image">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-detail__upload-controls">
                            <input type="file" id="mainImage" name="mainImage" accept="image/*" class="product-detail__file-input" required>
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
                        <div class="product-detail__variant-item" data-variant-id="1">
                            <h3 class="product-detail__variant-title">Biến thể 1</h3>
                            <div class="product-detail__form-row">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">ID Biến thể</label>
                                    <input type="number" class="product-detail__input" readonly>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Dung lượng</label>
                                    <input type="text" class="product-detail__input" name="variants[0][capacity]" placeholder="Nhập dung lượng" data-field="capacity">
                                </div>
                            </div>
                            <div class="product-detail__form-row">
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Giá bán (VNĐ)</label>
                                    <input type="number" class="product-detail__input" name="variants[0][price]" placeholder="Nhập giá bán" data-field="price" required>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Giá gốc (VNĐ)</label>
                                    <input type="number" class="product-detail__input" name="variants[0][original_price]" placeholder="Nhập giá gốc" data-field="original_price">
                                </div>
                            </div>
                            <!-- Colors for this variant -->
                            <div class="product-detail__colors-manager" data-variant-id="1">
                                <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant-id="1">
                                    <i class="fas fa-plus"></i> Thêm màu sắc
                                </button>
                            </div>
                            <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-variant" disabled>
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                            <i class="fas fa-plus"></i> Thêm biến thể
                        </button>
                    </div>
                </section>

                <button type="submit" class="product-detail__btn product-detail__btn--outline">Lưu sản phẩm</button>
            </form>
        </div>
    </main>

    <script>
        // Preview ảnh chính
        document.getElementById('mainImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.product-detail__preview-img');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                alert('Vui lòng chọn file ảnh hợp lệ (JPG, PNG).');
            }
        });

        // Cập nhật chỉ số name cho tất cả input
        function updateVariantIndices() {
            const variants = document.querySelectorAll('.product-detail__variant-item');
            variants.forEach((variant, variantIndex) => {
                variant.setAttribute('data-variant-id', variantIndex + 1);
                variant.querySelector('.product-detail__variant-title').textContent = `Biến thể ${variantIndex + 1}`;
                
                // Cập nhật name cho các input trong biến thể
                const inputs = variant.querySelectorAll('input[data-field], select[data-field]');
                inputs.forEach(input => {
                    const field = input.getAttribute('data-field');
                    if (field === 'capacity') input.name = `variants[${variantIndex}][capacity]`;
                    if (field === 'price') input.name = `variants[${variantIndex}][price]`;
                    if (field === 'original_price') input.name = `variants[${variantIndex}][original_price]`;
                    if (field === 'stock') input.name = `variants[${variantIndex}][stock]`;
                });

                // Cập nhật name cho các màu sắc
                const colors = variant.querySelectorAll('.product-detail__color-item');
                colors.forEach((color, colorIndex) => {
                    color.setAttribute('data-color-id', colorIndex + 1);
                    const colorInputs = color.querySelectorAll('input[data-field]');
                    colorInputs.forEach(input => {
                        const field = input.getAttribute('data-field');
                        if (field === 'color_name') input.name = `variants[${variantIndex}][colors][${colorIndex}][name]`;
                        if (field === 'hex_code') input.name = `variants[${variantIndex}][colors][${colorIndex}][hex_code]`;
                        if (field === 'color_stock') input.name = `variants[${variantIndex}][colors][${colorIndex}][stock]`;
                        if (field === 'is_active') input.name = `variants[${variantIndex}][colors][${colorIndex}][is_active]`;
                        if (field === 'is_active') input.id = `isActive_${variantIndex + 1}_${colorIndex + 1}`;
                    });
                    const label = color.querySelector('label');
                    label.setAttribute('for', `isActive_${variantIndex + 1}_${colorIndex + 1}`);

                    // Cập nhật name cho các input ảnh
                    const imageInputs = color.querySelectorAll('.product-detail__color-gallery input[type="file"]');
                    imageInputs.forEach((input, imgIndex) => {
                        input.name = `variants[${variantIndex}][colors][${colorIndex}][images][${imgIndex}]`;
                    });
                });
            });
        }

        // Thêm biến thể mới
        document.querySelector('.add-variant').addEventListener('click', function() {
            const variantsManager = document.querySelector('.product-detail__variants-manager');
            const variantCount = variantsManager.querySelectorAll('.product-detail__variant-item').length + 1;
            const variantId = variantCount;

            const newVariant = document.createElement('div');
            newVariant.className = 'product-detail__variant-item';
            newVariant.setAttribute('data-variant-id', variantId);
            newVariant.innerHTML = `
                <h3 class="product-detail__variant-title">Biến thể ${variantCount}</h3>
                <div class="product-detail__form-row">
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">ID Biến thể</label>
                        <input type="number" class="product-detail__input" readonly>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Dung lượng</label>
                        <input type="text" class="product-detail__input" name="variants[${variantCount - 1}][capacity]" placeholder="Nhập dung lượng" data-field="capacity">
                    </div>
                </div>
                <div class="product-detail__form-row">
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Giá bán (VNĐ)</label>
                        <input type="number" class="product-detail__input" name="variants[${variantCount - 1}][price]" placeholder="Nhập giá bán" data-field="price" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Giá gốc (VNĐ)</label>
                        <input type="number" class="product-detail__input" name="variants[${variantCount - 1}][original_price]" placeholder="Nhập giá gốc" data-field="original_price">
                    </div>
                </div>
                <div class="product-detail__form-group">
                    <label class="product-detail__label">Số lượng tồn kho</label>
                    <input type="number" class="product-detail__input" name="variants[${variantCount - 1}][stock]" placeholder="Nhập số lượng tồn kho" data-field="stock" required>
                </div>
                <div class="product-detail__colors-manager" data-variant-id="${variantId}">
                    <div class="product-detail__color-item" data-color-id="1">
                        <div class="product-detail__color-info">
                            <input type="number" class="product-detail__input product-detail__input--small" readonly>
                            <input type="text" class="product-detail__input product-detail__input--small" name="variants[${variantCount - 1}][colors][0][name]" placeholder="Tên màu" data-field="color_name" required>
                            <input type="color" class="product-detail__color-picker" name="variants[${variantCount - 1}][colors][0][hex_code]" data-field="hex_code" required>
                            <input type="number" class="product-detail__input product-detail__input--small" name="variants[${variantCount - 1}][colors][0][stock]" placeholder="Số lượng" data-field="color_stock" required>
                            <input type="checkbox" class="product-detail__input" id="isActive_${variantId}_1" name="variants[${variantCount - 1}][colors][0][is_active]" checked data-field="is_active">
                            <label for="isActive_${variantId}_1">Kích hoạt</label>
                        </div>
                        <div class="product-detail__color-gallery">
                            <div class="product-detail__gallery-item">
                                <input type="file" name="variants[${variantCount - 1}][colors][0][images][]" accept="image/*" class="product-detail__file-input">
                                <button type="button" class="product-detail__btn product-detail__btn--icon remove-image">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="product-detail__btn product-detail__btn--outline add-image">
                                <i class="fas fa-plus"></i> Thêm ảnh
                            </button>
                            <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-color" disabled>
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant-id="${variantId}">
                        <i class="fas fa-plus"></i> Thêm màu sắc
                    </button>
                </div>
                <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-variant">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            variantsManager.insertBefore(newVariant, variantsManager.lastElementChild);
            updateVariantIndices();
            updateRemoveButtons();
        });

        // Thêm màu sắc mới
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-color')) {
                const button = e.target.closest('.add-color');
                const variantId = button.getAttribute('data-variant-id');
                const colorsManager = button.closest('.product-detail__colors-manager');
                const colorCount = colorsManager.querySelectorAll('.product-detail__color-item').length + 1;
                const variantIndex = Array.from(document.querySelectorAll('.product-detail__variant-item')).findIndex(v => v.getAttribute('data-variant-id') == variantId);

                const newColor = document.createElement('div');
                newColor.className = 'product-detail__color-item';
                newColor.setAttribute('data-color-id', colorCount);
                newColor.innerHTML = `
                    <div class="product-detail__color-info">
                        <input type="number" class="product-detail__input product-detail__input--small" readonly>
                        <input type="text" class="product-detail__input product-detail__input--small" name="variants[${variantIndex}][colors][${colorCount - 1}][name]" placeholder="Tên màu" data-field="color_name" required>
                        <input type="color" class="product-detail__color-picker" name="variants[${variantIndex}][colors][${colorCount - 1}][hex_code]" data-field="hex_code" required>
                        <input type="number" class="product-detail__input product-detail__input--small" name="variants[${variantIndex}][colors][${colorCount - 1}][stock]" placeholder="Số lượng" data-field="color_stock" required>
                        <input type="checkbox" class="product-detail__input" id="isActive_${variantId}_${colorCount}" name="variants[${variantIndex}][colors][${colorCount - 1}][is_active]" checked data-field="is_active">
                        <label for="isActive_${variantId}_${colorCount}">Kích hoạt</label>
                    </div>
                    <div class="product-detail__color-gallery">
                        <div class="product-detail__gallery-item">
                            <input type="file" name="variants[${variantIndex}][colors][${colorCount - 1}][images][]" accept="image/*" class="product-detail__file-input">
                            <button type="button" class="product-detail__btn product-detail__btn--icon remove-image">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-image">
                            <i class="fas fa-plus"></i> Thêm ảnh
                        </button>
                        <button type="button" class="product-detail__btn product-detail__btn--danger-outline remove-color">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                colorsManager.insertBefore(newColor, colorsManager.lastElementChild);
                updateVariantIndices();
                updateRemoveButtons();
            }
        });

        // Thêm ảnh vào gallery
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-image')) {
                const colorItem = e.target.closest('.product-detail__color-item');
                const gallery = colorItem.querySelector('.product-detail__color-gallery');
                const variantIndex = Array.from(document.querySelectorAll('.product-detail__variant-item')).findIndex(v => v.contains(colorItem));
                const colorIndex = Array.from(colorItem.closest('.product-detail__colors-manager').querySelectorAll('.product-detail__color-item')).indexOf(colorItem);
                const imageCount = gallery.querySelectorAll('.product-detail__gallery-item').length;

                const newImage = document.createElement('div');
                newImage.className = 'product-detail__gallery-item';
                newImage.innerHTML = `
                    <input type="file" name="variants[${variantIndex}][colors][${colorIndex}][images][${imageCount}]" accept="image/*" class="product-detail__file-input">
                    <button type="button" class="product-detail__btn product-detail__btn--icon remove-image">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                gallery.appendChild(newImage);
            }
        });

        // Xóa ảnh
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-image')) {
                const galleryItem = e.target.closest('.product-detail__gallery-item');
                galleryItem.remove();
                updateVariantIndices();
            }
        });

        // Xóa màu sắc
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-color')) {
                const colorItem = e.target.closest('.product-detail__color-item');
                const colorsManager = colorItem.closest('.product-detail__colors-manager');
                colorItem.remove();
                updateVariantIndices();
                updateRemoveButtons();
            }
        });

        // Xóa biến thể
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-variant')) {
                const variantItem = e.target.closest('.product-detail__variant-item');
                variantItem.remove();
                updateVariantIndices();
                updateRemoveButtons();
            }
        });

        // Cập nhật trạng thái nút xóa
        function updateRemoveButtons() {
            const variants = document.querySelectorAll('.product-detail__variant-item');
            variants.forEach(variant => {
                const removeVariantBtn = variant.querySelector('.remove-variant');
                removeVariantBtn.disabled = variants.length <= 1;

                const colorsManager = variant.querySelector('.product-detail__colors-manager');
                const colorItems = colorsManager.querySelectorAll('.product-detail__color-item');
                const removeColorBtns = colorsManager.querySelectorAll('.remove-color');
                removeColorBtns.forEach(button => {
                    button.disabled = colorItems.length <= 1;
                });
            });
        }

        // Gọi lần đầu để thiết lập trạng thái ban đầu
        updateRemoveButtons();
    </script>
</body>
</html>