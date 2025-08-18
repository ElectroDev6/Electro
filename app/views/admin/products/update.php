<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm</title>
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
        .current-image { max-width: 100px; max-height: 100px; margin: 10px 0; }
        .image-preview { display: flex; align-items: center; gap: 10px; }
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
            <form class="product-detail__admin-form" action="/admin/products/update/handle" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title"><i class="fas fa-info-circle"></i> Thông tin cơ bản</h2>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productName">Tên sản phẩm</label>
                        <input class="product-detail__input" type="text" id="productName" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productDescription">Mô tả</label>
                        <textarea class="product-detail__textarea" id="productDescription" name="description_html"><?php echo htmlspecialchars($product['description_html']); ?></textarea>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="category">Danh mục</label>
                        <select class="product-detail__select" id="category" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="mainImage">Ảnh chính</label>
                        <?php if (!empty($product['media_url'])): ?>
                            <div class="image-preview">
                                <img src="<?php echo htmlspecialchars($product['media_url']); ?>" alt="Current main image" class="current-image">
                                <span>Ảnh hiện tại</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" id="mainImage" name="main_image" accept="image/*">
                        <small>Để trống nếu không muốn thay đổi ảnh chính</small>
                        <input type="text" class="product-detail__input" name="media_alt" placeholder="Mô tả ảnh chính" value="<?php echo htmlspecialchars($product['media_alt'] ?? ''); ?>" required>
                    </div>
                </section>

                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title"><i class="fas fa-layer-group"></i> Biến thể</h2>
                    <div class="product-detail__variants-manager">
                        <?php foreach ($product['variants'] as $v_idx => $variant): ?>
                            <div class="product-detail__variant-item">
                                <h3 class="product-detail__variant-title">Biến thể <?php echo $v_idx + 1; ?></h3>
                                
                                <!-- Hidden field để lưu variant ID -->
                                <input type="hidden" name="variants[<?php echo $v_idx; ?>][variant_id]" value="<?php echo htmlspecialchars($variant['variant_id'] ?? ''); ?>">
                                
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Dung lượng</label>
                                    <input class="product-detail__input" name="variants[<?php echo $v_idx; ?>][capacity_group]" value="<?php echo htmlspecialchars($variant['capacity_group'] ?? ''); ?>" required>
                                </div>
                                <div class="product-detail__form-row">
                                    <div class="product-detail__form-group">
                                        <label class="product-detail__label">Giá bán (VNĐ)</label>
                                        <input class="product-detail__input" type="number" step="0.01" name="variants[<?php echo $v_idx; ?>][price]" value="<?php echo htmlspecialchars($variant['price'] ?? '0'); ?>" required>
                                    </div>
                                    <div class="product-detail__form-group">
                                        <label class="product-detail__label">Giá gốc (VNĐ)</label>
                                        <input class="product-detail__input" type="number" step="0.01" name="variants[<?php echo $v_idx; ?>][original_price]" value="<?php echo htmlspecialchars($variant['original_price'] ?? '0'); ?>" required>
                                    </div>
                                </div>
                                <div class="product-detail__form-group">
                                    <label class="product-detail__label">Số lượng tồn kho</label>
                                    <input class="product-detail__input" type="number" name="variants[<?php echo $v_idx; ?>][stock_quantity]" value="<?php echo htmlspecialchars($variant['stock_quantity'] ?? '0'); ?>" required>
                                </div>
                                
                                <div class="product-detail__colors-manager">
                                    <?php foreach ($variant['colors'] as $c_idx => $color): ?>
                                        <div class="product-detail__color-item">
                                            <!-- Hidden field để lưu variant_color ID -->
                                            <input type="hidden" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][variant_color_id]" value="<?php echo htmlspecialchars($color['variant_color_id'] ?? ''); ?>">
                                            
                                            <div class="product-detail__form-row">
                                                <div class="product-detail__form-group">
                                                    <label class="product-detail__label">Màu sắc</label>
                                                    <select class="product-detail__select" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][color_id]" required>
                                                        <option value="">Chọn màu</option>
                                                        <?php foreach ($colors as $c): ?>
                                                            <option value="<?php echo htmlspecialchars($c['id']); ?>" <?php echo $c['id'] == $color['color_id'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($c['name']) . ' (' . $c['hex_code'] . ')'; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="product-detail__form-group">
                                                    <label class="product-detail__label">Số lượng</label>
                                                    <input class="product-detail__input" type="number" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][stock_quantity]" value="<?php echo htmlspecialchars($color['stock'] ?? '0'); ?>" required>
                                                </div>
                                            </div>
                                            <div class="product-detail__form-group">
                                                <input type="checkbox" id="isActive_<?php echo $v_idx; ?>_<?php echo $c_idx; ?>" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][is_active]" value="1" <?php echo $color['is_active'] ? 'checked' : ''; ?>>
                                                <label for="isActive_<?php echo $v_idx; ?>_<?php echo $c_idx; ?>">Kích hoạt</label>
                                            </div>
                                            
                                            <div class="product-detail__color-gallery">
                                                <?php foreach ($color['images'] as $i_idx => $image): ?>
                                                    <div class="product-detail__form-group">
                                                        <label class="product-detail__label">Ảnh màu <?php echo $i_idx + 1; ?></label>
                                                        
                                                        <!-- Hidden fields để lưu thông tin ảnh hiện tại -->
                                                        <input type="hidden" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][image_id]" value="<?php echo htmlspecialchars($image['image_id'] ?? ''); ?>">
                                                        <input type="hidden" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][current_url]" value="<?php echo htmlspecialchars($image['url'] ?? ''); ?>">
                                                        
                                                        <?php if (!empty($image['url'])): ?>
                                                            <div class="image-preview">
                                                                <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="Current image" class="current-image">
                                                                <span>Ảnh hiện tại</span>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <input type="file" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][file]" accept="image/*">
                                                        <small>Để trống nếu không muốn thay đổi ảnh</small>
                                                        
                                                        <input type="text" class="product-detail__input" name="variants[<?php echo $v_idx; ?>][colors][<?php echo $c_idx; ?>][images][<?php echo $i_idx; ?>][gallery_image_alt]" placeholder="Mô tả ảnh" value="<?php echo htmlspecialchars($image['gallery_image_alt'] ?? ''); ?>">
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
                            </div>
                        <?php endforeach; ?>
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                            <i class="fas fa-plus"></i> Thêm biến thể
                        </button>
                    </div>
                </section>
                
                <button type="submit" class="product-detail__btn product-detail__btn--primary">
                    <i class="fas fa-save"></i> Cập nhật sản phẩm
                </button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.product-detail__admin-form');
            let addVariantBtn = document.querySelector('.add-variant');
            let addColorBtns = document.querySelectorAll('.add-color');
            let addImageBtns = document.querySelectorAll('.add-image');

            // Function to update dynamic button event listeners
            function updateDynamicButtons() {
                addColorBtns.forEach(btn => btn.removeEventListener('click', handleAddColor));
                addImageBtns.forEach(btn => btn.removeEventListener('click', handleAddImage));
                addColorBtns = document.querySelectorAll('.add-color');
                addImageBtns = document.querySelectorAll('.add-image');
                addColorBtns.forEach(btn => btn.addEventListener('click', handleAddColor));
                addImageBtns.forEach(btn => btn.addEventListener('click', handleAddImage));
            }

            // Add new variant (similar to create page)
            addVariantBtn.addEventListener('click', function() {
                const variantItems = document.querySelectorAll('.product-detail__variant-item');
                const variantIdx = variantItems.length;
                const newVariant = `
                    <div class="product-detail__variant-item">
                        <h3 class="product-detail__variant-title">Biến thể ${variantIdx + 1}</h3>
                        <input type="hidden" name="variants[${variantIdx}][variant_id]" value="">
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
                                <input type="hidden" name="variants[${variantIdx}][colors][0][variant_color_id]" value="">
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
                                        <input type="hidden" name="variants[${variantIdx}][colors][0][images][0][image_id]" value="">
                                        <input type="hidden" name="variants[${variantIdx}][colors][0][images][0][current_url]" value="">
                                        <input type="file" name="variants[${variantIdx}][colors][0][images][0][file]" accept="image/*" class="product-detail__input" required>
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
                    </div>
                `;
                form.querySelector('.product-detail__variants-manager').insertAdjacentHTML('beforeend', newVariant);
                updateDynamicButtons();
            });

            // Add new color
            function handleAddColor(e) {
                const variantIdx = e.target.dataset.variant;
                const colorItems = e.target.closest('.product-detail__variant-item').querySelectorAll('.product-detail__color-item');
                const colorIdx = colorItems.length;
                const newColor = `
                    <div class="product-detail__color-item">
                        <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][variant_color_id]" value="">
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
                                <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][0][image_id]" value="">
                                <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][0][current_url]" value="">
                                <input type="file" name="variants[${variantIdx}][colors][${colorIdx}][images][0][file]" accept="image/*" class="product-detail__input" required>
                                <input type="text" class="product-detail__input" name="variants[${variantIdx}][colors][${colorIdx}][images][0][gallery_image_alt]" placeholder="Mô tả ảnh">
                                <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][0][sort_order]" value="0">
                            </div>
                        </div>
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-image" data-variant="${variantIdx}" data-color="${colorIdx}">
                            <i class="fas fa-plus"></i> Thêm ảnh
                        </button>
                    </div>
                `;
                e.target.insertAdjacentHTML('beforebegin', newColor);
                updateDynamicButtons();
            }

            // Add new image
            function handleAddImage(e) {
                const variantIdx = e.target.dataset.variant;
                const colorIdx = e.target.dataset.color;
                const gallery = e.target.closest('.product-detail__color-item').querySelector('.product-detail__color-gallery');
                const imageIdx = gallery.querySelectorAll('.product-detail__form-group').length;
                const newImage = `
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Ảnh màu ${imageIdx + 1}</label>
                        <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][image_id]" value="">
                        <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][current_url]" value="">
                        <input type="file" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][file]" accept="image/*" class="product-detail__input" required>
                        <input type="text" class="product-detail__input" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][gallery_image_alt]" placeholder="Mô tả ảnh">
                        <input type="hidden" name="variants[${variantIdx}][colors][${colorIdx}][images][${imageIdx}][sort_order]" value="${imageIdx}">
                    </div>
                `;
                e.target.insertAdjacentHTML('beforebegin', newImage);
            }

            // Attach event listeners
            addColorBtns.forEach(btn => btn.addEventListener('click', handleAddColor));
            addImageBtns.forEach(btn => btn.addEventListener('click', handleAddImage));

            // Form validation
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('input[required], select[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = 'red';
                    } else {
                        field.style.borderColor = '';
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Vui lòng điền đầy đủ thông tin bắt buộc.');
                }
            });
        });
    </script>
</body>
</html>