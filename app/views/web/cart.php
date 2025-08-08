<?php use Core\View; ?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

  <div class="container-main">
  <section class="cart-page">
   <div class="cart-page__header">
    <div class="cart-page__breadcrumb">
      <a href="/">Trang chủ</a> / Giỏ hàng
    </div>
    <h1 class="cart-page__title">Giỏ hàng của bạn</h1>
  </div>

    <div class="container">
  <div class="main-content">

    <!-- Left: Cart Section -->
    <div class="cart">
      <?php if (!isset($cart['products']) || count($cart['products']) === 0): ?>
        <div class="cart__empty">
          <p>🛒 Giỏ hàng của bạn chưa có sản phẩm nào!</p>
        </div>
      <?php else: ?>
        <?php
          $allSelected = true;
          foreach ($cart['products'] as $product) {
            if (empty($product['selected'])) {
              $allSelected = false;
              break;
            }
          }
        ?>
        <div class="cart__header">
          <div class="cart__select-all">
            <form method="POST" action="/cart/select-all" id="select-all-form">
    <input
        type="hidden"
        name="selected"
        value="<?= $allSelected ? '0' : '1' ?>"
    >
    <input
        type="checkbox"
        id="select-all"
        <?= $allSelected ? 'checked' : '' ?>
        onchange="document.getElementById('select-all-form').submit();"
    >
    <label for="select-all">
        Chọn tất cả (<?= count($cart['products']) ?>)
    </label>
</form>

          </div>
        </div>

        <?php foreach ($cart['products'] as $product): ?>
          <div class="product <?= $product['selected'] ? 'product--selected' : '' ?>">
            <div class="product__main">
              <input type="checkbox" class="product__checkbox" <?= $product['selected'] ? 'checked' : '' ?>>

              <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product__image">

              <div class="product__info">
                <div class="product__name"><?= htmlspecialchars($product['name']) ?></div>

                <form method="POST" action="/cart/update-color" class="product__variant">
                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                  <input type="hidden" name="sku_id" value="<?= $product['id'] ?>">
                  
                  <label for="color-select-<?= $product['id'] ?>">Màu:</label>
                  <select name="color" id="color-select-<?= $product['id'] ?>" onchange="this.form.submit()">
                      <?php foreach ($product['available_colors'] as $color): ?>
                          <option value="<?= htmlspecialchars($color) ?>"
                              <?= isset($_POST['selected_color']) && $_POST['selected_color'] === $color ? 'selected' : '' ?>>
                              <?= htmlspecialchars($color) ?>
                          </option>
                      <?php endforeach; ?>
                  </select>
              </form>



              </div>

              <div class="product__price">
                <span class="product__price--current"><?= number_format($product['price_current'], 0, ',', '.') ?> đ</span>
                <span class="product__price--original"><?= number_format($product['price_original'], 0, ',', '.') ?> đ</span>
              </div>

              <!-- Cập nhật số lượng -->
              <div class="product__quantity">
                <form method="POST" action="/cart/update-quantity">
                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                  <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1" class="product__quantity-input" onchange="this.form.submit()">
                </form>
              </div>

              <!-- Xoá sản phẩm -->
               <?php if (isset($_SESSION['message'])): ?>
                  <div class="alert">
                      <?= $_SESSION['message'] ?>
                  </div>
                  <?php unset($_SESSION['message']); ?>
              <?php endif; ?>
              <form method="POST" action="/cart/delete" onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?');" style="display:inline;">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="product__delete-btn">🗑</button>
              </form>
            </div>

            <div class="warranty">
              <div class="warranty__text">
                <input type="checkbox" <?= $product['warranty']['enabled'] ? 'checked' : '' ?>>
                Đặc quyền bảo hành trọn đời
                <span class="warranty__price">+<?= number_format($product['warranty']['price'], 0, ',', '.') ?> đ</span>
                <span class="warranty__price--original"><?= number_format($product['warranty']['price_original'], 0, ',', '.') ?> đ</span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Right: Order Summary -->
    <?php if (!empty($cart['products'])): ?>
      <div class="order-summary">
        <div class="order-summary__promos">
          <div class="promo">
            <div class="promo__icon">🎁</div>
            <span class="promo__text">Voucher</span>
            <input type="nhập voucher" name=" " value="">
            <button>Xác nhận voucher</button>
          </div>
        </div>

        <div class="order-summary__info">
          <h3 class="order-summary__title">Thông tin đơn hàng</h3>

          <div class="order-summary__table">
            <div class="order-summary__row">
              <div class="order-summary__label">Tổng tiền</div>
              <div class="order-summary__value"><?= number_format($cart['summary']['total_price'], 0, ',', '.') ?> ₫</div>
            </div>
            <div class="order-summary__row">
              <div class="order-summary__label">Tổng khuyến mãi</div>
              <div class="order-summary__value"><?= number_format($cart['summary']['total_discount'], 0, ',', '.') ?> ₫</div>
            </div>
            <div class="order-summary__row">
              <div class="order-summary__label">Tổng phí vận chuyển</div>
              <div class="order-summary__value"><?= number_format($cart['summary']['shipping_fee'], 0, ',', '.') ?> ₫</div>
            </div>
            <div class="order-summary__row order-summary__row--total">
              <div class="order-summary__label">Cần thanh toán</div>
              <div class="order-summary__value"><?= number_format($cart['summary']['final_total'], 0, ',', '.') ?> ₫</div>
            </div>            
          </div>
        </div>

        <form action="/cart/checkout" method="POST">
            <!-- Có thể kèm theo hidden input nếu cần gửi dữ liệu bổ sung -->
            <button type="submit" class="order-summary__checkout-btn">Xác nhận đơn</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>

  </section>
</div>


<?php View::endSection(); ?>
