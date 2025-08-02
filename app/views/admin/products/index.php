<?php
include dirname(__DIR__) . '/partials/sidebar.php';
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/pagination.php';
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
    <!-- <?php
        echo '<pre>';
        print_r($categories);
        echo '</pre>';
    ?> -->
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="product-page" data-target="pagination-container">
            <!-- Header Section -->
            <div class="product-page__header">
                <h1 class="product-page__title">Trang sản phẩm</h1>
                <a href="/admin/products/create" class="product-page__add-btn"> + Add new</a>
            </div>
            <!-- Filter Section -->
            <div class="product-filter">
                <div class="product-filter__group">
                    <label class="product-filter__label">Tên sản phẩm</label>
                    <input id="searchProduct" type="text" class="product-filter__input" placeholder="Tìm kiếm sản phẩm...">
                </div>
                
                <div class="product-filter__group">
                    <label class="product-filter__label">Danh mục</label>
                    <select class="product-filter__select" id="categoryFilter">
                        <option value="">Tất cả danh mục</option>
                        <?php
                        $uniqueCategories = array_unique(array_column($getProducts, 'Danh mục'));
                        foreach ($categories as $category) {
                            echo "<option value='" . htmlspecialchars($category['name']) . "'>" . htmlspecialchars($category['name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="product-filter__group">
                    <label class="product-filter__label">Thương hiệu</label>
                    <select class="product-filter__select" id="brandFilter">
                        <option value="">Tất cả thương hiệu</option>
                        <?php
                        $brands = array_unique(array_map(function($product) {
                            return 'Apple'; // Giả định thương hiệu là Apple
                        }, $getProducts));
                        foreach ($brands as $brand) {
                            if (!empty($brand)) {
                                echo "<option value='" . htmlspecialchars($brand) . "'>" . htmlspecialchars($brand) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="product-filter__actions">
                    <button class="product-filter__btn product-filter__btn--primary" id="filterButton">Lọc</button>
                    <button class="product-filter__btn product-filter__btn--secondary" id="resetButton">Reset</button>
                </div>
            </div>

            <!-- Products Section -->
            <div class="product-list">
                <h2 class="product-list__title">Sản phẩm</h2>
                <div class="product-table">
                    <div class="product-table__header">
                        <div class="product-table__cell product-table__cell--header">Tên</div>
                        <div class="product-table__cell product-table__cell--header">Danh mục</div>
                        <div class="product-table__cell product-table__cell--header">Giá</div>
                        <div class="product-table__cell product-table__cell--header">Số lượng</div>
                        <div class="product-table__cell product-table__cell--header">Action</div>
                    </div>

                    <?php foreach ($getProducts as $product): ?>
                        <?php
                            $productName = htmlspecialchars($product['Tên']);
                            $category = htmlspecialchars($product['Danh mục']);
                            $price = htmlspecialchars($product['Giá']);
                            $stock = htmlspecialchars($product['Số lượng']);
                            $mediaUrl = htmlspecialchars($product['media_url'] ?? '/img/default.png');
                            $mediaAlt = htmlspecialchars($product['media_alt'] ?? $productName);
                            $productId = htmlspecialchars($product['product_id']);
                        ?>
                        <div class="products-table__row productRows" data-product-id="<?= $productId ?>" data-brand="Apple">
                            <div class="product-table__cell product-table__cell--name">
                                <img src="<?= $mediaUrl ?>" alt="<?= $mediaAlt ?>" class="product-table__image">
                                <span class="product-table__name"><?= $productName ?></span>
                            </div>
                            <div class="product-table__cell"><?= $category ?></div>
                            <div class="product-table__cell"><?= $price ?></div>
                            <div class="product-table__cell"><?= $stock ?></div>
                            <div class="product-table__cell product-table__cell--actions">
                                <a href="/admin/products/detail?id=<?= $productId ?>" class="product-table__action-btn">
                                    <img src="/icons/view_icon.svg" alt="Xem">
                                </a>
                                <button class="product-table__action-btn"><img src="/icons/edit_icon.svg" alt="Sửa"></button>
                                <button class="product-table__action-btn"><img src="/icons/trash_icon.svg" alt="Xoá"></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php echo $htmlPagination; ?>
            </div>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/common/pagination.js"></script>
    <script type="module" src="/admin-ui/js/pages/productsFilter.js"></script>
</body>
</html>