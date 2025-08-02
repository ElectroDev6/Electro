<?php
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/header.php';
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
    <!-- Debug output (remove in production) -->
    <?php
    // echo '<pre>';
    // print_r($user);
    // echo '</pre>';
    ?>

    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="user-detail">
            <!-- Header -->
            <header class="user-detail__header">
                <h1 class="user-detail__title">Chi tiết người dùng</h1>
                <div class="user-detail__actions">
                    <a href="/admin/users" class="user-detail__button user-detail__button--back">← Back</a>
                    <button class="user-detail__button user-detail__button--edit" onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">✏ Edit</button>
                </div>
            </header>

            <!-- User Profile Section -->
            <section class="user-detail__profile">
                <div class="user-detail__avatar">
                    <span class="user-detail__avatar-text">
                        <?php echo strtoupper(substr($user['full_name'] ?? 'U', 0, 1)); ?>
                    </span>
                </div>
                <div class="user-detail__profile-info">
                    <h2 class="user-detail__name"><?php echo htmlspecialchars($user['full_name'] ?? 'Không có tên'); ?></h2>
                    <p class="user-detail__email"><?php echo htmlspecialchars($user['username'] ?? 'Không có email'); ?></p>
                    <div class="user-detail__badges">
                        <span class="user-detail__badge user-detail__badge--<?php echo ($user['role'] === 'admin' ? 'active' : 'inactive'); ?>">
                            <?php echo ($user['role'] === 'admin' ? 'Đang hoạt động' : 'Không hoạt động'); ?>
                        </span>
                        <span class="user-detail__badge user-detail__badge--<?php echo ($user['role'] === 'admin' ? 'admin' : 'customer'); ?>">
                            <?php echo ($user['role'] === 'admin' ? 'Administrator' : 'Customer'); ?>
                        </span>
                    </div>
                </div>
            </section>

            <!-- Personal Information -->
            <section class="user-detail__section">
                <h3 class="user-detail__section-title">Thông tin người dùng chi tiết</h3>
                <div class="user-detail__info-grid">
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Email:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['username'] ?? 'Không có email'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Phone:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['phone'] ?? 'Không có số điện thoại'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Address:</label>
                        <span class="user-detail__value">
                            <?php
                            $address = $user['address'] ?? null;
                            echo htmlspecialchars(
                                ($address ? $address['address_line'] . ', ' . $address['ward'] . ', ' . $address['district'] . ', ' . $address['city'] : 'Không có địa chỉ')
                            );
                            ?>
                        </span>
                    </div>
                </div>
            </section>

            <!-- Account Information -->
            <section class="user-detail__section">
                <h3 class="user-detail__section-title">Thông tin tài khoản</h3>
                <div class="user-detail__info-grid">
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Tên người dùng:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['full_name'] ?? 'Không có tên'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Vai trò:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['role'] ?? 'Không xác định'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Trạng thái:</label>
                        <span class="user-detail__value">
                            <?php echo ($user['role'] === 'admin' ? 'Đang hoạt động' : 'Không hoạt động'); ?>
                        </span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Ngày tạo:</label>
                        <span class="user-detail__value"><?php echo htmlspecialchars($user['created_at'] ?? 'Không có ngày'); ?></span>
                    </div>
                    <div class="user-detail__info-item">
                        <label class="user-detail__label">Đăng nhập cuối cùng:</label>
                        <span class="user-detail__value">
                            <?php
                            $createAt = new DateTime($user['created_at'] ?? 'now');
                            $now = new DateTime();
                            $diff = $now->diff($createAt);
                            $hour = (int)$createAt->format('H');

                            if ($diff->days === 0) {
                                if ($hour >= 18) {
                                    echo 'Hôm nay, ' . $createAt->format('H:i') . ' tối';
                                } elseif ($hour >= 12) {
                                    echo 'Hôm nay, ' . $createAt->format('H:i') . ' chiều';
                                } else {
                                    echo 'Hôm nay, ' . $createAt->format('H:i') . ' sáng';
                                }
                            } elseif ($diff->days === 1) {
                                echo '1 ngày trước';
                            } elseif ($diff->days > 1) {
                                echo $diff->days . ' ngày trước';
                            } else {
                                echo 'Không bao giờ';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Placeholder function for edit action
        function editUser(user) {
            console.log('Edit user:', user);
            // Implement edit logic (e.g., open modal or redirect to edit page)
        }
    </script>
</body>
</html>