<?php use Core\View; ?>

<?php foreach ($cart['products'] as $product): ?>
  <div class="product <?= $product['selected'] ? 'product--selected' : '' ?>">
    <div class="product__main">
      <input type="checkbox" class="product__checkbox" <?= $product['selected'] ? 'checked' : '' ?>>

      <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product__image">

      <div class="product__info">
        <div class="product__name"><?= htmlspecialchars($product['name']) ?></div>
        <div class="product__variant">Màu: <?= htmlspecialchars($product['color']) ?> ▼</div>
      </div>

      <div class="product__price">
        <span class="product__price--current"><?= number_format($product['price_current'], 0, ',', '.') ?> đ</span>
        <span class="product__price--original"><?= number_format($product['price_original'], 0, ',', '.') ?> đ</span>
      </div>

      <!-- Form cập nhật số lượng -->
      <div class="product__quantity">
        <form method="POST" action="/cart/update-quantity">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1" class="product__quantity-input" onchange="this.form.submit()">
        </form>
      </div>

      <!-- Form xoá sản phẩm -->
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
