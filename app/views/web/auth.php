<?php
use Core\View;
?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<main class="auth">
    <section class="auth__wrapper">

        <!-- Login Form -->
        <form method="POST" action="/handle-auth" class="auth__form auth__form--login">
            <input type="hidden" name="action" value="login">
            <h2 class="auth__title">Đăng nhập</h2>
            <p class="auth__subtitle">Chào mừng bạn đã trở lại.</p>

            <?php if (!empty($error) && isset($formType) && $formType === 'login'): ?>
            <p class="auth__error" style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <input name="username" type="text" placeholder="Tên đăng nhập" class="auth__input"
                value="<?= isset($old['username']) ? htmlspecialchars($old['username']) : '' ?>" required />
            <input name="password" type="password" placeholder="Mật khẩu" class="auth__input" required />

            <div class="auth__options">
                <label>
                    <input type="checkbox" name="remember" <?= !empty($old['remember']) ? 'checked' : '' ?> />
                    Nhớ mật khẩu (lưu 1 giờ)
                </label>
                <a href="/forgot-password" class="auth__link">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="auth__btn">Đăng nhập</button>
        </form>

        <div class="auth__divider"><span>Hoặc</span></div>

        <!-- Register Form -->
        <form method="POST" action="/handle-auth" class="auth__form auth__form--register">
            <input type="hidden" name="action" value="register">
            <h2 class="auth__title">Đăng ký</h2>
            <p class="auth__subtitle">Tạo tài khoản mới để có trải nghiệm tốt nhất.</p>

            <?php if (!empty($error) && isset($formType) && $formType === 'register'): ?>
            <p class="auth__error" style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <input name="reg_username" type="text" placeholder="Tên đăng ký" class="auth__input"
                value="<?= isset($old['reg_username']) ? htmlspecialchars($old['reg_username']) : '' ?>" required />
            <input name="reg_phone" type="text" placeholder="Số điện thoại" class="auth__input"
                value="<?= isset($old['reg_phone']) ? htmlspecialchars($old['reg_phone']) : '' ?>" required
                maxlength="11" />
            <input name="reg_password" type="password" placeholder="Mật khẩu" class="auth__input" required />
            <input name="reg_repassword" type="password" placeholder="Nhập lại mật khẩu" class="auth__input" required />

            <label class="auth__agree">
                <input type="checkbox" required /> Tôi đồng ý với các <a href="#">điều khoản</a>.
            </label>
            <button type="submit" class="auth__btn">Đăng ký</button>
        </form>

        <!-- Popup thành công đăng kí -->
        <?php if (isset($success) && $formType === 'register'): ?>
        <div id="registerSuccessPopup" class="popup"
            style="display: block; position: fixed; top: 50%; left: 50%; 
               transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000; border-radius: 8px;">
            <p><?= htmlspecialchars($success) ?></p>
            <button onclick="closeRegisterPopup()" class="auth__btn">
                Đóng và tiếp tục Đăng nhập
            </button>
        </div>
        <div class="popup-overlay" style="display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
             background: rgba(0,0,0,0.5); z-index: 999;"></div>

        <script>
        function closeRegisterPopup() {
            document.getElementById('registerSuccessPopup').style.display = 'none';
            document.querySelector('.popup-overlay').style.display = 'none';
            // Chuyển sang trang đăng nhập
            window.location.href = '/login';
        }
        </script>
        <?php endif; ?>



    </section>

</main>

<?php View::endSection(); ?>