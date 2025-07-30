<?php
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/header.php';
include dirname(__DIR__) . '/admin/partials/pagination.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng #<?php echo isset($orderDetail) ? htmlspecialchars($orderDetail['id']) : htmlspecialchars($_GET['id'] ?? ''); ?> - Electro</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
<!-- Debug output (comment out in production) -->
<!-- <?php 
echo '<pre>';
print_r($orderDetail);
echo '</pre>'; 
?> -->
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="page">
            <?php if (isset($errorMessage)): ?>
                <div class="page__error"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php elseif (isset($orderDetail)): ?>
                <!-- Header -->
                <div class="page__header">
                    <div class="breadcrumb">
                        <a href="/admin/orders" class="breadcrumb__link">← Quay lại danh sách / Chi tiết đơn hàng #<?php echo htmlspecialchars($orderDetail['id']); ?></a>
                    </div>
                    <div class="page__title-section">
                        <h1 class="page__title">Chi Tiết Đơn Hàng #<?php echo htmlspecialchars($orderDetail['id']); ?></h1>
                        <div class="page__actions">
                            <?php if ($orderDetail['status'] === 'pending'): ?>
                                <button class="btn btn--success">Xác nhận</button>
                                <button class="btn btn--danger">Từ chối</button>
                            <?php endif; ?>
                            <button class="btn btn--warning">Chỉnh sửa</button>
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
                                                <span class="info-row__value"><?php echo htmlspecialchars($orderDetail['id']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Tạo Đơn</span>
                                                <span class="info-row__value"><?php echo date('H:i:s d/m/Y', strtotime($orderDetail['order_date'])); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Cập Nhật Lần Cuối</span>
                                                <span class="info-row__value"><?php
                                                    $lastTimeline = end($orderDetail['timeline']);
                                                    echo date('H:i:s d/m/Y', strtotime($lastTimeline['timestamp']));
                                                ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Trạng Thái Đơn Hàng</span>
                                                <span class="info-row__value"><?php
                                                    $statusMap = [
                                                        'pending' => 'Chờ duyệt',
                                                        'processing' => 'Đang xử lý',
                                                        'delivered' => 'Đã giao',
                                                        'cancelled' => 'Đã hủy'
                                                    ];
                                                    echo htmlspecialchars($statusMap[$orderDetail['status']] ?? $orderDetail['status']);
                                                    if ($orderDetail['status'] === 'delivered') {
                                                        echo ' ' . date('H:i:s d/m/Y', strtotime($lastTimeline['timestamp']));
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
                                                <span class="info-row__value"><?php echo htmlspecialchars($orderDetail['user']['full_name']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Số Điện Thoại</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($orderDetail['user']['phone']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Email</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($orderDetail['user']['username']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Địa Chỉ Giao Hàng</span>
                                                <span class="info-row__value"><?php
                                                    echo htmlspecialchars($orderDetail['address']['address_line'] . ', ' . $orderDetail['address']['ward'] . ', ' . $orderDetail['address']['district'] . ', ' . $orderDetail['address']['city']);
                                                ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-card">
                                        <h3 class="info-card__title">Thông Tin Thanh Toán</h3>
                                        <div class="info-card__content">
                                            <div class="info-row">
                                                <span class="info-row__label">Phương Thức Thanh Toán</span>
                                                <span class="info-row__value"><?php echo htmlspecialchars($orderDetail['payment_method']); ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Trạng Thái Thanh Toán</span>
                                                <span class="info-row__value"><?php
                                                    $paymentStatus = array_filter($orderDetail['timeline'], function($item) {
                                                        return $item['status'] === 'paid';
                                                    });
                                                    echo !empty($paymentStatus) ? 'Đã thanh toán' : 'Chờ thanh toán';
                                                ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Ngày Thanh Toán</span>
                                                <span class="info-row__value"><?php echo $orderDetail['payment_date'] ? date('H:i:s d/m/Y', strtotime($orderDetail['payment_date'])) : 'Chưa thanh toán'; ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-row__label">Tổng Tiền</span>
                                                <span class="info-row__value"><?php echo number_format($orderDetail['totals']['total_amount'], 0, ',', '.') . ' đ'; ?></span>
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
                                    <?php foreach ($orderDetail['items'] as $item): ?>
                                        <div class="products-table__row">
                                            <div class="products-table__cell products-table__cell--product">
                                                <div class="product-item">
                                                    <img src="<?php echo htmlspecialchars($item['variant_color']['variant']['media_url']); ?>" alt="<?php echo htmlspecialchars($item['variant_color']['variant']['media_alt']); ?>" class="product-table__image">
                                                    <span class="product-item__name"><?php
                                                        if(!empty($item['variant_color']['color']['name']) && !empty($item['variant_color']['variant']['capacity_group'])) {
                                                            echo htmlspecialchars($item['variant_color']['variant']['product']['name'] . ' (' . $item['variant_color']['color']['name'] . ', ' . $item['variant_color']['variant']['capacity_group'] . ')');
                                                        } else {
                                                            echo htmlspecialchars($item['variant_color']['variant']['product']['name']);
                                                        }
                                                    ?></span>
                                                </div>
                                            </div>
                                            <div class="products-table__cell products-table__cell--category"><?php echo htmlspecialchars($item['variant_color']['variant']['product']['category']['name']); ?></div>
                                            <div class="products-table__cell products-table__cell--quantity"><?php echo $item['quantity']; ?></div>
                                            <div class="products-table__cell products-table__cell--unit-price"><?php echo number_format($item['variant_color']['variant']['price'], 0, ',', '.') . ' đ'; ?></div>
                                            <div class="products-table__cell products-table__cell--total"><?php echo number_format($item['variant_color']['variant']['price'] * $item['quantity'], 0, ',', '.') . ' đ'; ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <div class="order-summary">
                                    <?php
                                        $subtotal = array_sum(array_map(function($item) {
                                            return $item['variant_color']['variant']['price'] * $item['quantity'];
                                        }, $orderDetail['items']));
                                        ?>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Tạm Tính:</span>
                                        <span class="order-summary__value"><?php echo number_format($subtotal, 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Giảm Giá:</span>
                                        <span class="order-summary__value"><?php echo number_format($orderDetail['totals']['discount_amount'], 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row">
                                        <span class="order-summary__label">Phí Vận Chuyển:</span>
                                        <span class="order-summary__value"><?php echo number_format($orderDetail['totals']['shipping_fee'], 0, ',', '.') . ' đ'; ?></span>
                                    </div>
                                    <div class="order-summary__row order-summary__row--total">
                                        <span class="order-summary__label">Tổng Cộng:</span>
                                        <span class="order-summary__value"><?php echo number_format($subtotal -  $orderDetail['totals']['discount_amount'] + $orderDetail['totals']['shipping_fee']). ' đ';?></span>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Sidebar -->
                        <aside class="content__sidebar">
                            <div class="order-sidebar">
                                <div class="order-sidebar__section">
                                    <h3 class="order-sidebar__title">Hành Động</h3>
                                    <div class="action-buttons">
                                        <?php if ($orderDetail['status'] === 'pending'): ?>
                                            <button class="action-btn action-btn--success">
                                                <span class="action-btn__icon">✓</span>
                                                <div class="action-btn__content">
                                                    <div class="action-btn__title">Xác Nhận Đơn Hàng</div>
                                                    <div class="action-btn__time">Chưa thực hiện</div>
                                                </div>
                                            </button>
                                            <button class="action-btn action-btn--danger">
                                                <span class="action-btn__icon">✗</span>
                                                <div class="action-btn__content">
                                                    <div class="action-btn__title">Từ Chối Đơn Hàng</div>
                                                    <div class="action-btn__time">Chưa thực hiện</div>
                                                </div>
                                            </button>
                                        <?php endif; ?>
                                        <button class="action-btn action-btn--warning">
                                            <span class="action-btn__icon">✎</span>
                                            <div class="action-btn__content">
                                                <div class="action-btn__title">Chỉnh Sửa Đơn Hàng</div>
                                                <div class="action-btn__time"><?php echo date('d/m/Y H:i', strtotime($orderDetail['order_date'])); ?></div>
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="order-sidebar__section">
                                    <h3 class="order-sidebar__title">Lịch Sử Hoạt Động</h3>
                                    <div class="activity-list">
                                        <?php foreach ($orderDetail['timeline'] as $event): ?>
                                            <div class="activity-item">
                                                <span class="activity-item__icon">
                                                    <?php
                                                    $icons = [
                                                        'pending' => '📄',
                                                        'paid' => '💳',
                                                        'processing' => '⚙️',
                                                        'delivered' => '✅',
                                                        'cancelled' => '✖️'
                                                    ];
                                                    echo $icons[$event['status']] ?? '📄';
                                                    ?>
                                                </span>
                                                <div class="activity-item__content">
                                                    <div class="activity-item__title"><?php
                                                        $statusMap = [
                                                            'pending' => 'Chờ duyệt',
                                                            'processing' => 'Đang xử lý',
                                                            'delivered' => 'Đã giao',
                                                            'cancelled' => 'Đã hủy',
                                                            'paid' => 'Đã thanh toán'
                                                        ];
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
            <?php endif; ?>
        </div>
    </main>
</body>
</html>