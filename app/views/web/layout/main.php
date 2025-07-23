<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php yieldSection('page_title', 'My Awesome Website'); ?></title>
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
    <?php yieldSection('page_styles'); ?>
    <link rel="stylesheet" href="<?= asset("css/{$pageName}.css") ?>">
    <?php
    ?>
</head>

<body>
    <?php partial('partials.header'); ?>

    <?php yieldSection('hero_section'); // Section cho slider/hero image 
    ?>

    <div class="container-main">
        <main>
            <?php yieldSection('content'); // Nội dung chính của trang 
            ?>
        </main>
    </div>

    <?php partial('partials.footer'); // Include footer partial 
    ?>