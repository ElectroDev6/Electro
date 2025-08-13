<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
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
                
                <div class="product-detail__product-view">
                    <!-- Left - Images -->
                    <div class="product-detail__product-image">
                        <div class="product-detail__box-preview">
                            <img src="" alt="" class="product-detail__main-img" id="mainImage">
                        </div>
                        <div class="product-detail__image-thumbnails" id="thumbnailContainer">
                            <!-- JS sẽ render thumbnails -->
                        </div>
                    </div>
                    
                    <!-- Right - Product Info -->
                    <div class="product-detail__product-info">
                        <h1 class="product-detail__product-title">
                            <?= htmlspecialchars($product['product_name'] ?? '') ?>
                        </h1>
                        
                        <div class="rating-section">
                            <div class="stars">★★★★★</div>
                            <span>234 đánh giá</span>
                            <span>Đã bán 234</span>
                        </div>

                        <div class="product-detail__price-section">
                            <div class="product-detail__current-price" id="currentPrice">
                                <!-- JS sẽ cập nhật giá -->
                            </div>
                            <span class="original-price">20.490.000 đ</span>
                            <span class="discount-badge">-15%</span>
                        </div>

                        <div class="product-detail__variant-selector">
                            <label class="product-detail__variant-label">Màu sắc:</label>
                            <div class="product-detail__color-options" id="colorOptions">
                                <!-- JS sẽ render màu sắc -->
                            </div>
                        </div>
                        
                        <div class="product-detail__variant-selector">
                            <label class="product-detail__variant-label">Dung lượng:</label>
                            <div class="product-detail__size-options" id="sizeOptions">
                                <!-- JS sẽ render dung lượng -->
                            </div>
                        </div>
                        <div class="product-detail__stock-info" id="stockInfo">
                            <!-- JS sẽ cập nhật số lượng kho -->
                        </div>
                    </div>
                </div>

                <!-- Product Features -->
                <div class="product-features">
                    <h3 class="features-title">Điểm nổi bật sản phẩm:</h3>
                    <ul class="features-list">
                        <li>Màn hình Super Retina XDR 6.1 inch</li>
                        <li>Chip Apple A15 Bionic mạnh mẽ</li>
                        <li>Camera kép 12MP (Wide & Ultra Wide)</li>
                        <li>Hỗ trợ 5G và HDR Display</li>
                    </ul>
                </div>

                <!-- Specs Section -->
                <div class="specs-section">
                    <h3 class="features-title">Thông số nổi bật</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <div class="spec-icon"><i class="fas fa-microchip"></i></div>
                            <div>Chip</div>
                            <div>Apple A15 Bionic</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-icon"><i class="fas fa-mobile-alt"></i></div>
                            <div>Kích thước màn hình</div>
                            <div>6.1 inch</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-icon"><i class="fas fa-battery-three-quarters"></i></div>
                            <div>Thời lượng pin</div>
                            <div>22 Giờ</div>
                        </div>
                    </div>
                </div>

                <!-- Policy Section -->
                <div class="policy-section">
                    <h3 class="features-title">Chính sách sản phẩm</h3>
                    <div class="policy-grid">
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-shield-alt"></i></div>
                            <div>Hàng chính hãng - Bảo hành 12 tháng</div>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-shipping-fast"></i></div>
                            <div>Miễn phí giao hàng toàn quốc</div>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-user-shield"></i></div>
                            <div>Kỹ thuật viên hỗ trợ trực tuyến</div>
                        </div>
                        <div class="policy-item">
                            <div class="policy-icon"><i class="fas fa-undo-alt"></i></div>
                            <div>Đổi trả trong 7 ngày nếu có lỗi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dữ liệu từ PHP
    let productData = <?= json_encode($product, JSON_UNESCAPED_SLASHES) ?>;
    let variants = productData.variants || [];
    
    // State
    let selectedColor = null;
    let selectedCapacity = null;
    let currentVariant = null;

    // DOM elements
    const mainImage = document.getElementById('mainImage');
    const thumbnailContainer = document.getElementById('thumbnailContainer');
    const colorOptions = document.getElementById('colorOptions');
    const sizeOptions = document.getElementById('sizeOptions');
    const currentPrice = document.getElementById('currentPrice');
    const stockInfo = document.getElementById('stockInfo');

    // Helper functions
    function getCapacities() {
        return [...new Set(variants.map(v => v.attributes.Capacity))].sort((a, b) => parseInt(a) - parseInt(b));
    }

    function getColors() {
        return [...new Set(variants.map(v => v.attributes.Color))];
    }

    function findVariant(color, capacity) {
        return variants.find(v => v.attributes.Color === color && v.attributes.Capacity === capacity);
    }

    function findFallbackImages(color) {
        // Tìm variant cùng màu có ảnh, ưu tiên 128GB
        const sameColorVariants = variants.filter(v => 
            v.attributes.Color === color && v.images && v.images.length > 0
        );
        return sameColorVariants.find(v => v.attributes.Capacity === '128GB') || sameColorVariants[0];
    }

    function getColorHex(color) {
        const colors = {
            'Black': '#1d1d1f',
            'White': '#f5f5f7'
        };
        return colors[color] || '#666';
    }

    // Render màu sắc
    function renderColors() {
        colorOptions.innerHTML = '';
        getColors().forEach(color => {
            const div = document.createElement('div');
            div.className = 'product-detail__color-option';
            div.style.backgroundColor = getColorHex(color);
            div.onclick = () => selectColor(color);
            colorOptions.appendChild(div);
        });
    }

    // Render dung lượng
    function renderCapacities() {
        sizeOptions.innerHTML = '';
        getCapacities().forEach(capacity => {
            const div = document.createElement('div');
            div.className = 'product-detail__size-option';
            div.textContent = capacity;
            div.onclick = () => selectCapacity(capacity);
            sizeOptions.appendChild(div);
        });
    }

    // Chọn màu
    function selectColor(color) {
        selectedColor = color;
        document.querySelectorAll('.product-detail__color-option').forEach((el, i) => {
            el.classList.toggle('product-detail__color-option--active', getColors()[i] === color);
        });
        updateVariant();
    }

    // Chọn dung lượng
    function selectCapacity(capacity) {
        selectedCapacity = capacity;
        document.querySelectorAll('.product-detail__size-option').forEach((el, i) => {
            el.classList.toggle('product-detail__size-option--active', getCapacities()[i] === capacity);
        });
        updateVariant();
    }

    // Cập nhật variant
    function updateVariant() {
        if (!selectedColor || !selectedCapacity) return;
        
        currentVariant = findVariant(selectedColor, selectedCapacity);
        if (!currentVariant) return;

        // Cập nhật giá
        currentPrice.textContent = new Intl.NumberFormat('vi-VN').format(currentVariant.price) + ' đ';
        
        // Cập nhật kho
        stockInfo.innerHTML = `Còn lại: <strong>${currentVariant.stock_quantity}</strong> sản phẩm`;

        // Cập nhật ảnh
        updateImages();
    }

    // Cập nhật ảnh - FIXED LOGIC
    function updateImages() {
        let imageVariant = currentVariant;
        
        // Nếu variant hiện tại không có ảnh, tìm fallback
        if (!currentVariant.images || currentVariant.images.length === 0) {
            imageVariant = findFallbackImages(selectedColor);
        }

        // Cập nhật ảnh chính - Ưu tiên hiển thị ảnh đầu tiên trong gallery
        if (imageVariant && imageVariant.images && imageVariant.images.length > 0) {
            // Hiển thị ảnh đầu tiên từ gallery images
            mainImage.src = `/img/products/gallery/${imageVariant.images[0].gallery_image_url}`;
        } else if (imageVariant && imageVariant.main_media && imageVariant.main_media.url && imageVariant.main_media.url !== '/img/default.png') {
            // Fallback sang main_media nếu không có gallery images
            mainImage.src = `/img/products/gallery/${imageVariant.main_media.url}`;
        } else {
            // Cuối cùng mới dùng default image
            mainImage.src = '/img/default.png';
        }

        // Cập nhật thumbnails
        thumbnailContainer.innerHTML = '';
        if (imageVariant && imageVariant.images && imageVariant.images.length > 0) {
            imageVariant.images.forEach((img, index) => {
                const thumb = document.createElement('img');
                thumb.src = `/img/products/thumbnails/${img.gallery_image_url}`;
                thumb.className = 'product-detail__thumbnail';
                if (index === 0) thumb.classList.add('product-detail__thumbnail--active');
                
                thumb.onclick = () => {
                    mainImage.src = `/img/products/gallery/${img.gallery_image_url}`;
                    document.querySelectorAll('.product-detail__thumbnail').forEach(t => 
                        t.classList.remove('product-detail__thumbnail--active')
                    );
                    thumb.classList.add('product-detail__thumbnail--active');
                };
                
                thumbnailContainer.appendChild(thumb);
            });
        }
    }

    // Khởi tạo
    function init() {
        renderColors();
        renderCapacities();
        if (getColors().length > 0) {
            selectColor(getColors()[0]);
        }
        if (getCapacities().length > 0) {
            selectCapacity(getCapacities()[0]);
        }
    }

    init();
});
</script>
</body>
</html>