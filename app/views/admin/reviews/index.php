<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>
<?php
function buildPaginationUrl($pageNum, $reviewsPerPage, $search = '', $rating = '', $status = '', $date_range = '') {
    $params = [
        'page' => $pageNum,
        'limit' => $reviewsPerPage
    ];
    
    if (!empty($search)) $params['search'] = $search;
    if (!empty($rating)) $params['rating'] = $rating;
    if (!empty($status)) $params['status'] = $status;
    if (!empty($date_range)) $params['date_range'] = $date_range;
    
    // Get current path without query string
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath . '?' . http_build_query($params);
}

$currentSearch = isset($_GET['search']) ? $_GET['search'] : '';
$currentRating = isset($_GET['rating']) ? $_GET['rating'] : '';
$currentStatus = isset($_GET['status']) ? $_GET['status'] : '';
$currentDateRange = isset($_GET['date_range']) ? $_GET['date_range'] : '';

// Calculate pagination info
$startItem = ($page - 1) * $reviewsPerPage + 1;
$endItem = min($page * $reviewsPerPage, $totalReviews);
$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Reviews</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Debug code (commented out) -->
    <!--
    <?php // echo '<pre'; print_r($reviews); echo '</pre>'; ?>
    -->
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

        <div class="reviews">
            <!-- Header Section -->
            <div class="reviews__header">
                <h1 class="reviews__title">Quản lý Reviews</h1>
            </div>
            <!-- Stats Cards Section -->
            <div class="reviews__stats">
                <div class="reviews__stat-card">
                    <div class="reviews__stat-label">Tổng Reviews</div>
                    <div class="reviews__stat-value"><?php echo $totalReviews; ?></div>
                </div>
                <div class="reviews__stat-card">
                    <div class="reviews__stat-label">Chờ duyệt</div>
                    <div class="reviews__stat-value">0</div> <!-- Cần logic thực tế -->
                </div>
                <div class="reviews__stat-card">
                    <div class="reviews__stat-label">Điểm trung bình</div>
                    <div class="reviews__stat-value">
                        <?php
                        $totalRating = 0;
                        $ratedReviews = 0;
                        foreach ($reviews as $review) {
                            if (!empty($review['rating'])) {
                                $totalRating += $review['rating'];
                                $ratedReviews++;
                            }
                        }
                        echo $ratedReviews > 0 ? number_format($totalRating / $ratedReviews, 1) : '0';
                        ?>
                    </div>
                </div>
                <div class="reviews__stat-card">
                    <div class="reviews__stat-label">Tỷ lệ hài lòng</div>
                    <div class="reviews__stat-value">
                        <?php
                        $satisfied = 0;
                        foreach ($reviews as $review) {
                            if (!empty($review['rating']) && $review['rating'] >= 4) {
                                $satisfied++;
                            }
                        }
                        echo $ratedReviews > 0 ? number_format(($satisfied / $ratedReviews) * 100, 0) . '%' : '0%';
                        ?>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="reviews__filters">
                <form method="GET" class="reviews__filters" action="/admin/reviews">
                    <div class="reviews__filter-group">
                        <label for="rating" class="reviews__filter-label">Đánh giá</label>
                        <select id="rating" class="reviews__filter-select" name="rating">
                            <option value="">Tất cả</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo $i; ?>"
                                <?php echo isset($_GET['rating']) && $_GET['rating'] == $i ? 'selected' : ''; ?>>
                                <?php echo $i; ?> sao
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="reviews__filter-group">
                        <label for="status" class="reviews__filter-label">Trạng thái</label>
                        <select id="status" class="reviews__filter-select" name="status">
                            <option value="">Tất cả</option>
                            <option value="active"
                                <?php echo isset($_GET['status']) && $_GET['status'] === 'active' ? 'selected' : ''; ?>>
                                Active</option>
                            <option value="pending"
                                <?php echo isset($_GET['status']) && $_GET['status'] === 'pending' ? 'selected' : ''; ?>>
                                Pending</option>
                            <option value="inactive"
                                <?php echo isset($_GET['status']) && $_GET['status'] === 'inactive' ? 'selected' : ''; ?>>
                                Inactive</option>
                        </select>
                    </div>

                    <div class="reviews__filter-group">
                        <label for="date_range" class="reviews__filter-label">Ngày tạo</label>
                        <select id="date_range" class="reviews__filter-select" name="date_range">
                            <option value=""
                                <?php echo !isset($_GET['date_range']) || $_GET['date_range'] === '' ? 'selected' : ''; ?>>
                                Tất cả</option>
                            <option value="last_7_days"
                                <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'last_7_days' ? 'selected' : ''; ?>>
                                7 ngày qua</option>
                            <option value="last_30_days"
                                <?php echo isset($_GET['date_range']) && $_GET['date_range'] === 'last_30_days' ? 'selected' : ''; ?>>
                                30 ngày qua</option>
                        </select>
                    </div>
                    <div class="user-filter__group">
                        <label class="user-filter__label">Hiển thị</label>
                        <select name="limit" class="user-filter__select">
                            <option value="8" <?php echo $limit === 8 ? 'selected' : ''; ?>>8</option>
                            <option value="12" <?php echo $limit === 12 ? 'selected' : ''; ?>>12</option>
                            <option value="16" <?php echo $limit === 16 ? 'selected' : ''; ?>>16</option>
                            <option value="20" <?php echo $limit === 20 ? 'selected' : ''; ?>>20</option>
                        </select>
                    </div>
                    <div class="reviews__search-group">
                        <input type="text" class="reviews__search-input" name="search"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            placeholder="Tìm kiếm theo tên người dùng hoặc sản phẩm...">
                        <button type="submit" class="reviews__add-btn">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="?" class="reviews__clear-btn">Xóa bộ lọc</a>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="reviews__table-container">
                <table class="reviews__table">
                    <thead>
                        <tr class="reviews__table-row">
                            <th class="reviews__table-header">ID</th>
                            <th class="reviews__table-header">Người dùng</th>
                            <th class="reviews__table-header">Sản phẩm</th>
                            <th class="reviews__table-header">Đánh giá</th>
                            <th class="reviews__table-header">Nội dung</th>
                            <th class="reviews__table-header">Ngày tạo</th>
                            <th class="reviews__table-header">Trạng thái</th>
                            <th class="reviews__table-header">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="reviews__table-body">
                        <?php foreach ($reviews as $review): ?>
                        <tr class="reviews__table-row">
                            <td class="reviews__table-cell"><?php echo '#' . sprintf('%03d', $review['review_id']); ?>
                            </td>
                            <td class="reviews__table-cell">
                                <div class="reviews__user">
                                    <img src="<?php echo htmlspecialchars($review['user_avatar'] ?? '/img/avatar/default-avatar.jpg'); ?>"
                                        alt="Avatar" class="reviews__user-avatar">
                                    <span
                                        class="reviews__user-name"><?php echo htmlspecialchars($review['user_name']); ?></span>
                                </div>
                            </td>
                            <td class="reviews__table-cell"><?php echo htmlspecialchars($review['product_name']); ?>
                            </td>
                            <td class="reviews__table-cell">
                                <div class="reviews__rating">
                                    <?php
                                        $rating = !empty($review['rating']) ? (int)$review['rating'] : 0;
                                        for ($i = 1; $i <= 5; $i++):
                                        ?>
                                    <i
                                        class="fas fa-star reviews__star <?php echo $i <= $rating ? 'reviews__star--filled' : 'reviews__star--empty'; ?>"></i>
                                    <?php endfor; ?>
                                    <span
                                        class="reviews__rating-text"><?php echo $rating ? "$rating/5" : 'N/A'; ?></span>
                                </div>
                            </td>
                            <td class="reviews__table-cell">
                                <?php echo htmlspecialchars(substr($review['comment_text'], 0, 50)) . '...'; ?></td>
                            <td class="reviews__table-cell">
                                <div class="reviews__date">
                                    <?php echo date('d/m/Y', strtotime($review['review_date'])); ?></div>
                                <div class="reviews__time"><?php echo date('H:i', strtotime($review['review_date'])); ?>
                                </div>
                            </td>
                            <td class="reviews__table-cell">
                                <span
                                    class="reviews__status reviews__status--<?php echo strtolower(htmlspecialchars($review['status'])); ?>">
                                    <?php echo htmlspecialchars(ucfirst($review['status'])); ?>
                                </span>
                            </td>
                            <td class="reviews__table-cell">
                                <div class="reviews__actions">
                                    <a href="/admin/reviews/detail?id=<?php echo $review['review_id']; ?>"
                                        class="reviews__action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="reviews__action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="/admin/reviews/delete" method="POST" class="review-detail__form" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?');">
                                    <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                      <button class="reviews__action-btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination Navigation -->
                <div class="reviews__pagination">
                    <ul class="pagination__list">
                        <!-- First Page Button -->
                        <?php if ($page > 1): ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl(1, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
                                class="pagination__link pagination__link--first">
                                <i class="fas fa-angle-double-left"></i> Đầu
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Previous Button -->
                        <li class="pagination__item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <?php if ($page > 1): ?>
                            <a href="<?php echo buildPaginationUrl($page - 1, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
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
                            <a href="<?php echo buildPaginationUrl(1, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
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
                            <a href="<?php echo buildPaginationUrl($i, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
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
                            <a href="<?php echo buildPaginationUrl($totalPages, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
                                class="pagination__link"><?php echo $totalPages; ?></a>
                        </li>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <li class="pagination__item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                            <?php if ($page < $totalPages): ?>
                            <a href="<?php echo buildPaginationUrl($page + 1, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
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
                            <a href="<?php echo buildPaginationUrl($totalPages, $reviewsPerPage, $currentSearch, $currentRating, $currentStatus, $currentDateRange); ?>"
                                class="pagination__link pagination__link--last">
                                Cuối <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- Pagination Info -->
                <div class="reviews__pagination-info">
                    <span class="pagination__info-text">
                        Hiển thị <?php echo number_format($startItem); ?> - <?php echo number_format($endItem); ?>
                        trong tổng số <?php echo number_format($totalReviews); ?> đánh giá
                    </span>
                </div>

            </div>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
</body>

</html>