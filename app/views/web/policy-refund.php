<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Chính
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
                <div class="sidebar-item"><a href="customer">Chính sách giao hàng & lắp đặt</a></div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chỉ bán</div>
                <div class="sidebar-item"><a href="client">Chính sách khách hàng thân thiết tại Shop</a></div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item active"><a href="refund">Chính sách đổi trả và bảo hành tiêu chuẩn</a></div>
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
            <div class="breadcrumb">Trang chủ> <span>Chính sách đổi trả và bảo hành tiêu chuẩn</span></div>
            <h1>Chính sách đổi trả và bảo hành tiêu chuẩn</h1>
            <div class="intro-text">

            </div>

            <div class="policy-section">
                <h2>A. Khung chính sách đổi trả:</h2>
                <p> WooCommerce cung cấp các hướng dẫn thiết yếu cho việc tạo chính sách hoàn tiền và đổi trả hiệu quả, bao gồm các chủ đề như tầm quan trọng của việc có chính sách rõ ràng, ghi chú về các sản phẩm có thể hoặc không thể hoàn tiền, quyết định ai sẽ trả phí vận chuyển đổi trả, và thiết lập kỳ vọng của khách hàng về thời gian hoàn tiền .
                    Tính năng quản lý RMA (Return Merchandise Authorization)
                    Việc thêm chính sách bảo hành và đổi trả vừa đơn giản vừa phức tạp. Đơn giản vì dễ dàng thêm bảo hành cho một sản phẩm – có thể mất chưa đến một phút, nhưng phức tạp vì extension này có khả năng tùy chỉnh cực kỳ đa dạng.
                    Hệ thống quản lý quy trình RMA, thêm bảo hành cho sản phẩm, và cho phép khách hàng yêu cầu và quản lý đổi trả/hoàn tiền từ tài khoản của họ.
                    Các thành phần chính của chính sách đổi trả.</p>
            </div>

            <div class="policy-section">
                <h2>1. Thời gian đổi trả</h2>
                <p>Thiết lập số ngày tối đa cho phép đổi trả và Chọn trạng thái đơn hàng mà chính sách RMA được áp dụng.</p>
                <h2>2. Quy trình đổi trả</h2>
                <p>Quản lý quy trình hoàn tiền trong cửa hàng một cách dễ dàng. Kích hoạt biểu mẫu hoàn tiền, cho phép đổi trả tự động, tắt biểu mẫu hoàn tiền sau một thời gian cụ thể, và quản lý hoàn tiền trực tiếp từ đơn hàng WooCommerce.</p>
            </div>
            <div class="policy-section">
                <h2>3. Yêu cầu đổi trả không cần đăng nhập</h2>
                <p>Tính năng mới yêu cầu hoàn tiền mà không cần đăng nhập.
                    Chính sách bảo hành điển hình
                    Bảo hành sản phẩm điện tử
                    Đa số sản phẩm có bảo hành của nhà sản xuất 1 năm. Bảo hành mở rộng có sẵn cho hầu hết các sản phẩm với mức phí nhỏ.</p>
            </div>
            <div class="policy-section">
                <h2>4.Điều kiện bảo hành</h2>
                <p>Chúng tôi sẽ chấp nhận đổi trả bất kỳ sản phẩm mới chưa qua sử dụng của đại lý nếu sản phẩm không hoạt động do lỗi vật liệu hoặc lỗi sản xuất trong thời gian một năm kể từ ngày mua
                    Khuyến nghị cho chính sách đổi trả website điện tử.</p>
            </div>

            <div class="policy-section">
                <h2>5.Thời gian đổi trả phổ biến</h2>
                <p>7-14 ngày: Đổi trả do không hài lòng
                    30 ngày: Đổi trả do lỗi sản phẩm
                    1 năm: Bảo hành chính hãng.</p>
            </div>

            <div class="policy-section">
                <h2>6.Điều kiện đổi trả</h2>
                <p>Sản phẩm còn nguyên vẹn, chưa qua sử dụng
                    Có đầy đủ phụ kiện, hộp, sách hướng dẫn
                    Tem bảo hành còn nguyên vẹn
                    Có hóa đơn mua hàng.</p>
            </div>
            <div class="policy-section">
                <h2>7.Quy trình đổi trả</h2>
                <p>Khách hàng tạo yêu cầu đổi trả
                    Cung cấp lý do đổi trả
                    Đóng gói và gửi sản phẩm
                    Kiểm tra sản phẩm
                    Xử lý đổi trả/hoàn tiền.</p>
            </div>
            <div class="policy-section">
                <h2>7.Phí đổi trả</h2>
                <p>Lỗi do nhà sản xuất: Miễn phí.
                    Khách hàng đổi ý: Khách hàng chịu phí vận chuyển.
                    Đổi size/mẫu: Tùy chính sách cụ thể.
                    Quy trình hoàn tiền và đổi trả WooCommerce được thực hiện đơn giản. Cho phép khách hàng yêu cầu hoàn tiền và đổi trả sản, phẩm trực tiếp từ trang Tài khoản của tôi.</p>
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