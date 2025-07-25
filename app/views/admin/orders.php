<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<?php
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
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="order-page">
        <!-- Header Section -->
        <div class="order-page__header">
            <h1 class="order-page__title">Trang đơn hàng</h1>
        </div>

        <!-- Stats Section -->
        <div class="order-stats">
            <div class="order-stats__card">
                <div class="order-stats__label">Đã thanh toán</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
            
            <div class="order-stats__card">
                <div class="order-stats__label">Chờ duyệt</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
            
            <div class="order-stats__card">
                <div class="order-stats__label">Chờ đóng gói</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
            
            <div class="order-stats__card">
                <div class="order-stats__label">Đang giao hàng</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
            
            <div class="order-stats__card">
                <div class="order-stats__label">Giao hàng thành công</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
            
            <div class="order-stats__card">
                <div class="order-stats__label">Tổng danh thu</div>
                <div class="order-stats__value">143</div>
                <div class="order-stats__change order-stats__change--positive">
                    ↗ 12.5% so với tháng trước
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="order-filter">
            <div class="order-filter__group">
                <label class="order-filter__label">Trạng thái</label>
                <select class="order-filter__select">
                    <option>Tất cả</option>
                </select>
            </div>
            
            <div class="order-filter__group">
                <label class="order-filter__label">Ngày tạo</label>
                <select class="order-filter__select">
                    <option>Mọi ngày</option>
                </select>
            </div>
            
            <div class="order-filter__group">
                <label class="order-filter__label">Tìm kiếm</label>
                <input type="text" class="order-filter__input" placeholder="Tìm kiếm theo mã đơn hàng, tên...">
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
                    <!-- Order Row 1 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--delivered">Đã giao</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                             <a href="/admin/orderDetail" class="order-table__action-btn order-table__action-btn--view">Chi tiết</a>
                        </td>
                    </tr>
                    
                    <!-- Order Row 2 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--processing">Đang xử lý</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <a href="/admin/orderDetail" class="order-table__action-btn order-table__action-btn--view">Chi tiết</a>
                        </td>
                    </tr>
                    
                    <!-- Order Row 3 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--pending">Chờ duyệt</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                            <button class="order-table__action-btn order-table__action-btn--approve">Duyệt</button>
                            <button class="order-table__action-btn order-table__action-btn--reject">Từ chối</button>
                        </td>
                    </tr>
                    
                    <!-- Order Row 4 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--pending">Chờ duyệt</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                            <button class="order-table__action-btn order-table__action-btn--approve">Duyệt</button>
                            <button class="order-table__action-btn order-table__action-btn--reject">Từ chối</button>
                        </td>
                    </tr>
                    
                    <!-- Order Row 5 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--pending">Chờ duyệt</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                            <button class="order-table__action-btn order-table__action-btn--approve">Duyệt</button>
                            <button class="order-table__action-btn order-table__action-btn--reject">Từ chối</button>
                        </td>
                    </tr>
                    
                    <!-- Order Row 6 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--delivered">Đã giao</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                        </td>
                    </tr>
                    
                    <!-- Order Row 7 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--processing">Đang xử lý</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                        </td>
                    </tr>
                    
                    <!-- Order Row 8 -->
                    <tr class="order-table__row">
                        <td class="order-table__cell">14:57:44 17/8/2025</td>
                        <td class="order-table__cell">
                            <span class="order-table__order-id order-table__order-id--pending">HDON</span>
                        </td>
                        <td class="order-table__cell">Trịnh Tấn Phương Tuấn</td>
                        <td class="order-table__cell">
                            <span class="order-table__status order-table__status--pending">Chờ duyệt</span>
                        </td>
                        <td class="order-table__cell">
                            <span class="order-table__payment order-table__payment--paid">Đã thanh toán</span>
                        </td>
                        <td class="order-table__cell">40.000 đ</td>
                        <td class="order-table__cell order-table__cell--actions">
                            <button class="order-table__action-btn order-table__action-btn--view">Chi tiết</button>
                            <button class="order-table__action-btn order-table__action-btn--approve">Duyệt</button>
                            <button class="order-table__action-btn order-table__action-btn--reject">Từ chối</button>
                        </td>
                    </tr>
                </tbody>
            </table>
    <?php echo $htmlPagination; ?>
        </div>
        </div>
    </main>
</body>
</html>