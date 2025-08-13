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

                <!-- Tỉnh/Thành phố -->
                <div class="select-group">
                    <select name="province_city" id="province_city" class="select-group__field">
                        <option value="">Chọn Tỉnh/Thành phố</option>
                    </select>
                    <label for="province_city" class="select-group__label">Tỉnh/Thành phố</label>
                    <?php if (isset($errors['province_city'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['province_city']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Quận/Huyện -->
                <div class="select-group">
                    <select name="district" id="district" class="select-group__field">
                        <option value="">Chọn Quận/Huyện</option>
                    </select>
                    <label for="district" class="select-group__label">Quận/Huyện</label>
                    <?php if (isset($errors['district'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['district']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Phường/Xã -->
                <div class="select-group">
                    <select name="ward_commune" id="ward_commune" class="select-group__field">
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                    <label for="ward_commune" class="select-group__label">Phường/Xã</label>
                    <?php if (isset($errors['ward_commune'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['ward_commune']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Địa chỉ chi tiết -->
                <div class="input-group">
                    <input type="text" name="address_line1" id="address_line1" class="input-group__field" placeholder="Số nhà, tên đường..." value="<?= htmlspecialchars($user['address_line1'] ?? '') ?>">
                    <label for="address_line1" class="input-group__label">Địa chỉ chi tiết</label>
                    <?php if (isset($errors['address_line1'])): ?>
                        <span class="category-detail--error"><?= htmlspecialchars($errors['address_line1']) ?></span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="edit-user-form__submit">Lưu thay đổi</button>
            </form>
        </div>
    </main>

    <script>
        const vietnamAddresses = {
            "Hà Nội": {
                "Ba Đình": ["Phúc Xá", "Trúc Bạch", "Vĩnh Phúc", "Cống Vị", "Liễu Giai", "Nguyễn Trung Trực", "Quán Thánh", "Ngọc Hà", "Điện Biên", "Đội Cấn", "Ngọc Khánh", "Kim Mã", "Giảng Võ", "Thành Công"],
                "Hoàn Kiếm": ["Phúc Tân", "Đồng Xuân", "Hàng Mã", "Hàng Buồm", "Hàng Đào", "Hàng Bồ", "Cửa Đông", "Lý Thái Tổ", "Hàng Bạc", "Hàng Gai", "Chương Dương", "Cửa Nam", "Hàng Trống", "Tràng Tiền", "Trần Hưng Đạo", "Phan Chu Trinh"],
                "Tây Hồ": ["Phú Thượng", "Nhật Tan", "Tứ Liên", "Quảng An", "Xuân La", "Yến Phụ", "Bưởi", "Thụy Khuê"],
                "Long Biên": ["Thượng Thanh", "Ngọc Lâm", "Gia Thụy", "Ngọc Thụy", "Sài Đồng", "Long Biên", "Thạch Bàn", "Phúc Lợi", "Bo Đề", "Đức Giang", "Việt Hùng", "Cự Khối", "Phúc Đồng", "Long Biên"],
                "Cầu Giấy": ["Nghĩa Đô", "Nghĩa Tân", "Mai Dịch", "Dịch Vọng", "Dịch Vọng Hậu", "Quan Hoa", "Yên Hòa", "Trung Hòa"]
            },
            "TP. Hồ Chí Minh": {
                "Quận 1": ["Tân Định", "Đa Kao", "Bến Nghé", "Bến Thành", "Nguyễn Thái Bình", "Phạm Ngũ Lão", "Cầu Ông Lãnh", "Cô Giang", "Nguyễn Cư Trinh", "Cầu Kho"],
                "Quận 2": ["Thảo Điền", "An Phú", "An Khánh", "Bình An", "Bình Trưng Đông", "Bình Trưng Tây", "Cát Lái", "Thạnh Mỹ Lợi", "An Lợi Đông", "Thủ Thiêm"],
                "Quận 3": ["Võ Thị Sáu", "Đa Kao", "Nguyễn Thái Bình", "Phạm Ngũ Lão", "Nguyễn Cư Trinh", "Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5"],
                "Quận 4": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 6", "Phường 8", "Phường 9", "Phường 10", "Phường 13", "Phường 14"],
                "Quận 5": ["Phường 1", "Phường 2", "Phường 3", "Phường 4", "Phường 5", "Phường 6", "Phường 7", "Phường 8", "Phường 9", "Phường 10"]
            },
            "Đà Nẵng": {
                "Hải Châu": ["Thạch Thang", "Hải Châu I", "Hải Châu II", "Phước Ninh", "Hòa Thuận Tây", "Hòa Thuận Đông", "Nam Dương", "Bình Hiên", "Bình Thuận", "Hòa Cường Bắc"],
                "Thanh Khê": ["Tam Thuận", "Thanh Khê Tây", "Thanh Khê Đông", "Xuân Hà", "Tân Chính", "Chính Gián", "Vĩnh Trung", "Thạc Gián", "An Khê", "Hòa Khê"],
                "Sơn Trà": ["Thọ Quang", "Nại Hiên Đông", "Mân Thái", "An Hải Bắc", "Phước Mỹ", "An Hải Tây", "An Hải Đông"],
                "Ngũ Hành Sơn": ["Mỹ An", "Khuê Mỹ", "Hòa Quý", "Hòa Hải"]
            }
        };

        // Lấy giá trị hiện tại từ user data
        const currentProvinceCity = '<?= htmlspecialchars($user['province_city'] ?? '') ?>';
        const currentDistrict = '<?= htmlspecialchars($user['district'] ?? '') ?>';
        const currentWardCommune = '<?= htmlspecialchars($user['ward_commune'] ?? '') ?>';

        function loadProvinces() {
            const provinceSelect = document.getElementById('province_city');
            provinceSelect.innerHTML = '<option value="">Chọn Tỉnh/Thành phố</option>';

            Object.keys(vietnamAddresses).forEach(province => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;
                if (province === currentProvinceCity) {
                    option.selected = true;
                }
                provinceSelect.appendChild(option);
            });
        }

        // Hàm load quận/huyện
        function loadDistricts(province) {
            const districtSelect = document.getElementById('district');
            const wardSelect = document.getElementById('ward_commune');

            // Reset districts và wards
            districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

            if (province && vietnamAddresses[province]) {
                Object.keys(vietnamAddresses[province]).forEach(district => {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district;
                    if (district === currentDistrict) {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            }
        }

        // Hàm load phường/xã
        function loadWards(province, district) {
            const wardSelect = document.getElementById('ward_commune');
            wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';

            if (province && district && vietnamAddresses[province] && vietnamAddresses[province][district]) {
                vietnamAddresses[province][district].forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward;
                    option.textContent = ward;
                    if (ward === currentWardCommune) {
                        option.selected = true;
                    }
                    wardSelect.appendChild(option);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Load dữ liệu ban đầu
            loadProvinces();
            if (currentProvinceCity) {
                loadDistricts(currentProvinceCity);
                if (currentDistrict) {
                    loadWards(currentProvinceCity, currentDistrict);
                }
            }

            // Event listeners cho các dropdown
            document.getElementById('province_city').addEventListener('change', function() {
                const selectedProvince = this.value;
                loadDistricts(selectedProvince);
                if (this.value !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });

            document.getElementById('district').addEventListener('change', function() {
                const selectedProvince = document.getElementById('province_city').value;
                const selectedDistrict = this.value;
                loadWards(selectedProvince, selectedDistrict);
                if (this.value !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });

            document.getElementById('ward_commune').addEventListener('change', function() {
                if (this.value !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });

            // Avatar handling
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

            // Select styling
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

            // Input styling
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