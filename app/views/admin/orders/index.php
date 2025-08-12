<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
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
$currentSearch = $_GET['search'] ?? '';
$currentStatus = $_GET['status'] ?? '';
$currentDate = $_GET['date'] ?? '';
$ordersPerPage = 8;
$page = max(1, (int)($_GET['page'] ?? 1));
$totalPages = (int)ceil($totalOrders / $ordersPerPage);
$startItem = ($page - 1) * $ordersPerPage + 1;
$endItem = min($page * $ordersPerPage, $totalOrders ?? 0);
$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);
$pendingCount = $preparingCount = $deliveringCount = $deliveredCount = $canceledCount = $totalRevenue = 0;
foreach ($orders as $order) {
    $status = $order['status'];
    $totalPrice = floatval($order['total_price'] ?? 0);
    $paymentMethod = $order['payment_method'] ?? 'cod';
    $paymentStatus = $order['payment_status'] ?? 'pending';

    switch ($status) {
        case 'pending':
            $pendingCount++;
            break;
        case 'preparing':
            $preparingCount++;
            break;
        case 'delivering':
            $deliveringCount++;
            break;
        case 'delivered':
            $deliveredCount++;
            $totalRevenue += $totalPrice;
            break;
        case 'cancelled':
            $canceledCount++;
            break;
    }
}
$statusMap = [
    'pending' => 'Chờ duyệt',
    'preparing' => 'Chuẩn bị hàng',
    'delivering' => 'Đang giao hàng',
    'delivered' => 'Hoàn thành',
    'cancelled' => 'Đã hủy',
];

$paymentMethodMap = [
    'cod' => 'COD',
    'bank_transfer' => 'Chuyển khoản',
    'momo' => 'Momo',
    'credit_card' => 'Thẻ tín dụng',
    'zalopay' => 'ZaloPay',
];

$paymentStatusMap = [
    'pending' => 'Chưa thanh toán',
    'success' => 'Đã thanh toán',
    'failed' => 'Thất bại',
];
function getPaymentStatusDisplay($order) {
    $paymentMethod = $order['payment_method'] ?? 'cod';
    $paymentStatus = $order['payment_status'] ?? 'pending';
    $orderStatus = $order['status'];
    
    if ($paymentMethod === 'cod') {
        return $orderStatus === 'delivered' ? 'Đã thanh toán' : 'Chưa thanh toán';
    } else {
        return $paymentStatus === 'success' ? 'Đã thanh toán' : 'Chưa thanh toán';
    }
}
function getOrderStatusDisplay($order) {
    $status = $order['status'];
    $paymentMethod = $order['payment_method'] ?? 'cod';
    $paymentStatus = $order['payment_status'] ?? 'pending';
    if ($paymentMethod !== 'cod' && $status === 'pending' && $paymentStatus !== 'success') {
        return 'Chờ thanh toán';
    }
    $statusMap = [
        'pending' => 'Chờ duyệt',
        'preparing' => 'Chuẩn bị hàng',
        'delivering' => 'Đang giao hàng',
        'delivered' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
    ];
    
    return $statusMap[$status] ?? ucfirst($status);
}
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
    <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
    <div class="notification notification--success show" id="success-notification">
        <p id="success-message"><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
    <div class="notification notification--error" id="error-notification">
        <p id="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="order-page" data-target="pagination-container">
            <div class="order-page__header">
                <h1 class="order-page__title">Trang đơn hàng</h1>
            </div>
            <div class="order-stats">
                <div class="order-stats__card">
                    <div class="order-stats__label">Chờ duyệt</div>
                    <div class="order-stats__value"><?php echo $pendingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Chuẩn bị hàng</div>
                    <div class="order-stats__value"><?php echo $preparingCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Đang giao hàng</div>
                    <div class="order-stats__value"><?php echo $deliveringCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Hoàn thành</div>
                    <div class="order-stats__value"><?php echo $deliveredCount; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Đã hủy</div>
                    <div class="order-stats__value"><?php echo $canceledCount; ?></div>
                    <div class="order-stats__change order-stats__change--negative">↘ 5.2%</div>
                </div>
                <div class="order-stats__card">
                    <div class="order-stats__label">Tổng doanh thu</div>
                    <div class="order-stats__value"><?php echo number_format($totalRevenue, 0, ',', '.') . ' đ'; ?></div>
                    <div class="order-stats__change order-stats__change--positive">↗ 12.5%</div>
                </div>
            </div>
            
            <div class="order-filter">
                <form method="GET">
                    <div class="order-filter__group">
                        <label class="order-filter__label">Trạng thái</label>
                        <select class="order-filter__select" name="status">
                            <option value="">Tất cả</option>
                            <?php foreach ($statusMap as $value => $label): ?>
                                <option value="<?php echo $value; ?>" <?php echo ($currentStatus === $value) ? 'selected' : ''; ?>>
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
                        <button type="submit" class="order-filter__btn order-filter__btn--primary">Lọc</button>
                        <button type="button" class="order-filter__btn order-filter__btn--secondary"
                                onclick="window.location.href='/admin/orders';">Reset</button>
                    </div>
                </form>
            </div>
            
            <div class="order-list">
                <div class="order-table-wrapper">
                    <table class="order-table">
                        <thead class="order-table__head">
                            <tr class="order-table__header-row">
                                <th class="order-table__header">Mã đơn hàng</th>
                                <th class="order-table__header">Coupon</th>
                                <th class="order-table__header">Trạng thái đơn hàng</th>
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
                                $paymentMethod = $order['payment_method'] ?? 'cod';
                                $paymentStatus = $order['payment_status'] ?? 'pending';
                                
                                $orderStatusLabel = getOrderStatusDisplay($order);
                                $paymentStatusLabel = getPaymentStatusDisplay($order);
                                $paymentMethodLabel = $paymentMethodMap[$paymentMethod] ?? ucfirst($paymentMethod);
                            ?>
                        <tr class="order-table__row">
                            <td class="order-table__cell"><?php echo htmlspecialchars($order['order_code']); ?></td>
                            <td class="order-table__cell"><?php echo htmlspecialchars($order['coupon_code'] ?? 'Chưa áp dụng'); ?></td>
                            <td class="order-table__cell">
                                <span class="order-table__status order-table__status--<?php echo htmlspecialchars($status); ?>">
                                    <?php echo $orderStatusLabel; ?>
                                </span>
                            </td>
                            <td class="order-table__cell"><?php echo $paymentMethodLabel; ?></td>
                            <td class="order-table__cell">
                                <span class="payment-status payment-status--<?php echo ($paymentStatusLabel === 'Đã thanh toán') ? 'success' : 'pending'; ?>">
                                    <?php echo $paymentStatusLabel; ?>
                                </span>
                            </td>
                            <td class="order-table__cell"><?php echo number_format($order['total_price'] ?? 0, 0, ',', '.') . ' đ'; ?></td>
                            <td class="order-table__cell"><?php echo date('H:i:s d/m/Y', strtotime($order['created_at'] ?? 'now')); ?></td>
                            <td class="order-table__cell order-table__cell--actions">
                                <a href="/admin/orders/detail?id=<?php echo $order['order_id']; ?>" class="order-table__action-btn order-table__action-btn--view">Chi tiết</a>
                                
                                <?php if ($status === 'pending'): ?>
                                    <?php if ($paymentMethod === 'cod' || ($paymentMethod !== 'cod' && $paymentStatus === 'success')): ?>
                                        <!-- Có thể duyệt đơn -->
                                        <form action="/admin/orders/status" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="order-table__action-btn order-table__action-btn--approve" 
                                                    onclick="return confirm('Duyệt đơn hàng này?')">Duyệt đơn</button>
                                        </form>
                                    <?php else: ?>
                                        <!-- Bank transfer chưa thanh toán -->
                                        <span class="order-table__note">Chờ khách thanh toán</span>
                                    <?php endif; ?>
                                    
                                    <!-- Luôn có thể hủy đơn ở trạng thái pending -->
                                    <form action="/admin/orders/status" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--reject" 
                                                onclick="return confirm('<?php echo ($paymentMethod !== 'cod' && $paymentStatus === 'success') ? 'ĐƠN ĐÃ THANH TOÁN! Hủy sẽ cần hoàn tiền. Bạn có chắc?' : 'Hủy đơn hàng này?'; ?>')">
                                            <?php echo ($paymentMethod !== 'cod' && $paymentStatus === 'success') ? 'Hủy & Hoàn tiền' : 'Hủy đơn'; ?>
                                        </button>
                                    </form>
                                    
                                <?php elseif ($status === 'paid'): ?>
                                    <!-- Chuyển sang trạng thái shipped (chuẩn bị giao hàng) -->
                                    <form action="/admin/orders/status" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <input type="hidden" name="status" value="shipped">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--ship" 
                                                onclick="return confirm('Chuẩn bị giao hàng?')">Chuẩn bị giao</button>
                                    </form>
                                    
                                <?php elseif ($status === 'shipped'): ?>
                                    <!-- Chuyển sang trạng thái delivering (giao hàng) -->
                                    <form action="/admin/orders/status" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <input type="hidden" name="status" value="delivering">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--ship" 
                                                onclick="return confirm('Giao hàng cho shipper?')">Giao shipper</button>
                                    </form>
                                    
                                <?php elseif ($status === 'delivering'): ?>
                                    <!-- Xác nhận giao thành công -->
                                    <form action="/admin/orders/status" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="order-table__action-btn order-table__action-btn--complete" 
                                                onclick="return confirm('<?php echo ($paymentMethod === 'cod') ? 'Xác nhận giao hàng thành công và thu tiền?' : 'Xác nhận giao hàng thành công?'; ?>')">
                                            Giao thành công
                                        </button>
                                    </form>
                                    
                                <?php elseif ($status === 'completed'): ?>
                                    <span class="order-table__status-complete">Đã hoàn thành</span>
                                    
                                <?php elseif ($status === 'cancelled'): ?>
                                    <span class="order-table__status-cancelled">Đã hủy</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination section remains the same -->
                <div class="order-pagination">
                    <ul class="pagination__list">
                        <?php if ($page > 1): ?>
                            <li class="pagination__item">
                                <a href="<?php echo buildPaginationUrl(1, $ordersPerPage, $currentSearch, $currentStatus, $currentDate); ?>"
                                   class="pagination__link pagination__link--first">
                                    <i class="fas fa-angle-double-left"></i> Đầu
                                </a>
                            </li>
                        <?php endif; ?>
                        
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
        <script type="module" src="/admin-ui/js/common/notification.js"></script>
</body>
</html>