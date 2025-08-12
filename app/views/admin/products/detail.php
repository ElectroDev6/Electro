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
                        </div>
                    </div>
                    <div class="product-detail__preview-content">
                        <div class="product-detail__product-view">
                            <div class="product-detail__product-header">
                                <h1 class="product-detail__product-title" id="previewProductName"><?= htmlspecialchars($product['product_name'] ?? '') ?></h1>
                            </div>
                            <div class="product-detail__product-content">
                                <div class="product-detail__product-image">
                                    <?php
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
                                                <img src="<?= htmlspecialchars($image['gallery_image_url'] ?? $image['gallery_url'] ?? '') ?>" alt="<?= htmlspecialchars($image['gallery_image_alt'] ?? $image['gallery_image_alt'] ?? '') ?>" class="product-detail__thumbnail" data-src="<?= htmlspecialchars($image['gallery_image_url'] ?? $image['gallery_url'] ?? '') ?>">
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>Không có ảnh thumbnail</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-detail__product-info">
                                    <div class="product-detail__variant-selectors">
                                        <div class="product-detail__variant-selector">
                                            <?php
                                            $hasCapacityGroup = false;
                                            foreach ($product['variants'] as $variant) {
                                                if (!empty($variant['capacity_group']) && $variant['capacity_group'] !== 'Chưa xác định') {
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
                                                    if (!in_array($variant['capacity_group'], $seenCapacities) && $variant['capacity_group'] !== 'Chưa xác định'):
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
            const $ = document.getElementById.bind(document);
            const editToggle = $('editToggle');
            const adminForm = $('adminForm');
            const previewPanel = $('previewPanel');
            const previewMainImage = $('previewMainImage');
            const previewThumbnails = $('previewThumbnails');
            const previewSizeOptions = $('previewSizeOptions');
            const previewColorOptions = $('previewColorOptions');

            let productData = <?= json_encode($product, JSON_UNESCAPED_SLASHES) ?>;
            let currentVariant = productData.variants[0];
            let currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];

            // Toggle Edit Form
            editToggle.addEventListener('click', () => {
                const isHidden = adminForm.style.display === 'none';
                adminForm.style.display = isHidden ? 'block' : 'none';
                previewPanel.classList.toggle('product-detail__preview-panel--small', isHidden);
                editToggle.innerHTML = isHidden ? '<i class="fas fa-eye"></i> Ẩn form' : '<i class="fas fa-edit"></i> Chỉnh sửa';
            });

            // Update Preview Images
            function updatePreviewImages() {
                if (!previewMainImage || !previewThumbnails || !currentVariant) return;
                if (currentColor && Array.isArray(currentColor.images) && currentColor.images.length > 0) {
                    currentColor.images.sort((a, b) => (a.sort_order || 0) - (b.sort_order || 0));
                    const firstImage = currentColor.images[0];
                    previewMainImage.src = firstImage.gallery_image_url || (currentVariant.main_media?.url || '');
                    previewMainImage.alt = firstImage.gallery_image_alt || (currentVariant.main_media?.alt_text || '');

                    previewThumbnails.innerHTML = '';
                    currentColor.images.forEach(image => {
                        const thumb = document.createElement('img');
                        thumb.src = image.gallery_image_url || image.gallery_url || '';
                        thumb.alt = image.gallery_image_alt || '';
                        thumb.className = 'product-detail__thumbnail';
                        thumb.dataset.src = image.gallery_image_url || image.gallery_url || '';
                        thumb.addEventListener('click', () => {
                            previewMainImage.src = thumb.dataset.src;
                            previewMainImage.alt = thumb.alt;
                            previewThumbnails.querySelectorAll('.product-detail__thumbnail').forEach(t => t.classList.remove('product-detail__thumbnail--active'));
                            thumb.classList.add('product-detail__thumbnail--active');
                        });
                        previewThumbnails.appendChild(thumb);
                        if (image.gallery_image_url === previewMainImage.src || image.gallery_url === previewMainImage.src) {
                            thumb.classList.add('product-detail__thumbnail--active');
                        }
                    });
                } else {
                    previewMainImage.src = currentVariant.main_media?.url || '';
                    previewMainImage.alt = currentVariant.main_media?.alt_text || '';
                    previewThumbnails.innerHTML = '<p>Không có ảnh thumbnail</p>';
                }
            }

            // Event listener for size option click
            if (previewSizeOptions) {
                previewSizeOptions.querySelectorAll('.product-detail__size-option').forEach(button => {
                    button.addEventListener('click', () => {
                        const variantId = parseInt(button.dataset.variantId);
                        currentVariant = productData.variants.find(v => v.id === variantId) || currentVariant;
                        currentColor = currentVariant.colors.find(c => c.is_active == 1) || currentVariant.colors[0];
                        previewSizeOptions.querySelectorAll('.product-detail__size-option').forEach(btn => btn.classList.remove('product-detail__size-option--active'));
                        button.classList.add('product-detail__size-option--active');
                        updatePreviewImages();
                    });
                });
                // Activate first size option by default
                if (previewSizeOptions.querySelector('.product-detail__size-option')) {
                    previewSizeOptions.querySelector('.product-detail__size-option').classList.add('product-detail__size-option--active');
                }
            }

            // Event listener for color option click
            if (previewColorOptions) {
                previewColorOptions.querySelectorAll('.product-detail__color-option').forEach(button => {
                    button.addEventListener('click', () => {
                        const colorId = parseInt(button.dataset.colorId);
                        currentColor = currentVariant.colors.find(c => c.color_id === colorId) || currentColor;
                        previewColorOptions.querySelectorAll('.product-detail__color-option').forEach(btn => btn.classList.remove('product-detail__color-option--active'));
                        button.classList.add('product-detail__color-option--active');
                        updatePreviewImages();
                    });
                });
                // Activate first color option by default
                if (previewColorOptions.querySelector('.product-detail__color-option')) {
                    previewColorOptions.querySelector('.product-detail__color-option').classList.add('product-detail__color-option--active');
                }
            }

            // Initialize preview
            updatePreviewImages();
        });
    </script>
</body>
</html>