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
    <!-- <?php echo '<pre>';
        print_r($products);
        echo '</pre>'; // For debugging purposes, remove in production
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
                        $uniqueCategories = array_unique(array_column($products, 'category_name'));
                        foreach ($uniqueCategories as $category) {
                            if (!empty($category)) {
                                echo "<option value='" . htmlspecialchars($category) . "'>" . htmlspecialchars($category) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="product-filter__group">
                    <label class="product-filter__label">Thương hiệu</label>
                    <select class="product-filter__select" id="brandFilter">
                        <option value="">Tất cả thương hiệu</option>
                        <?php
                        $uniqueBrands = array_unique(array_column($products, 'brand_name'));
                        foreach ($uniqueBrands as $brand) {
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
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?php
                            $productName = htmlspecialchars($product['product_name'] ?? 'Chưa đặt tên');
                            $category = htmlspecialchars($product['category_name'] ?? 'Chưa phân loại');
                            $price = number_format($product['sku_price'] ?? 0, 0, ',', '.') . ' VNĐ';
                            $stock = htmlspecialchars($product['stock_quantity'] ?? 0);
                            $mediaUrl = htmlspecialchars($product['default_url'] ?? '/img/default.png');
                            $mediaAlt = htmlspecialchars($product['product_name'] ?? 'Hình ảnh sản phẩm');
                            $productId = htmlspecialchars($product['product_id'] ?? '');
                            $brandName = htmlspecialchars($product['brand_name'] ?? '');
                            ?>
                            <div class="products-table__row productRows" data-product-id="<?= $productId ?>" data-brand="<?= $brandName ?>">
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
                    <?php else: ?>
                        <div class="products-table__row">
                            <div class="product-table__cell" colspan="5">Không có sản phẩm nào</div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php echo $htmlPagination; ?>
            </div>
        </div>
    </main>
</body>
</html>