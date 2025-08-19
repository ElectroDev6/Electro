<?php
include dirname(__DIR__) . '/partials/header.php';
include dirname(__DIR__) . '/partials/sidebar.php';

// Hàm tạo URL phân trang
function buildPaginationUrl($pageNum) {
    $params = $_GET;
    $params['page'] = $pageNum;
    if ($pageNum == 1) {
        unset($params['page']);
    }
    $query = http_build_query($params);
    return '/admin/products' . ($query ? '?' . $query : '');
}

$startItem = ($page - 1) * $productsPerPage + 1;
$endItem = min($page * $productsPerPage, $totalProducts);
$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] !== ''): ?>
            <div class="notification notification--success" id="success-notification">
                <p id="success-message"><?php echo htmlspecialchars($_GET['success']); ?></p>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>
            <div class="notification notification--error" id="error-notification">
                <p id="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php endif; ?>

        <div class="product-page">
            <!-- Header Section -->
            <div class="product-page__header">
                <h1 class="product-page__title">Quản lý sản phẩm</h1>
                <a href="/admin/products/create" class="product-page__add-btn">+ Thêm sản phẩm</a>
            </div>

            <!-- Filter Section -->
            <form class="product-filter" method="GET" action="/admin/products">
                <div class="product-filter__group">
                    <label class="product-filter__label">Tên sản phẩm</label>
                    <input type="text" name="name" id="searchProduct" class="product-filter__input" placeholder="Tìm kiếm sản phẩm..." value="<?php echo htmlspecialchars($name ?? ''); ?>">
                </div>
                <div class="product-filter__group">
                    <label class="product-filter__label">Danh mục</label>
                    <select name="category" id="categoryFilter" class="product-filter__select">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $categoryItem): ?>
                            <option value="<?php echo htmlspecialchars($categoryItem); ?>" <?php echo ($category ?? '') === $categoryItem ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoryItem); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="product-filter__group">
                    <label class="product-filter__label">Thương hiệu</label>
                    <select name="brand" id="brandFilter" class="product-filter__select">
                        <option value="">Tất cả thương hiệu</option>
                        <?php foreach ($brands as $brandItem): ?>
                            <option value="<?php echo htmlspecialchars($brandItem); ?>" <?php echo ($brand ?? '') === $brandItem ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($brandItem); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="product-filter__group">
                    <label class="product-filter__label">Sắp xếp theo giá</label>
                    <select name="price_sort" id="priceSortFilter" class="product-filter__select">
                        <option value="">Mặc định</option>
                        <option value="asc" <?php echo ($price_sort ?? '') === 'asc' ? 'selected' : ''; ?>>Giá: Tăng dần</option>
                        <option value="desc" <?php echo ($price_sort ?? '') === 'desc' ? 'selected' : ''; ?>>Giá: Giảm dần</option>
                    </select>
                </div>
                <div class="product-filter__group">
                    <label class="product-filter__label">Hiển thị</label>
                    <select name="limit" class="product-filter__select">
                        <option value="8" <?php echo $limit === 8 ? 'selected' : ''; ?>>8</option>
                        <option value="12" <?php echo $limit === 12 ? 'selected' : ''; ?>>12</option>
                        <option value="16" <?php echo $limit === 16 ? 'selected' : ''; ?>>16</option>
                        <option value="20" <?php echo $limit === 20 ? 'selected' : ''; ?>>20</option>
                    </select>
                </div>
                <div class="product-filter__actions">
                    <button type="submit" class="product-filter__btn product-filter__btn--primary">Lọc</button>
                    <a href="/admin/products" class="product-filter__btn product-filter__btn--secondary">Reset</a>
                </div>
            </form>

            <!-- Filter Results Info -->
            <?php if (!empty($name) || !empty($category) || !empty($brand) || !empty($price_sort)): ?>
                <div class="filter-info" style="margin: 15px 0; padding: 10px; background: #e3f2fd; border-radius: 5px; color: #1976d2;">
                    <strong>Đang lọc:</strong>
                    <?php if (!empty($name)): ?>
                        <span class="filter-tag">Tên: "<?php echo htmlspecialchars($name); ?>"</span>
                    <?php endif; ?>
                    <?php if (!empty($category)): ?>
                        <span class="filter-tag">Danh mục: "<?php echo htmlspecialchars($category); ?>"</span>
                    <?php endif; ?>
                    <?php if (!empty($brand)): ?>
                        <span class="filter-tag">Thương hiệu: "<?php echo htmlspecialchars($brand); ?>"</span>
                    <?php endif; ?>
                    <?php if (!empty($price_sort)): ?>
                        <span class="filter-tag">Sắp xếp: "<?php echo $price_sort === 'asc' ? 'Giá tăng dần' : 'Giá giảm dần'; ?>"</span>
                    <?php endif; ?>
                    | <strong><?php echo $totalProducts; ?></strong> kết quả | Hiển thị <?php echo $limit; ?> mục/trang
                </div>
            <?php endif; ?>

            <!-- Products Table Section -->
            <div class="product-list">
                <h2 class="product-list__title">Danh sách sản phẩm</h2>
                <table class="product-table">
                    <div class="product-table__header">
                        <div class="product-table__cell product-table__cell--header">Tên</div>
                        <div class="product-table__cell product-table__cell--header">Thương hiệu</div>
                        <div class="product-table__cell product-table__cell--header">Danh mục phụ</div>
                        <div class="product-table__cell product-table__cell--header">Danh mục</div>
                        <div class="product-table__cell product-table__cell--header">Giá</div>
                        <div class="product-table__cell product-table__cell--header">Số lượng</div>
                        <div class="product-table__cell product-table__cell--header">Hành động</div>
                    </div>
                    <?php if (!empty($products) && is_array($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <?php
                            $productName = htmlspecialchars($product['product_name'] ?? 'Chưa đặt tên');
                            $brandName = htmlspecialchars($product['brand_name'] ?? 'Chưa có');
                            $subcategoryName = htmlspecialchars($product['subcategory_name'] ?? 'Chưa phân loại');
                            $category = htmlspecialchars($product['category_name'] ?? 'Chưa phân loại');
                            $price = number_format($product['sku_price'] ?? 0, 0, ',', '.') . ' VNĐ';
                            $stock = htmlspecialchars($product['stock_quantity'] ?? 0);
                            $mediaAlt = htmlspecialchars($product['product_name'] ?? 'Hình ảnh sản phẩm');
                            ?>
                            <div class="product-table__row productRows" data-product-id="<?= $productId ?>" data-brand="<?= $brandName ?>" data-subcategory="<?= $subcategoryName ?>">
                                <div class="product-table__cell product-table__cell--name">
                                    <img src="/img/products/default/<?=htmlspecialchars($product['default_url']) ?>" alt="<?= $mediaAlt ?>" class="product-table__image">
                                    <span class="product-table__name"><?= $productName ?></span>
                                </div>
                                <div class="product-table__cell"><?= $brandName ?></div>
                                <div class="product-table__cell"><?= $subcategoryName ?></div>
                                <div class="product-table__cell"><?= $category ?></div>
                                <div class="product-table__cell"><?= $price ?></div>
                                <div class="product-table__cell"><?= $stock ?></div>
                                <div class="product-table__cell product-table__cell--actions">
                                    <a href="/admin/products/detail?id=<?= htmlspecialchars($product['product_id']) ?>" class="product-table__action-btn">
                                        <img src="/icons/view_icon.svg" alt="Xem">
                                    </a>
                                    <a href="/admin/products/edit?id=<?= $productId ?>" class="product-table__action-btn">
                                        <img src="/icons/edit_icon.svg" alt="Sửa">
                                    </a>
                                    <button class="product-table__action-btn" onclick="deleteProduct(<?= $productId ?>)">
                                        <img src="/icons/trash_icon.svg" alt="Xoá">
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="product-table__row">
                            <div class="product-table__cell" colspan="7">Không có sản phẩm nào hoặc có lỗi khi tải dữ liệu.</div>
                        </div>
                    <?php endif; ?>
                </table>
                <?php if ($totalPages > 1): ?>
                    <div class="products__pagination">
                        <ul class="pagination__list">
                            <!-- First Page Button -->
                            <?php if ($page > 1): ?>
                                <li class="pagination__item">
                                    <a href="<?php echo buildPaginationUrl(1); ?>" class="pagination__link pagination__link--first">
                                        <i class="fas fa-angle-double-left"></i> Đầu
                                    </a>
                                </li>
                            <?php endif; ?>

                            <!-- Previous Button -->
                            <li class="pagination__item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <?php if ($page > 1): ?>
                                    <a href="<?php echo buildPaginationUrl($page - 1); ?>" class="pagination__link">
                                        <i class="fas fa-angle-left"></i> Trước
                                    </a>
                                <?php else: ?>
                                    <span class="pagination__link pagination__link--disabled">
                                        <i class="fas fa-angle-left"></i> Trước
                                    </span>
                                <?php endif; ?>
                            </li>

                            <!-- Show first page and ellipsis if needed -->
                            <?php if ($startPage > 1): ?>
                                <li class="pagination__item">
                                    <a href="<?php echo buildPaginationUrl(1); ?>" class="pagination__link">1</a>
                                </li>
                                <?php if ($startPage > 2): ?>
                                    <li class="pagination__item">
                                        <span class="pagination__ellipsis">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <!-- Page Numbers -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="pagination__item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <?php if ($i == $page): ?>
                                        <span class="pagination__link pagination__link--active"><?php echo $i; ?></span>
                                    <?php else: ?>
                                        <a href="<?php echo buildPaginationUrl($i); ?>" class="pagination__link"><?php echo $i; ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <!-- Show last page and ellipsis if needed -->
                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <li class="pagination__item">
                                        <span class="pagination__ellipsis">...</span>
                                    </li>
                                <?php endif; ?>
                                <li class="pagination__item">
                                    <a href="<?php echo buildPaginationUrl($totalPages); ?>" class="pagination__link"><?php echo $totalPages; ?></a>
                                </li>
                            <?php endif; ?>

                            <!-- Next Button -->
                            <li class="pagination__item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                <?php if ($page < $totalPages): ?>
                                    <a href="<?php echo buildPaginationUrl($page + 1); ?>" class="pagination__link">
                                        Sau <i class="fas fa-angle-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="pagination__link pagination__link--disabled">
                                        Sau <i class="fas fa-angle-right"></i>
                                    </span>
                                <?php endif; ?>
                            </li>

                            <!-- Last Page Button -->
                            <?php if ($page < $totalPages): ?>
                                <li class="pagination__item">
                                    <a href="<?php echo buildPaginationUrl($totalPages); ?>" class="pagination__link pagination__link--last">
                                        Cuối <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <!-- Pagination Info for Products -->
                    <div style="padding: 14px 16px">
                        <span class="pagination__info-text">
                            Hiển thị <?php echo number_format($startItem); ?> - <?php echo number_format($endItem); ?>
                            trong tổng số <?php echo number_format($totalProducts); ?> sản phẩm
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script type="module" src="/admin-ui/js/common/notification.js"></script>
</body>
</html>




























