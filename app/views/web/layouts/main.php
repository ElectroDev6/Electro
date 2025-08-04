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
<?php
?>

</html>