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
              <div id="voucher-message"></div>
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
    <?php 
    $hasSelectedProducts = false; 
    $products = isset($cart['products']) && is_array($cart['products']) ? $cart['products'] : [];
    ?>
    
    <?php foreach ($products as $product): ?>
        <?php if (!empty($product['selected']) && isset($product['id'], $product['quantity'])): ?>
            <?php $hasSelectedProducts = true; ?>
            <input type="hidden" name="items[<?= htmlspecialchars($product['id']) ?>][sku_id]" value="<?= htmlspecialchars($product['id']) ?>">
            <input type="hidden" name="items[<?= htmlspecialchars($product['id']) ?>][quantity]" value="<?= htmlspecialchars($product['quantity']) ?>">
        <?php endif; ?>
    <?php endforeach; ?>
    <button type="submit" class="order-summary__checkout-btn" <?= $hasSelectedProducts ? '' : 'disabled' ?>>Xác nhận đơn</button>
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
      body: new FormData(form)
    }).then(() => window.location.reload());
  }

  document.querySelectorAll('.product__delete-form').forEach(form => {
    form.addEventListener('submit', (e) => {
      if (!confirm('Bạn có chắc muốn xoá sản phẩm này?')) {
        e.preventDefault();
      }
    });
  });

  document.getElementById('voucher-form')?.addEventListener('submit', (e) => {
    e.preventDefault();
    const form = e.target;
    fetch(form.action, {
      method: 'POST',
      body: new FormData(form)
    })
    .then(response => response.json())
    .then(data => {
      const messageDiv = document.getElementById('voucher-message');
      messageDiv.textContent = data.message;
      messageDiv.style.color = data.success ? 'green' : 'red';
      if (data.success) {
        setTimeout(() => window.location.reload(), 1000);
      }
    });
  });

 
document.getElementById('confirm-order-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const hasItems = document.querySelectorAll('input[name^="items"]').length > 0;
    if (!hasItems) {
        alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        return;
    }
    const form = this;
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Cart AJAX Error:', error);
        alert('Đã xảy ra lỗi khi gửi yêu cầu. Vui lòng thử lại.');
    });
});
</script>
    


<?php View::endSection(); ?>