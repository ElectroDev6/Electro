<?php
use Core\View; 
?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>
<div class="container-main">
    <div class="profile">
        <!-- SIDEBAR -->
        <div class="profile__sidebar">
            <div class="profile__avatar">
                <img id="avatar-img" src="<?= htmlspecialchars($user['avatar_url'] ?? '/img/avatars/avatar.png') ?>"
                    alt="Avatar người dùng" />
            </div>
            <h3 class="profile__name"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h3>
            <p class="profile__phone"><?= htmlspecialchars($user['phone_number'] ?? '') ?></p>

            <button id="edit-avatar-btn" type="button" class="profile__edit-avatar-btn">Sửa avatar</button>

            <form id="avatar-form" class="profile__avatar-form" action="/profile/avatar" method="post"
                enctype="multipart/form-data" style="display:none;">
                <input type="file" name="avatar" accept="image/*" id="avatar-input" required />
                <button type="submit">Cập nhật</button>
            </form>

            <ul class="profile__menu">
                <li><a href="/profile">Tổng quan</a></li>
                <li><a href="/history">Đơn hàng của tôi</a></li>
                <li><a href="/wishlist">Sản phẩm yêu thích</a></li>
                <li><a href="/history">Lịch sử mua hàng</a></li>
                <li><a href="/logout">Đăng xuất</a></li>
            </ul>
        </div>

        <!-- CONTENT -->
        <div class="profile__content">
            <form method="POST" action="/profile/save" class="profile__form">

                <!-- HỒ SƠ -->
                <div class="profile__section">
                    <h2 class="profile__title">Hồ sơ của tôi</h2>
                    <div class="profile__row">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required />
                    </div>
                    <div class="profile__row">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone_number"
                            value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" required />
                    </div>
                    <div class="profile__row">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                            required />
                    </div>

                    <div class="profile__row--group">
                        <div class="profile__row">
                            <label>Ngày sinh</label>
                            <div class="profile__dob">
                                <select name="dob_day" required>
                                    <option value="">Ngày</option>
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= (isset($user['dob_day']) && $user['dob_day'] == $i) ? 'selected' : '' ?>>
                                        <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="dob_month" required>
                                    <option value="">Tháng</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= (isset($user['dob_month']) && $user['dob_month'] == $i) ? 'selected' : '' ?>>
                                        <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <select name="dob_year" required>
                                    <option value="">Năm</option>
                                    <?php $currentYear = date('Y'); ?>
                                    <?php for ($i = $currentYear; $i >= $currentYear - 100; $i--): ?>
                                    <option value="<?= $i ?>"
                                        <?= (isset($user['dob_year']) && $user['dob_year'] == $i) ? 'selected' : '' ?>>
                                        <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="profile__group">
                            <label>Giới tính</label>
                            <div class="profile__gender">
                                <label><input type="radio" name="gender" value="male"
                                        <?= (isset($user['gender']) && $user['gender'] === 'male') ? 'checked' : '' ?> />
                                    Nam</label>
                                <label><input type="radio" name="gender" value="female"
                                        <?= (isset($user['gender']) && $user['gender'] === 'female') ? 'checked' : '' ?> />
                                    Nữ</label>
                                <label><input type="radio" name="gender" value="other"
                                        <?= (isset($user['gender']) && $user['gender'] === 'other') ? 'checked' : '' ?> />
                                    Khác</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ĐỊA CHỈ -->
                <div class="profile__section">
                    <h2 class="profile__title">Địa chỉ</h2>
                    <div class="profile__row">
                        <label for="province_city">Tỉnh/Thành phố</label>
                        <select id="province_city" name="province_city" required>
                            <option value="">Chọn tỉnh/thành phố</option>
                            <option value="HCM"
                                <?= ($user['address']['province_city'] ?? '') === 'HCM' ? 'selected' : '' ?>>TP Hồ Chí
                                Minh
                            </option>
                            <option value="HN"
                                <?= ($user['address']['province_city'] ?? '') === 'HN' ? 'selected' : '' ?>>
                                Hà Nội</option>
                        </select>
                    </div>
                    <div class="profile__row">
                        <label for="district">Quận/Huyện</label>
                        <select id="district" name="district" required>
                            <option value="">Chọn quận/huyện</option>
                            <option value="cu_chi"
                                <?= ($user['address']['district'] ?? '') === 'cu_chi' ? 'selected' : '' ?>>Huyện Củ Chi
                            </option>
                            <option value="quan_1"
                                <?= ($user['address']['district'] ?? '') === 'quan_1' ? 'selected' : '' ?>>Quận 1
                            </option>
                        </select>
                    </div>
                    <div class="profile__row">
                        <label for="ward_commune">Phường/Xã</label>
                        <select id="ward_commune" name="ward_commune" required>
                            <option value="">Chọn phường/xã</option>
                            <option value="tan_phu_trung"
                                <?= ($user['address']['ward_commune'] ?? '') === 'tan_phu_trung' ? 'selected' : '' ?>>Xã
                                Tân
                                Phú Trung</option>
                            <option value="phuong_1"
                                <?= ($user['address']['ward_commune'] ?? '') === 'phuong_1' ? 'selected' : '' ?>>Phường
                                1
                            </option>
                        </select>
                    </div>
                    <div class="profile__row">
                        <label for="address">Địa chỉ chi tiết</label>
                        <input type="text" id="address" name="address"
                            value="<?= htmlspecialchars($user['address']['address'] ?? '') ?>" />
                    </div>
                    <button type="submit" class="profile__btn">Lưu</button>
                </div>
            </form>

            <?php if (isset($success)): ?>
            <p class="profile__message profile__message--success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <?php if (isset($error)): ?>
            <p class="profile__message profile__message--error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const editBtn = document.getElementById('edit-avatar-btn');
const avatarForm = document.getElementById('avatar-form');

editBtn.addEventListener('click', () => {
    avatarForm.style.display = 'block';
});
</script>

<?php View::endSection(); ?>