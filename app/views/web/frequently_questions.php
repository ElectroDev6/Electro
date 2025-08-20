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
                <div class="sidebar-item active"><a href="frequently_questions">Câu hỏi thường gặp</a></div>
                <div class="sidebar-item"><a href="introducing_shop">Giới thiệu về Shop</a></div>
                <div class="sidebar-item">Đại lý ủy quyền và TTBH ủy quyền của Apple</div>
                <div class="sidebar-item"><a href="policy-mobile">Chính sách mạng di động</a></div>
                <div class="sidebar-item">Chính sách gói cước di động</div>
                <div class="sidebar-item">Danh sách điểm cung cấp dịch vụ viễn thông</div>
                <div class="sidebar-item"><a href="customer">Chính sách giao hàng & lắp đặt</a></div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chỉ bán</div>
                <div class="sidebar-item"><a href="policy-client">Chính sách khách hàng thân thiết tại Shop</a></div>
                <div class="sidebar-item">Giới thiệu máy đổi trảm</div>
                <div class="sidebar-item"><a href="policy-refund">Chính sách đổi trả và bảo hành tiêu chuẩn</a></div>
                <div class="sidebar-item"><a href="policy-repair">Chính sách khui hộp sản phẩm</a></div>
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
            <div class="breadcrumb">Trang chủ> <span>Câu hỏi thường gặp</span></div>
            <h1>Câu hỏi thường gặp</h1>
            <div class="policy-wrapper">


                <div class="faq-item">
                    <div class="question">
                        <span>1.Mua sản phẩm FPT Shop được bảo hành như thế nào?</span>
                        <button class="toggle">+</button>
                    </div>
                </div>

                <div class="faq-item expanded">
                    <div class="question">
                        <span>2. Mua sản phẩm tại FPT Shop có được đổi trả không? Nếu được thì chi phí đổi trả sẽ được tính như thế nào?</span>
                        <button class="toggle">+</button>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="question">
                        <span>3. FPT Shop có chính sách giao hàng tận nhà không? Nếu giao hàng tại nhà mà không ưng sản phẩm lại không?</span>
                        <button class="toggle">+</button>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="question">
                        <span>4. Làm thế nào để kiểm tra được tình trạng máy đã gửi đi bảo hành tại FPT Shop?</span>
                        <button class="toggle">+</button>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="question">
                        <span>5. Muốn kiểm tra sản phẩm đã mua từ FPT Shop có chính hãng của Apple thì xem như thế nào?</span>
                        <button class="toggle">+</button>
                    </div>
                </div>

                <div class="see-more">
                    <button>Xem thêm</button>
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