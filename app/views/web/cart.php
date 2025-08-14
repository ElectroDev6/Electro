<?php

use Core\View;
?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>


<div class="container-main">
  <section class="cart-page">
    <div class="cart-page__header">
      <div class="cart-page__breadcrumb">
        <a href="/">Trang chủ</a> / Giỏ hàng
      </div>
      <h1 class="cart-page__title">Giỏ hàng</h1>
    </div>

    <div class="container">
      <div class="main-content" style="display: flex;">
        <!-- Left: Cart Section -->
        <div class="cart">
          <?php if (!isset($cart['products']) || count($cart['products']) === 0): ?>
            <div class="cart__empty">
              <p>🛒 Giỏ hàng của bạn chưa có sản phẩm nào!</p>
            </div>
          <?php else: ?>
            <div class="cart__header">
              <form method="POST" action="/cart/select-all" id="select-all-form">
                <input type="checkbox" id="select-all" name="select_all" onchange="toggleSelectAll(this)" <?= array_filter($cart['products'], fn($p) => $p['selected']) === $cart['products'] ? 'checked' : '' ?>>
                <label for="select-all">Chọn tất cả (<?= count($cart['products']) ?>)</label>
              </form>
            </div>

            <?php foreach ($cart['products'] as $product): ?>
              <div class="product <?= $product['selected'] ? 'product--selected' : '' ?>">
                <div class="product__main">
                  <form method="POST" action="/cart/select-product">
                    <input type="hidden" name="sku_id" value="<?= $product['id'] ?>">
                    <input type="checkbox" class="product__checkbox" name="selected" onchange="this.form.submit()" <?= $product['selected'] ? 'checked' : '' ?>>
                  </form>

                  <img src="/img/products/thumbnails/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product__image">

                  <div class="product__info">
                    <div class="product__name"><?= htmlspecialchars($product['name']) ?></div>
                    <form method="POST" action="/cart/update-color" class="product__variant">
                      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                      <label for="color-select-<?= $product['id'] ?>">Màu:</label>
                      <select name="color" id="color-select-<?= $product['id'] ?>" onchange="this.form.submit()">
                        <?php foreach ($product['available_colors'] as $colorOption): ?>
                          <option value="<?= htmlspecialchars($colorOption) ?>" <?= $colorOption === $product['color'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($colorOption) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </form>
                  </div>

                  <div class="product__price">
                    <span class="product__price--current"><?= number_format($product['price_current'], 0, ',', '.') ?> ₫</span>
                    <span class="product__price--original"><?= number_format($product['price_original'], 0, ',', '.') ?> ₫</span>
                  </div>

                  <div class="product__quantity">
                    <form method="POST" action="/cart/update-quantity" class="quantity-form">
                      <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                      <div class="quantity-control">
                        <button type="button" class="quantity-btn quantity-btn-minus" onclick="changeQuantity(this, -1)">−</button>
                        <input type="text" name="quantity" value="<?= $product['quantity'] ?>" class="quantity-input" readonly>
                        <button type="button" class="quantity-btn quantity-btn-plus" onclick="changeQuantity(this, 1)">+</button>
                      </div>
                    </form>
                  </div>

                  <form method="POST" action="/cart/delete" class="product__delete-form">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="product__delete-btn">🗑</button>
                  </form>
                </div>

                <div class="warranty">
                  <form method="POST" action="/cart/update-warranty">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="checkbox" name="warranty" onchange="this.form.submit()" <?= $product['warranty']['enabled'] ? 'checked' : '' ?>>
                    Đặc quyền bảo hành trọn đời
                    <span class="warranty__price">+<?= number_format($product['warranty']['price'], 0, ',', '.') ?> ₫</span>
                    <span class="warranty__price--original"><?= number_format($product['warranty']['price_original'], 0, ',', '.') ?> ₫</span>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Right: Order Summary -->
        <?php if (!empty($cart['products'])): ?>
          <div class="order-summary">
            <div class="order-summary__promos">
              <form method="POST" action="/cart/apply-voucher" id="voucher-form">
                <input type="text" name="voucher_code" placeholder="Nhập mã voucher" value="<?= htmlspecialchars($cart['summary']['voucher_code']) ?>">
                <button type="submit">Áp dụng</button>
              </form>
              <div id="voucher-message">
                <?php
                if (isset($_SESSION['voucher_message'])) {
                  echo htmlspecialchars($_SESSION['voucher_message']);
                  unset($_SESSION['voucher_message']); // Xóa thông báo sau khi hiển thị
                }
                ?>
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

            <form method="POST" action="/cart/confirm" id="confirm-order-form">
              <button type="submit" class="order-summary__checkout-btn">Xác nhận đơn</button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>

<script>
  function toggleSelectAll(checkbox) {
    const form = document.getElementById('select-all-form');
    fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(() => window.location.reload());
  }

  document.querySelectorAll('.product__delete-form').forEach(form => {
    form.addEventListener('submit', (e) => {
      if (!confirm('Bạn có chắc muốn xoá sản phẩm này?')) {
        e.preventDefault();
      }
    });
  });

  // Xử lý voucher-form
  const voucherForm = document.getElementById('voucher-form');
  if (voucherForm) {
    voucherForm.addEventListener('submit', async function(event) {
      event.preventDefault();
      const form = event.target;
      const formData = new FormData(form);
      const messageDiv = document.getElementById('voucher-message');

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        messageDiv.textContent = result.message;
        messageDiv.style.color = result.success ? 'green' : 'red';

        if (result.success) {
          setTimeout(() => window.location.reload(), 1500);
        }
      } catch (error) {
        console.error('Error applying voucher:', error);
        messageDiv.textContent = 'Lỗi khi áp dụng voucher: ' + error.message;
        messageDiv.style.color = 'red';
      }
    });
  }

  // Xử lý confirm-order-form
  const confirmOrderForm = document.getElementById('confirm-order-form');
  if (confirmOrderForm) {
    confirmOrderForm.addEventListener('submit', async function(event) {
      event.preventDefault();
      const form = event.target;
      const messageDiv = document.getElementById('voucher-message');

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form),
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        if (result.success) {
          window.location.href = '/checkout';
        } else {
          messageDiv.textContent = result.message;
          messageDiv.style.color = 'red';
          if (result.redirect) {
            setTimeout(() => window.location.href = result.redirect, 1500);
          }
        }
      } catch (error) {
        console.error('Error confirming order:', error);
        messageDiv.textContent = 'Lỗi khi xác nhận đơn hàng: ' + error.message;
        messageDiv.style.color = 'red';
      }
    });
  }


  // // Kiểm tra post_login_redirect sau khi đăng nhập
  // window.addEventListener('load', async function() {
  //   const postLoginRedirect = '<?php echo isset($_SESSION['post_login_redirect']) ? $_SESSION['post_login_redirect'] : ''; ?>';
  //   if (postLoginRedirect) {
  //     try {
  //       const response = await fetch(postLoginRedirect, {
  //         method: 'GET',
  //         headers: {
  //           'X-Requested-With': 'XMLHttpRequest'
  //         }
  //       });
  //       const result = await response.json();
  //       if (result.success) {
  //         window.location.href = '/checkout';
  //       } else {
  //         const messageDiv = document.getElementById('voucher-message');
  //         messageDiv.textContent = result.message;
  //         messageDiv.style.color = 'red';
  //         if (result.redirect) {
  //           setTimeout(() => window.location.href = result.redirect, 1500);
  //         }
  //       }
  //       // Xóa post_login_redirect sau khi xử lý
  //       <?php unset($_SESSION['post_login_redirect']); ?>
  //     } catch (error) {
  //       console.error('Error handling post-login redirect:', error);
  //     }
  //   }
  // });
</script>

<?php View::endSection(); ?>