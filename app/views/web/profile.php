<?php

use Core\View; ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('content'); ?>
<div class="profile">
    <div class="profile__sidebar">
        <div class="profile__avatar">
            <img src="<?= htmlspecialchars($user['avatar_url'] ?? '/img/default-avatar.jpg') ?>"
                alt="Avatar người dùng" />
            <h3 class="profile__name"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h3>
            <p class="profile__phone"><?= htmlspecialchars($user['phone_number'] ?? '') ?></p>
        </div>
        <ul class="profile__menu">
            <li><a href="#">Tổng quan</a></li>
            <li><a href="/history">Đơn hàng của tôi</a></li>
            <li><a href="#">Sản phẩm yêu thích</a></li>
            <li><a href="/history">Lịch sử mua hàng</a></li>
            <li><a href="/logout">Đăng xuất</a></li>
        </ul>
    </div>

    <div class="profile__content">
        <!-- Form gộp Hồ sơ và Địa chỉ -->
        <form method="POST" action="/profile/save" class="profile__form">

            <!-- Hồ sơ -->
            <div class="profile__section">
                <h2 class="profile__title">Hồ sơ của tôi</h2>

                <div class="profile__row">
                    <label>Họ và tên</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required />
                </div>

                <div class="profile__row">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>"
                        required />
                </div>

                <div class="profile__row">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required />
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
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="dob_month" required>
                                <option value="">Tháng</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>"
                                        <?= (isset($user['dob_month']) && $user['dob_month'] == $i) ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <select name="dob_year" required>
                                <option value="">Năm</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 100; $i--): ?>
                                    <option value="<?= $i ?>"
                                        <?= (isset($user['dob_year']) && $user['dob_year'] == $i) ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
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

            <!-- Địa chỉ -->
            <div class="profile__section">
                <h2 class="profile__title">Địa chỉ</h2>

                <div class="profile__row">
                    <label for="province_city">Tỉnh/Thành phố</label>
                    <select id="province_city" name="province_city" required>
                        <option value="">Chọn tỉnh/thành phố</option>
                        <option value="HCM"
                            <?= ($user['address']['province_city'] ?? '') === 'HCM' ? 'selected' : '' ?>>TP Hồ Chí Minh
                        </option>
                        <option value="HN" <?= ($user['address']['province_city'] ?? '') === 'HN' ? 'selected' : '' ?>>
                            Hà Nội</option>
                        <!-- Thêm các tỉnh khác -->
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
                            <?= ($user['address']['district'] ?? '') === 'quan_1' ? 'selected' : '' ?>>Quận 1</option>
                        <!-- Thêm các quận/huyện -->
                    </select>
                </div>

                <div class="profile__row">
                    <label for="ward_commune">Phường/Xã</label>
                    <select id="ward_commune" name="ward_commune" required>
                        <option value="">Chọn phường/xã</option>
                        <option value="tan_phu_trung"
                            <?= ($user['address']['ward_commune'] ?? '') === 'tan_phu_trung' ? 'selected' : '' ?>>Xã Tân
                            Phú Trung</option>
                        <option value="phuong_1"
                            <?= ($user['address']['ward_commune'] ?? '') === 'phuong_1' ? 'selected' : '' ?>>Phường 1
                        </option>
                        <!-- Thêm phường/xã -->
                    </select>
                </div>

                <div class="profile__row">
                    <label for="address_line1">Địa chỉ chi tiết</label>
                    <input type="text" id="address_line1" name="address_line1"
                        value="<?= htmlspecialchars($user['address']['address_line1'] ?? '') ?>" />
                </div>
                <button type="submit" class="profile__btn">Lưu</button>
            </div>


        </form>
    </div>
</div>

<?php if (isset($success)): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php View::endSection(); ?>