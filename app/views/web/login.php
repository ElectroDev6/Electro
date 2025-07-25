<?php

use Core\View; ?>

<?php View::extend('layouts.main'); ?>

<?php View::section('content'); ?>

<body>
    <main class="auth">
        <section class="auth__wrapper">
            <div class="auth__form auth__form--login">
                <h2 class="auth__title">Đăng nhập</h2>
                <p class="auth__subtitle">Chào mừng bạn đã trở lại.</p>
                <input type="text" placeholder="Tên đăng nhập" class="auth__input" />
                <input type="password" placeholder="Mật khẩu" class="auth__input" />
                <div class="auth__options">
                    <label><input type="checkbox" /> Remember Me</label>
                    <a href="#" class="auth__link">Forgot Password?</a>
                </div>
                <button class="auth__btn">Gửi</button>
                <div class="auth__social">
                    <p>Hoặc</p>
                    <div class="auth__icons">
                        <img src="https://img.icons8.com/?size=100&id=17949&format=png&color=000000" alt="Google" />
                        <img src="https://img.icons8.com/?size=100&id=118497&format=png&color=000000" alt="Facebook" />
                        <img src="https://img.icons8.com/?size=100&id=30659&format=png&color=000000" alt="Apple" />
                    </div>
                </div>
            </div>
            <div class="auth__divider">
                <span class="auth-span">HOẶC</span>
            </div>
            <div class="auth__form auth__form--register">
                <h2 class="auth__title">Đăng kí</h2>
                <p class="auth__subtitle">Tạo tài khoản mới để có trải nghiệm tốt nhất.</p>
                <input type="text" placeholder="Tên đăng nhập" class="auth__input" />
                <input type="text" placeholder="Số điện thoại" class="auth__input" />
                <input type="password" placeholder="Mật khẩu" class="auth__input" />
                <input type="password" placeholder="Nhập lại mật khẩu" class="auth__input" />
                <label class="auth__agree">
                    <input type="checkbox" /> Tôi đồng ý với các <a href="#">điều khoản</a>.
                </label>
                <button class="auth__btn">Gửi</button>
            </div>
        </section>
    </main>
</body>

<?php View::endSection(); ?>