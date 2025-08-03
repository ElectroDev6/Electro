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
    <title>Electro Header</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <!-- <?php 
        echo '<pre>';
        echo json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</pre>';
    ?> -->
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="order-page" data-target="pagination-container">
            <div class="order-page__header">
                <h1 class="order-page__title">Trang đơn hàng</h1>
            </div>
            <?php
            $paidCount = 0;
            $pendingCount = 0;
            $processingCount = 0;
            $shippingCount = 0;
            $deliveredCount = 0;
            $totalRevenue = 0;

            foreach ($orders as $order) {
                $status = $order['status'];
                $totalMount = floatval($order['totals']['total_amount']);

                if ($status === 'paid') {
                    $paidCount++;
                    $totalRevenue += $totalMount;
                }
                if ($status === 'pending') {
                    $pendingCount++;
                }
                if ($status === 'processing') {
                    $processingCount++;
                }
                if ($status === 'shipping') {
                    $shippingCount++;
                }
                if ($status === 'delivered') {
                    $deliveredCount++;
                }
            }
            ?>
            <div class="order-stats">
                <div class="order-stats__card">
                    <div class="order-stats__label">Đã thanh toán</div>
                    <div class="order-stats__value"><?php echo $paidCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
                
                <div class="order-stats__card">
                    <div class="order-stats__label">Chờ duyệt</div>
                    <div class="order-stats__value"><?php echo $pendingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
                
                <div class="order-stats__card">
                    <div class="order-stats__label">Đang xử lý</div>
                    <div class="order-stats__value"><?php echo $processingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
                
                <div class="order-stats__card">
                    <div class="order-stats__label">Đang giao hàng</div>
                    <div class="order-stats__value"><?php echo $shippingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
                
                <div class="order-stats__card">
                    <div class="order-stats__label">Giao hàng thành công</div>
                    <div class="order-stats__value"><?php echo $deliveredCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
                
                <div class="order-stats__card">
                    <div class="order-stats__label">Tổng doanh thu</div>
                    <div class="order-stats__value"><?php echo number_format($totalRevenue, 0, ',', '.') . ' đ'; ?></div>
                    <div class="order-stats__change order-stats__change--positive">
                        ↗ 12.5% so với tháng trước
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="order-filter">
            <div class="order-filter__group">
                <label class="order-filter__label">Trạng thái</label>
                <select class="order-filter__select" name="status">
                    <option value="">Tất cả</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="paid">Chờ duyệt</option>
                    <option value="delivering">Đang giao hàng</option>
                    <option value="delivered">Đã giao</option>
                    <option value="canceled">Đã hủy</option>
                </select>
            </div>
            
            <div class="order-filter__group">
                <label class="order-filter__label">Ngày tạo</label>
                <select class="order-filter__select" name="date">
                    <option value="">Mọi ngày</option>
                    <?php
                    $dates = array_unique(array_map(function($order) {
                        return date('Y-m-d', strtotime($order['order_date']));
                    }, $orders));
                    foreach ($dates as $date) {
                        echo '<option value="' . $date . '">' . date('d/m/Y', strtotime($date)) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="order-filter__group">
                <label class="order-filter__label">Tìm kiếm</label>
                <input type="text" class="order-filter__input" placeholder="Tìm kiếm theo mã đơn hàng, tên..." name="search">
            </div>
            
            <div class="order-filter__actions">
                <button class="order-filter__btn order-filter__btn--primary">Lọc</button>
                <button class="order-filter__btn order-filter__btn--secondary">Reset</button>
            </div>
        </div>

            <!-- Orders Table Section -->
            <div class="order-list">
                <table class="order-table">
                    <thead class="order-table__head">
                        <tr class="order-table__header-row">
                            <th class="order-table__header">Ngày Mua</th>
                            <th class="order-table__header">Mã Đơn Hàng</th>
                            <th class="order-table__header">Khách Hàng</th>
                            <th class="order-table__header">Trạng thái đơn hàng</th>
                            <th class="order-table__header">Trạng thái thanh toán</th>
                            <th class="order-table__header">Khách phải trả</th>
                            <th class="order-table__header">Thao tác</th>
                        </tr>
                    </thead>
                  <tbody class="order-table__body">
                    <?php foreach ($orders as $order): ?>
                        <tr class="orders-table__row">
                            <!-- Ngày tạo đơn -->
                            <td class="order-table__cell">
                                <?= date('H:i:s d/m/Y', strtotime($order['order_date'])) ?>
                            </td>

                            <!-- Mã đơn hàng -->
                            <td class="order-table__cell">
                                <span class="order-table__order-id order-table__order-id--<?= strtolower($order['status']) ?>">
                                    <?= htmlspecialchars($order['id']) ?>
                                </span>
                            </td>

                            <!-- Tên người dùng -->
                            <td class="order-table__cell">
                                <?= htmlspecialchars($order['user']['full_name']) ?>
                            </td>

                            <!-- Trạng thái đơn hàng -->
                            <td class="order-table__cell">
                                <?php
                                $statusMap = [
                                    'pending'     => 'Chờ duyệt',
                                    'paid'        => 'Chờ duyệt', 
                                    'delivering'  => 'Đang giao hàng',
                                    'delivered'   => 'Đã giao',
                                    'canceled'    => 'Đã hủy',
                                ];
                                $status = $order['status'];
                                $statusLabel = $statusMap[$status] ?? ucfirst($status);
                                ?>
                                <span class="order-table__status order-table__status--<?= htmlspecialchars($status) ?>">
                                    <?= $statusLabel ?>
                                </span>
                            </td>

                            <!-- Trạng thái thanh toán -->
                            <td class="order-table__cell">
                                <?php
                                $status = $order['status'];
                                $paymentMethod = $order['payment_method'] ?? 'COD';
                                
                                if ($status === 'canceled') {
                                    $hasPaidBefore = false;
                                    if ($paymentMethod === 'BankTransfer' && !empty($order['payment_date'])) {
                                        $hasPaidBefore = true;
                                    }
                                    
                                    if ($hasPaidBefore) {
                                        $paymentLabel = 'Chờ hoàn tiền';
                                        $paymentClass = 'refunding';
                                    } else {
                                        $paymentLabel = 'Đã hủy';
                                        $paymentClass = 'canceled';
                                    }
                                } elseif ($paymentMethod === 'COD') {
                                    if ($status === 'delivered') {
                                        $paymentLabel = 'Đã thanh toán';
                                        $paymentClass = 'paid';
                                    } else {
                                        $paymentLabel = 'Chưa thanh toán';
                                        $paymentClass = 'pending';
                                    }
                                    if ($status === 'pending') {
                                        $paymentLabel = 'Chưa thanh toán';
                                        $paymentClass = 'pending';
                                    } elseif (in_array($status, ['paid', 'delivering', 'delivered'])) {
                                        $paymentLabel = 'Đã thanh toán';
                                        $paymentClass = 'paid';
                                    } else {
                                        $paymentLabel = 'Chưa thanh toán';
                                        $paymentClass = 'pending';
                                    }
                                }
                                ?>
                                <span class="order-table__payment order-table__payment--<?= $paymentClass ?>">
                                    <?= $paymentLabel ?>
                                </span>
                            </td>

                            <!-- Tổng tiền -->
                            <td class="order-table__cell">
                                <?= number_format($order['totals']['total_amount'], 0, ',', '.') ?> đ
                            </td>

                            <!-- Hành động -->
                            <td class="order-table__cell order-table__cell--actions">
                                <a href="/admin/orderDetail?id=<?= urlencode($order['id']) ?>" 
                                class="order-table__action-btn order-table__action-btn--view">Chi tiết</a>

                                <?php if ($status === 'pending'): ?>
                                    <!-- COD: Admin duyệt trực tiếp -->
                                    <!-- BankTransfer: User cần thanh toán trước -->
                                    <?php if ($paymentMethod === 'COD'): ?>
                                        <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
                                            <button type="submit" class="order-table__action-btn order-table__action-btn--approve"
                                                onclick="return confirm('Duyệt đơn COD này?')">
                                                Duyệt đơn
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="order-table__note">Chờ khách thanh toán</span>
                                    <?php endif; ?>
                                    
                                    <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--reject"
                                            onclick="return confirm('Hủy đơn hàng này?')">
                                            Hủy đơn
                                        </button>
                                    </form>
                                    
                                <?php elseif ($status === 'paid'): ?>
                                    <!-- BankTransfer đã thanh toán: Admin duyệt hoặc hủy + hoàn tiền -->
                                    <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--approve"
                                            onclick="return confirm('Duyệt đơn đã thanh toán này?')">
                                            Duyệt đơn
                                        </button>
                                    </form>
                                    
                                    <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--reject"
                                            onclick="return confirm('ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?')">
                                            Hủy & Hoàn tiền
                                        </button>
                                    </form>
                                    
                                <?php elseif ($status === 'delivering'): ?>
                                    <!-- Đang giao hàng: Admin xác nhận đã giao -->
                                    <form action="/admin/orders/complete" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--complete">
                                            Đã giao xong
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
            <?php echo $htmlPagination; ?>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/pages/order-filter.js"></script>
    <script type="module" src="/admin-ui/js/common/pagination.js"></script>
</body>
</html>