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
                            <?php if ($order['status'] === 'pending'): ?>
                                <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Bạn có chắc muốn chấp nhận đơn hàng này không?')">
                                        ✓ Chấp nhận
                                    </button>
                                </form>
                                <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('Bạn có chắc muốn từ chối đơn hàng này không?')">
                                        ✗ Từ chối
                                    </button>
                                </form>
                            <?php elseif ($order['status'] === 'paid' && $order['payment_status'] === 'success'): ?>
                                <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Duyệt đơn đã thanh toán này?')">
                                        ✓ Duyệt đơn
                                    </button>
                                </form>
                                <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit" class="btn btn--danger"
                                            onclick="return confirm('ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?')">
                                        ✗ Hủy & Hoàn tiền
                                    </button>
                                </form>
                            <?php elseif ($order['status'] === 'delivering'): ?>
                                <form action="/admin/orders/complete" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                    <button type="submit" class="btn btn--success"
                                            onclick="return confirm('Xác nhận giao hàng thành công?')">
                                        ✓ Đã giao xong
                                    </button>
                                </form>
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
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['order_code']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Tạo Đơn</span>
                                                <span class="info-row__value"><?php echo date('H:i:s d/m/Y', strtotime($order['created_at'])); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Cập Nhật Lần Cuối</span>
                                                <span class="info-row__value"><?php echo date('H:i:s d/m/Y', strtotime($order['updated_at'])); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Trạng Thái Đơn Hàng</span>
                                                <span class="info-row__value"><?php
                                                    $statusMap = [
                                                        'pending' => 'Chờ duyệt',
                                                        'paid' => 'Đã thanh toán',
                                                        'delivering' => 'Đang giao hàng',
                                                        'delivered' => 'Đã giao',
                                                        'canceled' => 'Đã hủy'
                                                    ];
                                                    echo htmlspecialchars($statusMap[$order['status']] ?? $order['status']);
                                                    if ($order['status'] === 'delivered') {
                                                        echo ' - ' . date('H:i:s d/m/Y', strtotime($order['updated_at']));
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
                                                <span class="info-row__value"><?php echo htmlspecialchars('N/A'); // Chưa có dữ liệu phone, cần join thêm bảng users nếu có ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Email</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['username'] ?? 'N/A'); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Địa Chỉ Giao Hàng</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></span>
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
                                                    $status = $order['status'];
                                                    $paymentMethod = $order['payment_method'] ?? 'cod';
                                                    $paymentStatus = $order['payment_status'] ?? 'pending';
                                                    
                                                    if ($status === 'canceled') {
                                                        echo 'Đã hủy';
                                                        if ($paymentMethod !== 'cod' && $paymentStatus === 'success') {
                                                            echo ' - Chờ hoàn tiền';
                                                        }
                                                    } elseif ($paymentMethod === 'cod') {
                                                        if ($status === 'delivered') {
                                                            echo 'Đã thanh toán';
                                                        } else {
                                                            echo 'Chưa thanh toán';
                                                        }
                                                    } else {
                                                        echo ($paymentStatus === 'success') ? 'Đã thanh toán' : 'Chưa thanh toán';
                                                    }
                                                ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Thanh Toán</span>
                                                <span class="info-row__value"><?php echo $order['payment_status'] === 'success' ? date('H:i:s d/m/Y', strtotime($order['updated_at'])) : 'Chưa thanh toán'; ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Tổng Tiền</span>
                                                <span class="info-row__value"><?php echo number_format($order['total_price'], 0, ',', '.') . ' đ'; ?></span>
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
                                        <div class="products-table__cell products-table__cell--category">Danh Mục</div>
                                        <div class="products-table__cell products-table__cell--quantity">Số Lượng</div>
                                        <div class="products-table__cell products-table__cell--unit-price">Đơn Giá</div>
                                        <div class="products-table__cell products-table__cell--total">Thành Tiền</div>
                                    </div>
                                    <?php
                                    // Phân tích order_items từ chuỗi GROUP_CONCAT
                                    $items = [];
                                    if (!empty($order['order_items'])) {
                                        $itemStrings = explode(', ', $order['order_items']);
                                        foreach ($itemStrings as $itemString) {
                                            if (preg_match('/^(\d+) x SKU (\d+) \(@(\d+)đ\)$/', $itemString, $matches)) {
                                                $items[] = [
                            'quantity' => (int)$matches[1],
                            'sku_id' => (int)$matches[2],
                            'price' => (float)str_replace('.', '', $matches[3]) // Loại bỏ dấu chấm trong giá
                        ];
                                            }
                                        }
                                    }
                                    foreach ($items as $index => $item): ?>
                                        <div class="products-table__row">
                                            <div class="products-table__cell products-table__cell--product">
                                                <div class="product-item">
                                                    <img src="/images/placeholder.jpg" alt="SKU <?php echo htmlspecialchars($item['sku_id']); ?>" class="product-table__image">
                                                    <span class="product-item__name">SKU <?php echo htmlspecialchars($item['sku_id']); ?></span>
                                                </div>
                                            </div>
                                            <div class="products-table__cell products-table__cell--category">N/A</div>
                                            <div class="products-table__cell products-table__cell--quantity"><?php echo $item['quantity']; ?></div>
                                            <div class="products-table__cell products-table__cell--unit-price"><?php echo number_format($item['price'], 0, ',', '.') . ' đ'; ?></div>
                                            <div class="products-table__cell products-table__cell--total"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.') . ' đ'; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="order-summary">
                                    <?php
                                    $subtotal = array_sum(array_map(function($item) {
                                        return $item['price'] * $item['quantity'];
                                    }, $items));
                                    $discountAmount = 0; // Giả định, cần join coupons nếu có
                                    $shippingFee = 0; // Giả định, cần thêm logic nếu có
                                    ?>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Tạm Tính:</span>
                                        <span class="order-summary__value"><?php echo number_format($subtotal, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Giảm Giá:</span>
                                        <span class="order-summary__value"><?php echo number_format($discountAmount, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Phí Vận Chuyển:</span>
                                        <span class="order-summary__value"><?php echo number_format($shippingFee, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row order-summary__row--total">
                                        <span class="order-summary__label">Tổng Cộng:</span>
                                        <span class="order-summary__value"><?php echo number_format($subtotal - $discountAmount + $shippingFee, 0, ',', '.') . ' đ'; ?></span>
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
                                        // Giả định timeline dựa trên trạng thái và thời gian
                                        $timeline = [
                                            ['status' => $order['status'], 'timestamp' => $order['updated_at'], 'note' => $statusMap[$order['status']] ?? 'Cập nhật trạng thái']
                                        ];
                                        if ($order['payment_status'] === 'success' && $order['status'] !== 'pending') {
                                            $timeline[] = ['status' => 'paid', 'timestamp' => $order['updated_at'], 'note' => 'Thanh toán thành công'];
                                        }
                                        foreach ($timeline as $event): ?>
                                            <div class="activity-item">
                                                <span class="activity-item__icon">
                                                    <?php
                                                    $icons = [
                                                        'pending' => '📄',
                                                        'paid' => '💳',
                                                        'delivering' => '🚚',
                                                        'delivered' => '✅',
                                                        'canceled' => '✖️'
                                                    ];
                                                    echo $icons[$event['status']] ?? '📄';
                                                    ?>
                                                </span>
                                                <div class="activity-item__content">
                                                    <div class="activity-item__title"><?php
                                                        echo htmlspecialchars($statusMap[$event['status']] ?? $event['note']);
                                                    ?></div>
                                                    <div class="activity-item__time"><?php echo date('d/m/Y H:i', strtotime($event['timestamp'])); ?></div>
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