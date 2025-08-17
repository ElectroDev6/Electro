<?php
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/helpers/DateTimeHelper.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng mới - Admin</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="create-user-page">
            <?php if (!empty($error)): ?>
                <div class="category-detail__alert category-detail__alert--danger">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>
            <h1 class="create-user-page__title">Thêm người dùng mới</h1>
            <form action="/admin/users/handleCreate" method="POST" class="create-user-form" enctype="multipart/form-data">
                <!-- Họ và tên -->
                <div class="input-group">
                    <input type="text" name="name" id="name" class="input-group__field" value="<?= htmlspecialchars($name ?? '') ?>">
                    <label for="name" class="input-group__label">Họ và tên</label>
                                    <?php if (isset($errors['name'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['name']) ?></span>
                <?php endif; ?>

                </div>

                <!-- Email -->
                <div class="input-group">
                    <input type="email" name="email" id="email" class="input-group__field" value="<?= htmlspecialchars($email ?? '') ?>">
                    <label for="email" class="input-group__label">Email</label>
                                    <?php if (isset($errors['email'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['email']) ?></span>
                <?php endif; ?>
                </div>


                <!-- Số điện thoại -->
                <div class="input-group">
                    <input
                        type="tel"
                        name="phone_number"
                        id="phone_number"
                        class="input-group__field"
                        inputmode="numeric"
                        pattern="[0-9]{10,11}"
                        
                        value="<?= htmlspecialchars($phone_number ?? '') ?>">
                    <label for="phone_number" class="input-group__label">Số điện thoại</label>
                                    <?php if (isset($errors['phone_number'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['phone_number']) ?></span>
                <?php endif; ?>

                </div>

                <!-- Giới tính -->
                <div class="select-group">
                    <select name="gender" id="gender" class="select-group__field">
                        <option value="" <?= (!isset($gender) || $gender === '') ? 'selected' : '' ?>></option>
                        <option value="male" <?= (isset($gender) && $gender === 'male') ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= (isset($gender) && $gender === 'female') ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= (isset($gender) && $gender === 'other') ? 'selected' : '' ?>>Khác</option>
                    </select>
                    <label for="gender" class="select-group__label">Giới tính</label>
                    <?php if (isset($errors['gender'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['gender']) ?></span>
                <?php endif; ?>
                </div>
                <!-- Vai trò -->
                <div class="select-group">
                    <select name="role" id="role" class="select-group__field" >
                        <option value="" <?= (!isset($role) || $role === '') ? 'selected' : '' ?>></option>
                        <option value="user" <?= (isset($role) && $role === 'user') ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= (isset($role) && $role === 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="guest" <?= (isset($role) && $role === 'guest') ? 'selected' : '' ?>>Khách</option>
                    </select>
                    <label for="role" class="select-group__label">Vai trò</label>
                    
                <?php if (isset($errors['role'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['role']) ?></span>
                <?php endif; ?>

                </div>
                <!-- Trạng thái -->
                <div class="select-group">
                    <select name="is_active" id="is_active" class="select-group__field">
                        <option value="" <?= (!isset($is_active) || $is_active === '') ? 'selected' : '' ?>></option>
                        <option value="1" <?= (isset($is_active) && $is_active === '1') ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= (isset($is_active) && $is_active === '0') ? 'selected' : '' ?>>Tạm khóa</option>
                    </select>
                    <label for="is_active" class="select-group__label">Trạng thái</label>
                    
                <?php if (isset($errors['is_active'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['is_active']) ?></span>
                <?php endif; ?>
                </div>

                <!-- Mật khẩu -->
                <div class="input-group">
                    <input type="password" name="password" id="password" class="input-group__field" value="<?= htmlspecialchars($password ?? '') ?>">
                    <label for="password" class="input-group__label">Mật khẩu</label>
                    
                <?php if (isset($errors['password'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['password']) ?></span>
                <?php endif; ?>
                </div>

                <!-- Ảnh đại diện với Preview -->
                <div class="file-group">
                    <div class="file-group__container">
                        <div class="file-group__upload">
                            <input type="file" name="avatar_url" id="avatar_url" class="file-group__field" accept="image/*">
                            <label for="avatar_url" class="file-group__label">
                                <div class="file-group__icon">📷</div>
                                <div class="file-group__text">Chọn ảnh đại diện</div>
                                <div class="file-group__subtitle">PNG, JPG tối đa 5MB</div>
                                <div class="file-group__name"></div>
                            </label>
                        </div>
                        <div class="avatar-preview" id="avatarPreview">
                            <img class="avatar-preview__image" id="avatarImage" alt="Avatar preview">
                            <button type="button" class="avatar-preview__remove" id="removeAvatar" title="Xóa ảnh">×</button>
                        </div>
                    </div>
                    
                <?php if (isset($errors['avatar_url'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['avatar_url'] ?? $error) ?></span>
                <?php endif; ?>
                </div>

                <button type="submit" class="create-user-form__submit">Thêm người dùng</button>
            </form>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/pages/users.js"></script>
</body>
</html>