<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS chung -->
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
    <!-- CSS riêng cho từng trang -->
    <?php if (isset($pageName)): ?>
        <link rel="stylesheet" href="<?= asset("css/{$pageName}.css") ?>">
    <?php endif; ?>
</head>

<body>
    <header>
        <h1>Welcome to My Website</h1>
        <nav>
            <a href="/">Home</a>
            <a href="/about">About</a>
        </nav>
    </header>