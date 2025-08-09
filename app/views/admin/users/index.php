    <?php
    include dirname(__DIR__) . '/partials/header.php';
    include dirname(__DIR__) . '/partials/sidebar.php';
    // Function đơn giản cho users - chỉ cần 1 tham số
    function buildPaginationUrl($pageNum) {
        $params = $_GET; // Lấy tất cả tham số hiện tại
        $params['page'] = $pageNum; // Chỉ thay đổi page
        
        if ($pageNum == 1) {
            unset($params['page']); // Xóa page=1 cho URL sạch
        }
        $query = http_build_query($params);
        return '/admin/users' . ($query ? '?' . $query : '');
    }

    // Calculate pagination info - giữ nguyên
    $startItem = ($page - 1) * $usersPerPage + 1;
    $endItem = min($page * $usersPerPage, $totalUsers);
    $startPage = max(1, $page - 2);
    $endPage = min($totalPages, $page + 2);
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
                <!-- Filter Section -->
                <form class="user-filter" method="GET" action="/admin/users">
                    <div class="user-filter__group">
                        <label class="user-filter__label">Tìm kiếm</label>
                        <input type="text" name="search" class="user-filter__input"
                            placeholder="Tìm kiếm tên hoặc email..." value="<?php echo htmlspecialchars($search); ?>">
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
                <div class="filter-info"
                    style="margin: 15px 0; padding: 10px; background: #e3f2fd; border-radius: 5px; color: #1976d2;">
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
                                    <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="Avatar"
                                        class="user-table__avatar-img">
                                    <?php else: ?>
                                    <div class="user-table__avatar user-table__avatar--purple">
                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                    </div>
                                    <?php endif; ?>
                                    <span
                                        class="user-table__username"><?php echo htmlspecialchars($user['name']); ?></span>
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
                                    <a href="/admin/users/detail?id=<?php echo htmlspecialchars($user['user_id']); ?>"
                                        class="product-table__action-btn" title="Xem chi tiết">
                                        <img src="/icons/view_icon.svg" alt="Xem">
                                    </a>
                                    <a href="/admin/users/update?id=<?php echo htmlspecialchars($user['user_id']); ?>"
                                        class="product-table__action-btn" title="Chỉnh sửa">
                                        <img src="/icons/edit_icon.svg" alt="Sửa">
                                    </a>
                                    <form action="/admin/users/delete" method="POST" style="display:inline;"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá người dùng \'<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>\'?')">
                                        <input type="hidden" name="id" value="<?php echo $user['user_id']; ?>">
                                        <input type="hidden" name="name"
                                            value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>">
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
                <?php if ($totalPages > 1): ?>
                <div class="users__pagination">
                    <ul class="pagination__list">
                        <!-- First Page Button -->
                        <?php if ($page > 1): ?>
                        <li class="pagination__item">
                            <a href="<?php echo buildPaginationUrl(1); ?>"
                                class="pagination__link pagination__link--first">
                                <i class="fas fa-angle-double-left"></i> Đầu
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- Previous Button -->
                        <li class="pagination__item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <?php if ($page > 1): ?>
                            <a href="<?php echo buildPaginationUrl($page - 1); ?>"
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
                            <a href="<?php echo buildPaginationUrl(1); ?>"
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
                            <a href="<?php echo buildPaginationUrl($i); ?>"
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
                            <a href="<?php echo buildPaginationUrl($totalPages); ?>"
                                class="pagination__link"><?php echo $totalPages; ?></a>
                        </li>
                        <?php endif; ?>

                        <!-- Next Button -->
                        <li class="pagination__item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                            <?php if ($page < $totalPages): ?>
                            <a href="<?php echo buildPaginationUrl($page + 1); ?>"
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
                            <a href="<?php echo buildPaginationUrl($totalPages); ?>"
                                class="pagination__link pagination__link--last">
                                Cuối <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- Pagination Info for Users -->
                <div class="users__pagination-info">
                    <span class="pagination__info-text">
                        Hiển thị <?php echo number_format($startItem); ?> - <?php echo number_format($endItem); ?>
                        trong tổng số <?php echo number_format($totalUsers); ?> người dùng
                    </span>
                </div>
                <?php endif; ?>
                </div>
            </div>
        </main>
        <script type="module" src="/admin-ui/js/common/notification.js"></script>
    </body>

    </html>