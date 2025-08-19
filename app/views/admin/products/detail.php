<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?= htmlspecialchars($product['name'] ?? '') ?></title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <?php echo '<pre>'; echo print_r($product, true); echo '</pre>'; ?>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <!-- Notifications -->
        <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
            <div class="notification notification--success" id="success-notification">
                <p><?= htmlspecialchars($_GET['success']) ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
            <div class="notification notification--error" id="error-notification">
                <p><?= htmlspecialchars($_GET['error']) ?></p>
            </div>
        <?php endif; ?>
        <div class="product-detail">
            <div class="product-detail__header">
            <h1 class="product-detail__heading">Sản phẩm chi tiết</h1>
            <a href="/admin/products/update?id=<?= htmlspecialchars($product['product_id'] ?? '') ?>"
                class="product-detail-btn product-detail-btn--edit">
                <i class="fas fa-edit"></i> Chỉnh sửa
            </a>
            </div>
            <div class="product-detail__container">
                <div class="product-detail__layout">
                    <!-- Left side - Images -->
                    <div class="product-detail__images">
                        <div class="product-detail__main-image">
                            <img src="/img/default.png" alt="<?= htmlspecialchars($product['name'] ?? '') ?>" class="product-detail__main-img" id="mainImage">
                        </div>
                        <div class="product-detail__thumbnails" id="thumbnailContainer">
                            <!-- Thumbnails will be rendered by JavaScript -->
                        </div>
                    </div>
                    <!-- Right side - Product info -->
                    <div class="product-detail__info">
                        <h1 class="product-detail__title">
                            <?= htmlspecialchars($product['name'] ?? '') ?>
                        </h1>
                        
                        <div class="product-detail__rating">
                            <div class="product-detail__stars">★★★★★</div>
                            <div class="product-detail__rating-text">
                                <span>234 đánh giá</span>
                                <span>Đã bán 234</span>
                            </div>
                        </div>

                        <div class="product-detail__price">
                            <div class="product-detail__current-price" id="currentPrice">
                                <!-- Price will be updated by JavaScript -->
                            </div>
                            <div class="product-detail__price-info">
                                <?php 
                                $basePrice = 0;
                                if (!empty($product['variants'])) {
                                    $basePrice = $product['variants'][0]['price_original'] ?? 0;
                                }
                                ?>
                                <span class="product-detail__original-price"><?= number_format($basePrice, 0, ',', '.') ?> đ</span>
                                <span class="product-detail__discount">-15%</span>
                            </div>
                        </div>

                        <div class="product-detail__variants">
                            <!-- Color selection -->
                            <div class="product-detail__variant-group">
                                <label class="product-detail__variant-label">Màu sắc:</label>
                                <div class="product-detail__colors" id="colorOptions">
                                    <!-- Colors will be rendered by JavaScript -->
                                </div>
                            </div>
                            
                            <!-- Capacity selection -->
                            <div class="product-detail__variant-group">
                                <label class="product-detail__variant-label">Dung lượng:</label>
                                <div class="product-detail__capacities" id="capacityOptions">
                                    <!-- Capacities will be rendered by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <div class="product-detail__stock" id="stockInfo">
                            <!-- Stock info will be updated by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Product features -->
                <div class="product-detail__features">
                    <h3 class="product-detail__section-title">Điểm nổi bật sản phẩm:</h3>
                    <ul class="product-detail__feature-list">
                        <?php if (empty($product['descriptions'])): ?>
                            <li class="product-detail__feature-item">Chưa có mô tả chi tiết.</li>
                        <?php else: ?>
                            <?php foreach ($product['descriptions'] as $desc): ?>
                                <li class="product-detail__feature-item"><?= htmlspecialchars($desc['description'] ?? '') ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Product specifications -->
                <div class="product-detail__specs">
                    <h3 class="product-detail__section-title">Thông số kỹ thuật</h3>
                    <div class="product-detail__specs-grid">
                        <?php if (empty($product['specs'])): ?>
                            <div class="product-detail__spec-item">
                                <div class="product-detail__spec-icon"><i class="fas fa-microchip"></i></div>
                                <div class="product-detail__spec-name">Chưa có thông số</div>
                                <div class="product-detail__spec-value">-</div>
                            </div>
                        <?php else: ?>
                            <?php 
                            $specIcons = [
                                'Màn hình' => 'fas fa-tv',
                                'Chip xử lý' => 'fas fa-microchip',
                                'Camera' => 'fas fa-camera',
                                'Pin' => 'fas fa-battery-full',
                                'Bộ nhớ' => 'fas fa-memory',
                                'RAM' => 'fas fa-memory',
                                'Hệ điều hành' => 'fas fa-mobile-alt',
                                'Kết nối' => 'fas fa-wifi',
                                'Trọng lượng' => 'fas fa-weight',
                                'Màu sắc' => 'fas fa-palette'
                            ];
                            
                            foreach ($product['specs'] as $spec): 
                                $iconClass = 'fas fa-info-circle';
                                foreach ($specIcons as $keyword => $icon) {
                                    if (stripos($spec['spec_name'], $keyword) !== false) {
                                        $iconClass = $icon;
                                        break;
                                    }
                                }
                            ?>
                                <div class="product-detail__spec-item">
                                    <div class="product-detail__spec-icon"><i class="<?= $iconClass ?>"></i></div>
                                    <div class="product-detail__spec-name"><?= htmlspecialchars($spec['spec_name'] ?? '') ?></div>
                                    <div class="product-detail__spec-value"><?= htmlspecialchars($spec['spec_value'] ?? '') ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Policies -->
                <div class="product-detail__policies">
                    <h3 class="product-detail__section-title">Chính sách sản phẩm</h3>
                    <div class="product-detail__policy-grid">
                        <div class="product-detail__policy-item">
                            <div class="product-detail__policy-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="product-detail__policy-text">Hàng chính hãng - Bảo hành 12 tháng</div>
                        </div>
                        <div class="product-detail__policy-item">
                            <div class="product-detail__policy-icon"><i class="fas fa-user-shield"></i></div>
                            <div class="product-detail__policy-text">Kỹ thuật viên hỗ trợ trực tuyến</div>
                        </div>
                        <div class="product-detail__policy-item">
                            <div class="product-detail__policy-icon"><i class="fas fa-shipping-fast"></i></div>
                            <div class="product-detail__policy-text">Miễn phí giao hàng toàn quốc</div>
                        </div>
                        <div class="product-detail__policy-item">
                            <div class="product-detail__policy-icon"><i class="fas fa-undo-alt"></i></div>
                            <div class="product-detail__policy-text">Đổi trả trong 7 ngày nếu có lỗi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    // Product data from PHP
    const productData = <?= json_encode($product, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    console.log('Product data loaded:', productData);

    const variants = productData.variants || [];
    const images = productData.images || {};
    
    // Current state
    let selectedColor = null;
    let selectedCapacity = null;
    let currentVariant = null;

    // DOM elements
    const mainImage = document.getElementById('mainImage');
    const thumbnailContainer = document.getElementById('thumbnailContainer');
    const colorOptions = document.getElementById('colorOptions');
    const capacityOptions = document.getElementById('capacityOptions');
    const currentPrice = document.getElementById('currentPrice');
    const stockInfo = document.getElementById('stockInfo');

    // Utility functions
    function getUniqueCapacities() {
        const capacities = [...new Set(
            variants.map(v => v.attributes.find(a => a.option_name === 'Capacity')?.option_value)
        )].filter(Boolean);
        
        return capacities.sort((a, b) => {
            const numA = parseInt(a);
            const numB = parseInt(b);
            return numA - numB;
        });
    }

    function getUniqueColors() {
        return [...new Set(
            variants.map(v => v.attributes.find(a => a.option_name === 'Color')?.option_value)
        )].filter(Boolean);
    }

    function findVariantByAttributes(color, capacity) {
        return variants.find(variant => {
            const colorAttr = variant.attributes.find(a => a.option_name === 'Color')?.option_value;
            const capacityAttr = variant.attributes.find(a => a.option_name === 'Capacity')?.option_value;
            
            // ✅ FIX: Handle cases where capacity might be undefined
            if (capacity === null || capacity === undefined) {
                // If no capacity is selected/available, match only by color
                return colorAttr === color;
            }
            
            return colorAttr === color && capacityAttr === capacity;
        });
    }

    function getColorHexCode(colorName) {
        const colorMap = {
            'Black': '#1d1d1f',
            'White': '#f5f5f7', 
            'Blue': '#4A90E2',
            'Pink': '#FFB6C1',
            'Red': '#FF0000',
            'Green': '#228B22',
            'Purple': '#8A2BE2',
            'Yellow': '#FFD700',
            'Silver': '#C0C0C0',
            'Gold': '#FFD700'
        };
        return colorMap[colorName] || '#666666';
    }

    function getVariantImages(skuId) {
        return images[skuId] || null;
    }

    function findFallbackImagesByColor(color) {
        const sameColorVariants = variants.filter(variant => {
            const colorAttr = variant.attributes.find(a => a.option_name === 'Color')?.option_value;
            return colorAttr === color;
        });
        
        for (const variant of sameColorVariants) {
            const variantImages = getVariantImages(variant.sku_id);
            if (variantImages?.gallery_urls?.length > 0) {
                return variantImages;
            }
        }
        return null;
    }

    // Render functions
    function renderColorOptions() {
        const colors = getUniqueColors();
        colorOptions.innerHTML = '';
        
        colors.forEach((color, index) => {
            const colorElement = document.createElement('div');
            colorElement.className = 'product-detail__color';
            colorElement.style.backgroundColor = getColorHexCode(color);
            colorElement.title = color;
            colorElement.onclick = () => selectColor(color);
            
            if (index === 0 && !selectedColor) {
                colorElement.classList.add('product-detail__color--active');
            }
            
            colorOptions.appendChild(colorElement);
        });
    }

    function renderCapacityOptions() {
        const capacities = getUniqueCapacities();
        
        // ✅ FIX: Hide capacity section if no capacities available
        const capacityGroup = capacityOptions.closest('.product-detail__variant-group');
        if (capacities.length === 0) {
            if (capacityGroup) {
                capacityGroup.style.display = 'none';
            }
            return;
        }
        
        if (capacityGroup) {
            capacityGroup.style.display = 'block';
        }
        
        capacityOptions.innerHTML = '';
        
        capacities.forEach((capacity, index) => {
            const capacityElement = document.createElement('div');
            capacityElement.className = 'product-detail__capacity';
            capacityElement.textContent = capacity;
            capacityElement.onclick = () => selectCapacity(capacity);
            
            if (index === 0 && !selectedCapacity) {
                capacityElement.classList.add('product-detail__capacity--active');
            }
            
            capacityOptions.appendChild(capacityElement);
        });
    }

    function renderThumbnails() {
        thumbnailContainer.innerHTML = '';
        
        if (!currentVariant) return;
        
        let variantImages = getVariantImages(currentVariant.sku_id);
        
        // Fallback to same color images if current variant has no images
        if (!variantImages?.gallery_urls?.length && selectedColor) {
            variantImages = findFallbackImagesByColor(selectedColor);
        }
        
        if (!variantImages?.gallery_urls?.length) {
            console.log('No images found for variant:', currentVariant.sku_id);
            return;
        }
        
        variantImages.gallery_urls.forEach((imageUrl, index) => {
            const thumbnailDiv = document.createElement('div');
            thumbnailDiv.className = 'product-detail__thumbnail';
            
            if (index === 0) {
                thumbnailDiv.classList.add('product-detail__thumbnail--active');
            }
            
            const thumbnailImg = document.createElement('img');
            // Use thumbnail URL if available, otherwise use gallery URL
            const thumbnailUrl = variantImages.thumbnail_url?.[index] || imageUrl;
            thumbnailImg.src = `/img/products/thumbnails/${thumbnailUrl}`;
            thumbnailImg.alt = `${productData.name} - ${selectedColor} ${selectedCapacity || ''} - Ảnh ${index + 1}`;
            
            
            thumbnailImg.onclick = () => {
                const galleryImageSrc = `/img/products/gallery/${imageUrl}`;
                mainImage.src = galleryImageSrc;
                mainImage.alt = `${productData.name} - ${selectedColor} ${selectedCapacity || ''}`;
                
                // Update active thumbnail
                document.querySelectorAll('.product-detail__thumbnail').forEach(thumb => 
                    thumb.classList.remove('product-detail__thumbnail--active')
                );
                thumbnailDiv.classList.add('product-detail__thumbnail--active');
            };
            
            thumbnailDiv.appendChild(thumbnailImg);
            thumbnailContainer.appendChild(thumbnailDiv);
        });
    }

    // Selection functions
    function selectColor(color) {
        selectedColor = color;
        
        // Update active color
        const colors = getUniqueColors();
        document.querySelectorAll('.product-detail__color').forEach((element, index) => {
            element.classList.toggle('product-detail__color--active', colors[index] === color);
        });
        
        updateCurrentVariant();
    }

    function selectCapacity(capacity) {
        selectedCapacity = capacity;
        
        // Update active capacity
        const capacities = getUniqueCapacities();
        document.querySelectorAll('.product-detail__capacity').forEach((element, index) => {
            element.classList.toggle('product-detail__capacity--active', capacities[index] === capacity);
        });
        
        updateCurrentVariant();
    }

    // Update functions
    function updateCurrentVariant() {
        // ✅ FIX: Only require color if no capacities are available
        const hasCapacities = getUniqueCapacities().length > 0;
        
        if (!selectedColor) return;
        if (hasCapacities && !selectedCapacity) return;
        
        const foundVariant = findVariantByAttributes(selectedColor, selectedCapacity);
        
        if (!foundVariant) {
            console.warn(`No variant found for ${selectedColor} ${selectedCapacity || 'no capacity'}`);
            return;
        }
        
        currentVariant = foundVariant;
        console.log('Current variant updated:', currentVariant);
        updateProductDisplay();
    }

    function updateProductDisplay() {
        if (!currentVariant) return;
        
        // Update price
        updatePrice();
        
        // Update stock info
        updateStockInfo();
        
        // Update images
        updateImages();
    }

    function updatePrice() {
        if (!currentVariant.price_discount) return;
        
        const formattedPrice = new Intl.NumberFormat('vi-VN').format(currentVariant.price_discount);
        currentPrice.textContent = `${formattedPrice} đ`;
    }

    function updateStockInfo() {
        if (currentVariant.stock_quantity === undefined) return;
        
        const stockQuantity = currentVariant.stock_quantity;
        
        if (stockQuantity > 0) {
            stockInfo.innerHTML = `Còn lại: <strong>${stockQuantity}</strong> sản phẩm`;
            stockInfo.className = 'product-detail__stock';
        } else {
            stockInfo.innerHTML = `<strong>Hết hàng</strong>`;
            stockInfo.className = 'product-detail__stock product-detail__stock--out';
        }
    }

    function updateImages() {
        if (!currentVariant) return;
        
        let variantImages = getVariantImages(currentVariant.sku_id);
        
        // Fallback to same color images
        if (!variantImages?.gallery_urls?.length && selectedColor) {
            variantImages = findFallbackImagesByColor(selectedColor);
        }
        
        // Update main image
        if (variantImages?.gallery_urls?.length > 0) {
            const mainImageSrc = `/img/products/gallery/${variantImages.gallery_urls[0]}`;
            mainImage.src = mainImageSrc;
            mainImage.alt = `${productData.name} - ${selectedColor} ${selectedCapacity || ''}`;
        }
        renderThumbnails();
    }

    // Initialize the application
    function initializeApp() {
        console.log('Initializing product detail page...');
        
        if (!variants.length) {
            console.warn('No variants found');
            return;
        }
        
        // Render options
        renderColorOptions();
        renderCapacityOptions();
        
        // Set initial selections
        const colors = getUniqueColors();
        const capacities = getUniqueCapacities();
        
        if (colors.length > 0) {
            selectColor(colors[0]);
        }
        if (capacities.length > 0) {
            selectCapacity(capacities[0]);
        } else {
            setTimeout(() => {
                if (selectedColor && !currentVariant) {
                    updateCurrentVariant();
                }
            }, 100);
        }
    }
    initializeApp();
});
    </script>
</body>
</html>