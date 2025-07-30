<?php
namespace App\Views;
include dirname(__DIR__) . '/admin/partials/header.php';
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/pagination.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Bình luận</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
        <!-- <?php 
    echo '<pre>';
    echo json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo '</pre>';
    ?> -->
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="comment-management" data-target="pagination-container">
            <!-- Header Section -->
            <header class="comment-management__header">
                <div class="comment-management__title-section">
                    <h1 class="comment-management__title">Quản lý Bình luận</h1>
                    <p class="comment-management__subtitle">Xem và quản lý tất cả bình luận từ khách hàng</p>
                </div>
                <button class="comment-management__add-btn">
                    <i class="fas fa-plus"></i>
                    Thêm mới
                </button>
            </header>

            <!-- Statistics Cards -->
            <section class="comment-stats">
                <?php
                $totalComments = count($comments);
                $pendingComments = count(array_filter($comments, fn($c) => $c['status'] === 'pending'));
                $todayComments = count(array_filter($comments, fn($c) => date('Y-m-d', strtotime($c['created_at'])) === date('Y-m-d')));
                $totalLikes = array_sum(array_column($comments, 'likes'));
                ?>
                <div class="comment-stats__card">
                    <div class="comment-stats__label">Tổng Bình luận</div>
                    <div class="comment-stats__value"><?php echo $totalComments; ?></div>
                </div>
                <div class="comment-stats__card">
                    <div class="comment-stats__label">Chờ duyệt</div>
                    <div class="comment-stats__value"><?php echo $pendingComments; ?></div>
                </div>
                <div class="comment-stats__card">
                    <div class="comment-stats__label">Hôm nay</div>
                    <div class="comment-stats__value"><?php echo $todayComments; ?></div>
                </div>
                <div class="comment-stats__card">
                    <div class="comment-stats__label">Tổng Likes</div>
                    <div class="comment-stats__value"><?php echo $totalLikes; ?></div>
                </div>
            </section>

            <!-- Filters Section -->
            <section class="comment-filters">
                <div class="comment-filters__group">
                    <label class="comment-filters__label">Trạng thái</label>
                    <select class="comment-filters__select" name="status">
                        <option value="">Tất cả</option>
                        <option value="approved">Đã duyệt</option>
                        <option value="pending">Chờ duyệt</option>
                        <option value="rejected">Từ chối</option>
                    </select>
                </div>
                <div class="comment-filters__group">
                    <label class="comment-filters__label">Sắp xếp theo</label>
                    <select class="comment-filters__select" name="sort">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="most_liked">Nhiều like nhất</option>
                    </select>
                </div>
                <div class="comment-filters__search-group">
                    <label class="comment-filters__label">Tìm kiếm</label>
                    <div class="comment-filters__search-wrapper">
                        <input type="text" class="comment-filters__search" placeholder="Tìm kiếm theo nội dung bình luận..." name="search">
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
                        <?php foreach ($comments as $comment): ?>
                            <tr class="comments-table__row">
                                <td class="comment-table__cell">#<?php echo str_pad($comment['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                <td class="comment-table__cell">
                                    <div class="comment-user">
                                        <div class="comment-user__avatar">
                                            <span class="comment-user__initial"><?php echo strtoupper(substr($comment['user']['full_name'], 0, 1)); ?></span>
                                        </div>
                                        <span class="comment-user__name"><?php echo htmlspecialchars($comment['user']['full_name']); ?></span>
                                    </div>
                                </td>
                                <td class="comment-table__cell"><?php echo htmlspecialchars($comment['product']['name'] ?? 'N/A'); ?></td>
                                <td class="comment-table__cell">
                                    <div class="comment-likes">
                                        <i class="fas fa-heart comment-likes__icon"></i>
                                        <span class="comment-likes__count"><?php echo $comment['likes']; ?></span>
                                    </div>
                                </td>
                                <td class="comment-table__cell">
                                    <div class="comment-content"><?php echo htmlspecialchars(substr($comment['content'], 0, 50) . (strlen($comment['content']) > 50 ? '...' : '')); ?></div>
                                </td>
                                <td class="comment-table__cell">
                                    <span class="comment-status comment-status--<?php echo $comment['status']; ?>">
                                        <?php
                                        $statusMap = [
                                            'pending' => 'Chờ duyệt',
                                            'approved' => 'Đã duyệt',
                                            'rejected' => 'Từ chối'
                                        ];
                                        echo htmlspecialchars($statusMap[$comment['status']] ?? ucfirst($comment['status']));
                                        ?>
                                    </span>
                                </td>
                                <td class="comment-table__cell">
                                    <div class="comment-date">
                                        <div class="comment-date__date"><?php echo date('d/m/Y', strtotime($comment['created_at'])); ?></div>
                                        <div class="comment-date__time"><?php echo date('H:i', strtotime($comment['created_at'])); ?></div>
                                    </div>
                                </td>
                                <td class="comment-table__cell">
                                    <div class="comment-actions">
                                        <a href="/admin/commentDetail?id=<?php echo $comment['id']; ?>" class="comment-actions__btn comment-actions__btn--view">
                                            <img src="/icons/view_icon.svg" alt="Xem">
                                        </a>
                                        <button class="comment-actions__btn comment-actions__btn--edit">
                                            <img src="/icons/edit_icon.svg" alt="Sửa">
                                        </button>
                                        <button class="comment-actions__btn comment-actions__btn--delete">
                                            <img src="/icons/trash_icon.svg" alt="Xóa">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php echo $htmlPagination; ?>
            </section>
        </div>
    </main>
    <script src="/admin-ui/js/common/pagination.js"></script>
</body>
</html>
?>