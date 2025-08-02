<?php

use Core\View;

/** @var array $user */
?>

<?php View::extend('layouts.main'); ?>

<?php View::section('content'); ?>
<div class="profile">
    <div class="profile__sidebar">
        <div class="profile__avatar">
            <img src="<?= $user['avatar'] ?>" alt="Avatar người dùng" />
            <h3 class="profile__name"><?= $user['name'] ?></h3>
            <p class="profile__phone"><?= $user['phone'] ?></p>
        </div>
        <ul class="profile__menu">
            <li>Đơn hàng của tôi</li>
            <li>Thông tin bảo hành</li>
            <li>Địa chỉ nhận hàng</li>
            <li>Lịch sử mua hàng</li>
            <li>Đăng xuất</li>
        </ul>
    </div>

    <div class="profile__content">
        <!-- Hồ sơ -->
        <div class="profile__section">
            <h2 class="profile__title">Hồ sơ của tôi</h2>
            <form class="profile__form">
                <div class="profile__row">
                    <label>Họ và tên</label>
                    <input type="text" value="<?= $user['name'] ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row">
                    <label>Số điện thoại</label>
                    <input type="text" value="<?= substr($user['phone'], 0, 6) . '*****' ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row">
                    <label>Email</label>
                    <input type="email" value="<?= substr($user['email'], 0, 7) . '*****' ?>" disabled />
                    <a href="#">Sửa</a>
                </div>
                <div class="profile__row--group">
                    <div class="profile__row">
                        <label>Ngày sinh</label>
                        <div class="profile__dob">
                            <select>
                                <option selected><?= $user['dob']['day'] ?></option>
                            </select>
                            <select>
                                <option selected><?= $user['dob']['month'] ?></option>
                            </select>
                            <select>
                                <option selected><?= $user['dob']['year'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="profile__group">
                        <label>Giới tính</label>
                        <div class="profile__gender">
                            <label><input type="radio" name="gender"
                                    <?= $user['gender'] === 'Nam' ? 'checked' : '' ?> /> Nam</label>
                            <label><input type="radio" name="gender" <?= $user['gender'] === 'Nữ' ? 'checked' : '' ?> />
                                Nữ</label>
                            <label><input type="radio" name="gender"
                                    <?= $user['gender'] === 'Khác' ? 'checked' : '' ?> /> Khác</label>
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
                            <option selected><?= $user['address']['city'] ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Quận/Huyện</label>
                        <select>
                            <option selected><?= $user['address']['district'] ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Phường/Xã</label>
                        <select>
                            <option selected><?= $user['address']['ward'] ?></option>
                        </select>
                    </div>

                    <div class="profile__row">
                        <label>Địa chỉ</label>
                        <input type="text" value="<?= $user['address']['street'] ?>" />
                    </div>
                    <button class="profile__btn">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php View::endSection(); ?>