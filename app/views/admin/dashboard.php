<?php
include dirname(__DIR__) . '/admin/partials/sidebar.php';
include dirname(__DIR__) . '/admin/partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electro Dashboard</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @media (max-width: 768px) {
            .dashboard-stats {
                flex-direction: column;
            }
            .analytics-grid {
                grid-template-columns: 1fr;
            }
            .tables-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="main-content">
            <h1 class="dashboard__heading">Tổng quan hệ thống</h1>
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Tổng doanh thu bán hàng</h3>
                        <div class="stat-icon revenue">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo number_format($data['totalRevenue'], 0, ',', '.') . 'đ'; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Khách hàng mới</h3>
                        <div class="stat-icon customers">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo htmlspecialchars($data['newCustomers']); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Sản phẩm đang hoạt động</h3>
                        <div class="stat-icon products">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo htmlspecialchars($data['activeProducts']); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <h3 class="stat-title">Doanh số hôm nay</h3>
                        <div class="stat-icon today-sales">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo htmlspecialchars($data['todaySales']); ?></div>
                </div>
            </div>

            <h1 class="dashboard__heading">Phân tích hệ thống</h1>
            <div class="analytics-controls">
                <label for="monthSelect">Chọn tháng: </label>
                <select id="monthSelect" class="month-select">
                    <option value="">Tất cả</option>
                    <?php foreach ($data['months'] as $month): ?>
                        <option value="<?php echo htmlspecialchars($month); ?>" <?php echo $month === date('Y-m') ? 'selected' : ''; ?>>
                            <?php echo date('F Y', strtotime($month . '-01')); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="analytics-grid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Doanh thu theo danh mục</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="categoryRevenueChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Xu hướng đơn hàng</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="orderTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="analytics-grid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Phương thức thanh toán</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="paymentMethodChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tăng trưởng người dùng</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tables-row">
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Top sản phẩm bán chạy</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Thứ hạng</th>
                                        <th>Sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Số lượng bán</th>
                                        <th>Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody id="topProductsTable">
                                    <?php if (empty($data['topProducts'])): ?>
                                        <tr>
                                            <td colspan="5" class="table-empty">Không có sản phẩm nào.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($data['topProducts'] as $index => $product): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo htmlspecialchars($product['product_name'] ?? 'Không xác định'); ?></td>
                                                <td><?php echo htmlspecialchars($product['category_name'] ?? 'Không có'); ?></td>
                                                <td><?php echo htmlspecialchars($product['sold'] ?? 0); ?></td>
                                                <td><?php echo number_format($product['revenue'] ?? 0, 0, ',', '.') . 'đ'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Đơn hàng gần đây</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody id="recentOrdersTable">
                                    <?php if (empty($data['recentOrders'])): ?>
                                        <tr>
                                            <td colspan="4" class="table-empty">Không có đơn hàng nào.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($data['recentOrders'] as $order): ?>
                                            <tr>
                                                <td><?php echo '#' . sprintf('%04d', $order['order_id']); ?></td>
                                                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                                <td><?php echo number_format($order['total_price'] ?? 0, 0, ',', '.') . 'đ'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const initialCategoryRevenue = <?php echo json_encode($data['categoryRevenue']); ?>;
        const initialOrderTrend = <?php echo json_encode($data['orderTrend']); ?>;
        const initialPaymentMethods = <?php echo json_encode($data['paymentMethods']); ?>;
        const initialUserGrowth = <?php echo json_encode($data['userGrowth']); ?>;
        const categoryRevenueData = (filteredData = initialCategoryRevenue) => {
            const revenueByCategory = {};
            filteredData.forEach(item => {
                if (item.category && item.revenue) {
                    revenueByCategory[item.category] = (revenueByCategory[item.category] || 0) + parseFloat(item.revenue || 0);
                }
            });
            return {
                labels: Object.keys(revenueByCategory),
                datasets: [{
                    label: 'Doanh thu',
                    data: Object.values(revenueByCategory),
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
                        '#06b6d4', '#84cc16', '#f97316', '#ec4899', '#6366f1'
                    ],
                    borderColor: '#1d4ed8',
                    borderWidth: 1
                }]
            };
        };

        const categoryChart = new Chart(document.getElementById('categoryRevenueChart'), {
            type: 'bar',
            data: categoryRevenueData(),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => new Intl.NumberFormat('vi-VN').format(value) + 'đ'
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Xu hướng đơn hàng - Hiển thị 7 ngày gọn gàng hơn
        const orderTrendChart = new Chart(document.getElementById('orderTrendChart'), {
            type: 'line',
            data: {
                labels: initialOrderTrend.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('vi-VN', { 
                        weekday: 'short',
                        day: '2-digit', 
                        month: '2-digit' 
                    });
                }),
                datasets: [
                    {
                        label: 'Số đơn hàng',
                        data: initialOrderTrend.map(item => parseInt(item.order_count) || 0),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Doanh thu',
                        data: initialOrderTrend.map(item => parseFloat(item.total_revenue) || 0),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Ngày (7 ngày gần nhất)'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Số đơn hàng'
                        },
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Doanh thu (VNĐ)'
                        },
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: value => new Intl.NumberFormat('vi-VN').format(value) + 'đ'
                        }
                    }
                },
                plugins: {
                    legend: { 
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        // Phương thức thanh toán
        const paymentMethodData = () => {
            console.log('Raw payment data:', initialPaymentMethods);
            if (!initialPaymentMethods || initialPaymentMethods.length === 0) {
                return {
                    labels: ['Không có dữ liệu'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['#ccc']
                    }]
                };
            }

            const paymentCounts = {};
            initialPaymentMethods.forEach(item => {
                console.log('Processing item:', item);
                if (item.payment_method && item.count) {
                    const method = item.payment_method.trim();
                    const methodMap = {
                        'momo': 'MoMo',
                        'cod': 'COD',
                        'banking': 'Banking',
                        'bank_transfer': 'Chuyển khoản',
                        'vnpay': 'VNPay',
                        'zalopay': 'ZaloPay',
                        'cash': 'Tiền mặt'
                    };
                    const displayName = methodMap[method.toLowerCase()] || method;
                    paymentCounts[displayName] = parseInt(item.count);
                    console.log(`Added: ${displayName} = ${item.count}`);
                }
            });
            
            console.log('Final payment counts:', paymentCounts);
            
            return {
                labels: Object.keys(paymentCounts),
                datasets: [{
                    data: Object.values(paymentCounts),
                    backgroundColor: [
                        '#3b82f6', '#10b981', '#f59e0b', 
                        '#ef4444', '#8b5cf6', '#06b6d4',
                        '#84cc16', '#f97316'
                    ]
                }]
            };
        };

        const paymentChart = new Chart(document.getElementById('paymentMethodChart'), {
            type: 'doughnut',
            data: paymentMethodData(),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} đơn (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Tăng trưởng người dùng - 7 ngày
        const userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels: initialUserGrowth.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('vi-VN', { 
                        weekday: 'short',
                        day: '2-digit', 
                        month: '2-digit' 
                    });
                }),
                datasets: [{
                    label: 'Người dùng mới',
                    data: initialUserGrowth.map(item => parseInt(item.user_count) || 0),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Số người dùng'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày (7 ngày gần nhất)'
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Lọc theo tháng - Đơn giản hóa
        document.getElementById('monthSelect').addEventListener('change', (e) => {
            const selectedMonth = e.target.value;

            // Lọc dữ liệu doanh thu theo danh mục
            const filteredRevenue = selectedMonth 
                ? initialCategoryRevenue.filter(item => item.created_at && item.created_at.startsWith(selectedMonth))
                : initialCategoryRevenue;
            
            categoryChart.data = categoryRevenueData(filteredRevenue);
            categoryChart.update();

            // Các chart khác giữ nguyên vì đã lấy dữ liệu trong khoảng thời gian ngắn
            // Có thể thêm thông báo cho người dùng
            if (selectedMonth) {
                console.log('Đã lọc theo tháng:', selectedMonth);
            }
        });
    </script>
</body>
</html>