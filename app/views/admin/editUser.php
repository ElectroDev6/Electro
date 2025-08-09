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
<form action="/admin/users/update" method="POST" class="user-edit-form">
    <h2>Cập nhật người dùng</h2>

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <label for="username">Username</label>
    <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required>

    <label for="full_name">Họ và tên</label>
    <input type="text" id="full_name" name="full_name" value="<?= $user['full_name'] ?>" required>

    <label for="phone">Số điện thoại</label>
    <input type="text" id="phone" name="phone" value="<?= $user['phone'] ?>">

    <label for="sex">Giới tính</label>
    <select id="sex" name="sex">
        <option value="male" <?= $user['sex'] === 'male' ? 'selected' : '' ?>>Nam</option>
        <option value="female" <?= $user['sex'] === 'female' ? 'selected' : '' ?>>Nữ</option>
        <option value="other" <?= $user['sex'] === 'other' ? 'selected' : '' ?>>Khác</option>
    </select>

    <label for="role">Vai trò</label>
    <select id="role" name="role">
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Người dùng</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
    </select>

    <label for="password">Mật khẩu mới (nếu thay đổi)</label>
    <input type="password" id="password" name="password" placeholder="Để trống nếu không đổi">

    <label for="created_at">Ngày tạo</label>
    <input type="text" id="created_at" name="created_at" value="<?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>" readonly>

    <button type="submit">Cập nhật</button>
</form>

    </main>
</body>
</html>