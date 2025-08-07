<?php
namespace App\Views;
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/sidebar.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo mới danh mục</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="category-detail__container">
            <?php if (!empty($error)): ?>
                <div class="category-detail__alert category-detail__alert--danger">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endif; ?>
            <div id="edit-form-container" class="category-detail__form-container">
                <div class="category-detail__form">
                    <h3 class="category-detail__heading">Tạo mới danh mục</h3>
                    <form action="/admin/categories/handleCreate" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <label class="category-detail__form-label" for="name">Tên danh mục:</label>
                        <input class="category-detail__form-input" name="name" id="name" 
                            value="<?= htmlspecialchars($name ?? '') ?>" 
                            maxlength="255">
                        <?php if (isset($errors['name'])): ?>
                            <span class="category-detail--error"><?= htmlspecialchars($errors['name']) ?></span>
                        <?php endif; ?>

                        <label class="category-detail__form-label" for="image">Hình ảnh:</label>
                        <input class="category-detail__form-input" type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif, image/webp">
                        <small class="category-detail__note">
                            Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WEBP). Tối đa 2MB.
                        </small>
                        <?php if (isset($error) && strpos($error, 'image') !== false): ?>
                            <span class="category-detail--error"><?= htmlspecialchars($error) ?></span>
                        <?php endif; ?>

                        <label class="category-detail__form-label" for="description">Mô tả:</label>
                        <textarea class="category-detail__form-textarea" name="description" id="description" rows="4" 
                            placeholder="Nhập mô tả cho danh mục..." maxlength="1000"><?= htmlspecialchars($description ?? '') ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <span class="category-detail--error"><?= htmlspecialchars($errors['description']) ?></span>
                        <?php endif; ?>
                        <label class="category-detail__form-label" for="slug">Slug:</label>
                        <input class="category-detail__form-textarea" name="slug" id="slug"
                            placeholder="Nhập slug cho danh mục..." 
                            value="<?= htmlspecialchars($slug ?? '') ?>" 
                            maxlength="255" title="Chỉ bao gồm chữ thường, số và dấu gạch ngang">
                            <?php if (isset($errors['slug'])): ?>
                                <span class="category-detail--error"><?= htmlspecialchars($errors['slug']) ?></span>
                            <?php endif; ?>
                        <div style="margin-top: 20px; display: flex; align-items: center">
                            <button type="submit" class="category-detail__btn category-detail__btn--save">Thêm mới</button>
                            <a href="/admin/categories" type="button" class="category-detail__btn category-detail__btn--cancel">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="/admin-ui/js/pages/category-detail.js"></script>
</body>
</html>