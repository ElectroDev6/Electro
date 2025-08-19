<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<div class="container-main">
  <section class="cart-page">
    <div class="cart-page__header">
      <div class="cart-page__breadcrumb">
        <a href="/">Trang chủ</a> / Thanh Toán
      </div>
      <h1 class="cart-page__title">Đây là trang thanh toán</h1>
    </div>

    <!-- Form thanh toán -->
    <form class="order-page" action="/checkout/pay" method="POST">
      <input type="hidden" name="user_address_id" value="<?= htmlspecialchars($user_address['user_address_id'] ?? '') ?>">

      <div class="order-page__main">
        <a href="/cart" class="order-page__back-btn">Quay lại giỏ hàng</a>

        <!-- Hiển thị lỗi nếu có -->
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <!-- Sản phẩm trong đơn -->
        <div class="order-section">
          <div class="order-section__title">Sản phẩm trong đơn (<?= count($Items['products'] ?? []) ?>)</div>
          <?php foreach ($Items['products'] ?? [] as $product): ?>
            <div class="order-product-box" data-product-id="<?= htmlspecialchars($product['cart_item_id']) ?>">
              <div class="order-product">
                <div class="order-product__image">
                  <img src="/img/products/thumbnails/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                </div>
                <div class="order-product__info">
                  <div class="order-product__name"><?= htmlspecialchars($product['name']) ?></div>
                  <div class="order-product__color">Màu: <?= htmlspecialchars($product['color'] ?? 'Không rõ') ?></div>
                </div>
                <div class="order-product__price">
                  <span class="order-product__quantity">x<?= (int)$product['quantity'] ?></span>
                  <div class="order-product__current-price"><?= number_format($product['price'], 0, ',', '.') ?> ₫</div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Người đặt hàng -->
        <div class="order-section">
          <div class="order-section__title">Người đặt hàng</div>

          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="name"
              placeholder="Họ và tên"
              value="<?= htmlspecialchars($_POST['name'] ?? $user_address['name'] ?? '') ?>"
              readonly />
          </div>

          <div class="order-form__group">
            <input
              type="tel"
              class="order-form__input"
              name="phone"
              placeholder="Số điện thoại"
              value="<?= htmlspecialchars($_POST['phone'] ?? $user_address['phone_number'] ?? '') ?>"
              readonly />
          </div>

          <div class="order-form__group">
            <input
              type="email"
              class="order-form__input"
              name="email"
              placeholder="Email (Không bắt buộc)"
              value="<?= htmlspecialchars($_POST['email'] ?? $user_address['email'] ?? '') ?>"
              readonly />
          </div>
        </div>

        <!-- Hình thức nhận hàng -->
        <div class="order-section">
          <div class="order-section__header" style="display: flex; gap: 10px;">
            <div class="order-section__title">Thông tin nhận hàng</div>
            <button type="button" class="btn btn-primary" id="update-address">Cập nhật thông tin</button>
          </div>

          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="address"
              placeholder="Địa chỉ"
              value="<?= htmlspecialchars($_POST['address'] ?? $user_address['address'] ?? '') ?>"
              readonly />
          </div>
          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="address"
              placeholder="Phường / Xã"
              value="<?= htmlspecialchars($_POST['address'] ?? $user_address['ward_commune'] ?? '') ?>"
              readonly />
          </div>
          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="address"
              placeholder="Quận / Huyện"
              value="<?= htmlspecialchars($_POST['address'] ?? $user_address['district'] ?? '') ?>"
              readonly />
          </div>

          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="note"
              placeholder="Ghi chú đơn hàng của bạn"
              value="<?= htmlspecialchars($_POST['note'] ?? '') ?>" />
          </div>

          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="coupon_code"
              placeholder="Mã giảm giá (nếu có)"
              value="<?= htmlspecialchars($_POST['coupon_code'] ?? '') ?>" />
          </div>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="order-section">
          <div class="order-section__title">Phương thức thanh toán</div>

          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="cod" <?= (($_POST['payment_method'] ?? 'cod') === 'cod') ? 'checked' : '' ?> />
              <span>Thanh toán khi nhận hàng</span>
            </label>
          </div>

          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="bank_transfer" <?= (($_POST['payment_method'] ?? '') === 'bank_transfer') ? 'checked' : '' ?> />
              <span>Chuyển khoản ngân hàng</span>
            </label>
          </div>

          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="credit_card" <?= (($_POST['payment_method'] ?? '') === 'credit_card') ? 'checked' : '' ?> />
              <span>Thẻ tín dụng</span>
            </label>
          </div>

          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="momo" <?= (($_POST['payment_method'] ?? '') === 'momo') ? 'checked' : '' ?> />
              <span>Momo</span>
            </label>
          </div>

          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="zalopay" <?= (($_POST['payment_method'] ?? '') === 'zalopay') ? 'checked' : '' ?> />
              <span>ZaloPay</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Sidebar đơn hàng -->
      <div class="order-page__sidebar">
        <div class="order-summary__title">Thông tin đơn hàng</div>

        <div class="order-summary__row">
          <span>Tổng tiền</span>
          <span><?= number_format($Items['summary']['total_price'] ?? 0, 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Tổng khuyến mãi</span>
          <span class="order-summary__discount"><?= number_format($Items['summary']['total_discount'] ?? 0, 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row">
          <span>Phí vận chuyển</span>
          <span><?= number_format($Items['summary']['shipping_fee'] ?? 0, 0, ',', '.') ?> ₫</span>
        </div>

        <div class="order-summary__row order-summary__row--total">
          <span>Cần thanh toán</span>
          <div><?= number_format($Items['summary']['final_total'] ?? 0, 0, ',', '.') ?> ₫</div>
        </div>

        <div class="order-summary__btn-wrapper">
          <input type="hidden" name="amount" value="<?= (int)($Items['summary']['final_total'] ?? 0) ?>">

          <button type="submit" class="order-summary__btn">Đặt hàng</button>
        </div>

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

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const updateAddress = document.getElementById('update-address');

    updateAddress.addEventListener('click', () => {
      window.location.href = '/profile';
    })
  })
</script>

<?php View::endSection(); ?>