<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
</head>

<body>
    <?php Core\View::partial('partials.header'); ?>
    <main class="error-404" style="min-height: 80vh; display: flex; justify-content: center; align-items: center;">
        <section style="text-align:center; padding: 3rem 1rem; display: flex; flex-direction: column; gap: 1rem;">
            <h1 style="font-size: 3rem; color: #e74c3c;">404</h1>
            <p style="font-size: 1.5rem;">Trang bạn tìm kiếm không tồn tại.</p>
            <a href="/" style="color: #3498db; text-decoration: underline;">Quay về trang chủ</a>
        </section>
    </main>

    <?php Core\View::partial('partials.footer'); ?>
</body>

</html>