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
    <title>Chỉnh sửa người dùng - Admin</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>

<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="edit-user-page">
            <?php if (!empty($errors)): ?>
                <div class="category-detail__alert category-detail__alert--danger">
                    <?php foreach ($errors as $field => $message): ?>
                        <p><?= htmlspecialchars($field . ': ' . $message) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="category-detail__alert category-detail__alert--success">
                    <p><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endif; ?>

            <h1 class="edit-user-page__title">Chỉnh sửa người dùng</h1>
            <form action="/admin/users/update" method="POST" class="edit-user-form" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id'] ?? '') ?>">

                <!-- Họ và tên -->
                <div class="input-group">
                    <input type="text" name="name" id="name" class="input-group__field" required value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                    <label for="name" class="input-group__label">Họ và tên</label>
                </div>
                <?php if (isset($errors['name'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['name']) ?></span>
                <?php endif; ?>

                <!-- Email -->
                <div class="input-group">
                    <input type="email" name="email" id="email" class="input-group__field" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                    <label for="email" class="input-group__label">Email</label>
                </div>
                <?php if (isset($errors['email'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['email']) ?></span>
                <?php endif; ?>

                <!-- Số điện thoại -->
                <div class="input-group">
                    <input type="tel" name="phone_number" id="phone_number" class="input-group__field" inputmode="numeric" pattern="[0-9]{10,11}" required value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                    <label for="phone_number" class="input-group__label">Số điện thoại</label>
                </div>
                <?php if (isset($errors['phone_number'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['phone_number']) ?></span>
                <?php endif; ?>

                <!-- Giới tính -->
                <div class="select-group">
                    <select name="gender" id="gender" class="select-group__field" required>
                        <option value="" <?= (!isset($user['gender']) || $user['gender'] === '') ? 'selected' : '' ?>></option>
                        <option value="male" <?= (isset($user['gender']) && $user['gender'] === 'male') ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= (isset($user['gender']) && $user['gender'] === 'female') ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= (isset($user['gender']) && $user['gender'] === 'other') ? 'selected' : '' ?>>Khác</option>
                    </select>
                    <label for="gender" class="select-group__label">Giới tính</label>
                    <?php if (isset($errors['gender'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['gender']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Ngày sinh -->
                <div class="input-group">
                    <input type="date" name="birth_date" id="birth_date" class="input-group__field input-group__field--date input-group__field--date-top" value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>" required>
                    <label for="birth_date" class="input-group__label">Ngày sinh</label>
                    <?php if (isset($errors['birth_date'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['birth_date']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Vai trò -->
                <div class="select-group">
                    <select name="role" id="role" class="select-group__field" required>
                        <option value="" <?= (!isset($user['role']) || $user['role'] === '') ? 'selected' : '' ?>></option>
                        <option value="user" <?= (isset($user['role']) && $user['role'] === 'user') ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= (isset($user['role']) && $user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="guest" <?= (isset($user['role']) && $user['role'] === 'guest') ? 'selected' : '' ?>>Khách</option>
                    </select>
                    <label for="role" class="select-group__label">Vai trò</label>
                    <?php if (isset($errors['role'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['role']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Trạng thái -->
                <div class="select-group">
                    <select name="is_active" id="is_active" class="select-group__field" required>
                        <option value="" <?= (!isset($user['is_active']) || $user['is_active'] === '') ? 'selected' : '' ?>></option>
                        <option value="1" <?= (isset($user['is_active']) && $user['is_active'] == 1) ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="0" <?= (isset($user['is_active']) && $user['is_active'] == 0) ? 'selected' : '' ?>>Tạm khóa</option>
                    </select>
                    <label for="is_active" class="select-group__label">Trạng thái</label>
                    <?php if (isset($errors['is_active'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['is_active']) ?></span>
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
                            <?php if ($user['avatar_url']): ?>
                                <img class="avatar-preview__image" id="avatarImage" src="<?= htmlspecialchars($user['avatar_url']) ?>" alt="Avatar preview">
                            <?php else: ?>
                                <img class="avatar-preview__image" id="avatarImage" alt="Avatar preview">
                            <?php endif; ?>
                            <button type="button" class="avatar-preview__remove" id="removeAvatar" title="Xóa ảnh">×</button>
                        </div>
                    </div>
                    <?php if (isset($errors['avatar_url'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['avatar_url'] ?? '') ?></span>
                    <?php endif; ?>
                </div>

                <!-- Địa chỉ -->
                <div class="input-group">
                    <input type="text" name="address" id="address" class="input-group__field" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
                    <label for="address" class="input-group__label">Địa chỉ (Dòng 1)</label>
                </div>
                <?php if (isset($errors['address'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['address']) ?></span>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="ward_commune" id="ward_commune" class="input-group__field" value="<?= htmlspecialchars($user['ward_commune'] ?? '') ?>">
                    <label for="ward_commune" class="input-group__label">Phường/Xã</label>
                </div>
                <?php if (isset($errors['ward_commune'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['ward_commune']) ?></span>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="district" id="district" class="input-group__field" value="<?= htmlspecialchars($user['district'] ?? '') ?>">
                    <label for="district" class="input-group__label">Quận/Huyện</label>
                </div>
                <?php if (isset($errors['district'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['district']) ?></span>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="province_city" id="province_city" class="input-group__field" value="<?= htmlspecialchars($user['province_city'] ?? '') ?>">
                    <label for="province_city" class="input-group__label">Tỉnh/Thành phố</label>
                </div>
                <?php if (isset($errors['province_city'])): ?>
                    <span class="category-detail--error"><?= htmlspecialchars($errors['province_city']) ?></span>
                <?php endif; ?>
                <button type="submit" class="edit-user-form__submit">Lưu thay đổi</button>
            </form>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarUrl = '<?= htmlspecialchars($user['avatar_url'] ?? '') ?>';
            const avatarInput = document.getElementById('avatar_url');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarImage = document.getElementById('avatarImage');
            const removeButton = document.getElementById('removeAvatar');
            const fileName = document.querySelector('.file-group__name');

            // Show existing avatar on load
            if (avatarUrl) {
                avatarImage.src = avatarUrl;
                avatarPreview.classList.add('show');
            }

            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Kích thước file không được vượt quá 5MB');
                        e.target.value = '';
                        return;
                    }
                    if (!file.type.startsWith('image/')) {
                        alert('Vui lòng chọn file ảnh hợp lệ');
                        e.target.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        avatarImage.src = event.target.result;
                        avatarPreview.classList.add('show');
                        fileName.textContent = file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeButton.addEventListener('click', function() {
                avatarInput.value = '';
                avatarPreview.classList.remove('show');
                fileName.textContent = '';
                avatarImage.src = '';
            });

            const dropZone = document.querySelector('.file-group__label');
            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.style.borderColor = '#3b82f6';
                dropZone.style.backgroundColor = '#eff6ff';
            });
            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropZone.style.borderColor = '#cbd5e1';
                dropZone.style.backgroundColor = '#f8fafc';
            });
            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.style.borderColor = '#cbd5e1';
                dropZone.style.backgroundColor = '#f8fafc';
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    avatarInput.files = files;
                    avatarInput.dispatchEvent(new Event('change'));
                }
            });

            const selectElements = document.querySelectorAll('.select-group__field');
            selectElements.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value !== '') {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
                if (select.value !== '') {
                    select.classList.add('has-value');
                }
            });

            const inputElements = document.querySelectorAll('.input-group__field');
            inputElements.forEach(input => {
                if (!input.classList.contains('input-group__field--date-top')) {
                    input.addEventListener('input', function() {
                        if (this.value.trim() !== '') {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }
                    });
                    if (input.value.trim() !== '') {
                        input.classList.add('has-value');
                    }
                }
            });

            // Restrict phone number input to numbers only
            const phoneInput = document.getElementById('phone_number');
            phoneInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        });
    </script>
</body>

</html>