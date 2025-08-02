<?php use Core\View; ?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<main class="auth">
    <section class="auth__wrapper">

        <!-- Login Form -->
        <form method="POST" action="/handle-auth" class="auth__form auth__form--login">
            <input type="hidden" name="action" value="login">
            <h2 class="auth__title">Đăng nhập</h2>
            <p class="auth__subtitle">Chào mừng bạn đã trở lại.</p>

            <?php if (!empty($error) && isset($_POST['action']) && $_POST['action'] === 'login') : ?>
            <p class="auth__error" style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <input name="username" type="text" placeholder="Tên đăng nhập" class="auth__input" required />
            <input name="password" type="password" placeholder="Mật khẩu" class="auth__input" required />

            <div class="auth__options">
                <label><input type="checkbox" /> Nhớ mật khẩu </label>
                <a href="#" class="auth__link">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="auth__btn">Đăng nhập</button>
        </form>

        <div class="auth__divider">
            <span class="auth-span">Hoặc</span>
        </div>

        <!-- Register Form -->
        <form method="POST" action="/handle-auth" class="auth__form auth__form--register">
            <input type="hidden" name="action" value="register">
            <h2 class="auth__title">Đăng ký</h2>
            <p class="auth__subtitle">Tạo tài khoản mới để có trải nghiệm tốt nhất.</p>

            <?php if (!empty($error) && isset($_POST['action']) && $_POST['action'] === 'register') : ?>
            <p class="auth__error" style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <input name="reg_username" type="text" placeholder="Tên đăng ký" class="auth__input" required />
            <input name="reg_phone" type="text" placeholder="Số điện thoại" class="auth__input" required />
            <input name="reg_password" type="password" placeholder="Mật khẩu" class="auth__input" required />
            <input name="reg_repassword" type="password" placeholder="Nhập lại mật khẩu" class="auth__input" required />

            <label class="auth__agree">
                <input type="checkbox" required /> Tôi đồng ý với các <a href="#">điều khoản</a>.
            </label>
            <button type="submit" class="auth__btn">Đăng ký</button>
        </form>

    </section>
</main>

<?php View::endSection(); ?>