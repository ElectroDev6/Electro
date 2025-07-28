<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
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
        <div class="main-content">
            <h1 class="dashboard__heading">Tổng quan hệ thống</h1>
            <div class="dashboard">
                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Tổng doanh thu <br> bán hàng</h3>
                        <div class="stat-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="stat-value">24,780,000đ</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>12.5% so với tháng trước</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Khách hàng mới</h3>
                        <div class="stat-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">578</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>8.2% so với tháng trước</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Sản phẩm đang <br> hoạt động</h3>
                        <div class="stat-icon products">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-value">1,247</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>4.3% so với tháng trước</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Doanh số hôm nay</h3>
                        <div class="stat-icon today-sales">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="stat-value">145</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i>
                        <span>8.2% so với ngày trước</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>