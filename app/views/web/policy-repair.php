<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Trang chủ
<?php View::endSection(); ?>

<?php View::section('content'); ?>
<div class="container-main">
    <div class="container-policy">

        <div class="sidebar">
            <div class="sidebar-header">Danh mục chính sách</div>
            <div class="sidebar-content">
                <div class="sidebar-item "><a href="frequently_questions">Câu hỏi thường gặp</a></div>
                <div class="sidebar-item"><a href="introducing_shop">Giới thiệu về Shop</a></div>
                <div class="sidebar-item">Đại lý ủy quyền và TTBH ủy quyền của Apple</div>
                <div class="sidebar-item"><a href="policy">Chính sách mạng di động</a></div>
                <div class="sidebar-item">Chính sách gói cước di động</div>
                <div class="sidebar-item">Danh sách điểm cung cấp dịch vụ viễn thông</div>
                <div class="sidebar-item"><a href="customer">Chính sách giao hàng & lắp đặt</a></div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chỉ bán</div>
                <div class="sidebar-item"><a href="client">Chính sách khách hàng thân thiết tại Shop</a></div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item"><a href="refund">Chính sách đổi trả và bảo hành tiêu chuẩn</a></div>
                <div class="sidebar-item active"><a href="repair">Chính sách khui hộp sản phẩm</a></div>
                <div class="sidebar-item"><a href="information">Chính sách bảo mật</a></div>
                <div class="sidebar-item">Chính sách bảo hành</div>
                <div class="sidebar-item"><a href="delivery">Chính sách bảo mật dữ liệu cá nhân khách hàng</a></div>
                <div class="sidebar-item">Hướng dẫn mua hàng và thanh toán online</div>
                <div class="sidebar-item">Chính sách đổi trả</div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const items = document.querySelectorAll('.sidebar-item');

                items.forEach(item => {
                    item.addEventListener('click', function() {
                        items.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>

        <div class="main-content">
            <div class="breadcrumb">Trang chủ><span>Chính sách khui hộp sản phẩm</span></div>
            <h1>Chính sách khui hộp sản phẩm</h1>
            <div class="intro-text">

            </div>

            <div class="policy-section">
                <h2>Chính sách khui hộp sản phẩm</h2>
                <p>Áp dụng cho các sản phẩm bán ra tại FPT Shop bao gồm ĐTDĐ, MT, MTB, Đồng hồ thông minh.</p>
                <p> Nội dung chính sách:</p>
                <p> Sản phẩm bắt buộc phải khui seal/mở hộp và kích hoạt bảo hành điện tử (Active) ngay tại shop hoặc ngay tại thời điểm nhận hàng khi có nhân viên giao hàng tại nhà.</p>
                <p> Đối với các sản phẩm bán nguyên seal khách hàng cần phải thanh toán trước 100% giá trị đơn hàng trước khi khui seal sản phẩm.</p>
            </div>

            <div class="policy-section">
                <h2>Lưu ý:</h2>
                <p>Trước khi kích hoạt bảo hành điện tử (Active) sản phẩm khách hàng cần kiểm tra các lỗi ngoại quan của sản phẩm (Cấn_Trầy thân máy, bụi trong camera, bụi màn hình, hở viền…). Nếu phát hiện các lỗi trên khách hàng sẽ được đổi 1 sản phẩm khác hoặc hoàn tiền.</p>

                <p> Ngay sau khi kiểm tra lỗi ngoại quan, tiến hành bật nguồn để kiểm tra đến lỗi kỹ thuật; nếu sản phẩm có lỗi kỹ thuật của nhà sản xuất khách hàng sẽ được đổi 1 sản phẩm mới tương đương tại FPT Shop.</p>

                <p> Nếu quý khách báo lỗi ngoại quan sau khi sản phẩm đã được kích hoạt bảo hành điện tử (Active) hoặc sau khi nhân viên giao hàng rời đi FPT shop chỉ hỗ trợ chuyển sản phẩm của khách hàng đến hãng để thẩm định và xử lý.</p>

                <img src="https://cdn2.fptshop.com.vn/unsafe/chinh_sach_khui_hop_97039e3365.jpg" alt="Loyalty Program" class="loyalty-image">
                <h2>Một số hình ảnh sản phẩm bị lỗi thẩm mỹ.</h2>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.sidebar-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
<?php View::endSection(); ?>