<?php
namespace App\Views;
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chỉnh sửa danh mục</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>

<?php echo $htmlHeader; ?>
<main class="wrapper">
  <?php echo $contentSidebar; ?>
  <div class="category-detail">
    <div id="edit-form-container" class="category-detail__form-container active">
      <?php if (!empty($errors)): ?>
        <div class="category-detail__alert category-detail__alert--danger">
          <ul class="category-detail__alert-list">
            <?php foreach ($errors as $err): ?>
              <li class="category-detail__alert-item"><?php echo htmlspecialchars($err); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php elseif (!empty($error)): ?>
        <div class="category-detail__alert category-detail__alert--danger">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      <div class="category-detail__form">
        <h3 class="category-detail__heading">Chỉnh sửa danh mục</h3>
    <form action="/admin/categories/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="category_id" value="<?= $category['category_id'] ?? '' ?>">
        <?php if (!empty($success)): ?>
          <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <label for="name" class="category-detail__form-label">Tên danh mục:</label>
        <input type="text" name="name" class="category-detail__form-input" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>

        <label for="image" class="category-detail__form-label">Hình ảnh:</label>

        <?php if (!empty($category['image'])): ?>
          <div style="margin-bottom: 10px;">
            <img src="<?= $category['image'] ?>" alt="Ảnh hiện tại" style="max-height: 100px;">
          </div>
        <?php endif; ?>

        <input type="file" name="image" id="image" class="category-detail__form-input" accept="image/*">
        <p class="category-detail__note">Chỉ chấp nhận file ảnh (JPG, PNG, GIF). Tối đa 2MB.</p>

        <label for="description" class="category-detail__form-label">Mô tả:</label>
        <textarea name="description" class="category-detail__form-textarea" required><?= htmlspecialchars($category['description'] ?? '') ?></textarea>

        <div style="margin-top: 20px; display: flex; align-items: center">
            <button type="submit" class="category-detail__btn category-detail__btn--save">
                Lưu thay đổi
            </button>
            <a href="/admin/categories" class="category-detail__btn category-detail__btn--cancel">
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
