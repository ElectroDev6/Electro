<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết người dùng</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php
    // Optional: Uncomment to debug the $user array
    // echo '<pre>';
    // print_r($user);
    // echo '</pre>';
    ?>
    <?php echo $htmlHeader; ?>
    <!-- Notification -->
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
        <div class="user-detail">
            <!-- Header -->
            <header class="user-detail__header">
                <h1 class="user-detail__title">Chi tiết người dùng</h1>
                <div class="user-detail__actions">
                    <a href="/admin/users" class="user-detail__button user-detail__button--back">← Back</a>
                    <form action="/admin/users/update" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['user_id'] ?? ''); ?>">
                        <button type="submit" class="user-detail__button user-detail__button--edit">
                            ✏ Edit
                        </button>
                    </form>
                </div>
            </header>

            <!-- User Profile Section -->
            <section class="user-detail__profile">
                <div class="user-detail__avatar">
                    <?php if ($user['avatar_url']): ?>
                        <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="Avatar" class="user-detail__avatar-image">
                    <?php else: ?>
                        <span class="user-detail__avatar-text">
                            <?php echo strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="user-detail__profile-info">
                    <h2 class="user-detail__name"><?php echo htmlspecialchars($user['name'] ?? 'Không có tên'); ?></h2>
                    <p class="user-detail__email"><?php echo htmlspecialchars($user['email'] ?? 'Không có email'); ?></p>
                    <div class="user-detail__badges">
                        <span class="user-detail__badge user-detail__badge--<?php echo ($user['is_active'] ? 'active' : 'inactive'); ?>">
                            <?php echo ($user['is_active'] ? 'Đang hoạt động' : 'Không hoạt động'); ?>
                        </span>
                        <span class="user-detail__badge user-detail__badge--<?php echo ($user['role'] === 'admin' ? 'admin' : 'customer'); ?>">
                            <?php echo ($user['role'] === 'admin' ? 'Administrator' : 'Customer'); ?>
                        </span>
                    </div>
                </div>
            </section>

            <!-- Personal Information -->
            <div class="user-detail__row">
                <section class="user-detail__section">
                    <h3 class="user-detail__section-title">Thông tin người dùng chi tiết</h3>
                    <div class="user-detail__info-grid">
                        <div class="user-detail__info-item">
                            <label class="user-detail__label">Email:</label>
                            <span class="user-detail__value"><?php echo htmlspecialchars($user['email'] ?? 'Không có email'); ?></span>
                        </div>
                        <div class="user-detail__info-item">
                            <label class="user-detail__label">Phone:</label>
                            <span class="user-detail__value"><?php echo htmlspecialchars($user['phone_number'] ?? 'Không có số điện thoại'); ?></span>
                        </div>
                        <div class="user-detail__info-item">
                            <label class="user-detail__label">Gender:</label>
                            <span class="user-detail__value"><?php echo htmlspecialchars($user['gender'] ?? 'Không xác định'); ?></span>
                        </div>
                        <div class="user-detail__info-item">
                            <label class="user-detail__label">Birth Date:</label>
                            <span class="user-detail__value"><?php echo htmlspecialchars($user['birth_date'] ?? 'Không có ngày sinh'); ?></span>
                        </div>
                    </div>
                </section>

                <!-- Address Information -->
                <section class="user-detail__section">
                    <h3 class="user-detail__section-title">Thông tin địa chỉ</h3>
                    <div class="user-detail__info-grid">
                        <?php 
                        // Kiểm tra xem có địa chỉ không
                        $hasAddress = !empty($user['address_line1']) || !empty($user['ward_commune']) || 
                                    !empty($user['district']) || !empty($user['province_city']);
                        
                        if ($hasAddress): ?>
                            <div class="user-detail__info-item user-detail__info-item--full">
                                <label class="user-detail__label">Địa chỉ đầy đủ:</label>
                                <span class="user-detail__value">
                                    <?php 
                                    $addressParts = array_filter([
                                        $user['address_line1'] ?? '',
                                        $user['ward_commune'] ?? '',
                                        $user['district'] ?? '',
                                        $user['province_city'] ?? ''
                                    ]);
                                    echo htmlspecialchars(implode(', ', $addressParts));
                                    ?>
                                </span>
                            </div>
                            
                            <div class="user-detail__info-item">
                                <label class="user-detail__label">Địa chỉ cụ thể:</label>
                                <span class="user-detail__value"><?php echo htmlspecialchars($user['address_line1'] ?? 'Không có'); ?></span>
                            </div>
                            <div class="user-detail__info-item">
                                <label class="user-detail__label">Phường/Xã:</label>
                                <span class="user-detail__value"><?php echo htmlspecialchars($user['ward_commune'] ?? 'Không có'); ?></span>
                            </div>
                            <div class="user-detail__info-item">
                                <label class="user-detail__label">Quận/Huyện:</label>
                                <span class="user-detail__value"><?php echo htmlspecialchars($user['district'] ?? 'Không có'); ?></span>
                            </div>
                            <div class="user-detail__info-item">
                                <label class="user-detail__label">Tỉnh/Thành phố:</label>
                                <span class="user-detail__value"><?php echo htmlspecialchars($user['province_city'] ?? 'Không có'); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="user-detail__info-item user-detail__info-item--full">
                                <label class="user-detail__label">Địa chỉ:</label>
                                <span class="user-detail__value user-detail__value--empty">
                                    Địa chỉ người dùng chưa cập nhật
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

          </div>
            <!-- Account Information -->
            <section class="user-detail__section">
                <h3 class="user-detail__section-title">Thông tin tài khoản</h3>
                <div class="user-detail__info-grid">
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Tên người dùng:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['name'] ?? 'Không có tên'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Vai trò:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['role'] ?? 'Không xác định'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Trạng thái:</label>
                        <span class="user-detail__value">
                            <?php echo ($user['is_active'] ? 'Hoạt động' : 'Tạm khóa'); ?>
                        </span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Ngày tạo:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['created_at'] ?? 'Không có ngày'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Cập nhật lần cuối:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['updated_at'] ?? 'Không có ngày'); ?></span>
                    </div>
                </div>
            </section>
        </div>
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
    </main>
</body>
</html>