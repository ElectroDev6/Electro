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
        
        <?php if (!empty($errors)): ?>
            <div class="category-detail__alert category-detail__alert--danger">
                <ul class="category-detail__alert-list">
                    <?php foreach ($errors as $err): ?>
                        <li class="category-detail__alert-item"><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="category-detail__alert category-detail__alert--danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="category-detail__alert category-detail__alert--success">
                Đã xoá danh mục thành công.
            </div>
        <?php endif; ?>
        
        <div class="category-detail__container">
            <div id="edit-form-container" class="category-detail__form-container">
                <div class="category-detail__form">
                    <h3 class="category-detail__heading">Tạo mới danh mục</h3>
                    <form action="/admin/categories/handleCreate" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <!-- BỎ input hidden id vì đây là tạo mới -->
                        
                        <label class="category-detail__form-label" for="name">Tên danh mục:</label>
                        <input class="category-detail__form-input" name="name" id="name" 
                               value="<?= isset($name) ? htmlspecialchars($name) : '' ?>">

                        <label class="category-detail__form-label" for="image">Hình ảnh:</label>
                        <input class="category-detail__form-input" type="file" name="image" id="image" accept="image/*">
                        <small class="category-detail__note">
                            Chỉ chấp nhận file ảnh (JPG, PNG, GIF). Tối đa 2MB.
                        </small>

                        <label class="category-detail__form-label" for="content_html">Mô tả:</label>
                        <textarea class="category-detail__form-textarea" name="content_html" id="content_html" rows="4" 
                                  placeholder="Nhập mô tả cho danh mục..."><?= isset($content_html) ? htmlspecialchars($content_html) : '' ?></textarea>

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