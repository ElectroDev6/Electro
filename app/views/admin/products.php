<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/pagination.php';
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
        <div class="product-page">
        <!-- Header Section -->
        <div class="product-page__header">
            <h1 class="product-page__title">Trang sản phẩm</h1>
            <button class="product-page__add-btn"> + Add new</button>
        </div>
 
        <!-- Filter Section -->
        <div class="product-filter">
            <div class="product-filter__group">
                <label class="product-filter__label">Tên sản phẩm</label>
                <input type="text" class="product-filter__input" placeholder="Tìm kiếm sản phẩm...">
            </div>
            
            <div class="product-filter__group">
                <label class="product-filter__label">Danh mục</label>
                <select class="product-filter__select">
                    <option>Tất cả danh mục</option>
                </select>
            </div>
            
            <div class="product-filter__group">
                <label class="product-filter__label">Thương hiệu</label>
                <select class="product-filter__select">
                    <option>Tất cả thương hiệu</option>
                </select>
            </div>
            
            <div class="product-filter__actions">
                <button class="product-filter__btn product-filter__btn--primary">Lọc</button>
                <button class="product-filter__btn product-filter__btn--secondary">Reset</button>
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
                
                <!-- Product Row 1 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                        <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Smartphone</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 2 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                        <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Laptop</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 3 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                        <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Lamborgini</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 4 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                         <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Tivi</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 5 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                         <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Smartphone</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn">
                            <img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 6 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                        <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Smartphone</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 7 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                        <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Smartphone</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn"><img src="/icons/view_icon.svg" alt=""></button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
                
                <!-- Product Row 8 -->
                <div class="product-table__row">
                    <div class="product-table__cell product-table__cell--name">
                       <img src="/img/product.png" alt="iPhone 15 Promax" class="product-table__image">
                        <span class="product-table__name">Iphone 15 Promax</span>
                    </div>
                    <div class="product-table__cell">Smartphone</div>
                    <div class="product-table__cell">123,456,000đ</div>
                    <div class="product-table__cell">30</div>
                    <div class="product-table__cell product-table__cell--actions">
                        <button class="product-table__action-btn">
                            <img src="/icons/view_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/edit_icon.svg" alt="">
                        </button>
                        <button class="product-table__action-btn">
                            <img src="/icons/trash_icon.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
    <?php echo $htmlPagination; ?>
        </div>
        </div>
    </main>
</body>
</html>