<?php

$colorMap = [
    'black' => '#000000',
    'white' => '#ffffff',
    'blue'  => '#007bff',
    'red'   => '#ff0000',
    'gray'  => '#666666',
];


use Core\View; ?>

<?php View::section('page_styles'); ?>

<?php View::endSection(); ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Chi tiết sản phẩm
<?php View::endSection(); ?>

<?php View::section('content'); ?>

<div class="container-main">
    <div class="product-detail">
        <!-- Breadcrumb -->
        <div class="product-detail__breadcrumb">
            <a href="/" class="product-detail__breadcrumb-item">Trang chủ</a>
            <span class="product-detail__breadcrumb-separator">/</span>
            <span class="product-detail__breadcrumb-item product-detail__breadcrumb-item--active"><?php echo htmlspecialchars($product['name'] ?? 'Sản phẩm'); ?></span>
        </div>

        <!-- Product Main Section -->
        <div class="product-detail__main">
            <div class="product-detail__images">
                <!-- Main Image -->
                <div class="product-detail__main-image">
                    <?php
                    $defaultSkuId = $product['variants'][0]['sku_id'] ?? 1;
                    $mainImage = $product['images'][$defaultSkuId]['thumbnail_url'][0] ?? '/img/placeholder.jpg';
                    ?>
                    <img id="main-product-image" src="/img/products/gallery/<?php echo htmlspecialchars($mainImage); ?>" alt="Ảnh chính sản phẩm" />
                </div>

                <!-- Thumbnail Images -->
                <div class="product-detail__thumbnail-images" id="thumbnail-container">
                    <?php
                    $images = $product['images'][$defaultSkuId] ?? [];
                    foreach ($images['thumbnail_url'] ?? [] as $index => $thumbnailUrl): ?>
                        <div class="product-detail__thumbnail <?= $index === 0 ? 'product-detail__thumbnail--active' : '' ?>">
                            <img
                                src="/img/products/thumbnails/<?php echo htmlspecialchars($thumbnailUrl); ?>"
                                data-gallery-url="/img/products/gallery/<?php echo htmlspecialchars($images['gallery_urls'][$index] ?? $thumbnailUrl); ?>"
                                alt="Thumbnail" />
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Product Highlights and Policy -->
                <div class="product-detail__info-box">
                    <!-- Thông số nổi bật -->
                    <div class="product-detail__highlights">
                        <div class="highlights__header">
                            <h3>Thông số nổi bật</h3>
                        </div>
                        <div class="highlights__list">
                            <div class="highlight__item">
                                <img src="/icons/chip-svgrepo-com.svg" alt="screen" />
                                <p>Chip</p>
                                <strong>Apple A15 Bionic</strong>
                            </div>
                            <div class="highlight__item">
                                <img src="/icons/screen-smartphone-svgrepo-com.svg" alt="screen" />
                                <p>Kích thước màn hình</p>
                                <strong>6.1 inch</strong>
                            </div>
                            <div class="highlight__item">
                                <img src="/icons/battery-100-svgrepo-com.svg" alt="screen" />
                                <p>Thời lượng pin</p>
                                <strong>22 Giờ</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Chính sách sản phẩm -->
                    <div class="product-detail__policy">
                        <h3>Chính sách sản phẩm</h3>
                        <div class="policy__list">
                            <div class="policy__items">
                                <div class="policy__item">
                                    <img src="/icons/Type_Bao_hanh_chinh_hang.svg" alt="shield" />
                                    <p>Hàng chính hãng - Bảo hành 12 tháng</p>
                                </div>
                                <div class="policy__item">
                                    <img src="/icons/Type_Giao_hang_toan_quoc.svg" alt="shield" />
                                    <p>Miễn phí giao hàng toàn quốc</p>
                                </div>
                            </div>
                            <div class="policy__items">
                                <div class="policy__item">
                                    <img src="/icons/icon_ktv.svg" alt="shield" />
                                    <p>Kỹ thuật viên hỗ trợ trực tuyến</p>
                                </div>
                                <!-- <div class="policy__item">
                                    <img src="/icons/monitor.svg" alt="shield" />
                                    <p>Hàng chính hãng – Bảo hành 36 tháng</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-detail__info">
                <h1 class="product-detail__title"><?= htmlspecialchars($product['name']) ?></h1>

                <div class="product-detail__rating">
                    <div class="product-detail__stars">
                        <span>★★★★★</span>
                    </div>
                    <span class="product-detail__rating-text">234 đánh giá</span>
                    <span class="product-detail__sold">Đã bán 234</span>
                </div>

                <div class="product-detail__price">
                    <div class="product-detail__current-price">
                        <?= number_format($product['variants'][0]['price_discount'] ?? 0, 0, ',', '.') ?> ₫
                    </div>

                    <div class="product-detail__original-price">
                        <?= number_format($product['variants'][0]['price_original'] ?? 0, 0, ',', '.') ?> ₫
                    </div>

                    <div class="product-detail__discount-badge">-<?= $product['variants'][0]['discount_percent'] ?? 0 ?>%</div>
                </div>

                <div class="product-detail__options">
                    <div class="product-detail__size-options">

                    </div>
                    <div class="product-detail__options">
                        <!-- Màu sắc -->
                        <div class="product-detail__color-options">
                            <label class="product-detail__color-label">Màu sắc:</label>
                            <div class="product-detail__color-buttons">
                                <?php
                                $colors = [];
                                foreach ($product['variants'] as $variant) {
                                    $skuId = $variant['sku_id'];
                                    $color = 'unknown';
                                    foreach ($product['attributes'][$skuId] ?? [] as $attr) {
                                        if (strtolower($attr['option_name']) === 'color') {
                                            $color = strtolower($attr['option_value']);
                                            break;
                                        }
                                    }
                                    $colors[$color] = $skuId;
                                }
                                $i = 0;
                                foreach ($colors as $colorName => $skuId): ?>
                                    <button
                                        class="product-detail__option-btn product-detail__color-btn <?= $i === 0 ? 'product-detail__color-btn--active' : '' ?>"
                                        style="background-color: <?= $colorMap[$colorName] ?? '#ccc' ?>"
                                        data-option-id="1"
                                        data-value="<?= htmlspecialchars($colorName) ?>"
                                        data-sku-id="<?= $skuId ?>">
                                        <span class="product-detail__color-name"></span>
                                    </button>
                                <?php $i++;
                                endforeach; ?>
                            </div>
                        </div>

                        <!-- Dung lượng -->
                        <div class="product-detail__capacity-options">
                            <label class="product-detail__capacity-label">Dung lượng:</label>
                            <div class="product-detail__capacity-buttons">
                                <?php
                                $capacities = [];
                                foreach ($product['variants'] as $variant) {
                                    $skuId = $variant['sku_id'];
                                    $capacity = 'unknown';
                                    foreach ($product['attributes'][$skuId] ?? [] as $attr) {
                                        if (strtolower($attr['option_name']) === 'capacity') {
                                            $capacity = strtolower($attr['option_value']);
                                            break;
                                        }
                                    }
                                    $capacities[$capacity] = $skuId;
                                }
                                $j = 0;
                                foreach ($capacities as $capacity => $skuId): ?>
                                    <button
                                        class="product-detail__option-btn product-detail__capacity-btn <?= $j === 0 ? 'product-detail__capacity-btn--active' : '' ?>"
                                        data-option-id="2"
                                        data-value="<?= htmlspecialchars($capacity) ?>"
                                        data-sku-id="<?= $skuId ?>">
                                        <?php echo htmlspecialchars(strtoupper($capacity)); ?>
                                    </button>
                                <?php $j++;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-detail__quantity-section">
                    <label class="product-detail__quantity-label">Số lượng:</label>
                    <div class="product-detail__quantity-controls">
                        <button class="product-detail__qty-btn product-detail__qty-btn--minus">-</button>
                        <input type="number" value="1" min="1" class="product-detail__qty-input" />
                        <button class="product-detail__qty-btn product-detail__qty-btn--plus">+</button>
                    </div>
                </div>

                <div class="product-detail__action-buttons">
                    <button class="product-detail__btn-add-cart">Thêm vào giỏ hàng</button>
                    <!-- <button class="product-detail__btn-buy-now">Mua ngay</button> -->
                    <?php View::partial('components.button-buy-now', ['href' => '#', 'text' => 'Mua ngay']); ?>
                </div>

                <div class="product-detail__shipping-info">
                    <p><strong>Miễn phí vận chuyển</strong> cho đơn hàng từ 500.000₫</p>
                </div>

                <div class="product-detail__product-highlights">
                    <h3 class="product-detail__highlight-title">Điểm nổi bật sản phẩm:</h3>
                    <ul class="product-detail__highlight-list">
                        <li>✓ Màn hình Super Retina XDR 6.1 inch</li>
                        <li>✓ Chip Apple A15 Bionic mạnh mẽ</li>
                        <li>✓ Camera kép 12MP (Wide & Ultra Wide)</li>
                        <li>✓ Hỗ trợ 5G và HDR Display</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product-detail__tabs-section">
            <div class="product-detail__tabs-nav">
                <button class="product-detail__tab-btn product-detail__tab-btn--active" data-tab="description">Chi tiết sản phẩm</button>
                <button class="product-detail__tab-btn" data-tab="specifications">Thông số kỹ thuật</button>
                <button class="product-detail__tab-btn" data-tab="comments">Bình luận</button>
            </div>

            <div class="product-detail__tabs-content">
                <!-- Chi tiết sản phẩm Tab -->
                <div class="product-detail__tab-panel product-detail__tab-panel--active" id="description-panel">
                    <div class="product-detail__description">
                        <div class="product-detail__description-content">
                            <?php if (!empty($product['descriptions'])): ?>
                                <?php foreach ($product['descriptions'] as $desc): ?>
                                    <p><?php echo htmlspecialchars($desc['description'], ENT_QUOTES, 'UTF-8'); ?></p>

                                    <?php if (!empty($desc['image_url'])): ?>
                                        <div class="product-detail__feature-image">
                                            <img src="/img/detail/<?php echo htmlspecialchars(trim($desc['image_url']), ENT_QUOTES, 'UTF-8'); ?>" alt="Tính năng sản phẩm" />
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Thông số kỹ thuật Tab -->
                <div class="product-detail__tab-panel" id="specifications-panel">
                    <div class="product-detail__specifications">
                        <div class="product-detail__spec-table">
                            <?php if (!empty($product['specs'])): ?>
                                <?php foreach ($product['specs'] as $spec): ?>
                                    <div class="product-detail__spec-row">
                                        <div class="product-detail__spec-label">
                                            <?php echo htmlspecialchars($spec['spec_name'], ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                        <div class="product-detail__spec-value">
                                            <?php echo htmlspecialchars($spec['spec_value'], ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


                <!-- Bình luận Tab -->
                <div class="product-detail__tab-panel" id="comments-panel">
                    <div class="product-detail__comments">
                        <div class="product-detail__comment-form">
                            <h3>Để lại bình luận</h3>
                            <form class="product-detail__form">
                                <!-- <div class="product-detail__form-group">
                                    <label for="comment-name">Họ và tên *</label>
                                    <input type="text" id="comment-name" required />
                                </div>
                                <div class="product-detail__form-group">
                                    <label for="comment-email">Email *</label>
                                    <input type="email" id="comment-email" required />
                                </div> -->
                                <div class="product-detail__form-group">
                                    <label for="comment-content">Nội dung bình luận *</label>
                                    <textarea id="comment-content" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="product-detail__comment-submit">Gửi bình luận</button>
                            </form>
                            <h3>Bình luận từ khách hàng</h3>
                            <div class="product-detail__reviews-list">
                                <?php foreach ($product['comments'] as $comment): ?>
                                    <div class="product-detail__review-item">
                                        <div class="product-detail__reviewer-info">
                                            <img src="/img/avatars/avatar.png" alt="User avatar" class="product-detail__reviewer-avatar" />
                                            <div class="product-detail__reviewer-details">
                                                <h4 class="product-detail__reviewer-name">
                                                    <?= htmlspecialchars($comment['user_name']) ?>
                                                </h4>
                                                <div class="product-detail__review-rating">
                                                    <?= str_repeat('★', (int)$comment['rating']) ?>
                                                    <?= str_repeat('☆', 5 - (int)$comment['rating']) ?>
                                                </div>
                                                <!-- Ở đây bạn có thể thêm ngày tạo nếu bảng có cột created_at -->
                                                <span class="product-detail__review-date">
                                                    <?= isset($comment['created_at']) ? date('d/m/Y', strtotime($comment['created_at'])) : '' ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="product-detail__review-content">
                                            <p><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></p>

                                            <?php if (!empty($comment['images'])): ?>
                                                <div class="product-detail__review-images">
                                                    <?php foreach ($comment['images'] as $img): ?>
                                                        <img src="/img/reviews/<?= htmlspecialchars($img) ?>" alt="Review image" />
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="product-detail__comments-list">
            <!-- FAQ Section -->
            <div class="product-detail__faq-section">
                <h2 class="product-detail__faq-title">Câu hỏi thường gặp</h2>
                <div class="product-detail__faq-list">
                    <div class="product-detail__faq-item">
                        <div class="product-detail__faq-question">
                            <span class="product-detail__faq-question-text">Sản phẩm này có bảo hành bao lâu?</span>
                            <span class="product-detail__faq-toggle">+</span>
                        </div>
                        <div class="product-detail__faq-answer">
                            <p>Sản phẩm được bảo hành chính hãng 24 tháng.</p>
                        </div>
                    </div>

                    <div class="product-detail__faq-item">
                        <div class="product-detail__faq-question">
                            <span class="product-detail__faq-question-text">Sản phẩm này có hỗ trợ tiếng Việt không?</span>
                            <span class="product-detail__faq-toggle">+</span>
                        </div>
                        <div class="product-detail__faq-answer">
                            <p>Có, sản phẩm hỗ trợ đầy đủ tiếng Việt trong menu và các ứng dụng.</p>
                        </div>
                    </div>

                    <div class="product-detail__faq-item">
                        <div class="product-detail__faq-question">
                            <span class="product-detail__faq-question-text">Tivi này có kết nối internet không?</span>
                            <span class="product-detail__faq-toggle">+</span>
                        </div>
                        <div class="product-detail__faq-answer">
                            <p>Có, sản phẩm hỗ trợ kết nối WiFi và cổng LAN.</p>
                        </div>
                    </div>

                    <div class="product-detail__faq-item">
                        <div class="product-detail__faq-question">
                            <span class="product-detail__faq-question-text">Sản phẩm này có remote điều khiển không?</span>
                            <span class="product-detail__faq-toggle">+</span>
                        </div>
                        <div class="product-detail__faq-answer">
                            <p>Có, sản phẩm đi kèm remote điều khiển thông minh.</p>
                        </div>
                    </div>

                    <div class="product-detail__faq-item">
                        <div class="product-detail__faq-question">
                            <span class="product-detail__faq-question-text">Sản phẩm này có hỗ trợ lắp đặt không?</span>
                            <span class="product-detail__faq-toggle">+</span>
                        </div>
                        <div class="product-detail__faq-answer">
                            <p>Có, chúng tôi hỗ trợ lắp đặt miễn phí tại nhà.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Reviews -->
            <div class="product-detail__reviews-section">
                <h2 class="product-detail__reviews-title">Đánh giá sản phẩm</h2>
                <div class="product-detail__review-summary">
                    <div class="product-detail__rating-overview">
                        <span class="product-detail__rating-score">4 trên 5</span>
                        <div class="product-detail__rating-bars">
                            <div class="product-detail__rating-bar">
                                <span class="product-detail__rating-label">5 sao</span>
                                <div class="product-detail__bar">
                                    <div class="product-detail__fill" style="width: 60%"></div>
                                </div>
                                <span class="product-detail__rating-count">3 đánh giá</span>
                            </div>
                            <div class="product-detail__rating-bar">
                                <span class="product-detail__rating-label">4 sao</span>
                                <div class="product-detail__bar">
                                    <div class="product-detail__fill" style="width: 40%"></div>
                                </div>
                                <span class="product-detail__rating-count">2 đánh giá</span>
                            </div>
                            <div class="product-detail__rating-bar">
                                <span class="product-detail__rating-label">3 sao</span>
                                <div class="product-detail__bar">
                                    <div class="product-detail__fill" style="width: 0%"></div>
                                </div>
                                <span class="product-detail__rating-count">0 đánh giá</span>
                            </div>
                            <div class="product-detail__rating-bar">
                                <span class="product-detail__rating-label">2 sao</span>
                                <div class="product-detail__bar">
                                    <div class="product-detail__fill" style="width: 0%"></div>
                                </div>
                                <span class="product-detail__rating-count">0 đánh giá</span>
                            </div>
                            <div class="product-detail__rating-bar">
                                <span class="product-detail__rating-label">1 sao</span>
                                <div class="product-detail__bar">
                                    <div class="product-detail__fill" style="width: 0%"></div>
                                </div>
                                <span class="product-detail__rating-count">0 đánh giá</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/img/avatars/avatar.png" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Phạm Thị D</h4>
                            <div class="product-detail__review-rating">★★★★☆</div>
                            <span class="product-detail__review-date">2 tuần trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Sản phẩm tốt, đúng như mô tả. Chất lượng hình ảnh rất đẹp. Âm thanh to rõ. Giá hợp lý. Cảm ơn shop!</p>
                        <div class="product-detail__review-images">
                            <img src="/img/reviews/review-1.jpg" alt="Review image" />
                            <img src="/img/reviews/review-1.jpg" alt="Review image" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-detail__load-more">
                <button class="product-detail__btn-load-more">Xem thêm đánh giá</button>
            </div>
        </div>
        <!-- Related Products -->
        <div class="product-detail__related-products">
            <?php View::partial('partials.related-container', ['relatedProducts' => $relatedProducts]); ?>
        </div>
    </div>
    <script>
        window.productData = {
            images: <?= json_encode($product['images']) ?>,
            variants: <?= json_encode(
                            array_map(function ($variant) use ($product) {
                                $skuId = $variant['sku_id'];
                                $attributes = array_map(function ($attr) {
                                    return [
                                        'attribute_name' => $attr['option_name'],
                                        'option_value' => strtolower($attr['option_value']),
                                    ];
                                }, $product['attributes'][$skuId] ?? []);
                                return [
                                    'sku_id' => $skuId,
                                    'sku_code' => $variant['sku_code'],
                                    'price_original' => $variant['price_original'],
                                    'price_discount' => $variant['price_discount'],
                                    'discount_percent' => $variant['discount_percent'],
                                    'discount_amount' => $variant['discount_amount'],
                                    'stock_quantity' => $variant['stock_quantity'],
                                    'attributes' => $attributes,
                                ];
                            }, $product['variants'])
                        ) ?>
        };
    </script>
    <?php View::endSection(); ?>