<?php
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/helpers/DateTimeHelper.php';
$successMessage = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
function buildPaginationUrl($pageNum) {
    global $search, $role, $gender, $limit;
    $params = [];
    if ($pageNum > 1) $params['page'] = $pageNum;
    if (!empty($search)) $params['search'] = $search;
    if (!empty($role)) $params['role'] = $role;
    if (!empty($gender)) $params['gender'] = $gender;
    if ($limit != 8) $params['limit'] = $limit;
    $queryString = http_build_query($params);
    return '/admin/users' . (!empty($queryString) ? '?' . $queryString : '');
}
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
            <!-- Notification -->
            <div class="notification" id="success-notification">
                <p id="success-message"><?php echo $successMessage; ?></p>
            </div>
            
            <!-- Header Section -->
            <div class="user-page__header">
                <h1 class="user-page__title">Trang người dùng</h1>
                <a href="/admin/users/create" class="user-page__add-btn">+ Thêm người dùng</a>
            </div>
            
            <!-- Filter Section -->
            <form class="user-filter" method="GET" action="/admin/users">
                <div class="user-filter__group">
                    <label class="user-filter__label">Tìm kiếm</label>
                    <input type="text" name="search" class="user-filter__input" 
                           placeholder="Tìm kiếm tên hoặc email..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="user-filter__group">
                    <label class="user-filter__label">Vai trò</label>
                    <select name="role" class="user-filter__select">
                        <option value="">Tất cả vai trò</option>
                        <option value="admin" <?php echo $role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo $role === 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="guest" <?php echo $role === 'guest' ? 'selected' : ''; ?>>Khách</option>
                    </select>
                </div>
                
                <div class="user-filter__group">
                    <label class="user-filter__label">Giới tính</label>
                    <select name="gender" class="user-filter__select">
                        <option value="">Tất cả giới tính</option>
                        <option value="male" <?php echo $gender === 'male' ? 'selected' : ''; ?>>Nam</option>
                        <option value="female" <?php echo $gender === 'female' ? 'selected' : ''; ?>>Nữ</option>
                        <option value="other" <?php echo $gender === 'other' ? 'selected' : ''; ?>>Khác</option>
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
                
                <div class="user-filter__actions">
                    <button type="submit" class="user-filter__btn user-filter__btn--primary">Lọc</button>
                    <a href="/admin/users" class="user-filter__btn user-filter__btn--secondary">Reset</a>
                </div>
            </form>

            <!-- Filter Results Info -->
            <?php if (!empty($search) || !empty($role) || !empty($gender)): ?>
                <div class="filter-info" style="margin: 15px 0; padding: 10px; background: #e3f2fd; border-radius: 5px; color: #1976d2;">
                    <strong>Đang lọc:</strong>
                    <?php if (!empty($search)): ?>
                        <span class="filter-tag">Tìm kiếm: "<?php echo htmlspecialchars($search); ?>"</span>
                    <?php endif; ?>
                    <?php if (!empty($role)): ?>
                        <span class="filter-tag">Vai trò: "<?php echo htmlspecialchars($role); ?>"</span>
                    <?php endif; ?>
                    <?php if (!empty($gender)): ?>
                        <span class="filter-tag">Giới tính: "<?php echo htmlspecialchars($gender); ?>"</span>
                    <?php endif; ?>
                    | <strong><?php echo $totalUsers; ?></strong> kết quả | Hiển thị <?php echo $limit; ?> mục/trang
                </div>
            <?php endif; ?>

            <!-- Users Table Section -->
            <div class="user-list">
                <table class="user-table">
                    <thead class="user-table__head">
                        <tr class="user-table__header-row">
                            <th class="user-table__header">Tên</th>
                            <th class="user-table__header">Email</th>
                            <th class="user-table__header">Vai trò</th>
                            <th class="user-table__header">SĐT</th>
                            <th class="user-table__header">Giới tính</th>
                            <th class="user-table__header">Ngày sinh</th>
                            <th class="user-table__header">Điều hướng</th>
                        </tr>
                    </thead>
                    <tbody class="user-table__body">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="users-table__row">
                                    <td class="user-table__cell user-table__cell--name">
                                        <?php if (!empty($user['avatar_url'])): ?>
                                            <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="Avatar" class="user-table__avatar-img">
                                        <?php else: ?>
                                            <div class="user-table__avatar user-table__avatar--purple">
                                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                            </div>
                                        <?php endif; ?>
                                        <span class="user-table__username"><?php echo htmlspecialchars($user['name']); ?></span>
                                    </td>
                                    <td class="user-table__cell"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="user-table__cell">
                                        <?php 
                                        $roleMap = [
                                            'admin' => 'Admin',
                                            'user' => 'User',
                                            'guest' => 'Khách'
                                        ];
                                        echo htmlspecialchars($roleMap[$user['role']] ?? 'Unknown');
                                        ?>
                                    </td>
                                    <td class="user-table__cell"><?php echo htmlspecialchars($user['phone_number']); ?></td>
                                    <td class="user-table__cell">
                                        <?php 
                                        $genderMap = [
                                            'male' => 'Nam',
                                            'female' => 'Nữ',
                                            'other' => 'Khác'
                                        ];
                                        echo htmlspecialchars($genderMap[$user['gender']] ?? 'Không xác định');
                                        ?>
                                    </td>
                                    <td class="user-table__cell">
                                        <?php 
                                        if ($user['birth_date']) {
                                            $birthDate = new DateTime($user['birth_date']);
                                            echo $birthDate->format('d/m/Y');
                                        } else {
                                            echo 'Chưa cập nhật';
                                        }
                                        ?>
                                    </td>
                                    <td class="user-table__cell user-table__cell--actions">
                                        <a href="/admin/users/detail?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="product-table__action-btn" title="Xem chi tiết">
                                            <img src="/icons/view_icon.svg" alt="Xem">
                                        </a>
                                        <a href="/admin/users/update?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="product-table__action-btn" title="Chỉnh sửa">
                                            <img src="/icons/edit_icon.svg" alt="Sửa">
                                        </a>
                                        <form action="/admin/users/delete" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xoá người dùng \'<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>\'?')">
                                            <input type="hidden" name="id" value="<?php echo $user['user_id']; ?>">
                                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>">
                                            <button type="submit" class="product-table__action-btn" title="Xóa">
                                                <img src="/icons/trash_icon.svg" alt="Xóa">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="user-table__cell">Không có người dùng nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <!-- Pagination Section -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <div class="pagination-right">
                            <!-- First Button -->
                            <a href="<?php echo buildPaginationUrl(1); ?>" 
                               class="pagination__btn first-btn <?php echo $page === 1 ? 'pagination__btn--disabled' : ''; ?>">
                                Đầu
                            </a>
                            
                            <!-- Previous Button -->
                            <a href="<?php echo buildPaginationUrl(max(1, $page - 1)); ?>" 
                               class="pagination__btn prev-btn <?php echo $page === 1 ? 'pagination__btn--disabled' : ''; ?>">
                                Trước
                            </a>
                            
                            <!-- Page Numbers -->
                            <?php 
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <a href="<?php echo buildPaginationUrl($i); ?>" 
                                   class="pagination__btn page-btn <?php echo $i === $page ? 'pagination__btn--active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                            
                            <!-- Next Button -->
                            <a href="<?php echo buildPaginationUrl(min($totalPages, $page + 1)); ?>" 
                               class="pagination__btn next-btn <?php echo $page === $totalPages ? 'pagination__btn--disabled' : ''; ?>">
                                Sau
                            </a>
                            
                            <!-- Last Button -->
                            <a href="<?php echo buildPaginationUrl($totalPages); ?>" 
                               class="pagination__btn last-btn <?php echo $page === $totalPages ? 'pagination__btn--disabled' : ''; ?>">
                                Cuối
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Pagination Info -->
                <div class="pagination-info">
                    Hiển thị <?php echo min($totalUsers, ($page - 1) * $usersPerPage + 1); ?> - 
                    <?php echo min($totalUsers, $page * $usersPerPage); ?> 
                    trong tổng số <?php echo $totalUsers; ?> người dùng
                </div>
            </div>
        </div>
    </main>
    
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
</body>
</html>