<?php

use Core\View; ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('content'); ?>
<div class="profile">
    <div class="profile__sidebar">
        <div class="profile__avatar">
            <img src="<?= htmlspecialchars($user['avatar_url'] ?? '/img/default-avatar.jpg') ?>" alt="Avatar người dùng" />
            <h3 class="profile__name"><?= htmlspecialchars($user['name'] ?? 'Người dùng') ?></h3>
            <p class="profile__phone"><?= htmlspecialchars($user['phone_number'] ?? '') ?></p>
        </div>
        <ul class="profile__menu">
            <li><a href="#">Tổng quan</a></li>User avatar
            <li><a href="#">Đơn hàng của tôi</a></li>
            <li><a href="#">Thông tin bảo hành</a></li>
            <li><a href="#">Địa chỉ nhận hàng</a></li>
            <li><a href="#">Sản phẩm yêu thích</a></li>
            <li><a href="/history">Lịch sử mua hàng</a></li>
            <li><a href="/logout">Đăng xuất</a></li>
        </ul>
    </div>

    <div class="profile__content">
        <!-- Hồ sơ -->
        <div class="profile__section">
            <h2 class="profile__title">Hồ sơ của tôi</h2>
            <form class="profile__form">
                <div class="profile__row">
                    <label>Họ và tên</label>
                    <input type="text" value="<?= htmlspecialchars($user['name'] ?? '') ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row">
                    <label>Số điện thoại</label>
                    <input type="text" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row">
                    <label>Email</label>
                    <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row--group">
                    <div class="profile__row">
                        <label>Ngày sinh</label>
                        <div class="profile__dob">
                            <select>
                                <option>Ngày</option>
                                <!-- TODO: Populate with dynamic date -->
                            </select>
                            <select>
                                <option>Tháng</option>
                                <!-- TODO: Populate with dynamic month -->
                            </select>
                            <select>
                                <option>Năm</option>
                                <!-- TODO: Populate with dynamic year -->
                            </select>
                        </div>
                    </div>
                    <div class="profile__group">
                        <label>Giới tính</label>
                        <div class="profile__gender">
                            <label><input type="radio" name="gender" <?= isset($user['gender']) && $user['gender'] === 'male' ? 'checked' : '' ?> /> Nam</label>
                            <label><input type="radio" name="gender" <?= isset($user['gender']) && $user['gender'] === 'female' ? 'checked' : '' ?> /> Nữ</label>
                            <label><input type="radio" name="gender" <?= isset($user['gender']) && $user['gender'] === 'other' ? 'checked' : '' ?> /> Khác</label>
                        </div>
                    </div>
                </div>
                <button class="profile__btn">Lưu</button>
            </form>
        </div>

        <!-- Địa chỉ -->
        <div class="profile__section">
            <h2 class="profile__title">Địa chỉ</h2>
            <form class="profile__form">
                <div class="profile__row--group">
                    <div class="profile__row">
                        <label>Tỉnh/Thành phố</label>
                        <select>
                            <option><?= htmlspecialchars($user['address']['province_city'] ?? 'TP Hồ Chí Minh') ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Quận/Huyện</label>
                        <select>
                            <option><?= htmlspecialchars($user['address']['district'] ?? 'Huyện Củ Chi') ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Phường/Xã</label>
                        <select>
                            <option><?= htmlspecialchars($user['address']['ward_commune'] ?? 'Xã Tân Phú Trung') ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Địa chỉ</label>
                        <input type="text" value="<?= htmlspecialchars($user['address']['address_line1'] ?? 'Số 2.4, ABC') ?>" />
                    </div>
                    <button class="profile__btn">Lưu</button>
            </form>
        </div>
    </div>
</div>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php View::endSection(); ?>