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
       <div class="reviews">
        <!-- Header Section -->
        <div class="reviews__header">
            <h1 class="reviews__title">Quản lý Reviews</h1>
            <button class="reviews__add-btn">
                <i class="fas fa-plus"></i>
                Add new
            </button>
        </div>

        <!-- Stats Cards Section -->
        <div class="reviews__stats">
            <div class="reviews__stat-card">
                <div class="reviews__stat-label">Tổng Reviews</div>
                <div class="reviews__stat-value">1,234</div>
            </div>
            <div class="reviews__stat-card">
                <div class="reviews__stat-label">Chờ duyệt</div>
                <div class="reviews__stat-value">123</div>
            </div>
            <div class="reviews__stat-card">
                <div class="reviews__stat-label">Điểm trung bình</div>
                <div class="reviews__stat-value">4.9</div>
            </div>
            <div class="reviews__stat-card">
                <div class="reviews__stat-label">Tỷ lệ hài lòng</div>
                <div class="reviews__stat-value">98%</div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="reviews__filters">
            <div class="reviews__filter-group">
                <label class="reviews__filter-label">Trạng thái</label>
                <select class="reviews__filter-select">
                    <option>Tất cả</option>
                    <option>Đã duyệt</option>
                    <option>Chờ duyệt</option>
                    <option>Từ chối</option>
                </select>
            </div>
            <div class="reviews__filter-group">
                <label class="reviews__filter-label">Đánh giá</label>
                <select class="reviews__filter-select">
                    <option>Tất cả</option>
                    <option>5 sao</option>
                    <option>4 sao</option>
                    <option>3 sao</option>
                    <option>2 sao</option>
                    <option>1 sao</option>
                </select>
            </div>
            <div class="reviews__search-group">
                <input type="text" class="reviews__search-input" placeholder="Tìm kiếm theo tên người dùng hoặc sản phẩm...">
            </div>
        </div>

        <!-- Table Section -->
        <div class="reviews__table-container">
            <table class="reviews__table">
                <thead class="reviews__table-head">
                    <tr class="reviews__table-row">
                        <th class="reviews__table-header">ID</th>
                        <th class="reviews__table-header">Người dùng</th>
                        <th class="reviews__table-header">Sản phẩm</th>
                        <th class="reviews__table-header">Đánh giá</th>
                        <th class="reviews__table-header">Nội dung</th>
                        <th class="reviews__table-header">Trạng thái</th>
                        <th class="reviews__table-header">Ngày tạo</th>
                        <th class="reviews__table-header">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="reviews__table-body">
                    <tr class="reviews__table-row">
                        <td class="reviews__table-cell">#001</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__user">
                                <div class="reviews__user-avatar reviews__user-avatar--blue">N</div>
                                <span class="reviews__user-name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">iPhone 14 Pro Max</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__rating">
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <span class="reviews__rating-text">5/5</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</td>
                        <td class="reviews__table-cell">
                            <span class="reviews__status reviews__status--approved">Approved</span>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__date">15/07/2025</div>
                            <div class="reviews__time">14:30</div>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__actions">
                                <button class="reviews__action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="reviews__action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="reviews__action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="reviews__table-row">
                        <td class="reviews__table-cell">#001</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__user">
                                <div class="reviews__user-avatar reviews__user-avatar--purple">D</div>
                                <span class="reviews__user-name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">iPhone 14 Pro Max</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__rating">
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <span class="reviews__rating-text">5/5</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</td>
                        <td class="reviews__table-cell">
                            <span class="reviews__status reviews__status--pending">Pending</span>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__date">15/07/2025</div>
                            <div class="reviews__time">14:30</div>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__actions">
                                <button class="reviews__action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="reviews__action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="reviews__action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="reviews__table-row">
                        <td class="reviews__table-cell">#001</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__user">
                                <div class="reviews__user-avatar reviews__user-avatar--green">D</div>
                                <span class="reviews__user-name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">iPhone 14 Pro Max</td>
                        <td class="reviews__table-cell">
                            <div class="reviews__rating">
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--filled"></i>
                                <i class="fas fa-star reviews__star reviews__star--empty"></i>
                                <i class="fas fa-star reviews__star reviews__star--empty"></i>
                                <span class="reviews__rating-text">3/5</span>
                            </div>
                        </td>
                        <td class="reviews__table-cell">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</td>
                        <td class="reviews__table-cell">
                            <span class="reviews__status reviews__status--rejected">Rejected</span>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__date">15/07/2025</div>
                            <div class="reviews__time">14:30</div>
                        </td>
                        <td class="reviews__table-cell">
                            <div class="reviews__actions">
                                <button class="reviews__action-btn" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="reviews__action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="reviews__action-btn" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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