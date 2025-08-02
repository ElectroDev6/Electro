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
    <style>
        /* CSS cho form */
        .edit-form-container {
            display: none; /* Ẩn mặc định */
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .edit-form-container.active {
            display: block; /* Hiển thị khi có class active */
        }
        
        .edit-form {
            width: 100%;
        }
        
        .edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .edit-form input,
        .edit-form textarea,
        .edit-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        /* Ngăn không cho nhập chữ vào trường số */
        .edit-form input[type="number"] {
            -moz-appearance: textfield;
        }
        
        .edit-form input[type="number"]::-webkit-inner-spin-button,
        .edit-form input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .edit-form button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .edit-form .btn-save {
            background-color: #28a745;
            color: white;
        }
        
        .edit-form .btn-save:hover {
            background-color: #218838;
        }
        
        .edit-form .btn-cancel {
            background-color: #dc3545;
            color: white;
        }
        
        .edit-form .btn-cancel:hover {
            background-color: #c82333;
        }
        
        .category-detail__btn--edit:hover {
            background-color: #0056b3;
        }
        
        .category-detail__btn--delete:hover {
            background-color: #c82333;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .edit-form-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="category-detail">
            <?php if (!empty($_GET['success'])): ?>
                <div class="category-detail__alert category-detail__alert--success">
                    Danh mục đã được tạo thành công!
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
                            <a href="/admin/categories/update?id=<?= $category['id'] ?>" class="category-detail__btn category-detail__btn--edit">Chỉnh sửa
                            </a>
                            <button 
                            class="category-detail__btn category-detail__btn--delete"
                            onclick="confirmDelete(<?= $category['id'] ?>, '<?= htmlspecialchars($category['name'], ENT_QUOTES) ?>')"
                            >
                            Xóa
                            </button>
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
                                    <span class="category-detail__value category-detail__value--id">#<?php echo $category['id']; ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Tên danh mục:</label>
                                    <span class="category-detail__value"><?php echo htmlspecialchars($category['name']); ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Mô tả:</label>
                                    <span class="category-detail__value"><?php echo $category['content_html']; ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Số lượng sản phẩm:</label>
                                    <span class="category-detail__value category-detail__value--count"><?php echo $category['total_products']; ?> sản phẩm</span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Trạng thái:</label>
                                    <span class="category-detail__value">
                                        <span class="category-detail__status category-detail__status--active">Đang hoạt động
                                        </span>
                                    </span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Ngày tạo:</label>
                                    <span class="category-detail__value"><?php echo date('d/m/Y H:i', strtotime($category['create_at'])); ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Cập nhật lần cuối:</label>
                                    <span class="category-detail__value"><?php echo date('d/m/Y H:i', strtotime($category['update_date'])); ?></span>
                                </div>

                                <div class="category-detail__field">
                                    <label class="category-detail__label">Người tạo:</label>
                                    <span class="category-detail__value">Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/admin-ui/js/pages/category-detail.js"></script>
</body>
</html>