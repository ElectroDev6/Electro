<?php
use Core\View;
?>

<?php View::extend('layouts.main'); ?>
<?php View::section('content'); ?>

<main class="auth">
    <section class="auth__wrapper">

        <form method="POST" action="/handle-forgot-password" class="auth__form">
            <h2 class="auth__form-title"><strong>Nhập email để lấy mật khẩu</strong></h2>

            <?php if (!empty($error)): ?>
            <p class="auth__form-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
            <p class="auth__form-success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <input name="email" type="email" placeholder="Email của bạn" class="auth__form-input" required />
            <button type="submit" class="auth__form-btn">Gửi</button>
        </form>

    </section>
</main>

<?php View::endSection(); ?>