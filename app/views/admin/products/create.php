<?php
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
    <style>
        .product-detail__form-group { margin-bottom: 1rem; }
        .product-detail__label { display: block; font-weight: bold; margin-bottom: 0.5rem; }
        .product-detail__input, .product-detail__select, .product-detail__textarea {
            width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;
        }
        .product-detail__textarea { height: 150px; }
        .product-detail__form-row { display: flex; gap: 1rem; }
        .product-detail__btn { padding: 0.5rem 1rem; margin: 0.5rem 0; cursor: pointer; }
        .product-detail__btn--primary { background: #007bff; color: white; border: none; }
        .product-detail__btn--outline { background: none; border: 1px solid #007bff; color: #007bff; }
        .product-detail__variant-item, .product-detail__color-item { border: 1px solid #eee; padding: 1rem; margin-bottom: 1rem; }
        .product-detail__variant-title { font-size: 1.2rem; margin-bottom: 1rem; }
        .product-detail__colors-manager, .product-detail__color-gallery { margin-top: 1rem; }
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
                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title"><i class="fas fa-info-circle"></i> Thông tin cơ bản</h2>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productName">Tên sản phẩm</label>
                        <input class="product-detail__input" type="text" id="productName" name="product_name" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="productDescription">Mô tả sản phẩm (HTML)</label>
                        <textarea class="product-detail__textarea" id="productDescription" name="description_html" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="basePrice">Giá cơ bản (VNĐ)</label>
                        <input class="product-detail__input" type="number" step="0.01" id="basePrice" name="base_price" placeholder="Nhập giá cơ bản" required>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="brand">Thương hiệu</label>
                        <select class="product-detail__select" id="brand" name="brand_id" required>
                            <option value="">Chọn thương hiệu</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?php echo htmlspecialchars($brand['id']); ?>">
                                    <?php echo htmlspecialchars($brand['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="category">Danh mục</label>
                        <select class="product-detail__select" id="category" name="category_id" required>
                            <option value="">Chọn danh mục</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="subcategory">Danh mục phụ</label>
                        <select class="product-detail__select" id="subcategory" name="subcategory_id" required>
                            <option value="">Chọn danh mục phụ</option>
                        </select>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label" for="isFeatured">Nổi bật</label>
                        <input type="checkbox" id="isFeatured" name="is_featured" value="1">
                    </div>
                </section>

                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title"><i class="fas fa-image"></i> Ảnh chính sản phẩm</h2>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Ảnh chính</label>
                        <input type="file" id="mainImage" name="main_image" accept="image/*" class="product-detail__input" required>
                        <input type="text" class="product-detail__input" name="media_alt" placeholder="Mô tả ảnh chính" required>
                    </div>
                </section>

                <section class="product-detail__admin-section">
                    <h2 class="product-detail__admin-section-title"><i class="fas fa-layer-group"></i> Biến thể sản phẩm</h2>
                    <div class="product-detail__variants-manager">
                        <button type="button" class="product-detail__btn product-detail__btn--outline add-variant">
                            <i class="fas fa-plus"></i> Thêm biến thể
                        </button>
                    </div>
                </section>

                <button type="submit" class="product-detail__btn product-detail__btn--primary">
                    <i class="fas fa-save"></i> Tạo sản phẩm
                </button>
            </form>
        </div>
    </main>

    <script>
        let variantIndex = 0;
        let colorIndices = {};

        function addVariant() {
            variantIndex++;
            colorIndices[variantIndex] = 0;
            const variantContainer = document.querySelector('.product-detail__variants-manager');
            const variantTemplate = `
                <div class="product-detail__variant-item" data-variant="${variantIndex}">
                    <h3 class="product-detail__variant-title">Biến thể ${variantIndex + 1}</h3>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Dung lượng</label>
                        <select class="product-detail__select" name="variants[${variantIndex}][capacity_id]" required>
                            <option value="">Chọn dung lượng</option>
                            <?php foreach ($capacities as $capacity): ?>
                                <option value="<?php echo htmlspecialchars($capacity['id']); ?>">
                                    <?php echo htmlspecialchars($capacity['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="product-detail__form-row">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Giá bán (VNĐ)</label>
                            <input type="number" step="0.01" class="product-detail__input" name="variants[${variantIndex}][price]" placeholder="Nhập giá bán" required>
                        </div>
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Giá gốc (VNĐ)</label>
                            <input type="number" step="0.01" class="product-detail__input" name="variants[${variantIndex}][original_price]" placeholder="Nhập giá gốc" required>
                        </div>
                    </div>
                    <div class="product-detail__form-group">
                        <label class="product-detail__label">Số lượng tồn kho</label>
                        <input type="number" class="product-detail__input" name="variants[${variantIndex}][stock_quantity]" placeholder="Nhập số lượng tồn kho" required>
                    </div>
                    <div class="product-detail__colors-manager" data-variant="${variantIndex}"></div>
                    <button type="button" class="product-detail__btn product-detail__btn--outline add-color" data-variant="${variantIndex}">
                        <i class="fas fa-plus"></i> Thêm màu
                    </button>
                    <button type="button" class="product-detail__btn product-detail__btn--outline remove-variant" data-variant="${variantIndex}">
                        <i class="fas fa-trash"></i> Xóa biến thể
                    </button>
                </div>`;
            variantContainer.insertAdjacentHTML('beforeend', variantTemplate);
        }

        function addColor(variantIndex) {
            if (!colorIndices[variantIndex]) colorIndices[variantIndex] = 0;
            const colorIndex = colorIndices[variantIndex]++;
            const colorsContainer = document.querySelector(`.product-detail__colors-manager[data-variant="${variantIndex}"]`);
            const colorTemplate = `
                <div class="product-detail__color-item" data-color="${colorIndex}">
                    <div class="product-detail__form-row">
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Màu sắc</label>
                            <select class="product-detail__select" name="variants[${variantIndex}][colors][${colorIndex}][color_id]" required>
                                <option value="">Chọn màu</option>
                                <?php foreach ($colors as $color): ?>
                                    <option value="<?php echo htmlspecialchars($color['id']); ?>">
                                        <?php echo htmlspecialchars($color['name']) . ' (' . htmlspecialchars($color['hex_code']) . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="product-detail__form-group">
                            <label class="product-detail__label">Số lượng</label>
                            <input type="number" class="product-detail__input" name="variants[${variantIndex}][colors][${colorIndex}][stock_quantity]" placeholder="Số lượng" required>
                        </div>
                    </div>
                    <div class="product-detail__form-group">
                        <input type="checkbox" id="isActive_${variantIndex}_${colorIndex}" name="variants[${variantIndex}][colors][${colorIndex}][is_active]" value="1" checked>
                        <label for="isActive_${variantIndex}_${colorIndex}">Kích hoạt</label>
                    </div>
                    <div class="product-detail__color-gallery" data-variant="${variantIndex}" data-color="${colorIndex}"></div>
                    <button type="button" class="product-detail__btn product-detail__btn--outline add-image" data-variant="${variantIndex}" data-color="${colorIndex}">
                        <i class="fas fa-plus"></i> Thêm ảnh
                    </button>
                    <button type="button" class="product-detail__btn product-detail__btn--outline remove-color" data-variant="${variantIndex}" data-color="${colorIndex}">
                        <i class="fas fa-trash"></i> Xóa màu
                    </button>
                </div>`;
            colorsContainer.insertAdjacentHTML('beforeend', colorTemplate);
        }

        function addImage(variantIndex, colorIndex) {
            const imageIndex = document.querySelectorAll(`.product-detail__color-gallery[data-variant="${variantIndex}"][data-color="${colorIndex}"] .product-detail__form-group`).length;
            const galleryContainer = document.querySelector(`.product-detail__color-gallery[data-variant="${variantIndex}"][data-color="${colorIndex}"]`);
            const imageTemplate = `
                <div class="product-detail__form-group" data-image="${imageIndex}">
                    <label class="product-detail__label">Ảnh màu</label>
                    <input type="file" name="variants[${variantIndex}][colors][${colorIndex}][images][${imageIndex}][file]" accept="image/*" class="product-detail__input">
                    <input type="text" class="product-detail__input" name="variants[${variantIndex}][colors][${colorIndex}][images][${imageIndex}][gallery_image_alt]" placeholder="Mô tả ảnh">
                    <input type="hidden" name="variants[${variantIndex}][colors][${colorIndex}][images][${imageIndex}][sort_order]" value="${imageIndex}">
                    <button type="button" class="product-detail__btn product-detail__btn--outline remove-image" data-variant="${variantIndex}" data-color="${colorIndex}" data-image="${imageIndex}">
                        <i class="fas fa-trash"></i> Xóa ảnh
                    </button>
                </div>`;
            galleryContainer.insertAdjacentHTML('beforeend', imageTemplate);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('add-variant')) {
                    addVariant();
                } else if (e.target.classList.contains('add-color') || e.target.parentElement.classList.contains('add-color')) {
                    const variantIndex = e.target.dataset.variant || e.target.parentElement.dataset.variant;
                    addColor(variantIndex);
                } else if (e.target.classList.contains('add-image') || e.target.parentElement.classList.contains('add-image')) {
                    const variantIndex = e.target.dataset.variant || e.target.parentElement.dataset.variant;
                    const colorIndex = e.target.dataset.color || e.target.parentElement.dataset.color;
                    addImage(variantIndex, colorIndex);
                } else if (e.target.classList.contains('remove-variant') || e.target.parentElement.classList.contains('remove-variant')) {
                    const variantIndex = e.target.dataset.variant || e.target.parentElement.dataset.variant;
                    document.querySelector(`.product-detail__variant-item[data-variant="${variantIndex}"]`).remove();
                    delete colorIndices[variantIndex];
                } else if (e.target.classList.contains('remove-color') || e.target.parentElement.classList.contains('remove-color')) {
                    const variantIndex = e.target.dataset.variant || e.target.parentElement.dataset.variant;
                    const colorIndex = e.target.dataset.color || e.target.parentElement.dataset.color;
                    document.querySelector(`.product-detail__color-item[data-color="${colorIndex}"]`).remove();
                } else if (e.target.classList.contains('remove-image') || e.target.parentElement.classList.contains('remove-image')) {
                    const variantIndex = e.target.dataset.variant || e.target.parentElement.dataset.variant;
                    const colorIndex = e.target.dataset.color || e.target.parentElement.dataset.color;
                    const imageIndex = e.target.dataset.image || e.target.parentElement.dataset.image;
                    document.querySelector(`.product-detail__color-gallery[data-variant="${variantIndex}"][data-color="${colorIndex}"] .product-detail__form-group[data-image="${imageIndex}"]`).remove();
                }
            });

            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const subcategories = <?php echo json_encode($subcategories); ?>;

            categorySelect.addEventListener('change', () => {
                const categoryId = categorySelect.value;
                subcategorySelect.innerHTML = '<option value="">Chọn danh mục phụ</option>';
                subcategories.forEach(sub => {
                    if (sub.category_id == categoryId) {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name;
                        subcategorySelect.appendChild(option);
                    }
                });
            });
        });
    </script>
</body>
</html>