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
    <div class="user-detail">
        <!-- Header -->
        <header class="user-detail__header">
            <h1 class="user-detail__title">Chi tiết người dùng</h1>
            <div class="user-detail__actions">
                <button class="user-detail__button user-detail__button--back">← Back</button>
                <button class="user-detail__button user-detail__button--edit">✏ Edit</button>
            </div>
        </header>

        <!-- User Profile Section -->
        <section class="user-detail__profile">
            <div class="user-detail__avatar">
                <span class="user-detail__avatar-text">D</span>
            </div>
            <div class="user-detail__profile-info">
                <h2 class="user-detail__name">Nguyễn Văn Đức</h2>
                <p class="user-detail__email">nguyenvanduc@gmail.com</p>
                <div class="user-detail__badges">
                    <span class="user-detail__badge user-detail__badge--active">Đang hoạt động</span>
                    <span class="user-detail__badge user-detail__badge--admin">Administrator</span>
                </div>
            </div>
        </section>

        <!-- Personal Information -->
        <section class="user-detail__section">
            <h3 class="user-detail__section-title">Thông tin người dùng chi tiết</h3>
            <div class="user-detail__info-grid">
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Email:</label>
                    <span class="user-detail__value">nguyenvanduc@gmail.com</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Phone:</label>
                    <span class="user-detail__value">0987654321</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Address:</label>
                    <span class="user-detail__value">123 Lê Lợi, Phường Bến Nghé, Quận 1, TPHCM</span>
                </div>
            </div>
        </section>

        <!-- Account Information -->
        <section class="user-detail__section">
            <h3 class="user-detail__section-title">Thông tin tài khoản</h3>
            <div class="user-detail__info-grid">
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Tên người dùng:</label>
                    <span class="user-detail__value">Nguyễn Văn Đức</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Vai trò:</label>
                    <span class="user-detail__value">Adminshop</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Trạng thái:</label>
                    <span class="user-detail__value">Đang hoạt động</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Ngày tạo:</label>
                    <span class="user-detail__value">2024-05-07 10:00:00</span>
                </div>
                <div class="user-detail__info-item">
                    <label class="user-detail__label">Đăng nhập cuối cùng:</label>
                    <span class="user-detail__value">Today, 09:45 AM</span>
                </div>
            </div>
        </section>
    </div>
    </main>
   
</body>
</html>