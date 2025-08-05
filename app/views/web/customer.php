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
                <div class="sidebar-item"><a href="frequently_questions">Câu hỏi thường gặp</a></div>
                <div class="sidebar-item"><a href="introducing_shop">Giới thiệu về Shop</a></div>
                <div class="sidebar-item">Đại lý ủy quyền và TTBH ủy quyền của Apple</div>
                <div class="sidebar-item"><a href="policy">Chính sách mạng di động</a></div>
                <div class="sidebar-item">Chính sách gói cước di động</div>
                <div class="sidebar-item">Danh sách điểm cung cấp dịch vụ viễn thông</div>
                <div class="sidebar-item active"><a href="customer">Chính sách giao hàng & lắp đặt</a></div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chỉ bán</div>
                <div class="sidebar-item"><a href="client">Chính sách khách hàng thân thiết tại Shop</a></div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item"><a href="refund">Chính sách đổi trả và bảo hành tiêu chuẩn</a></div>
                <div class="sidebar-item"><a href="repair">Chính sách khui hộp sản phẩm</a></div>
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
            <div class="breadcrumb">Trang chủ> <span>Chính sách giao hàng & lắp đặt </span></div>
            <h1>Chính sách giao hàng & lắp đặt</h1>
            <div class="policy-section">
                <h2>Giao hàng tại nhà</h2>
                <p>Mua hàng tại FPT Shop, khách hàng sẽ được hỗ trợ giao hàng tại nhà hầu như trên toàn quốc. Với độ phủ trên khắp 63 tỉnh thành, Quý khách sẽ nhận được sản phẩm nhanh chóng mà không cần mất thời gian di chuyển tới cửa hàng.</p>
            </div>

            <div class="policy-section">
                <h2>Giao hàng</h2>
                <p>• Áp dụng với tất cả các sản phẩm có áp dụng giao hàng tại nhà, không giới hạn giá trị.</p>

                <p>• Miễn phí giao hàng trong bán kính 20km có đặt shop (Đơn hàng giá trị < 100.000 VNĐ thu phí 10.000 VNĐ).</p>

                        <p>• Với khoảng cách lớn hơn 20km, nhân viên FPT Shop sẽ tư vấn chi tiết về cách thức giao nhận thuận tiện nhất.</p>
            </div>


            <div class="policy-section">
                <h2>Thanh toán</h2>
                <p>Đối với các sản phẩm có chính sách lắp đặt tại nhà (VD: TV, Điều hòa,...) sau khi sản phẩm được giao tới nơi. FPT Shop sẽ hỗ trợ tư vấn, lắp đặt và hướng dẫn sử dụng miễn phí cho khách hàng.</p>
            </div>

            <div class="policy-section">
                <h2>Riêng đối với các sản phẩm Chỉ bán Online:</h2>
                <p>• Khi nhận hàng, quý khách không đồng kiểm chi tiết với nhà vận chuyển (chỉ kiểm tra ngoại quan kiện hàng, không bóc và kiểm tra chi tiết sản phẩm bên trong). Trường hợp Quý khách không nhận sản phẩm, kiện hàng sẽ được nhà vận chuyển chuyển hoàn về nơi gửi.</p>

                <p> • Quý khách cần quay video khi nhận hàng mở kiện để được thực hiện đổi trả nếu hàng hoá có phát sinh vấn đề.</p>

                <p> • Quý khách có 01 ngày để gọi lên tổng đài khiếu kiện trong trường hợp phát sinh đến hàng hoá.</p>
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