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
    <title>Chi tiết Đơn hàng #001</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
         <?php echo $contentSidebar; ?>
         <div class="comment-management">
        <!-- Header Section -->
        <header class="comment-management__header">
            <div class="comment-management__title-section">
                <h1 class="comment-management__title">Quản lý Comments</h1>
                <p class="comment-management__subtitle">Xem và quản lý tất cả comments từ khách hàng</p>
            </div>
            <button class="comment-management__add-btn">
                <i class="fas fa-plus"></i>
                Add new
            </button>
        </header>

        <!-- Statistics Cards -->
        <section class="comment-stats">
            <div class="comment-stats__card">
                <div class="comment-stats__label">Tổng Comments</div>
                <div class="comment-stats__value">1,234</div>
            </div>
            <div class="comment-stats__card">
                <div class="comment-stats__label">Chờ duyệt</div>
                <div class="comment-stats__value">123</div>
            </div>
            <div class="comment-stats__card">
                <div class="comment-stats__label">Hôm nay</div>
                <div class="comment-stats__value">12</div>
            </div>
            <div class="comment-stats__card">
                <div class="comment-stats__label">Tổng Likes</div>
                <div class="comment-stats__value">2,567</div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="comment-filters">
            <div class="comment-filters__group">
                <label class="comment-filters__label">Trạng thái</label>
                <select class="comment-filters__select">
                    <option>Tất cả</option>
                    <option>Đã duyệt</option>
                    <option>Chờ duyệt</option>
                    <option>Từ chối</option>
                </select>
            </div>
            <div class="comment-filters__group">
                <label class="comment-filters__label">Sắp xếp theo</label>
                <select class="comment-filters__select">
                    <option>Mới nhất</option>
                    <option>Cũ nhất</option>
                    <option>Nhiều like nhất</option>
                </select>
            </div>
            <div class="comment-filters__search-group">
                <label class="comment-filters__label">Tìm kiếm</label>
                <div class="comment-filters__search-wrapper">
                    <input type="text" class="comment-filters__search" placeholder="Tìm kiếm theo nội dung comments...">
                    <button class="comment-filters__search-btn">
                        <i class="fas fa-search"></i>
                        Lọc
                    </button>
                    <button class="comment-filters__reset-btn">
                        <i class="fas fa-times"></i>
                        Reset
                    </button>
                </div>
            </div>
        </section>

        <!-- Comments Table -->
        <section class="comment-table-wrapper">
            <table class="comment-table">
                <thead class="comment-table__head">
                    <tr class="comment-table__row comment-table__row--header">
                        <th class="comment-table__header">ID</th>
                        <th class="comment-table__header">Người dùng</th>
                        <th class="comment-table__header">Sản phẩm</th>
                        <th class="comment-table__header">Likes</th>
                        <th class="comment-table__header">Nội dung</th>
                        <th class="comment-table__header">Trạng thái</th>
                        <th class="comment-table__header">Ngày tạo</th>
                        <th class="comment-table__header">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="comment-table__body">
                     <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <a href="/admin/commentDetail" class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt="">
                                </a>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                      <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <button class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt=""></button>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                      <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <button class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt=""></button>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                      <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <button class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt=""></button>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                      <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <button class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt=""></button>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                      <tr class="comment-table__row">
                        <td class="comment-table__cell">#001</td>
                        <td class="comment-table__cell">
                            <div class="comment-user">
                                <div class="comment-user__avatar">
                                    <span class="comment-user__initial">D</span>
                                </div>
                                <span class="comment-user__name">Nguyễn Văn Đức</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">iPhone 14 Pro Max</td>
                        <td class="comment-table__cell">
                            <div class="comment-likes">
                                <i class="fas fa-heart comment-likes__icon"></i>
                                <span class="comment-likes__count">15</span>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-content">Sản phẩm rất tuyệt vời, chất lượng tốt, giao...</div>
                        </td>
                        <td class="comment-table__cell">
                            <span class="comment-status comment-status--pending">Hạng chờ</span>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-date">
                                <div class="comment-date__date">15/07/2025</div>
                                <div class="comment-date__time">14:30</div>
                            </div>
                        </td>
                        <td class="comment-table__cell">
                            <div class="comment-actions">
                                <button class="comment-actions__btn comment-actions__btn--view">
                                   <img src="/icons/view_icon.svg" alt=""></button>
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--like">
                                     <img src="/icons/edit_icon.svg" alt="">
                                </button>
                                <button class="comment-actions__btn comment-actions__btn--delete">
                                    <img src="/icons/trash_icon.svg" alt="">
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                
            </table>
            
        <!-- Pagination -->
            <?php echo $htmlPagination; ?>
        </section>
    </main>

</body>
</html>