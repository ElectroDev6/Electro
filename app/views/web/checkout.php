<?php use Core\View; ?>
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
    <form class="order-page" action="/checkout/submit" method="POST">
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
     <?php
$cart = $_SESSION['cart_data_' . ($_SESSION['user_id'] ?? session_id())] ?? null;
$allProducts = $cart['products'] ?? [];

// Lọc sản phẩm đã chọn
$products = array_filter($allProducts, fn($p) => !empty($p['selected']));

// Tính tổng giá (ví dụ)
$summary = [
    'total_price' => array_sum(array_map(fn($p) => ($p['sku_price'] ?? 0) * ($p['quantity'] ?? 1), $products)),
    'total_discount' => 0,  // bạn có thể tính nếu có data
    'shipping_fee' => $cart['summary']['shipping_fee'] ?? 0,
    'final_total' => 0,
];
$summary['final_total'] = $summary['total_price'] + $summary['shipping_fee'] - $summary['total_discount'];
?>

<div class="order-section">
  <div class="order-section__title">Sản phẩm trong đơn (<?= count($products) ?>)</div>

  <?php if (count($products) > 0): ?>
    <ul>
      <?php foreach ($products as $product): ?>
        <li>
          <img src="/img/products/thumbnails/<?= htmlspecialchars($product['image_url'] ?? '') ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không xác định') ?>" class="product__image">
          <span><?= htmlspecialchars($product['product_name'] ?? 'Sản phẩm không xác định') ?></span>
          <span>Số lượng: <?= htmlspecialchars($product['quantity'] ?? 1) ?></span>
          <span>Giá: <?= number_format($product['sku_price'] ?? 0, 0, ',', '.') ?> VND</span>
          <?php if (!empty($product['color'])): ?>
            <span>Màu: <?= htmlspecialchars($product['color']) ?></span>
          <?php endif; ?>
          <?php if (!empty($product['warranty_enabled'])): ?>
            <span>Bảo hành: Có</span>
            <!-- Nếu có giá bảo hành riêng thì hiển thị ở đây -->
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <div class="alert alert-danger">
              Không có sản phẩm nào được chọn để thanh toán. <a href="/cart">Quay lại giỏ hàng</a>
            </div>
  <?php endif; ?>
</div>


        </li>
    

        <!-- Người đặt hàng -->
        <div class="order-section">
          <div class="order-section__title">Người đặt hàng</div>
          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="name"
              placeholder="Họ và tên"
              value="<?= htmlspecialchars($_POST['name'] ?? $user['name'] ?? '') ?>"
              required
            />
          </div>
          <div class="order-form__group">
            <input
              type="tel"
              class="order-form__input"
              name="phone"
              placeholder="Số điện thoại"
              value="<?= htmlspecialchars($_POST['phone'] ?? $user['phone'] ?? '') ?>"
              required
            />
          </div>
          <div class="order-form__group">
            <input
              type="email"
              class="order-form__input"
              name="email"
              placeholder="Email (Không bắt buộc)"
              value="<?= htmlspecialchars($_POST['email'] ?? $user['email'] ?? '') ?>"
            />
          </div>
        </div>

        <!-- Hình thức nhận hàng -->
        <div class="order-section">
          <div class="order-section__title">Hình thức nhận hàng</div>
          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="address"
              placeholder="Tỉnh/Thành Phố, Quận/Huyện, Phường/Xã"
              value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
              required
            />
          </div>
          <div class="order-form__group">
            <input
              type="text"
              class="order-form__input"
              name="note"
              placeholder="Ghi chú đơn hàng của bạn"
              value="<?= htmlspecialchars($_POST['note'] ?? '') ?>"
            />
          </div>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="order-section">
          <div class="order-section__title">Phương thức thanh toán</div>
          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="cod" <?= (($_POST['payment_method'] ?? '') === 'cod') ? 'checked' : '' ?> checked />
              <span>Thanh toán khi nhận hàng</span>
            </label>
          </div>
          <div class="order-payment__method">
            <label>
              <input type="radio" name="payment_method" value="vnpay" <?= (($_POST['payment_method'] ?? '') === 'vnpay') ? 'checked' : '' ?> />
              <span>Thanh toán qua VNPay</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Sidebar đơn hàng -->
      <div class="order-page__sidebar">
        <div class="order-summary">
          <div class="order-summary__title">Thông tin đơn hàng</div>
          <div class="order-summary__row">
            <span>Tổng tiền</span>
            <span><?= number_format($summary['total_price'] ?? 0, 0, ',', '.'); ?> ₫</span>
          </div>
          <div class="order-summary__row">
            <span>Tổng khuyến mãi</span>
            <span class="order-summary__discount"><?= number_format($summary['total_discount'] ?? 0, 0, ',', '.'); ?> ₫</span>
          </div>
          <div class="order-summary__row">
            <span>Phí vận chuyển</span>
            <span><?= number_format($summary['shipping_fee'] ?? 0, 0, ',', '.'); ?> ₫</span>
          </div>
          <div class="order-summary__row">
            <span>Cần thanh toán</span>
            <div><?= number_format($summary['final_total'] ?? 0, 0, ',', '.'); ?> ₫</div>
          </div>
          <div class="order-summary__btn-wrapper">
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

<?php View::endSection(); ?>