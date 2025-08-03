<?php
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/header.php';
include dirname(__DIR__) . '/admin/helpers/DateTimeHelper.php';
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
        <div class="user-page" data-target="pagination-container">
            <!-- Header Section -->
            <div class="user-page__header">
                <h1 class="user-page__title">Trang người dùng</h1>
            <a href="/admin/users/addUser" class="user-page__add-btn">+ Thêm người dùng</a>
            </div>
            <!-- Filter Section -->
            <div class="user-filter">
                <div class="user-filter__group">
                    <label class="user-filter__label">Tên người dùng</label>
                    <input type="text" class="user-filter__input" placeholder="Tìm kiếm người dùng..." id="filter-username">
                </div>
                
                <div class="user-filter__group">
                    <label class="user-filter__label">Vai trò</label>
                    <select class="user-filter__select" id="filter-role">
                        <option value="">Tất cả vai trò</option>
                        <option value="0">Admin</option>
                        <option value="1">User</option>
                        <option value="2">Khách</option>
                    </select>
                </div>
                
                <div class="user-filter__actions">
                    <button class="user-filter__btn user-filter__btn--primary" id="filter-btn">Lọc</button>
                    <button class="user-filter__btn user-filter__btn--secondary" id="reset-btn">Reset</button>
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
                            <th class="user-table__header">Lần cuối đăng nhập</th>
                            <th class="user-table__header">Điều hướng</th>
                        </tr>
                    </thead>
                    <tbody class="user-table__body">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="users-table__row">
                                    <td class="user-table__cell user-table__cell--name">
                                        <div class="user-table__avatar user-table__avatar--purple">
                                            <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                                        </div>
                                        <span class="user-table__username"><?php echo htmlspecialchars($user['full_name']); ?></span>
                                    </td>
                                    <td class="user-table__cell"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="user-table__cell">
                                        <?php 
                                        $roleMap = [
                                            0 => 'Admin',
                                            1 => 'User',
                                            2 => 'Khách'
                                        ];
                                        echo htmlspecialchars($roleMap[$user['role']] ?? 'Unknown');
                                        ?>
                                    </td>
                                    <td class="user-table__cell"><?php echo htmlspecialchars($user['phone']); ?></td>
                                    
                                    <td class="user-table__cell">
                                        <?php echo formatTimeAgo($user['created_at']); ?>
                                    </td>
                                    <td class="user-table__cell user-table__cell--actions">
                                        <a href="/admin/userDetail?id=<?php echo htmlspecialchars($user['id']); ?>" class="product-table__action-btn">
                                            <img src="/icons/view_icon.svg" alt="Xem">
                                        </a>
                                        <form action="/admin/users/editUser" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="product-table__action-btn">
                                                <img src="/icons/edit_icon.svg" alt="Sửa">
                                            </button>
                                        </form>
                                        <form action="/admin/users/delete" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="product-table__action-btn">
                                                <img src="/icons/trash_icon.svg" alt="Xóa">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="user-table__row">
                                <td colspan="7" class="user-table__cell">Không có người dùng nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination__info">Hiển thị 1-<?php echo count($users); ?> trong số <?php echo count($users); ?> mục</div>
                    <div class="pagination__controls">
                        <?php for ($i = 1; $i <= ceil(count($users) / 9); $i++): ?>
                            <button class="pagination__btn <?php echo ($i === 1 ? 'pagination__btn--active' : ''); ?>">
                                <?php echo $i; ?>
                            </button>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/common/pagination.js"></script>
    <script type="module" src="/admin-ui/js/pages/user-filter.js"></script>
</body>
</html>