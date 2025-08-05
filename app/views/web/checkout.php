<?php use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('page_title'); ?>Thanh toán<?php View::endSection(); ?>
<?php View::section('content'); ?>

<div class="container-main">
<section class="cart-page">
  <div class="cart-page__header">
    <div class="cart-page__breadcrumb">
      <a href="/">Trang chủ</a> / Thanh Toán
    </div>
    <h1 class="cart-page__title">Đây là trang thanh toán</h1>
  </div>

  <form class="order-page" action="/checkout" method="POST">
    <div class="order-page__main">
      <a href="/cart" class="order-page__back-btn">Quay lại giỏ hàng</a>

      <!-- Sản phẩm trong đơn -->
      <div class="order-section">
        <div class="order-section__title">Sản phẩm trong đơn (<?= count($cart['products']) ?>)</div>

        <?php foreach ($cart['products'] as $product): ?>
          <div class="order-product-box">
            <div class="order-product">
              <div class="order-product__image">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
              </div>
              <div class="order-product__info">
                <div class="order-product__name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="order-product__color">Màu: <?= htmlspecialchars($product['color']) ?></div>
              </div>
              <div class="order-product__price">
                <span class="order-product__quantity">x<?= $product['quantity'] ?></span>
                <div class="order-product__current-price"><?= number_format($product['price_current'], 0, ',', '.') ?> ₫</div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="order-gift">
          <span class="order-gift__icon">🎁</span> <?= count($cart['products']) ?> Quà tặng đơn hàng >
        </div>
      </div>

      <!-- Người đặt hàng -->
      <div class="order-section">
        <div class="order-section__title">Người đặt hàng</div>
        <div class="order-form__group">
          <input type="text" class="order-form__input" name="fullname" placeholder="Họ và tên" required />
        </div>
        <div class="order-form__group">
          <input type="tel" class="order-form__input" name="phone" placeholder="Số điện thoại" required />
        </div>
        <div class="order-form__group">
          <input type="email" class="order-form__input" name="email" placeholder="Email (Không bắt buộc)" />
        </div>
      </div>

      <!-- Hình thức nhận hàng -->
      <div class="order-section">
        <div class="order-section__title">Hình thức nhận hàng</div>
        <div class="order-form__group">
          <input type="text" class="order-form__input" name="address" placeholder="Tỉnh/Thành Phố, Quận/Huyện, Phường Xã" required />
        </div>
        <div class="order-form__group">
          <input type="text" class="order-form__input" name="note" placeholder="Ghi chú đơn hàng của bạn" />
        </div>
      </div>

      <!-- Phương thức thanh toán -->
      <div class="order-section">
        <div class="order-section__title">Phương thức thanh toán</div>
        <div class="order-payment__method">
          <label>
            <input type="radio" name="payment_method" value="cod" checked />
            <span>Thanh toán khi nhận hàng</span>
          </label>
        </div>
        <div class="order-payment__method">
          <label>
            <input type="radio" name="payment_method" value="vnpay" />
            <span>Thanh toán qua VNPay</span>
          </label>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="order-page__sidebar">
      <div class="order-summary">
        <div class="order-summary__title">Thông tin đơn hàng</div>

        <div class="order-summary__row">
          <span>Tổng tiền</span>
          <span><?= number_format($cart['summary']['total_price'], 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Tổng khuyến mãi</span>
          <span class="order-summary__discount"><?= number_format($cart['summary']['total_discount'], 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Phí vận chuyển</span>
          <span><?= number_format($cart['summary']['shipping_fee'], 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row order-summary__row--total">
          <span>Cần thanh toán</span>
          <div><?= number_format($cart['summary']['final_total'], 0, ',', '.') ?> ₫</div>
        </div>

        <div class="order-summary__row">
          <span>Voucher FreeShip</span>
          <span class="order-summary__points">-20.000</span>
        </div>

        <form action="/checkout/submit" method="POST">
  <!-- Các thông tin giỏ hàng, sản phẩm đã có ở đây -->
  <button type="submit" class="btn btn-primary">Đặt hàng</button>
</form>
        <div class="order-summary__terms">
          Bằng việc tiến hành đặt mua hàng, bạn đồng ý với
          <a href="#" class="order-summary__link-text">Điều khoản dịch vụ</a> và
          <a href="#" class="order-summary__link-text">Chính sách xử lý dữ liệu cá nhân</a>
          của <strong>Electro</strong>
        </div>
      </div>
    </div>
  </form>
</section>
</div>
<?php View::endSection(); ?>
