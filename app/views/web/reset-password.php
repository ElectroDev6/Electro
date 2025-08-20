<?php
use Core\View;
View::extend('layouts.main');
View::section('content');

$token = $token ?? '';
?>

<main class="auth">
    <section class="auth__wrapper">
        <form method="POST" action="/handle-reset-password" class="auth__form">
            <h2 class="auth__title">Đặt lại mật khẩu</h2>

            <?php if (!empty($error)): ?>
            <p class="auth__error" style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
            <input name="password" type="password" placeholder="Mật khẩu mới" class="auth__input" required />
            <input name="re_password" type="password" placeholder="Nhập lại mật khẩu mới" class="auth__input" required />

            <button type="submit" class="auth__btn">Đặt lại mật khẩu</button>
        </form>
    </section>
</main>

<?php View::endSection(); ?>
