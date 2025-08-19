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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="stylesheet" href="/css/admin/style-admin.css">
    <style>
    </style>
</head>
<body>
    <?php echo '<pre>'; print_r($colors); echo '</pre>'; ?>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="product-create">
            <div class="product-create__header">
                <h1 class="product-create__heading">
                    <i class="fas fa-plus-circle"></i> Tạo sản phẩm mới
                </h1>
                <a href="#" class="product-create-btn product-page__add-btn">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
            <form class="product-create__container" id="createProductForm" method="POST" action="/admin/products/handleCreate" enctype="multipart/form-data">
                <!-- Basic Information Section -->
                <div class="product-create__section">
                    <h3 class="product-create__section-title">
                        <i class="fas fa-info-circle"></i> Thông tin cơ bản
                    </h3>
                    
                    <div class="product-create__form-grid">
                        <div class="product-create__form-group">
                            <label class="product-create__label" for="productName">
                                Tên sản phẩm <span class="required">*</span>
                            </label>
                            <input class="product-create__input" 
                                   type="text" 
                                   id="productName" 
                                   name="product_name" 
                                   placeholder="VD: iPhone 15 Pro Max" 
                                   required>
                        </div>

                        <div class="product-create__form-group">
                           <label class="product-create__label" for="brand">
                                Thương hiệu <span class="required">*</span>
                            </label>
                            <select class="product-create__select" id="brand" name="brand_id" required>
                                <option value="">Chọn thương hiệu</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= htmlspecialchars($brand['brand_id']) ?>">
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="product-create__form-group">
                            <label class="product-create__label" for="category">
                                    Danh mục <span class="required">*</span>
                                </label>
                                <select id="category_id" name="category_id" class="product-create__select product-create__select--category" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($categories ?? [] as $category): ?>
                                        <option value="<?php echo $category['category_id']; ?>">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>

                        <div class="product-create__form-group">
                                <label class="product-create__label" for="subcategory_id">
                                    Danh mục phụ <span class="required">*</span>
                                </label>
                                <select class="product-create__select" id="subcategory_id" name="subcategory_id" required>
                                    <option value="">Chọn danh mục phụ</option>
                                </select>
                        </div>
                        <div class="product-create__form-group product-create__form-group--full">
                            <label class="product-create__label" for="productDescription">
                                Mô tả sản phẩm
                            </label>
                            <textarea class="product-create__textarea" 
                                      id="productDescription" 
                                      name="description_html" 
                                      rows="4"
                                      placeholder="Nhập mô tả chi tiết về sản phẩm, tính năng nổi bật..."></textarea>
                        </div>

                        <div class="product-create__form-group">
                            <div class="product-create__checkbox-group">
                                <input type="checkbox" id="isFeatured" name="is_featured" value="1">
                                <label class="product-create__label" for="isFeatured">
                                    Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Image Section -->
                <div class="product-create__section">
                    <h3 class="product-create__section-title">
                        <i class="fas fa-image"></i> Ảnh đại diện sản phẩm
                    </h3>
                    
                    <div class="product-create__image-upload">
                        <div class="product-create__image-preview" id="mainImagePreview">
                            <div class="product-create__upload-overlay">
                                <i class="fas fa-camera"></i>
                                <span>Chọn ảnh đại diện</span>
                            </div>
                        </div>
                        <input type="file" 
                               id="mainImageInput" 
                               name="main_image" 
                               accept="image/*" 
                               class="product-create__file-input" 
                               required>
                        <div class="product-create__form-group">
                            <label class="product-create__label">Mô tả ảnh</label>
                            <input type="text" 
                                   class="product-create__input" 
                                   name="media_alt" 
                                   placeholder="VD: iPhone 15 Pro Max màu Titan Tự Nhiên" 
                                   required>
                        </div>
                    </div>
                </div>
                <!-- Product Specifications Section -->
                <div class="product-create__section">
                    <h3 class="product-create__section-title">
                        <i class="fas fa-cogs"></i> Thông số kỹ thuật
                    </h3>
                    
                    <div class="product-create__dynamic-list" id="specsContainer">
                        <div class="product-create__list-item">
                            <input type="text" 
                                   class="product-create__input" 
                                   name="specs[0][name]" 
                                   placeholder="Tên thông số (VD: Màn hình)">
                            <input type="text" 
                                   class="product-create__input" 
                                   name="specs[0][value]" 
                                   placeholder="Giá trị (VD: 6.7 inch Super Retina XDR)">
                            <button type="button" class="product-create__btn product-create__btn--icon product-create__btn--danger remove-spec">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" class="product-create-btn product-create-btn--outline" id="addSpecBtn">
                        <i class="fas fa-plus"></i> Thêm thông số kỹ thuật
                    </button>
                </div>

                <!-- Product Variants Section -->
                <div class="product-create__section">
                    <h3 class="product-create__section-title">
                        <i class="fas fa-layer-group"></i> Biến thể sản phẩm
                    </h3>
                    <div class="product-create__variants-container" id="variantsContainer">
                        
                    </div>
                    <button type="button" class="product-create-btn product-create-btn--outline" id="addVariantBtn">
                        <i class="fas fa-plus"></i> Thêm biến thể mới
                    </button>
                </div>

                <!-- Submit Actions -->
                <div class="product-create__actions">
                    <button type="submit" class="product-create-btn product-create-btn--primary">
                        <i class="fas fa-save"></i> Tạo sản phẩm
                    </button>
                    <a href="#" class="product-create-btn product-create-btn--secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
    </main>
    <script>
        const colors = <?php echo json_encode($colors ?? []); ?>;
        const capacities = <?php echo json_encode($capacities ?? []); ?>;
    </script>
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
    <script type="module" src="/admin-ui/js/pages/product-create.js"></script>
</body>
</html>