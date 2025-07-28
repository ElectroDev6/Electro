<?php extend('layout.main'); ?>

<?php section('content'); ?>
<section class="cart-page">
  <div class="cart-page__header">
    <div class="cart-page__breadcrumb">Trang chủ / Gicd /Applications/XAMPP/xamppfiles/htdocs/Electro
ỏ hàng</div>
    <h1 class="cart-page__title">Đây là trang giỏ hàng</h1>
  </div>

  <div class="container">
    <div class="main-content">
      <!-- Left: Cart Section -->
      <div class="cart">
        <div class="cart__header">
          <div class="cart__select-all">
            <input type="checkbox" id="select-all">
            <label for="select-all">Chọn tất cả (1)</label>
          </div>
        </div>

        <!-- Product 1 -->
        <div class="product product--selected">
          <div class="product__main">
            <input type="checkbox" class="product__checkbox" checked>
            <img src="https://cdn2.fptshop.com.vn/unsafe/128x0/filters:format(webp):quality(75)/00911929_robot_hut_bui_lau_nha_ecovacs_n30_pro_omni_f0d56eb739.png" alt="Robot hút bụi" class="product__image">
            <div class="product__info">
              <div class="product__name">Robot hút bụi lau nhà Dreame L40 Ultra Trắng</div>
              <div class="product__variant">Màu: Trắng ▼</div>
            </div>
            <div class="product__price">
              <span class="product__price--current">17.290.000 đ</span>
              <span class="product__price--original">35.990.000 đ</span>
            </div>
            <div class="product__quantity">
              <button class="product__quantity-btn">-</button>
              <input type="number" value="1" class="product__quantity-input">
              <button class="product__quantity-btn">+</button>
            </div>
            <button class="product__delete-btn">🗑</button>
          </div>

          <div class="warranty">
            <div class="warranty__text">
              <input type="checkbox"> Đặc quyền bảo hành trọn đời 
              <span class="warranty__price">+1.800.000 đ</span>
              <span class="warranty__price--original">3.600.000 đ</span>
            </div>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product">
          <div class="product__main">
            <input type="checkbox" class="product__checkbox">
            <img src="https://cdn2.fptshop.com.vn/unsafe/750x0/filters:format(webp):quality(75)/msi_mpg_271qrx_qd_oled_1_73a2121521.png" alt="Màn hình Xiaomi" class="product__image">
            <div class="product__info">
              <div class="product__name">Màn hình Xiaomi A27i EU...</div>
              <div class="product__variant">Màu: Đen ▼</div>
            </div>
            <div class="product__price">
              <span class="product__price--current">2.390.000 đ</span>
              <span class="product__price--original">3.000.000 đ</span>
            </div>
            <div class="product__quantity">
              <button class="product__quantity-btn">-</button>
              <input type="number" value="1" class="product__quantity-input">
              <button class="product__quantity-btn">+</button>
            </div>
            <button class="product__delete-btn">🗑</button>
          </div>

          <div class="warranty">
            <div class="warranty__text">
              <input type="checkbox"> Đặc quyền bảo hành trọn đời 
              <span class="warranty__price">+300.000 đ</span>
              <span class="warranty__price--original">600.000 đ</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Order Summary -->
      <div class="order-summary">
        <div class="order-summary__promos">
          <div class="promo">
            <div class="promo__icon">🎁</div>
            <span class="promo__text">Quà tặng</span>
            <button>Xem ngay</button>
          </div>

          <div class="promo">
            <div class="promo__icon">
              <img src="https://www.svgrepo.com/show/222709/voucher-coupon.svg" alt="Voucher" style="width: 20px; height: 20px;">
            </div>
            <span class="promo__text">Voucher</span>
            <button>Xem ngay</button>
          </div>

          <div class="promo">
            <div class="promo__icon promo__icon--points">⭐</div>
            <span class="promo__text">Đăng nhập để sử dụng điểm thưởng</span>
          </div>
        </div>

        <div class="order-summary__info">
          <h3 class="order-summary__title">Thông tin đơn hàng</h3>

          <div class="order-summary__table">
            <div class="order-summary__row">
              <div class="order-summary__label">Tổng tiền</div>
              <div class="order-summary__value">37.980.000 ₫</div>
            </div>
            <div class="order-summary__row">
              <div class="order-summary__label">Tổng khuyến mãi</div>
              <div class="order-summary__value">7.200.000 ₫</div>
            </div>
            <div class="order-summary__row order-summary__row--total">
              <div class="order-summary__label">Cần thanh toán</div>
              <div class="order-summary__value">30.780.000 ₫</div>
            </div>
            <div class="order-summary__row">
              <div class="order-summary__label">Điểm thưởng</div>
              <div class="order-summary__value">
                <span class="order-summary__points-badge">+7.695</span>
              </div>
            </div>
          </div>

          <a href="#" class="order-summary__view-details">Xem chi tiết ▼</a>
        </div>

        <button class="order-summary__checkout-btn">Xác nhận đơn</button>
      </div>
    </div>
  </div>
</section>
<?php endSection(); ?>
