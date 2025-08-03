<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electro Header</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
    <form action="/admin/users/addUser" method="POST" class="add-user__form">
        <input type="text" name="add-user__username" placeholder="Tên đăng nhập" required>
        <input type="email" name="add-user__email" placeholder="Email" required>
        <input type="text" name="add-user__full_name" placeholder="Họ tên" required>
        <input type="tel" name="add-user__phone" placeholder="Số điện thoại">

        <select name="add-user__role">
            <option value="1">User</option>
            <option value="0">Admin</option>
            <option value="2">Khách</option>
        </select>

        <select name="add-user__sex">
            <option value="male">Nam</option>
            <option value="female">Nữ</option>
            <option value="other">Khác</option>
        </select>

        <input type="password" name="add-user__password" placeholder="Mật khẩu" required>
        <button type="submit" class="add-user__submit">Thêm người dùng</button>
    </form>

    </main>
</body>
</html>