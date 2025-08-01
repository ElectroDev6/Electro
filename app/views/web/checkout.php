<?php

use Core\View; ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Thanh toán
<?php View::endSection(); ?>

<?php View::section('content'); ?>
<section class="cart-page">
  <div class="cart-page__header">
    <div class="cart-page__breadcrumb">
      <a href="#">Trang chủ</a> / Thanh Toán
    </div>
    <h1 class="cart-page__title">Đây là trang thanh toán</h1>
  </div>

  <div class="order-page">
    <div class="order-page__main">
      <a href="#" class="order-page__back-btn">Quay lại giỏ hàng</a>

      <!-- Sản phẩm trong đơn -->
      <div class="order-section">
        <div class="order-section__title">Sản phẩm trong đơn (2)</div>

        <!-- Product 1 -->
        <div class="order-product-box">
          <div class="order-product">
            <div class="order-product__image">
              <img src="https://cdn2.fptshop.com.vn/unsafe/96x0/filters:format(webp):quality(75)/msi_mpg_271qrx_qd_oled_1_73a2121521.png" alt="">
            </div>
            <div class="order-product__info">
              <div class="order-product__name">
                Laptop MSI Gaming Crosshair 16 HX D2XWFKG-070VN...
              </div>
              <div class="order-product__color">Màu: Xám</div>
            </div>
            <div class="order-product__price">
              <span class="order-product__quantity">x1</span>
              <div class="order-product__current-price">41.990.000 ₫</div>

            </div>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="order-product-box">
          <div class="order-product">
            <div class="order-product__image">
              <img src="https://cdn2.fptshop.com.vn/unsafe/96x0/filters:format(webp):quality(75)/msi_mpg_271qrx_qd_oled_1_73a2121521.png" alt="">
            </div>
            <div class="order-product__info">
              <div class="order-product__name">
                Laptop MSI Gaming Crosshair 16 HX D2XWFKG-070VN...
              </div>
              <div class="order-product__color">Màu: Xám</div>
            </div>
            <div class="order-product__price">
              <span class="order-product__quantity">x1</span>
              <div class="order-product__current-price">41.990.000 ₫</div>

            </div>
          </div>
        </div>

        <div class="order-gift">
          <span class="order-gift__icon">🎁</span> 9 Quà tặng đơn hàng >
        </div>
      </div>

      <!-- Người đặt hàng -->
      <div class="order-section">
        <div class="order-section__title">Người đặt hàng</div>
        <div class="order-form__group">
          <input type="text" class="order-form__input" placeholder="Họ và tên" />
        </div>
        <div class="order-form__group">
          <input type="tel" class="order-form__input" placeholder="Số điện thoại" />
        </div>
        <div class="order-form__group">
          <input type="email" class="order-form__input" placeholder="Email (Không bắt buộc)" />
        </div>
      </div>

      <!-- Hình thức nhận hàng -->
      <div class="order-section">
        <div class="order-section__title">Hình thức nhận hàng</div>
        <div class="order-delivery__option">
          <input type="radio" name="delivery" id="pickup" checked />
          <label for="pickup" class="order-delivery__label order-delivery__label--selected">Giao hàng tận nơi</label>
        </div>

        <div class="order-form__group">
          <input type="text" class="order-form__input" placeholder="Tỉnh/Thành Phố, Quận/Huyện, Phường Xã" />
        </div>

        <div class="order-form__group">
          <input type="text" class="order-form__input" placeholder="Ghi chú đơn hàng của bạn)" />
        </div>

        <div class="order-checkbox-group">
          <div class="order-checkbox__item">
            <input type="checkbox" id="other-receiver" />
            <label for="other-receiver" class="order-checkbox__label">Nhờ người khác nhận hàng</label>
          </div>
          <div class="order-checkbox__item">
            <input type="checkbox" id="tech-support" />
            <label for="tech-support" class="order-checkbox__label">Yêu cầu hỗ trợ kỹ thuật</label>
          </div>
          <div class="order-checkbox__item">
            <input type="checkbox" id="promotion" />
            <label for="promotion" class="order-checkbox__label">Có mã giới thiệu</label>
          </div>
        </div>
      </div>

      <!-- Xuất hóa đơn -->
      <div class="order-section">
        <div class="order-invoice-toggle">
          <span class="order-section__title">Xuất hóa đơn điện tử</span>
          <div class="order-invoice-toggle__switch"></div>
        </div>
      </div>

      <!-- Phương thức thanh toán -->
      <div class="order-section">
        <div class="order-section__title">Phương thức thanh toán</div>
        <div class="order-payment__method">
          <div class="order-payment__icon"></div>
          <span>Thanh toán khi nhận hàng</span>
        </div>
        
         
      </div>
      
    </div>

    <!-- Sidebar -->
    <div class="order-page__sidebar">
      <div class="order-summary">


        <div class="order-summary__title">Thông tin đơn hàng</div>

        <div class="order-summary__row">
          <span>Tổng tiền</span>
          <span>46.090.000 ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Tổng khuyến mãi</span>
          <span class="order-summary__discount">6.100.000 ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Phí vận chuyển</span>
          <span>Miễn phí</span>
        </div>

        <div class="order-summary__row order-summary__row--total">
          <span>Cần thanh toán</span>
          <div>39.990.000 ₫</div>
        </div>

        <div class="order-summary__row">
          <span>Voucher FreeShip</span>
          <span class="order-summary__points">-20.000</span>
        </div>

        <button class="order-summary__btn">Đặt hàng</button>

        <div class="order-summary__terms">
          Bằng việc tiến hành đặt mua hàng, bạn đồng ý với
          <a href="#" class="order-summary__link-text">Điều khoản dịch vụ</a> và
          <a href="#" class="order-summary__link-text">Chính sách xử lý dữ liệu cá nhân</a>
          của <strong>Electro</strong>
        </div>
      </div>
    </div>
  </div>
</section>
<?php View::endSection(); ?>