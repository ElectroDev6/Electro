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
    <title>Quản lý danh mục - Admin</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
<!-- <?php  
    echo '<pre>';
    print_r($categories);
    echo '</pre>';
    ?> -->
    <?php echo $htmlHeader; ?>
    <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
    <div class="notification notification--success show" id="success-notification">
        <p id="success-message"><?= htmlspecialchars($_GET['success']) ?></p>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
    <div class="notification notification--error" id="error-notification">
        <p id="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <?php if (!empty($_GET['deleted'])): ?>
            <div class="category-list__alert category-list__alert--success">
                Danh mục đã được xóa thành công
            </div>
        <?php endif; ?>
        <div class="categories">
            <!-- Header -->
            <header class="categories__header">
                <h1 class="categories__title">Quản lý danh mục</h1>
                <a href="/admin/categories/create" class="product-page__add-btn">+ Add new</a>
            </header>
            <?php
            $totalCategories = count($categories);
            $totalActive = 0;
            $totalProducts = 0;
            ?>

            <!-- Stats -->
            <section class="categories__stats">
                <div class="categories__stats-card">
                    <p class="categories__stats-number"><?php echo $totalCategories; ?></p>
                    <p class="categories__stats-label">Tổng danh mục</p>
                </div>
                <div class="categories__stats-card">
                    <p class="categories__stats-number"><?php echo $totalActive; ?></p>
                    <p class="categories__stats-label">Đang hoạt động</p>
                </div>
                <div class="categories__stats-card">
                    <p class="categories__stats-number"><?php echo number_format($totalProducts); ?></p>
                    <p class="categories__stats-label">Sản phẩm</p>
                </div>
                <div class="categories__stats-card">
                    <p class="categories__stats-number">100%</p>
                    <p class="categories__stats-label">Tỷ lệ hiển thị</p>
                </div>
            </section>

            <!-- Categories Grid -->
            <section class="categories__grid">
                <?php foreach ($categories as $category): ?>
                    <article class="categories__card">
                        <img src="<?php echo $category['image']; ?>" 
                             alt="Ảnh danh mục" class="categories__card-image">
                        <div class="categories__card-content">
                            <div class="categories__card-header">
                                <h3 class="categories__card-title"><?php echo $category['name']; ?></h3>
                                <span class="categories__card-id">#<?php echo $category['category_id']; ?></span>
                            </div>
                            <div class="categories__card-meta">
                                <div class="categories__card-actions">
                                    <a href="/admin/categories/detail?id=<?php echo $category['category_id']; ?>" class="categories__action-btn categories__action-btn--view">Xem</a>
                            <form method="POST" action="/admin/categories/delete" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này không không?');" style="display: inline">
                                <input type="hidden" name="id" value="<?php echo $category['category_id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $category['name']; ?>">
                                <button class="categories__action-btn categories__action-btn--delete"
                                            onclick="confirmDelete(<?= $category['category_id'] ?>, '<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>')">
                                        Xoá
                                </button>
                            </form>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </div>
    </main>
</body>
</html>
