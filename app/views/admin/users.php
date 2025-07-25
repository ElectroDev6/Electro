<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang người dùng</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
    <div class="user-page">
        <!-- Header Section -->
        <div class="user-page__header">
            <h1 class="user-page__title">Trang người dùng</h1>
            <button class="user-page__add-btn">+ Add new</button>
        </div>

        <!-- Filter Section -->
        <div class="user-filter">
            <div class="user-filter__group">
                <label class="user-filter__label">Tên người dùng</label>
                <input type="text" class="user-filter__input" placeholder="Tìm kiếm sản phẩm...">
            </div>
            
            <div class="user-filter__group">
                <label class="user-filter__label">Vai trò</label>
                <select class="user-filter__select">
                    <option>Tất cả danh mục</option>
                </select>
            </div>
            
            <div class="user-filter__group">
                <label class="user-filter__label">Trạng thái</label>
                <select class="user-filter__select">
                    <option>Tất cả thương hiệu</option>
                </select>
            </div>
            
            <div class="user-filter__actions">
                <button class="user-filter__btn user-filter__btn--primary">Lọc</button>
                <button class="user-filter__btn user-filter__btn--secondary">Reset</button>
            </div>
        </div>

        <!-- Users Table Section -->
        <div class="user-list">
            <table class="user-table">
                <thead class="user-table__head">
                    <tr class="user-table__header-row">
                        <th class="user-table__header">Tên</th>
                        <th class="user-table__header">Email</th>
                        <th class="user-table__header">Vai trò</th>
                        <th class="user-table__header">SĐT</th>
                        <th class="user-table__header">Trạng thái</th>
                        <th class="user-table__header">Lần cuối đăng nhập</th>
                        <th class="user-table__header">Điều hướng</th>
                    </tr>
                </thead>
                <tbody class="user-table__body">
                    <!-- User Row 1 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">Hôm nay, 9:30 tối</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <a href="/admin/userDetail" class="user-table__action-btn">👁</a>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 2 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">Hôm nay, 9:30 sáng</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 3 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">Hôm nay, 9:30 sáng</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 4 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">2 ngày trước</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 5 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">5 phút trước</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 6 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">2 ngày trước</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 7 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--active">đang hoạt động</span>
                        </td>
                        <td class="user-table__cell">2 ngày trước</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 8 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--inactive">không hoạt động</span>
                        </td>
                        <td class="user-table__cell">Không bao giờ</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                    
                    <!-- User Row 9 -->
                    <tr class="user-table__row">
                        <td class="user-table__cell user-table__cell--name">
                            <div class="user-table__avatar user-table__avatar--purple">D</div>
                            <span class="user-table__username">Nguyễn Văn Đức</span>
                        </td>
                        <td class="user-table__cell">nguyenduc097@gmail.com</td>
                        <td class="user-table__cell">admin</td>
                        <td class="user-table__cell">0987654321</td>
                        <td class="user-table__cell">
                            <span class="user-table__status user-table__status--inactive">không hoạt động</span>
                        </td>
                        <td class="user-table__cell">Không bao giờ</td>
                        <td class="user-table__cell user-table__cell--actions">
                            <button class="user-table__action-btn">👁</button>
                            <button class="user-table__action-btn">✏️</button>
                            <button class="user-table__action-btn">🗑</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="pagination">
                <div class="pagination__info">Hiển thị 1-9 trong số 54 mục</div>
                <div class="pagination__controls">
                    <button class="pagination__btn pagination__btn--active">1</button>
                    <button class="pagination__btn">2</button>
                    <button class="pagination__btn">3</button>
                    <button class="pagination__btn">4</button>
                    <button class="pagination__btn">5</button>
                </div>
            </div>
        </div>
    </div>
    </main>
   
</body>
</html>