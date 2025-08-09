<?php

$colorMap = [
    'black' => '#000000',
    'white' => '#ffffff',
    'blue'  => '#007bff',
    'red'   => '#ff0000',
    'gray'  => '#666666',
];



use Core\View; ?>
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
            <span class="product-detail__breadcrumb-item product-detail__breadcrumb-item--active">Tivi OLED</span>
        </div>

        <!-- Product Main Section -->
        <div class="product-detail__main">
            <div class="product-detail__images">
                <!-- Main Image -->
                <div class="product-detail__main-image">
                    <img
                        id="main-product-image"
                        src="/img/products<?= htmlspecialchars($product['images'][$product['variants'][0]['sku_id']][0]['gallery_url'] ?? '') ?>"
                        alt="Ảnh chính sản phẩm" />
                    <div class="header__icon">
                        <a href="/wishlist">
                            <svg href="/wishlist" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#333e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>

                    </div>


                </div>

                <!-- Thumbnail Images -->
                <div class="product-detail__thumbnail-images" id="thumbnail-container">
                    <?php
                    $defaultSkuId = $product['variants'][0]['sku_id'];
                    $images = $product['images'][$defaultSkuId] ?? [];
                    foreach (array_slice($images, 0, 4) as $img): ?>
                        <div class="product-detail__thumbnail <?= $img['sort_order'] == 1 ? 'product-detail__thumbnail--active' : '' ?>">
                            <img
                                src="/img/products<?= htmlspecialchars($img['thumbnail_url']) ?>"
                                data-gallery-url="/img/products<?= htmlspecialchars($img['gallery_url']) ?>"
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
                            <a href="#" class="highlights__link">Xem tất cả thông số</a>
                        </div>
                        <div class="highlights__list">
                            <div class="highlight__item">
                                <img src="/icons/monitor.svg" alt="screen" />
                                <p>Kích thước màn hình</p>
                                <strong>27 inch</strong>
                            </div>
                            <div class="highlight__item">
                                <img src="/icons/monitor.svg" alt="screen" />
                                <p>Kích thước màn hình</p>
                                <strong>27 inch</strong>
                            </div>
                            <div class="highlight__item">
                                <img src="/icons/monitor.svg" alt="screen" />
                                <p>Kích thước màn hình</p>
                                <strong>27 inch</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Chính sách sản phẩm -->
                    <div class="product-detail__policy">
                        <h3>Chính sách sản phẩm</h3>
                        <div class="policy__list">
                            <div class="policy__items">
                                <div class="policy__item">
                                    <img src="/icons/monitor.svg" alt="shield" />
                                    <p>Hàng chính hãng – Bảo hành 36 tháng</p>
                                </div>
                                <div class="policy__item">
                                    <img src="/icons/monitor.svg" alt="shield" />
                                    <p>Hàng chính hãng – Bảo hành 36 tháng</p>
                                </div>
                            </div>
                            <div class="policy__items">
                                <div class="policy__item">
                                    <img src="/icons/monitor.svg" alt="shield" />
                                    <p>Hàng chính hãng – Bảo hành 36 tháng</p>
                                </div>
                                <div class="policy__item">
                                    <img src="/icons/monitor.svg" alt="shield" />
                                    <p>Hàng chính hãng – Bảo hành 36 tháng</p>
                                </div>
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
                    <a class="product-detail__link" href="#">Thông số kỹ thuật</a>
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
                        <div class="product-detail__color-options">
                            <label class="product-detail__color-label">Màu sắc:</label>
                            <div class="product-detail__color-buttons">
                                <?php $i = 0;
                                $colors = [];
                                foreach ($product['variants'] as $variant) {
                                    $attributes = $product['attributes'][$variant['sku_id']] ?? [];
                                    $color = strtolower($attributes[0]['option_value'] ?? 'unknown');
                                    $colors[$color] = true;
                                }
                                // print_r($colors);
                                foreach (array_keys($colors) as $colorName): ?>
                                    <button
                                        class="product-detail__option-btn product-detail__color-btn <?= $i === 0 ? 'product-detail__color-btn--active' : '' ?>"
                                        style="background-color: <?= $colorMap[$colorName] ?? '#ccc' ?>"
                                        data-option-id="1"
                                        data-value="<?= htmlspecialchars($colorName) ?>">
                                        <span class="product-detail__color-name"></span>
                                    </button>
                                <?php $i++;
                                endforeach; ?>
                            </div>
                        </div>

                        <div class="product-detail__capacity-options">
                            <label class="product-detail__capacity-label">Dung lượng:</label>
                            <div class="product-detail__capacity-buttons">
                                <?php $j = 0;
                                $capacities = [];
                                foreach ($product['variants'] as $variant) {
                                    $attributes = $product['attributes'][$variant['sku_id']] ?? [];
                                    $capacity = strtolower($attributes[1]['option_value'] ?? 'unknown'); // Chuẩn hóa thành chữ thường
                                    $capacities[$capacity] = true;
                                }
                                foreach (array_keys($capacities) as $capacity): ?>
                                    <button
                                        class="product-detail__option-btn product-detail__capacity-btn <?= $j === 0 ? 'product-detail__capacity-btn--active' : '' ?>"
                                        data-option-id="2"
                                        data-value="<?= htmlspecialchars(strtolower($capacity)) ?>">
                                        <?= htmlspecialchars(strtoupper($capacity)) ?>
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

                <div class="product-detail__highlights">
                    <h3 class="product-detail__highlight-title">Điểm nổi bật sản phẩm:</h3>
                    <ul class="product-detail__highlight-list">
                        <li>✓ Tấm nền QD-OLED thế hệ mới</li>
                        <li>✓ Độ phân giải 4K Ultra HD</li>
                        <li>✓ Smart TV với hệ điều hành Tizen</li>
                        <li>✓ Hỗ trợ HDR10+, Dolby Vision</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="product-detail__description">
            <h2 class="product-detail__description-title">Mô tả sản phẩm</h2>
            <div class="product-detail__description-content">
                <p>Tivi OLED Samsung QE65S95D 65 inch là sản phẩm tivi cao cấp mới nhất của Samsung, được trang bị công nghệ QD-OLED tiên tiến, mang đến trải nghiệm hình ảnh vượt trội với độ tương phản vô cực và dải màu rộng.</p>

                <div class="product-detail__feature-image">
                    <img src="/img/tv-feature.webp" alt="Tính năng sản phẩm" />
                </div>
            </div>
        </div>

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

            <div class="product-detail__reviews-list">
                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/img/avatar.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Nguyễn Văn A</h4>
                            <div class="product-detail__review-rating">★★★★★</div>
                            <span class="product-detail__review-date">2 tháng trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Sản phẩm rất tốt, hình ảnh sắc nét, màn hình lớn phù hợp với phòng khách. Giao hàng nhanh, đóng gói cẩn thận. Tôi rất hài lòng với sản phẩm này. Sẽ tiếp tục ủng hộ shop.</p>
                        <div class="product-detail__review-images">
                            <img src="/img/review.webp" alt="Review image" />
                            <img src="/img/review.webp" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/img/avatar.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Trần Thị B</h4>
                            <div class="product-detail__review-rating">★★★★☆</div>
                            <span class="product-detail__review-date">1 tháng trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Tivi đẹp, chất lượng tốt. Nhân viên tư vấn nhiệt tình. Giao hàng đúng hẹn. Giá cả hợp lý. Recommend!</p>
                        <div class="product-detail__review-images">
                            <img src="/img/review.webp" alt="Review image" />
                            <img src="/img/review.webp" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/img/avatar.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Lê Văn C</h4>
                            <div class="product-detail__review-rating">★★★★★</div>
                            <span class="product-detail__review-date">3 tuần trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Màn hình to, hình ảnh đẹp, âm thanh hay. Shop tư vấn nhiệt tình, giao hàng nhanh. Sẽ giới thiệu cho bạn bè.</p>
                        <div class="product-detail__review-images">
                            <img src="/img/review.webp" alt="Review image" />
                            <img src="/img/review.webp" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/img/avatar.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Phạm Thị D</h4>
                            <div class="product-detail__review-rating">★★★★☆</div>
                            <span class="product-detail__review-date">2 tuần trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Sản phẩm tốt, đúng như mô tả. Chất lượng hình ảnh rất đẹp. Âm thanh to rõ. Giá hợp lý. Cảm ơn shop!</p>
                        <div class="product-detail__review-images">
                            <img src="/img/review.webp" alt="Review image" />
                            <img src="/img/review.webp" alt="Review image" />
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
            <?php View::partial('partials.related-container', ['audioProducts' => $audioProducts]); ?>
        </div>
    </div>
</div>

<script>
    const variants = <?= json_encode(
                            array_map(function ($variant) use ($product) {
                                $skuId = $variant['sku_id'];
                                $images = [];
                                $currentAttributes = $product['attributes'][$skuId] ?? [];
                                $currentColor = strtolower($currentAttributes[0]['option_value'] ?? '');
                                if (!empty($product['images'][$skuId])) {
                                    foreach ($product['images'][$skuId] as $img) {
                                        $images[] = [
                                            'default_url'   => !empty($img['default_url']) ? $img['default_url'] : '',
                                            'thumbnail_url' => $img['thumbnail_url'],
                                            'gallery_url'   => $img['gallery_url'],
                                            'sort_order'    => $img['sort_order'],
                                        ];
                                    }
                                } else {
                                    $matchingSku = array_filter($product['variants'], function ($v) use ($skuId, $currentColor, $product) {
                                        $otherAttributes = $product['attributes'][$v['sku_id']] ?? [];
                                        $otherColor = strtolower($otherAttributes[0]['option_value'] ?? '');
                                        return $v['sku_id'] !== $skuId && $currentColor === $otherColor && !empty($product['images'][$v['sku_id']]);
                                    });
                                    $fallbackSkuId = !empty($matchingSku) ? reset($matchingSku)['sku_id'] : $product['variants'][0]['sku_id'];
                                    foreach ($product['images'][$fallbackSkuId] ?? [] as $img) {
                                        $images[] = [
                                            'default_url'   => !empty($img['default_url']) ? $img['default_url'] : '',
                                            'thumbnail_url' => $img['thumbnail_url'],
                                            'gallery_url'   => $img['gallery_url'],
                                            'sort_order'    => $img['sort_order'],
                                        ];
                                    }
                                }
                                $attributes = $product['attributes'][$skuId] ?? [];
                                foreach ($attributes as &$attr) {
                                    $attr['option_value'] = strtolower($attr['option_value']);
                                }
                                return [
                                    'sku_id'          => $skuId,
                                    'sku_code'        => $variant['sku_code'],
                                    'price_original'  => $variant['price_original'],
                                    'price_discount'  => $variant['price_discount'],
                                    'discount_percent' => $variant['discount_percent'],
                                    'discount_amount' => $variant['discount_amount'],
                                    'stock_quantity'  => $variant['stock_quantity'],
                                    'attributes'      => $attributes,
                                    'images'          => $images,
                                ];
                            }, $product['variants'])
                        ) ?>;

    document.addEventListener('DOMContentLoaded', () => {
        const addToCartBtn = document.querySelector('.product-detail__btn-add-cart');
        const qtyInput = document.querySelector('.product-detail__qty-input');
        let selectedSkuId = variants[0].sku_id; // Mặc định chọn SKU đầu tiên

        // Xử lý chọn màu sắc
        document.querySelectorAll('.product-detail__color-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.product-detail__color-btn').forEach(b => b.classList.remove('product-detail__color-btn--active'));
                btn.classList.add('product-detail__color-btn--active');
                updateSelectedSku();
            });
        });

        // Xử lý chọn dung lượng
        document.querySelectorAll('.product-detail__capacity-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.product-detail__capacity-btn').forEach(b => b.classList.remove('product-detail__capacity-btn--active'));
                btn.classList.add('product-detail__capacity-btn--active');
                updateSelectedSku();
            });
        });

        // Cập nhật SKU dựa trên màu sắc và dung lượng
        function updateSelectedSku() {
            const selectedColor = document.querySelector('.product-detail__color-btn--active')?.dataset.value;
            const selectedCapacity = document.querySelector('.product-detail__capacity-btn--active')?.dataset.value;
            selectedSkuId = variants.find(v => {
                const attrs = v.attributes;
                return attrs.some(a => a.option_value === selectedColor) && attrs.some(a => a.option_value === selectedCapacity);
            })?.sku_id || variants[0].sku_id;
        }
        console.log('[Variants Debug] All variants:', variants);
        // Xử lý nút thêm vào giỏ hàng
        addToCartBtn.addEventListener('click', () => {
            const quantity = parseInt(qtyInput.value) || 1;

            console.log('[Add to Cart] Bắt đầu gửi request...');
            console.log('[Add to Cart] SKU:', selectedSkuId);
            console.log('[Add to Cart] Quantity:', quantity);

            fetch('/detail/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        sku_id: selectedSkuId,
                        quantity: quantity
                    })
                })
                .then(response => {
                    console.log('[Fetch] Raw response object:', response);
                    return response.text();
                })
                .then(text => {
                    console.log('[Fetch] Raw response text:', text);
                    const jsonMatch = text.match(/\{.*\}/s);
                    if (jsonMatch) {
                        const json = JSON.parse(jsonMatch[0]);
                        console.log('[Fetch] Parsed JSON:', json);
                        return json;
                    } else {
                        throw new Error('Không tìm thấy JSON hợp lệ trong response!');
                    }
                })
                .then(data => {
                    if (data.success) {
                        console.log('[Add to Cart] Success:', data.message);
                        alert(data.message);
                        if (data.redirect) {
                            window.location.href = data.redirect; // Chuyển hướng sang trang cart
                        }
                    } else {
                        console.warn('[Add to Cart] Failure:', data.message);
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('[Catch Block] Error occurred:', error);
                    alert('Đã xảy ra lỗi khi thêm vào giỏ hàng.');
                });
        });


        // Xử lý tăng/giảm số lượng (chưa hoàn thiện theo yêu cầu)
        document.querySelector('.product-detail__qty-btn--plus').addEventListener('click', () => {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });
        document.querySelector('.product-detail__qty-btn--minus').addEventListener('click', () => {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        });
    });
</script>


<?php View::endSection(); ?>