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
            <!-- Header Section -->
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
                        <option value="processing">Đang xử lý</option>
                        <option value="delivered">Đã giao</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
                
                <div class="order-filter__group">
                    <label class="order-filter__label">Ngày tạo</label>
                    <select class="order-filter__select" name="date">
                        <option value="">Mọi ngày</option>
                        <?php
                        // Get unique dates from orders
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
                                <td class="order-table__cell"><?php echo date('H:i:s d/m/Y', strtotime($order['order_date'])); ?></td>
                                <td class="order-table__cell">
                                    <span class="order-table__order-id order-table__order-id--<?php echo strtolower($order['status']); ?>">
                                        <?php echo htmlspecialchars($order['id']); ?>
                                    </span>
                                </td>
                                <td class="order-table__cell"><?php echo htmlspecialchars($order['user']['full_name']); ?></td>
                                    <!-- Trạng thái đơn hàng -->
                                    <td class="order-table__cell">
                                        <span class="order-table__status order-table__status--<?php echo $order['status']; ?>">
                                            <?php
                                            $statusMap = [
                                                'pending'     => 'Chờ duyệt',
                                                'processing'  => 'Đang xử lý',
                                                'shipping'    => 'Đang giao hàng',
                                                'delivered'   => 'Đã giao',
                                                'canceled'    => 'Đã hủy',
                                            ];
                                            echo htmlspecialchars($statusMap[$order['status']] ?? ucfirst($order['status']));
                                            ?>
                                        </span>
                                    </td>

                                <!-- Trạng thái thanh toán -->
                                <td class="order-table__cell">
                                    <?php
                                    $isCanceled = $order['status'] === 'canceled';

                                    // Kiểm tra trong timeline có bước thanh toán chưa
                                    $hasPaid = !empty(array_filter($order['timeline'], function($item) {
                                        return $item['status'] === 'paid';
                                    }));

                                    if ($isCanceled) {
                                        $paymentLabel = 'canceled';
                                        $paymentClass = 'Đã hủy';
                                        // $paymentLabel = 'canceled';
                                    } else {
                                        $paymentLabel = $hasPaid ? 'Đã thanh toán' : 'Chờ thanh toán';
                                        $paymentClass = $hasPaid ? 'paid' : 'pending';
                                    }
                                    ?>
                                    <span class="order-table__payment order-table__payment--<?php echo $paymentClass; ?>">
                                        <?php echo $paymentLabel; ?>
                                    </span>
                                </td>
                                <td class="order-table__cell"><?php echo number_format($order['totals']['total_amount'], 0, ',', '.') . ' đ'; ?></td>
                                <td class="order-table__cell order-table__cell--actions">
                                    <a href="/admin/orderDetail?id=<?php echo $order['id']; ?>" class="order-table__action-btn order-table__action-btn--view">Chi tiết</a>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <button class="order-table__action-btn order-table__action-btn--approve">Duyệt</button>
                                        <button class="order-table__action-btn order-table__action-btn--reject">Từ chối</button>
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
    <script src="/admin-ui/js/common/pagination.js"></script>
</body>
</html>