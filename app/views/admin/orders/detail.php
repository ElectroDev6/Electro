<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng #<?php echo isset($order) ? htmlspecialchars($order['order_id']) : htmlspecialchars($_GET['id'] ?? ''); ?> - Electro</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="page">
            <?php if (isset($errorMessage)): ?>
                <div class="page__error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php elseif (isset($order)): ?>
                <!-- Header -->
                <div class="page__header">
                    <div class="breadcrumb">
                        <a href="/admin/orders" class="breadcrumb__link">← Quay lại danh sách / Chi tiết đơn hàng #<?php echo htmlspecialchars($order['order_id']); ?></a>
                    </div>
                    <div class="page__title-section">
                        <h1 class="page__title">Chi Tiết Đơn Hàng #<?php echo htmlspecialchars($order['order_id']); ?></h1>
                        <div class="page__actions">
                            <?php
                            $status = $order['status'] ?? 'pending';
                            $paymentStatus = $order['payment_status'] ?? 'pending';
                            $paymentMethod = $order['payment_method'] ?? 'cod';
                            ?>
                            <?php if ($status === 'pending'): ?>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Bạn có chắc muốn chấp nhận đơn hàng này không?')">
                                        ✓ Chấp nhận
                                    </button>
                                </form>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
                                        ✗ Hủy
                                    </button>
                                </form>
                            <?php elseif ($status === 'paid'): ?>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Chuẩn bị giao hàng cho đơn này?')">
                                        ✓ Chuẩn bị giao
                                    </button>
        </form>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('<?php echo ($paymentStatus === 'success' && $paymentMethod !== 'cod') ? 'ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?' : 'Bạn có chắc muốn hủy đơn hàng này không?'; ?>')">
                                        ✗ Hủy
                                    </button>
                                </form>
                            <?php elseif ($status === 'shipped'): ?>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="delivering">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Bắt đầu giao hàng cho đơn này?')">
                                        ✓ Bắt đầu giao
                                    </button>
                                </form>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('<?php echo ($paymentStatus === 'success' && $paymentMethod !== 'cod') ? 'ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?' : 'Bạn có chắc muốn hủy đơn hàng này không?'; ?>')">
                                        ✗ Hủy
                                    </button>
                                </form>
                            <?php elseif ($status === 'delivering'): ?>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('<?php echo ($paymentMethod === 'cod') ? 'Xác nhận giao hàng thành công và thu tiền?' : 'Xác nhận giao hàng thành công?'; ?>')">
                                        ✓ Giao thành công
                                    </button>
                                </form>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('<?php echo ($paymentStatus === 'success' && $paymentMethod !== 'cod') ? 'ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?' : 'Bạn có chắc muốn hủy đơn hàng này không?'; ?>')">
                                        ✗ Hủy
                                    </button>
                                </form>
                            <?php elseif ($status === 'completed'): ?>
                                <span class="btn btn--success" style="cursor: default;">✓ Đã hoàn thành</span>
                                <form action="/admin/orders/status" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('<?php echo ($paymentStatus === 'success' && $paymentMethod !== 'cod') ? 'ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?' : 'Bạn có chắc muốn hủy đơn hàng này không?'; ?>')">
                                        ✗ Hủy
                                    </button>
                                </form>
                            <?php elseif ($status === 'cancelled'): ?>
                                <span class="btn btn--danger" style="cursor: default;">✗ Đã hủy</span>
                            <?php endif; ?>
                            <a href="/admin/orders" class="btn btn--secondary">Quay lại</a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="page__content">
                    <div class="content">
                        <div class="content__main">
                            <!-- Order Information Section -->
                            <section class="info-section">
                                <div class="info-section__grid">
                                    <div class="info-card">
                                        <h3 class="info-card__title">Thông Tin Đơn Hàng</h3>
                                        <div class="info-card__content">
                                            <div class="info-row">
                                                <span class="info-row__label">Mã Đơn Hàng</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['order_code'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Tạo Đơn</span>
                                                <span class="info-row__value"><?php echo date('H:i:s d/m/Y', strtotime($order['created_at'] ?? 'now')); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Cập Nhật Lần Cuối</span>
                                                <span class="info-row__value"><?php echo date('H:i:s d/m/Y', strtotime($order['updated_at'] ?? 'now')); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Trạng Thái Đơn Hàng</span>
                                                <span class="info-row__value"><?php
                                                    $statusMap = [
                                                        'pending' => 'Chờ duyệt',
                                                        'paid' => 'Đã chấp nhận',
                                                        'shipped' => 'Chuẩn bị giao',
                                                        'delivering' => 'Đang giao hàng',
                                                        'completed' => 'Hoàn thành',
                                                        'cancelled' => 'Đã hủy'
                                                    ];
                                                    echo htmlspecialchars($statusMap[$order['status']] ?? $order['status']);
                                                    if ($order['status'] === 'completed') {
                                                        echo ' - ' . date('H:i:s d/m/Y', strtotime($order['updated_at'] ?? 'now'));
                                                    }
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-card">
                                        <h3 class="info-card__title">Thông Tin Khách Hàng</h3>
                                        <div class="info-card__content">
                                            <div class="info-row">
                                                <span class="info-row__label">Tên Khách Hàng</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['username'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Số Điện Thoại</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['phone_number'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Email</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['email'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Địa Chỉ Giao Hàng</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['full_address'] ?? 'N/A'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-card">
                                        <h3 class="info-card__title">Thông Tin Thanh Toán</h3>
                                        <div class="info-card__content">
                                            <div class="info-row">
                                                <span class="info-row__label">Phương Thức Thanh Toán</span>
                                                <span class="info-row__value"><?php 
                                                    $paymentMethods = [
                                                        'cod' => 'Thanh toán khi nhận hàng',
                                                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                                                        'momo' => 'MoMo'
                                                    ];
                                                    echo htmlspecialchars($paymentMethods[$order['payment_method']] ?? $order['payment_method'] ?? 'N/A'); 
                                                ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Trạng Thái Thanh Toán</span>
                                                <span class="info-row__value"><?php
                                                    $status = $order['status'] ?? 'pending';
                                                    $paymentMethod = $order['payment_method'] ?? 'cod';
                                                    $paymentStatus = $order['payment_status'] ?? 'pending';
                                                    if ($status === 'cancelled') {
                                                        echo 'Đã hủy';
                                                        if ($paymentMethod !== 'cod' && $paymentStatus === 'success') {
                                                            echo ' - Chờ hoàn tiền';
                                                        }
                                                    } elseif ($paymentMethod === 'cod') {
                                                        if ($status === 'completed') {
                                                            echo 'Đã thanh toán';
                                                        } else {
                                                            echo 'Chưa thanh toán';
                                                        }
                                                    } else {
                                                        echo ($paymentStatus === 'success') ? 'Đã thanh toán' : 'Chưa thanh toán';
                                                    }
                                                ?></span>
                                            </div>
                                            <?php if (isset($order['coupon_code']) && $order['coupon_code']): ?>
                                            <div class="info-row">
                                                <span class="info-row__label">Mã Giảm Giá</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['coupon_code']) . ' (-' . ($order['coupon_discount'] ?? 0) . '%)'; ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Thanh Toán</span>
                                                <span class="info-row__value"><?php echo ($paymentStatus === 'success' && $paymentMethod !== 'cod') ? date('H:i:s d/m/Y', strtotime($order['updated_at'] ?? 'now')) : 'Chưa thanh toán'; ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Tổng Tiền</span>
                                                <span class="info-row__value"><?php echo number_format($order['total_price'] ?? 0, 0, ',', '.') . ' đ'; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Products Section -->
                            <section class="products-section">
                                <h3 class="products-section__title">Sản Phẩm Đã Đặt</h3>
                                <div class="products-table">
                                    <div class="products-table__header">
                                        <div class="products-table__cell products-table__cell--product">Sản Phẩm</div>
                                        <div class="products-table__cell products-table__cell--category">Thương Hiệu</div>
                                        <div class="products-table__cell products-table__cell--quantity">Số Lượng</div>
                                        <div class="products-table__cell products-table__cell--unit-price">Đơn Giá</div>
                                        <div class="products-table__cell products-table__cell--total">Thành Tiền</div>
                                    </div>
                                    
                                    <?php if (!empty($order['order_items'])): ?>
                                        <?php foreach ($order['order_items'] as $item): ?>
                                            <div class="products-table__row">
                                                <div class="products-table__cell products-table__cell--product">
                                                    <div class="product-item">
                                                        <img src="/img/products/gallery/<?php echo htmlspecialchars($item['image_path'] ?? '/images/placeholder.jpg'); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['product_name'] ?? 'N/A'); ?>" 
                                                             class="product-table__image">
                                                        <div class="product-item__info">
                                                            <span class="product-item__name"><?php echo htmlspecialchars($item['product_name'] ?? 'N/A'); ?></span>
                                                            <span class="product-item__sku">SKU: <?php echo htmlspecialchars($item['sku_code'] ?? 'N/A'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="products-table__cell products-table__cell--category">
                                                    <?php echo htmlspecialchars($item['brand_name'] ?? 'N/A'); ?>
                                                </div>
                                                <div class="products-table__cell products-table__cell--quantity">
                                                    <?php echo $item['quantity'] ?? 0; ?>
                                                </div>
                                                <div class="products-table__cell products-table__cell--unit-price">
                                                    <?php echo number_format($item['price'] ?? 0, 0, ',', '.') . ' đ'; ?>
                                                </div>
                                                <div class="products-table__cell products-table__cell--total">
                                                    <?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') . ' đ'; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="products-table__row">
                                            <div class="products-table__cell" colspan="5">Không có sản phẩm nào</div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="order-summary">
                                    <?php
                                    $subtotal = $order['calculated_total'] ?? $order['total_price'] ?? 0;
                                    $discountAmount = 0;
                                    if (isset($order['coupon_discount']) && $order['coupon_discount'] > 0) {
                                        $discountAmount = $subtotal * ($order['coupon_discount'] / 100);
                                    }
                                    $finalTotal = isset($order['discounted_total']) ? $order['discounted_total'] : ($subtotal - $discountAmount);
                                    ?>
                                    
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Tạm Tính:</span>
                                        <span class="order-summary__value"><?php echo number_format($subtotal, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    
                                    <?php if ($discountAmount > 0): ?>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Giảm Giá (<?php echo $order['coupon_code'] ?? 'N/A'; ?> -<?php echo $order['coupon_discount'] ?? 0; ?>%):</span>
                                        <span class="order-summary__value">-<?php echo number_format($discountAmount, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Phí Vận Chuyển:</span>
                                        <span class="order-summary__value">Miễn phí</span>
                                    </div>
                                    
                                    <div class="order-summary__row order-summary__row--total">
                                        <span class="order-summary__label">Tổng Cộng:</span>
                                        <span class="order-summary__value"><?php echo number_format($finalTotal, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Sidebar -->
                        <aside class="content__sidebar">
                            <div class="order-sidebar">
                                <div class="order-sidebar__section">
                                    <h3 class="order-sidebar__title">Lịch Sử Hoạt Động</h3>
                                    <div class="activity-list">
                                        <?php
                                        // Tạo timeline dựa trên dữ liệu
                                        $timeline = [];
                                        
                                        // 1. Đơn hàng được tạo (luôn có)
                                        $timeline[] = [
                                            'time' => $order['created_at'] ?? 'now',
                                            'title' => 'Đơn hàng được tạo',
                                            'icon' => '📄'
                                        ];
                                        
                                        // 2. Thanh toán (nếu có và không phải COD)
                                        if (($order['payment_status'] ?? 'pending') === 'success' && ($order['payment_method'] ?? 'cod') !== 'cod') {
                                            $timeline[] = [
                                                'time' => $order['updated_at'] ?? 'now',
                                                'title' => 'Thanh toán thành công',
                                                'icon' => '💳'
                                            ];
                                        }
                                        
                                        // 3. Cập nhật trạng thái đơn hàng
                                        $statusTitles = [
                                            'paid' => 'Đã chấp nhận',
                                            'shipped' => 'Chuẩn bị giao',
                                            'delivering' => 'Đang giao hàng',
                                            'completed' => 'Giao hàng thành công',
                                            'cancelled' => 'Đơn hàng đã bị hủy'
                                        ];
                                        $statusIcons = [
                                            'paid' => '✅',
                                            'shipped' => '📦',
                                            'delivering' => '🚚',
                                            'completed' => '✔️',
                                            'cancelled' => '❌'
                                        ];
                                        
                                        if ($order['status'] !== 'pending') {
                                            $timeline[] = [
                                                'time' => $order['updated_at'] ?? 'now',
                                                'title' => $statusTitles[$order['status']] ?? 'Cập nhật trạng thái',
                                                'icon' => $statusIcons[$order['status']] ?? '📄'
                                            ];
                                        }
                                        
                                        // Sắp xếp theo thời gian (mới nhất trên đầu)
                                        usort($timeline, function($a, $b) {
                                            return strtotime($b['time']) - strtotime($a['time']);
                                        });
                                        ?>
                                        
                                        <?php foreach ($timeline as $event): ?>
                                        <div class="activity-item">
                                            <span class="activity-item__icon"><?php echo $event['icon']; ?></span>
                                            <div class="activity-item__content">
                                                <div class="activity-item__title"><?php echo htmlspecialchars($event['title']); ?></div>
                                                <div class="activity-item__time"><?php echo date('d/m/Y H:i', strtotime($event['time'])); ?></div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            <?php else: ?>
                <div class="page__error">Không tìm thấy đơn hàng.</div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>