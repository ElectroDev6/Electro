<?php

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
            <span class="product-detail__breadcrumb-item">Trang chủ</span>
            <span class="product-detail__breadcrumb-separator">></span>
            <span class="product-detail__breadcrumb-item">Tivi OLED</span>
        </div>

        <!-- Product Main Section -->
        <div class="product-detail__main">
            <div class="product-detail__images">
                <!-- Main Image -->
                <div class="product-detail__main-image">
                    <img src="/images/tv-main.jpg" alt="Tivi OLED 65 inch" />
                    <div class="product-detail__promotion-badge">
                        <span class="product-detail__promo-text">TẤM NỀN QD-OLED THẾ HỆ MỚI</span>
                        <p>Nâng tầm trải nghiệm Quantum Dot với tấm nền QD-OLED mới nhất từ Samsung Display, mang đến hình ảnh sắc nét và màu sắc sống động như thật.</p>
                    </div>
                </div>

                <!-- Thumbnail Images -->
                <div class="product-detail__thumbnail-images">
                    <div class="product-detail__thumbnail product-detail__thumbnail--active">
                        <img src="/images/tv-thumb1.jpg" alt="Thumbnail 1" />
                    </div>
                    <div class="product-detail__thumbnail">
                        <img src="/images/tv-thumb2.jpg" alt="Thumbnail 2" />
                    </div>
                    <div class="product-detail__thumbnail">
                        <img src="/images/tv-thumb3.jpg" alt="Thumbnail 3" />
                    </div>
                    <div class="product-detail__thumbnail">
                        <img src="/images/tv-thumb4.jpg" alt="Thumbnail 4" />
                    </div>
                    <div class="product-detail__thumbnail">
                        <img src="/images/tv-thumb5.jpg" alt="Thumbnail 5" />
                    </div>
                    <div class="product-detail__thumbnail">
                        <img src="/images/tv-thumb6.jpg" alt="Thumbnail 6" />
                    </div>
                </div>
            </div>

            <div class="product-detail__info">
                <h1 class="product-detail__title">Tivi OLED Samsung QE65S95D 65 inch 4K Smart TV Quantum Dot mới 2024</h1>

                <div class="product-detail__rating">
                    <div class="product-detail__stars">
                        <span>★★★★★</span>
                    </div>
                    <span class="product-detail__rating-text">(234 đánh giá)</span>
                </div>

                <div class="product-detail__price">
                    <div class="product-detail__current-price">23.990.000₫</div>
                    <div class="product-detail__original-price">29.990.000₫</div>
                    <div class="product-detail__discount-badge">-20%</div>
                </div>

                <div class="product-detail__options">
                    <div class="product-detail__size-options">
                        <label class="product-detail__size-label">Kích thước:</label>
                        <div class="product-detail__size-buttons">
                            <button class="product-detail__size-btn">55 inch</button>
                            <button class="product-detail__size-btn product-detail__size-btn--active">65 inch</button>
                            <button class="product-detail__size-btn">75 inch</button>
                        </div>
                    </div>

                    <div class="product-detail__color-options">
                        <label class="product-detail__color-label">Màu sắc:</label>
                        <div class="product-detail__color-buttons">
                            <button class="product-detail__color-btn product-detail__color-btn--active" style="background: #000"></button>
                            <button class="product-detail__color-btn" style="background: #666"></button>
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
                    <button class="product-detail__btn-buy-now">Mua ngay</button>
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
                    <img src="/images/tv-feature.jpg" alt="Tính năng sản phẩm" />
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
            <h2 class="product-detail__reviews-title">Mô tả sản phẩm</h2>
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
                        <img src="/images/avatar1.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Nguyễn Văn A</h4>
                            <div class="product-detail__review-rating">★★★★★</div>
                            <span class="product-detail__review-date">2 tháng trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Sản phẩm rất tốt, hình ảnh sắc nét, màn hình lớn phù hợp với phòng khách. Giao hàng nhanh, đóng gói cẩn thận. Tôi rất hài lòng với sản phẩm này. Sẽ tiếp tục ủng hộ shop.</p>
                        <div class="product-detail__review-images">
                            <img src="/images/review1.jpg" alt="Review image" />
                            <img src="/images/review2.jpg" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/images/avatar2.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Trần Thị B</h4>
                            <div class="product-detail__review-rating">★★★★☆</div>
                            <span class="product-detail__review-date">1 tháng trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Tivi đẹp, chất lượng tốt. Nhân viên tư vấn nhiệt tình. Giao hàng đúng hẹn. Giá cả hợp lý. Recommend!</p>
                        <div class="product-detail__review-images">
                            <img src="/images/review3.jpg" alt="Review image" />
                            <img src="/images/review4.jpg" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/images/avatar3.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Lê Văn C</h4>
                            <div class="product-detail__review-rating">★★★★★</div>
                            <span class="product-detail__review-date">3 tuần trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Màn hình to, hình ảnh đẹp, âm thanh hay. Shop tư vấn nhiệt tình, giao hàng nhanh. Sẽ giới thiệu cho bạn bè.</p>
                        <div class="product-detail__review-images">
                            <img src="/images/review5.jpg" alt="Review image" />
                            <img src="/images/review6.jpg" alt="Review image" />
                        </div>
                    </div>
                </div>

                <div class="product-detail__review-item">
                    <div class="product-detail__reviewer-info">
                        <img src="/images/avatar4.jpg" alt="User avatar" class="product-detail__reviewer-avatar" />
                        <div class="product-detail__reviewer-details">
                            <h4 class="product-detail__reviewer-name">Phạm Thị D</h4>
                            <div class="product-detail__review-rating">★★★★☆</div>
                            <span class="product-detail__review-date">2 tuần trước</span>
                        </div>
                    </div>
                    <div class="product-detail__review-content">
                        <p>Sản phẩm tốt, đúng như mô tả. Chất lượng hình ảnh rất đẹp. Âm thanh to rõ. Giá hợp lý. Cảm ơn shop!</p>
                        <div class="product-detail__review-images">
                            <img src="/images/review7.jpg" alt="Review image" />
                            <img src="/images/review8.jpg" alt="Review image" />
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
            <h2 class="product-detail__related-title">Có thể bạn cũng thích</h2>
            <div class="product-detail__products-grid">
                <div class="product-detail__product-card">
                    <div class="product-detail__product-image">
                        <img src="/images/product1.jpg" alt="Product 1" />
                    </div>
                    <div class="product-detail__product-info">
                        <h3 class="product-detail__product-name">Tivi OLED LG C3 55 inch</h3>
                        <div class="product-detail__product-price">
                            <span class="product-detail__current-price">18.990.000₫</span>
                            <span class="product-detail__original-price">22.990.000₫</span>
                        </div>
                        <button class="product-detail__btn-add-cart">Thêm vào giỏ</button>
                    </div>
                </div>

                <div class="product-detail__product-card">
                    <div class="product-detail__product-image">
                        <img src="/images/product2.jpg" alt="Product 2" />
                    </div>
                    <div class="product-detail__product-info">
                        <h3 class="product-detail__product-name">Tivi QLED Samsung QN65Q80C</h3>
                        <div class="product-detail__product-price">
                            <span class="product-detail__current-price">25.990.000₫</span>
                            <span class="product-detail__original-price">29.990.000₫</span>
                        </div>
                        <button class="product-detail__btn-add-cart">Thêm vào giỏ</button>
                    </div>
                </div>

                <div class="product-detail__product-card">
                    <div class="product-detail__product-image">
                        <img src="/images/product3.jpg" alt="Product 3" />
                    </div>
                    <div class="product-detail__product-info">
                        <h3 class="product-detail__product-name">Tivi Sony X90L 65 inch</h3>
                        <div class="product-detail__product-price">
                            <span class="product-detail__current-price">21.990.000₫</span>
                            <span class="product-detail__original-price">24.990.000₫</span>
                        </div>
                        <button class="product-detail__btn-add-cart">Thêm vào giỏ</button>
                    </div>
                </div>

                <div class="product-detail__product-card">
                    <div class="product-detail__product-image">
                        <img src="/images/product4.jpg" alt="Product 4" />
                    </div>
                    <div class="product-detail__product-info">
                        <h3 class="product-detail__product-name">Tivi TCL C845 65 inch</h3>
                        <div class="product-detail__product-price">
                            <span class="product-detail__current-price">19.990.000₫</span>
                            <span class="product-detail__original-price">23.990.000₫</span>
                        </div>
                        <button class="product-detail__btn-add-cart">Thêm vào giỏ</button>
                    </div>
                </div>

                <div class="product-detail__product-card">
                    <div class="product-detail__product-image">
                        <img src="/images/product5.jpg" alt="Product 5" />
                    </div>
                    <div class="product-detail__product-info">
                        <h3 class="product-detail__product-name">Tivi Xiaomi A Pro 65 inch</h3>
                        <div class="product-detail__product-price">
                            <span class="product-detail__current-price">16.990.000₫</span>
                            <span class="product-detail__original-price">19.990.000₫</span>
                        </div>
                        <button class="product-detail__btn-add-cart">Thêm vào giỏ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php View::endSection(); ?>