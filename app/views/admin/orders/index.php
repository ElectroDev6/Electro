<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';

// Function to build pagination URL
function buildPaginationUrl($pageNum, $ordersPerPage, $search = '', $status = '', $date = '') {
    $params = [
        'page' => $pageNum,
        'limit' => $ordersPerPage
    ];
    
    if (!empty($search)) $params['search'] = $search;
    if (!empty($status)) $params['status'] = $status;
    if (!empty($date)) $params['date'] = $date;

    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath . '?' . http_build_query($params);
}

// Pagination variables
$currentSearch = $_GET['search'] ?? '';
$currentStatus = $_GET['status'] ?? '';
$currentDate = $_GET['date'] ?? '';
$ordersPerPage = 8;
$page = max(1, (int)($currentPage ?? 1));
$totalPages = (int)($totalPages ?? 1);

$startItem = ($page - 1) * $ordersPerPage + 1;
$endItem = min($page * $ordersPerPage, $totalOrders ?? 0);
$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);

// Calculate statistics
$paidCount = $pendingCount = $deliveringCount = $deliveredCount = $canceledCount = $totalRevenue = 0;
foreach ($orders as $order) {
    $status = $order['status'];
    $totalPrice = floatval($order['total_price']);
    
    switch ($status) {
        case 'paid':
            $paidCount++;
            $totalRevenue += $totalPrice;
            break;
        case 'pending':
            $pendingCount++;
            break;
        case 'delivering':
            $deliveringCount++;
            break;
        case 'delivered':
            $deliveredCount++;
            $totalRevenue += $totalPrice;
            break;
        case 'canceled':
            $canceledCount++;
            break;
    }
}

// Status mapping
$statusMap = [
    'pending' => 'Chờ duyệt',
    'paid' => 'Đã thanh toán',
    'delivering' => 'Đang giao hàng',
    'delivered' => 'Giao thành công',
    'canceled' => 'Đã hủy',
];

$paymentMethodMap = [
    'cod' => 'COD',
];

$paymentStatusMap = [
    'pending' => 'Chờ thanh toán',
    'success' => 'Thành công',
    'failed' => 'Thất bại',
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php echo $htmlHeader; ?>

    <main class="wrapper">
        <?php echo $contentSidebar; ?>

        <div class="order-page" data-target="pagination-container">
            <div class="order-page__header">
                <h1 class="order-page__title">Trang đơn hàng</h1>
            </div>

            <!-- Statistics Section -->
            <div class="order-stats">
                <div class="order-stats__card">
                    <div class="order-stats__label">Đã thanh toán</div>
                    <div class="order-stats__value"><?php echo $paidCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Chờ duyệt</div>
                    <div class="order-stats__value"><?php echo $pendingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Đang giao hàng</div>
                    <div class="order-stats__value"><?php echo $deliveringCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Giao thành công</div>
                    <div class="order-stats__value"><?php echo $deliveredCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Đã hủy</div>
                    <div class="order-stats__value"><?php echo $canceledCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Tổng doanh thu</div>
                    <div class="order-stats__value">
                        <?php echo number_format($totalRevenue, 0, ',', '.') . ' đ'; ?>
                    </div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="order-filter">
                <form method="GET">
                    <div class="order-filter__group">
                        <label class="order-filter__label">Trạng thái</label>
                        <select class="order-filter__select" name="status">
                            <option value="">Tất cả</option>
                            <?php foreach ($statusMap as $value => $label): ?>
                            <option value="<?php echo $value; ?>"
                                <?php echo ($currentStatus === $value) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="order-filter__group">
                        <label class="order-filter__label">Ngày tạo</label>
                        <select class="order-filter__select" name="date">
                            <option value="">Mọi ngày</option>
                            <?php
                            $dates = array_unique(array_map(function($order) {
                                return date('Y-m-d', strtotime($order['created_at']));
                            }, $orders));
                            
                            foreach ($dates as $date):
                                $selected = ($currentDate === $date) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $date; ?>" <?php echo $selected; ?>>
                                <?php echo date('d/m/Y', strtotime($date)); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="order-filter__group">
                        <label class="order-filter__label">Tìm kiếm</label>
                        <input type="text" class="order-filter__input" placeholder="Tìm kiếm theo mã đơn hàng"
                            name="search" value="<?php echo htmlspecialchars($currentSearch); ?>">
                    </div>

                    <div class="order-filter__actions">
                        <button type="submit" class="order-filter__btn order-filter__btn--primary">
                            Lọc
                        </button>
                        <button type="button" class="order-filter__btn order-filter__btn--secondary"
                            onclick="window.location.href='/admin/orders';">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            <div class="order-list">
                <div class="order-table-wrapper">
                    <table class="order-table">
                        <thead class="order-table__head">
                            <tr class="order-table__header-row">
                                <th class="order-table__header">Mã đơn hàng</th>
                                <th class="order-table__header">Coupon</th>
                                <th class="order-table__header">Trạng thái giao hàng</th>
                                <th class="order-table__header">Phương thức thanh toán</th>
                                <th class="order-table__header">Trạng thái thanh toán</th>
                                <th class="order-table__header">Tổng giá</th>
                                <th class="order-table__header">Ngày tạo</th>
                                <th class="order-table__header">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="order-table__body">
                            <?php foreach ($orders as $order): 
                                $status = $order['status'];
                                $statusLabel = $statusMap[$status] ?? ucfirst($status);
                                $paymentMethod = $order['payment_method'] ?? 'cod';
                                $paymentStatus = $order['payment_status'] ?? 'pending';
                            ?>
                            <tr class="order-table__row">
                                <td class="order-table__cell">
                                    <?php echo htmlspecialchars($order['order_code']); ?>
                                </td>
                                <td class="order-table__cell">
                                    <?php echo htmlspecialchars($order['coupon_code'] ?? 'Chưa áp dụng'); ?>
                                </td>
                                <td class="order-table__cell">
                                    <span
                                        class="order-table__status order-table__status--<?php echo htmlspecialchars($status); ?>">
                                        <?php echo $statusLabel; ?>
                                    </span>
                                </td>
                                <td class="order-table__cell">
                                    <?php echo $paymentMethodMap[$paymentMethod] ?? ucfirst($paymentMethod); ?>
                                </td>
                                <td class="order-table__cell">
                                    <?php echo $paymentStatusMap[$paymentStatus] ?? ucfirst($paymentStatus); ?>
                                </td>
                                <td class="order-table__cell">
                                    <?php echo number_format($order['total_price'], 0, ',', '.') . ' đ'; ?>
                                </td>
                                <td class="order-table__cell">
                                    <?php echo date('H:i:s d/m/Y', strtotime($order['created_at'])); ?>
                                </td>
                                <td class="order-table__cell order-table__cell--actions">
                                    <a href="/admin/orders/detail?id=<?php echo $order['order_id']; ?>"
                                        class="order-table__action-btn order-table__action-btn--view">
                                        Chi tiết
                                    </a>

                                    <?php if ($status === 'pending'): ?>
                                    <?php if ($paymentMethod === 'cod'): ?>
                                    <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--approve"
                                            onclick="return confirm('Duyệt đơn COD này?')">
                                            Duyệt đơn
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <span class="order-table__note">Chờ khách thanh toán</span>
                                    <?php endif; ?>

                                    <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--reject"
                                            onclick="return confirm('Hủy đơn hàng này?')">
                                            Hủy đơn
                                        </button>
                                    </form>

                                    <?php elseif ($status === 'paid' && $paymentStatus === 'success'): ?>
                                    <form action="/admin/orders/approve" method="POST" style="display:inline;">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--approve"
                                            onclick="return confirm('Duyệt đơn đã thanh toán này?')">
                                            Duyệt đơn
                                        </button>
                                    </form>
                                    <form action="/admin/orders/cancel" method="POST" style="display:inline;">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--reject"
                                            onclick="return confirm('ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?')">
                                            Hủy & Hoàn tiền
                                        </button>
                                    </form>

                                    <?php elseif ($status === 'delivering'): ?>
                                    <form action="/admin/orders/complete" method="POST" style="display:inline;">
                                        <input type="hidden" name="id"
                                            value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <?php if ($paymentMethod === 'cod'): ?>
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--complete"
                                            onclick="return confirm('Xác nhận giao hàng thành công và thu tiền?')">
                                            Giao thành công
                                        </button>
                                        <?php else: ?>
                                        <button type="submit"
                                            class="order-table__action-btn order-table__action-btn--complete"
                                            onclick="return confirm('Xác nhận giao hàng thành công?')">
                                            Giao thành công
                                        </button>
                                        <?php endif; ?>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="order-pagination">
                    <ul class="pagination__list">
                        <!-- First Page Button -->
                        <?php if ($page > 1): ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl(1, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link pagination__link--first">
                                <i class="fas fa-angle-double-left"></i> Đầu
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Previous Button -->
                        <li class="pagination__item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <?php if ($page > 1): ?>
                            <a href="<?php echo buildPaginationUrl($page - 1, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link">
                                <i class="fas fa-angle-left"></i> Trước
                            </a>
                            <?php else: ?>
                            <span class="pagination__link pagination__link--disabled">
                                <i class="fas fa-angle-left"></i> Trước
                            </span>
                            <?php endif; ?>
                        </li>

                        <!-- Show first page and ellipsis if needed -->
                        <?php if ($startPage > 1): ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl(1, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link">1</a>
                        </li>
                        <?php if ($startPage > 2): ?>
                        <li class="pagination__item">
                            <span class="pagination__ellipsis">...</span>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="pagination__item <?php echo $i == $page ? 'active' : ''; ?>">
                            <?php if ($i == $page): ?>
                            <span class="pagination__link pagination__link--active"><?php echo $i; ?></span>
                            <?php else: ?>
                            <a href="<?php echo buildPaginationUrl($i, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link"><?php echo $i; ?></a>
                            <?php endif; ?>
                        </li>
                        <?php endfor; ?>

                        <!-- Show last page and ellipsis if needed -->
                        <?php if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                        <li class="pagination__item">
                            <span class="pagination__ellipsis">...</span>
                        </li>
                        <?php endif; ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl($totalPages, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link"><?php echo $totalPages; ?></a>
                        </li>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <li class="pagination__item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                            <?php if ($page < $totalPages): ?>
                            <a href="<?php echo buildPaginationUrl($page + 1, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link">
                                Sau <i class="fas fa-angle-right"></i>
                            </a>
                            <?php else: ?>
                            <span class="pagination__link pagination__link--disabled">
                                Sau <i class="fas fa-angle-right"></i>
                            </span>
                            <?php endif; ?>
                        </li>

                        <!-- Last Page Button -->
                        <?php if ($page < $totalPages): ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl($totalPages, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                class="pagination__link pagination__link--last">
                                Cuối <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="order-pagination-info">
                    <span class="pagination__info-text">
                        Hiển thị <?php echo number_format($startItem); ?> - <?php echo number_format($endItem); ?>
                        trong tổng số <?php echo number_format($totalOrders ?? 0); ?> đơn hàng
                    </span>
                </div>
            </div>
        </div>
    </main>
</body>

</html>