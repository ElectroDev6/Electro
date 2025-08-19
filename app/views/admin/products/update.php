<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sản phẩm - <?php echo htmlspecialchars($product['name'] ?? 'Sản phẩm'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/admin/style-admin.css">

</head>
<body>
        <?php
        echo '<pre>';
        print_r($product);
        echo '</pre>';
        ?>
    <?php echo $htmlHeader; ?>
     <main class="wrapper">
         <?php echo $contentSidebar; ?>
        <div class="product-update">
            <div class="product-update__header">
                <div>
                    <h1 class="product-update__title">
                        <i class="fas fa-edit"></i>
                        Cập nhật sản phẩm
                    </h1>
                    <div class="product-update__breadcrumb">
                        <a href="/admin/products">Quản lý sản phẩm</a> / Cập nhật sản phẩm
                    </div>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="product-update__alert product-update__alert--error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="product-update__alert product-update__alert--success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="/admin/products/update/handle" enctype="multipart/form-data" class="product-update__form-container">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id'] ?? ''); ?>">
                <input type="hidden" name="is_featured" value="<?php echo htmlspecialchars($product['is_featured'] ?? ''); ?>">
                
                <!-- Basic Product Information -->
                <div class="product-update__section">
                    <h2 class="product-update__section-title">
                        <i class="fas fa-info-circle"></i>
                        Thông tin cơ bản
                    </h2>
                    <div class="product-update__form-row">
                        <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required" for="product_name">
                                Tên sản phẩm
                            </label>
                            <input type="text" 
                                id="product_name" 
                                name="product_name" 
                                class="product-update__input" 
                                value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" 
                                required>
                        </div>
                        <div class="product-update__form-group">
                            <label class="product-update__label" for="slug">
                                Slug (URL thân thiện)
                            </label>
                            <input type="text" 
                                id="slug" 
                                name="slug" 
                                class="product-update__input" 
                                value="<?php echo htmlspecialchars($product['slug'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="product-update__form-row--three">
                        <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required" for="brand_id">
                                Thương hiệu
                            </label>
                            <select id="brand_id" name="brand_id" class="product-update__select" required>
                                <option value="">-- Chọn thương hiệu --</option>
                                <?php foreach ($brands ?? [] as $brand): ?>
                                    <option value="<?php echo $brand['brand_id']; ?>" 
                                            <?php echo ($product['brand_id'] ?? '') == $brand['brand_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($brand['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                       <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required" for="category_id">
                                Danh mục
                            </label>
                            <select id="category_id" name="category_id" class="product-update__select" required onchange="updateSubcategories()">
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories ?? [] as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>" 
                                            <?php echo ($product['category_id'] ?? '') == $category['category_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="product-update__form-group">
                            <label class="product-update__label" for="subcategory_id">
                                Danh mục con
                            </label>
                            <select id="subcategory_id" name="subcategory_id" class="product-update__select">
                                <option value="">-- Chọn danh mục con --</option>
                                <?php foreach ($subcategories ?? [] as $subcategory): ?>
                                    <option value="<?php echo $subcategory['subcategory_id']; ?>" 
                                            <?php echo ($product['subcategory_id'] ?? '') == $subcategory['subcategory_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($subcategory['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product Descriptions -->
                <div class="product-update__section">
                    <h2 class="product-update__section-title">
                        <i class="fas fa-align-left"></i>
                        Mô tả sản phẩm
                    </h2>
                    <div class="product-update__descriptions" id="descriptions-container">
                        <?php 
                        $descriptions = $product['descriptions'] ?? [];
                        foreach ($descriptions as $index => $desc): 
                        ?>
                        <div class="product-update__description-item">
                            <div class="product-update__description-header">
                                <span class="product-update__description-title">Mô tả <?php echo $index + 1; ?></span>
                                <?php if (count($descriptions) > 1): ?>
                                <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeDescription(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="descriptions[<?php echo $index; ?>][content_id]" value="<?php echo htmlspecialchars($desc['content_id'] ?? ''); ?>">
                            <div class="product-update__form-group">
                                <label class="product-update__label">Nội dung mô tả</label>
                                <textarea name="descriptions[<?php echo $index; ?>][description]" 
                                        class="product-update__textarea" 
                                        rows="4"><?php echo htmlspecialchars($desc['description'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="product-update__form-group">
                                <label class="product-update__label">Hình ảnh mô tả</label>
                                <?php if (!empty($desc['image_url'])): ?>
                                    <div style="margin-bottom: 10px;">
                                        <img src="<?php echo htmlspecialchars($desc['image_url']); ?>" 
                                            class="product-update__current-image" 
                                            style="height: 80px; width: auto;">
                                        <input type="hidden" name="descriptions[<?php echo $index; ?>][current_image]" value="<?php echo htmlspecialchars($desc['image_url']); ?>">
                                    </div>
                                <?php endif; ?>
                                <input type="file" 
                                    name="descriptions[<?php echo $index; ?>][new_image]" 
                                    class="product-update__image-upload" 
                                    accept="image/*">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="button" class="product-update__btn product-update__btn--success" onclick="addDescription()">
                        <i class="fas fa-plus"></i>
                        Thêm mô tả
                    </button>
                </div>

                <!-- Product Specifications -->
                <div class="product-update__section">
                    <h2 class="product-update__section-title">
                        <i class="fas fa-cogs"></i>
                        Thông số kỹ thuật
                    </h2>
                    
                    <div class="product-update__specs-container" id="specs-container">
                        <?php 
                        $specs = $product['specs'] ?? [];
                        if (empty($specs)) {
                            $specs = [['spec_id' => null, 'spec_name' => '', 'spec_value' => '', 'display_order' => 1]];
                        }
                        foreach ($specs as $index => $spec): 
                        ?>
                        <div class="product-update__spec-item">
                            <input type="hidden" name="specs[<?php echo $index; ?>][spec_id]" value="<?php echo htmlspecialchars($spec['spec_id'] ?? ''); ?>">
                            
                            <div class="product-update__form-group">
                                <label class="product-update__label">Tên thông số</label>
                                <input type="text" 
                                    name="specs[<?php echo $index; ?>][spec_name]" 
                                    class="product-update__input" 
                                    value="<?php echo htmlspecialchars($spec['spec_name'] ?? ''); ?>" >
                            </div>
                            <div class="product-update__form-group">
                                <label class="product-update__label">Giá trị</label>
                                <input type="text" 
                                    name="specs[<?php echo $index; ?>][spec_value]" 
                                    class="product-update__input" 
                                    value="<?php echo htmlspecialchars($spec['spec_value'] ?? ''); ?>" >
                            </div>
                            
                            <div class="product-update__form-group">
                                <label class="product-update__label">Thứ tự</label>
                                <input type="number" 
                                    name="specs[<?php echo $index; ?>][display_order]" 
                                    class="product-update__input" 
                                    value="<?php echo htmlspecialchars($spec['display_order'] ?? ''); ?>" 
                                    min="1">
                            </div>
                            
                            <div>
                                <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeSpec(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <button type="button" class="product-update__add-spec-btn" onclick="addSpec()">
                        <i class="fas fa-plus"></i>
                        Thêm thông số
                    </button>
                </div>

                <!-- Product Variants -->
                <div class="product-update__section">
                    <h2 class="product-update__section-title">
                        <i class="fas fa-boxes"></i>
                        Biến thể sản phẩm
                    </h2>
                    
                    <div class="product-update__variants" id="variants-container">
                        <?php 
                        $variants = $product['variants'] ?? [];
                        if (empty($variants)) {
                            // Tạo một biến thể mặc định nếu chưa có
                            $variants = [['sku_id' => '', 'sku_code' => '', 'price_original' => '', 'stock_quantity' => '', 'is_default' => 1, 'attributes' => [], 'images' => []]];
                        }
                        foreach ($variants as $variantIndex => $variant): 
                        ?>
                        <div class="product-update__variant" data-variant-index="<?php echo $variantIndex; ?>">
                            <div class="product-update__variant-header">
                                <h3 class="product-update__variant-title">
                                    Biến thể <?php echo $variantIndex + 1; ?>: 
                                    <?php 
                                    $variantLabel = '';
                                    if (!empty($variant['attributes'])) {
                                        $attributes = array_map(function($attr) {
                                            return $attr['option_value'];
                                        }, $variant['attributes']);
                                        $variantLabel = implode(', ', $attributes);
                                    }
                                    echo htmlspecialchars($variantLabel ?: $variant['sku_code']);
                                    ?>
                                </h3>
                                <?php if (count($variants) > 1): ?>
                                <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeVariant(this)">
                                    <i class="fas fa-trash"></i>
                                    Xóa biến thể
                                </button>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-update__variant-content">
                                <input type="hidden" name="variants[<?php echo $variantIndex; ?>][sku_id]" value="<?php echo htmlspecialchars($variant['sku_id'] ?? ''); ?>">
                                
                                <!-- Basic Variant Info -->
                                <div class="product-update__variant-basic">
                                    <div class="product-update__form-group">
                                        <label class="product-update__label product-update__label--required">Mã SKU</label>
                                        <input type="text" 
                                            name="variants[<?php echo $variantIndex; ?>][sku_code]" 
                                            class="product-update__input" 
                                            value="<?php echo htmlspecialchars($variant['sku_code'] ?? ''); ?>" 
                                            required>
                                    </div>
                                    
                                    <div class="product-update__form-group">
                                        <label class="product-update__label product-update__label--required">Giá (VNĐ)</label>
                                        <input type="number" 
                                            name="variants[<?php echo $variantIndex; ?>][price]" 
                                            class="product-update__input" 
                                            value="<?php echo htmlspecialchars($variant['price_original'] ?? ''); ?>" 
                                            step="0.01" 
                                            min="0" 
                                            required>
                                    </div>
                                    
                                    <div class="product-update__form-group">
                                        <label class="product-update__label product-update__label--required">Số lượng</label>
                                        <input type="number" 
                                            name="variants[<?php echo $variantIndex; ?>][stock_quantity]" 
                                            class="product-update__input" 
                                            value="<?php echo htmlspecialchars($variant['stock_quantity'] ?? ''); ?>" 
                                            min="0" 
                                            required>
                                    </div>
                                    
                                    <div class="product-update__form-group">
                                        <label class="product-update__label">
                                            <input type="checkbox" 
                                                name="variants[<?php echo $variantIndex; ?>][is_default]" 
                                                value="1" 
                                                class="variant-default-checkbox"
                                                <?php echo !empty($variant['is_default']) ? 'checked' : ''; ?>>
                                            Biến thể mặc định
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Variant Attributes -->
                                <div class="product-update__subsection-title">Thuộc tính biến thể</div>
                                <div class="product-update__attributes-grid">
                                    <!-- Color Attribute -->
                                    <div class="product-update__attribute-group">
                                        <label class="product-update__label">Màu sắc</label>
                                        <select name="variants[<?php echo $variantIndex; ?>][attributes][color]" class="product-update__select">
                                            <option value="">-- Chọn màu --</option>
                                            <?php 
                                            $currentColor = '';
                                            if (!empty($variant['attributes'])) {
                                                foreach ($variant['attributes'] as $attr) {
                                                    if ($attr['option_name'] === 'Color') {
                                                        $currentColor = $attr['option_value'];
                                                        break;
                                                    }
                                                }
                                            }
                                            foreach ($colors ?? [] as $color): 
                                            ?>
                                                <option value="<?php echo htmlspecialchars($color['name']); ?>" 
                                                        <?php echo $currentColor === $color['name'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($color['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <!-- Capacity Attribute -->
                                    <div class="product-update__attribute-group">
                                        <label class="product-update__label">Dung lượng</label>
                                        <select name="variants[<?php echo $variantIndex; ?>][attributes][capacity]" class="product-update__select">
                                            <option value="">-- Chọn dung lượng --</option>
                                            <?php 
                                            $currentCapacity = '';
                                            if (!empty($variant['attributes'])) {
                                                foreach ($variant['attributes'] as $attr) {
                                                    if ($attr['option_name'] === 'Capacity') {
                                                        $currentCapacity = $attr['option_value'];
                                                        break;
                                                    }
                                                }
                                            }
                                            foreach ($capacities ?? [] as $capacity): 
                                            ?>
                                                <option value="<?php echo htmlspecialchars($capacity['name']); ?>" 
                                                        <?php echo $currentCapacity === $capacity['name'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($capacity['name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <!-- RAM Attribute -->
                                    <div class="product-update__attribute-group">
                                        <label class="product-update__label">RAM</label>
                                        <input type="text" 
                                            name="variants[<?php echo $variantIndex; ?>][attributes][ram]" 
                                            class="product-update__input" 
                                            value="<?php 
                                            $currentRAM = '';
                                            if (!empty($variant['attributes'])) {
                                                foreach ($variant['attributes'] as $attr) {
                                                    if ($attr['option_name'] === 'RAM') {
                                                        $currentRAM = $attr['option_value'];
                                                        break;
                                                    }
                                                }
                                            }
                                            echo htmlspecialchars($currentRAM);
                                            ?>" 
                                            placeholder="VD: 8GB">
                                    </div>
                                    
                                    <!-- CPU Attribute -->
                                    <div class="product-update__attribute-group">
                                        <label class="product-update__label">CPU</label>
                                        <input type="text" 
                                            name="variants[<?php echo $variantIndex; ?>][attributes][cpu]" 
                                            class="product-update__input" 
                                            value="<?php 
                                            $currentCPU = '';
                                            if (!empty($variant['attributes'])) {
                                                foreach ($variant['attributes'] as $attr) {
                                                    if ($attr['option_name'] === 'CPU') {
                                                        $currentCPU = $attr['option_value'];
                                                        break;
                                                    }
                                                }
                                            }
                                            echo htmlspecialchars($currentCPU);
                                            ?>" 
                                            placeholder="VD: A15 Bionic">
                                    </div>
                                    
                                    <!-- Screen Size Attribute -->
                                    <div class="product-update__attribute-group">
                                        <label class="product-update__label">Kích thước màn hình</label>
                                        <input type="text" 
                                            name="variants[<?php echo $variantIndex; ?>][attributes][screen_size]" 
                                            class="product-update__input" 
                                            value="<?php 
                                            $currentScreenSize = '';
                                            if (!empty($variant['attributes'])) {
                                                foreach ($variant['attributes'] as $attr) {
                                                    if ($attr['option_name'] === 'Screen Size') {
                                                        $currentScreenSize = $attr['option_value'];
                                                        break;
                                                    }
                                                }
                                            }
                                            echo htmlspecialchars($currentScreenSize);
                                            ?>" 
                                            placeholder="VD: 6.1 inch">
                                    </div>
                                </div>
                                
                                <!-- Variant Images -->
                                <div class="product-update__image-section">
                                    <div class="product-update__subsection-title">Hình ảnh biến thể</div>
                                    <div class="product-update__image-grid">
                                        <?php 
                                        $images = $variant['images'] ?? [];
                                        // Ensure we have at least 4 image slots
                                        for ($i = 0; $i < max(4, count($images)); $i++): 
                                        ?>
                                        <div class="product-update__image-item <?php echo isset($images[$i]) ? 'product-update__image-item--has-image' : ''; ?>">
                                            <?php if (isset($images[$i])): ?>
                                                <img src="/img/products/gallery/<?php echo htmlspecialchars($images[$i]); ?>" 
                                                    class="product-update__current-image">
                                                <input type="hidden" 
                                                    name="variants[<?php echo $variantIndex; ?>][current_images][]" 
                                                    value="<?php echo htmlspecialchars($images[$i]); ?>">
                                                <button type="button" 
                                                        class="product-update__image-remove" 
                                                        onclick="removeImage(this)">×</button>
                                            <?php endif; ?>
                                            <input type="file" 
                                                name="variants[<?php echo $variantIndex; ?>][new_images][]" 
                                                class="product-update__image-upload" 
                                                accept="image/*">
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Add Variant Button -->
                    <button type="button" class="product-update__btn product-update__btn--success" onclick="addVariant()">
                        <i class="fas fa-plus"></i>
                        Thêm biến thể
                    </button>
                </div>

                <!-- Form Actions -->
                <div class="product-update__form-actions">
                    <a href="/admin/products" class="product-update__btn product-update__btn--outline">
                        <i class="fas fa-arrow-left"></i>
                        Hủy
                    </a>
                    <button type="submit" class="product-update__btn product-update__btn--primary">
                        <i class="fas fa-save"></i>
                        Cập nhật sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </main>
    <script>
        // Dynamic Description Management
        let descriptionIndex = <?php echo count($product['descriptions'] ?? []) - 1; ?>;
        
        function addDescription() {
            descriptionIndex++;
            const container = document.getElementById('descriptions-container');
            const newDescription = document.createElement('div');
            newDescription.className = 'product-update__description-item';
            newDescription.innerHTML = `
                <div class="product-update__description-header">
                    <span class="product-update__description-title">Mô tả ${descriptionIndex + 1}</span>
                    <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeDescription(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <input type="hidden" name="descriptions[${descriptionIndex}][content_id]" value="">
                
                <div class="product-update__form-group">
                    <label class="product-update__label">Nội dung mô tả</label>
                    <textarea name="descriptions[${descriptionIndex}][description]" 
                            class="product-update__textarea" 
                            rows="4"></textarea>
                </div>
                
                <div class="product-update__form-group">
                    <label class="product-update__label">Hình ảnh mô tả</label>
                    <input type="file" 
                           name="descriptions[${descriptionIndex}][new_image]" 
                           class="product-update__image-upload" 
                           accept="image/*">
                </div>
            `;
            container.appendChild(newDescription);
        }
        
        function removeDescription(button) {
            if (document.querySelectorAll('.product-update__description-item').length > 1) {
                button.closest('.product-update__description-item').remove();
                updateDescriptionLabels();
            }
        }
        
        function updateDescriptionLabels() {
            const descriptions = document.querySelectorAll('.product-update__description-item');
            descriptions.forEach((desc, index) => {
                const title = desc.querySelector('.product-update__description-title');
                if (title) {
                    title.textContent = `Mô tả ${index + 1}`;
                }
            });
        }
        
        // Dynamic Specifications Management
        let specIndex = <?php echo count($product['specs'] ?? []) - 1; ?>;
        
        function addSpec() {
            specIndex++;
            const container = document.getElementById('specs-container');
            const newSpec = document.createElement('div');
            newSpec.className = 'product-update__spec-item';
            newSpec.innerHTML = `
                <input type="hidden" name="specs[${specIndex}][spec_id]" value="">
                
                <div class="product-update__form-group">
                    <label class="product-update__label">Tên thông số</label>
                    <input type="text" 
                           name="specs[${specIndex}][spec_name]" 
                           class="product-update__input" 
                           placeholder="VD: Màn hình">
                </div>
                
                <div class="product-update__form-group">
                    <label class="product-update__label">Giá trị</label>
                    <input type="text" 
                           name="specs[${specIndex}][spec_value]" 
                           class="product-update__input" 
                           placeholder="VD: 6.1 inch">
                </div>
                
                <div class="product-update__form-group">
                    <label class="product-update__label">Thứ tự</label>
                    <input type="number" 
                           name="specs[${specIndex}][display_order]" 
                           class="product-update__input" 
                           value="${specIndex + 1}" 
                           min="1">
                </div>
                
                <div>
                    <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeSpec(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(newSpec);
        }
        
        function removeSpec(button) {
            if (document.querySelectorAll('.product-update__spec-item').length > 1) {
                button.closest('.product-update__spec-item').remove();
            }
        }
        
        // Dynamic Variant Management
        let variantIndex = <?php echo count($product['variants'] ?? []) - 1; ?>;
        
        function addVariant() {
            variantIndex++;
            const container = document.getElementById('variants-container');
            const newVariant = document.createElement('div');
            newVariant.className = 'product-update__variant';
            newVariant.setAttribute('data-variant-index', variantIndex);
            
            newVariant.innerHTML = `
                <div class="product-update__variant-header">
                    <h3 class="product-update__variant-title">Biến thể ${variantIndex + 1}</h3>
                    <button type="button" class="product-update__btn product-update__btn--danger btn-sm" onclick="removeVariant(this)">
                        <i class="fas fa-trash"></i>
                        Xóa biến thể
                    </button>
                </div>
                
                <div class="product-update__variant-content">
                    <input type="hidden" name="variants[${variantIndex}][sku_id]" value="">
                    
                    <!-- Basic Variant Info -->
                    <div class="product-update__variant-basic">
                        <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required">Mã SKU</label>
                            <input type="text" 
                                name="variants[${variantIndex}][sku_code]" 
                                class="product-update__input" 
                                placeholder="VD: SKU-001"
                                required>
                        </div>
                        
                        <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required">Giá (VNĐ)</label>
                            <input type="number" 
                                name="variants[${variantIndex}][price]" 
                                class="product-update__input" 
                                step="0.01" 
                                min="0" 
                                placeholder="0"
                                required>
                        </div>
                        
                        <div class="product-update__form-group">
                            <label class="product-update__label product-update__label--required">Số lượng</label>
                            <input type="number" 
                                name="variants[${variantIndex}][stock_quantity]" 
                                class="product-update__input" 
                                min="0" 
                                placeholder="0"
                                required>
                        </div>
                        
                        <div class="product-update__form-group">
                            <label class="product-update__label">
                                <input type="checkbox" 
                                    name="variants[${variantIndex}][is_default]" 
                                    value="1" 
                                    class="variant-default-checkbox">
                                Biến thể mặc định
                            </label>
                        </div>
                    </div>
                    
                    <!-- Variant Attributes -->
                    <div class="product-update__subsection-title">Thuộc tính biến thể</div>
                    <div class="product-update__attributes-grid">
                        <!-- Color Attribute -->
                        <div class="product-update__attribute-group">
                            <label class="product-update__label">Màu sắc</label>
                            <select name="variants[${variantIndex}][attributes][color]" class="product-update__select">
                                <option value="">-- Chọn màu --</option>
                                <?php foreach ($colors ?? [] as $color): ?>
                                    <option value="<?php echo htmlspecialchars($color['name']); ?>">
                                        <?php echo htmlspecialchars($color['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Capacity Attribute -->
                        <div class="product-update__attribute-group">
                            <label class="product-update__label">Dung lượng</label>
                            <select name="variants[${variantIndex}][attributes][capacity]" class="product-update__select">
                                <option value="">-- Chọn dung lượng --</option>
                                <?php foreach ($capacities ?? [] as $capacity): ?>
                                    <option value="<?php echo htmlspecialchars($capacity['name']); ?>">
                                        <?php echo htmlspecialchars($capacity['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- RAM Attribute -->
                        <div class="product-update__attribute-group">
                            <label class="product-update__label">RAM</label>
                            <input type="text" 
                                name="variants[${variantIndex}][attributes][ram]" 
                                class="product-update__input" 
                                placeholder="VD: 8GB">
                        </div>
                        
                        <!-- CPU Attribute -->
                        <div class="product-update__attribute-group">
                            <label class="product-update__label">CPU</label>
                            <input type="text" 
                                name="variants[${variantIndex}][attributes][cpu]" 
                                class="product-update__input" 
                                placeholder="VD: A15 Bionic">
                        </div>
                        
                        <!-- Screen Size Attribute -->
                        <div class="product-update__attribute-group">
                            <label class="product-update__label">Kích thước màn hình</label>
                            <input type="text" 
                                name="variants[${variantIndex}][attributes][screen_size]" 
                                class="product-update__input" 
                                placeholder="VD: 6.1 inch">
                        </div>
                    </div>
                    
                    <!-- Variant Images -->
                    <div class="product-update__image-section">
                        <div class="product-update__subsection-title">Hình ảnh biến thể</div>
                        <div class="product-update__image-grid">
                            <div class="product-update__image-item">
                                <input type="file" 
                                    name="variants[${variantIndex}][new_images][]" 
                                    class="product-update__image-upload" 
                                    accept="image/*">
                            </div>
                            <div class="product-update__image-item">
                                <input type="file" 
                                    name="variants[${variantIndex}][new_images][]" 
                                    class="product-update__image-upload" 
                                    accept="image/*">
                            </div>
                            <div class="product-update__image-item">
                                <input type="file" 
                                    name="variants[${variantIndex}][new_images][]" 
                                    class="product-update__image-upload" 
                                    accept="image/*">
                            </div>
                            <div class="product-update__image-item">
                                <input type="file" 
                                    name="variants[${variantIndex}][new_images][]" 
                                    class="product-update__image-upload" 
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            
            container.appendChild(newVariant);
            updateVariantLabels();
        }
        
        function removeVariant(button) {
            const variants = document.querySelectorAll('.product-update__variant');
            if (variants.length > 1) {
                button.closest('.product-update__variant').remove();
                updateVariantLabels();
                updateDefaultCheckboxes();
            } else {
                alert('Phải có ít nhất một biến thể cho sản phẩm');
            }
        }
        
        function updateVariantLabels() {
            const variants = document.querySelectorAll('.product-update__variant');
            variants.forEach((variant, index) => {
                const title = variant.querySelector('.product-update__variant-title');
                if (title) {
                    const currentText = title.textContent;
                    const colonIndex = currentText.indexOf(':');
                    const suffix = colonIndex > -1 ? currentText.substring(colonIndex) : '';
                    title.textContent = `Biến thể ${index + 1}${suffix}`;
                }
                
                // Update variant index attribute
                variant.setAttribute('data-variant-index', index);
            });
        }
        
        function updateDefaultCheckboxes() {
            const checkboxes = document.querySelectorAll('.variant-default-checkbox');
            
            // Ensure only one default variant is selected
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach((otherCheckbox, otherIndex) => {
                            if (otherIndex !== index) {
                                otherCheckbox.checked = false;
                            }
                        });
                    }
                });
            });
        }
        
        // Image Management
        function removeImage(button) {
            const imageItem = button.closest('.product-update__image-item');
            const img = imageItem.querySelector('.product-update__current-image');
            const hiddenInput = imageItem.querySelector('input[type="hidden"]');
            
            if (img) img.remove();
            if (hiddenInput) hiddenInput.remove();
            if (button) button.remove();
            
            imageItem.classList.remove('product-update__image-item--has-image');
        }
        
        // Category-Subcategory Dynamic Loading
        function updateSubcategories() {
            const categoryId = document.getElementById('category_id').value;
            
            const subcategorySelect = document.getElementById('subcategory_id');
            subcategorySelect.innerHTML = '<option value="">-- Chọn danh mục con --</option>';
            if (categoryId) {
                // Sử dụng route mới /admin/categories/subcategories
                fetch(`/admin/categories/subcategories?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error('Lỗi:', data.error);
                            return;
                        }
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.subcategory_id;
                            option.text = item.name;
                            subcategorySelect.appendChild(option);
                        });
                        const currentSubcategoryId = '<?php echo $product['subcategory_id'] ?? ''; ?>';
                        if (currentSubcategoryId) {
                            subcategorySelect.value = currentSubcategoryId;
                        }
                    })
                    .catch(error => console.error('Error fetching subcategories:', error));
            }
        }
        
        // Form Validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const productName = document.getElementById('product_name').value.trim();
            const brandId = document.getElementById('brand_id').value;
            const categoryId = document.getElementById('category_id').value;
            
            if (!productName) {
                alert('Vui lòng nhập tên sản phẩm');
                e.preventDefault();
                return;
            }
            
            if (!brandId) {
                alert('Vui lòng chọn thương hiệu');
                e.preventDefault();
                return;
            }
            
            if (!categoryId) {
                alert('Vui lòng chọn danh mục');
                e.preventDefault();
                return;
            }
            
            // Validate variants
            const variants = document.querySelectorAll('.product-update__variant');
            let hasValidVariant = false;
            let hasDefaultVariant = false;
            
            variants.forEach(function(variant) {
                const skuCode = variant.querySelector('input[name*="[sku_code]"]').value.trim();
                const price = variant.querySelector('input[name*="[price]"]').value;
                const stockQuantity = variant.querySelector('input[name*="[stock_quantity]"]').value;
                const isDefault = variant.querySelector('input[name*="[is_default]"]').checked;
                
                if (skuCode && price && stockQuantity) {
                    hasValidVariant = true;
                }
                
                if (isDefault) {
                    hasDefaultVariant = true;
                }
            });
            
            if (!hasValidVariant) {
                alert('Vui lòng nhập thông tin cho ít nhất một biến thể sản phẩm');
                e.preventDefault();
                return;
            }
            
            if (!hasDefaultVariant) {
                alert('Vui lòng chọn một biến thể làm mặc định');
                e.preventDefault();
                return;
            }
        });
        
        // Initialize default checkbox behavior
        document.addEventListener('DOMContentLoaded', function() {
            updateDefaultCheckboxes();
        });
    </script>
</body>
</html>