<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php Core\View::yield('page_title', 'My Awesome Website'); ?></title>
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
    <?php Core\View::yield('page_styles'); ?>
    <link rel="stylesheet" href="<?= asset("css/{$pageName}.css") ?>">
    <?php
    ?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?= asset("img/favicon/apple-icon-57x57.png") ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= asset("img/favicon/apple-icon-60x60.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= asset("img/favicon/apple-icon-72x72.png") ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= asset("img/favicon/apple-icon-76x76.png") ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= asset("img/favicon/apple-icon-114x114.png") ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= asset("img/favicon/apple-icon-120x120.png") ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= asset("img/favicon/apple-icon-144x144.png") ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= asset("img/favicon/apple-icon-152x152.png") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset("img/favicon/apple-icon-180x180.png") ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= asset("img/favicon/android-icon-192x192.png") ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset("img/favicon/favicon-32x32.png") ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= asset("img/favicon/favicon-96x96.png") ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset("img/favicon/favicon-16x16.png") ?>">
    <link rel="manifest" href="<?= asset("img/favicon/manifest.json") ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= asset("img/favicon/ms-icon-144x144.png") ?>">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <?php Core\View::partial('partials.header'); ?>

    <main>
        <?php Core\View::yield('content'); ?>
    </main>

    <?php Core\View::partial('partials.footer'); ?>
</body>
<?php Core\View::yield('page_styles'); ?>
<script type="module" src="<?= asset("js/{$pageName}.js") ?>"></script>
<script type="module" src="<?= asset("js/main.js") ?>"></script>
<?php
?>

</html>