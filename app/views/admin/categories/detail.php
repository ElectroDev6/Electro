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
    <title>Chi tiết danh mục - <?php echo htmlspecialchars($category['name']); ?></title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <!-- <?php
        echo '<pre>';
        print_r($category);
        echo '</pre>';
        // exit;
        ?> -->
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="category-detail">
            <?php if (!empty($success)): ?>
            <div class="category-detail__alert category-detail__alert--success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
            <div class="category-detail__container">
                <!-- Header -->
                <div class="category-detail__header">
                    <div class="category-detail__breadcrumb">
                        <a href="/admin" class="category-detail__breadcrumb-link">Trang chủ</a>
                        <span class="category-detail__breadcrumb-separator">/</span>
                        <a href="/admin/categories" class="category-detail__breadcrumb-link">Danh mục</a>
                        <span class="category-detail__breadcrumb-separator">/</span>
                        <span class="category-detail__breadcrumb-current">Chi tiết danh mục</span>
                    </div>
                    <h1 class="category-detail__page-title">Chi tiết danh mục</h1>
                </div>

                <!-- Category Info Card -->
                <div class="category-detail__card" id="category-detail-card">
                    <div class="category-detail__card-header">
                        <h2 class="category-detail__card-title">Thông tin danh mục</h2>
                        <div class="category-detail__actions">
                            <a href="/admin/categories/update?id=<?= $category['category_id'] ?>" class="category-detail__btn category-detail__btn--edit">Chỉnh sửa
                            </a>
                            <form 
                                method="POST" 
                                action="/admin/categories/delete" 
                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục <?= htmlspecialchars($category['name']) ?> không?');"
                                style="display: inline"
                            >
                                <input type="hidden" name="id" value="<?= $category['category_id'] ?>">
                                <input type="hidden" name="name" value="<?= $category['name'] ?>">
                                <button type="submit" class="category-detail__btn category-detail__btn--delete">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="category-detail__card-body">
                        <div class="category-detail__info-grid">
                            <!-- Category Image & Icon -->
                            <div class="category-detail__image-section">
                                <div class="category-detail__image-container">
                                    <img src="<?php echo htmlspecialchars($category['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($category['name']); ?>" 
                                         class="category-detail__image">
                                </div>
                            </div>
                            <!-- Category Details -->
                            <div class="category-detail__details">
                                <div class="category-detail__field">
                                    <label class="category-detail__label">ID danh mục:</label>
                                    <span class="category-detail__value category-detail__value--id">#<?php echo $category['category_id']; ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Tên danh mục:</label>
                                    <span class="category-detail__value"><?php echo htmlspecialchars($category['name']); ?></span>
                                </div>
                                <div class="category-detail__field">
                                    <label class="category-detail__label">Mô tả:</label>
                                    <span class="category-detail__value"><?php echo $category['description']; ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Ngày tạo:</label>
                                    <span class="category-detail__value"><?php echo date('d/m/Y H:i', strtotime($category['created_at'])); ?></span>
                                </div>
                                <div class="category-detail__field">
                                    <label class="category-detail__label">Cập nhật lần cuối:</label>
                                    <span class="category-detail__value"><?php echo date('d/m/Y H:i', strtotime($category['updated_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>