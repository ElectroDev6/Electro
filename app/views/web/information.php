<?php

use Core\View; ?>
<?php View::extend('layouts.main'); ?>

<?php View::section('page_title'); ?>
Trang chủ
<?php View::endSection(); ?>

<?php View::section('content'); ?>
<div class="container">
    <div class="sidebar">
        <div class="sidebar-header">Danh mục chính sách</div>
        <div class="sidebar-content">
            <div class="sidebar-item">Câu hỏi thường gặp</div> <a></a>
            <div class="sidebar-item">Giới thiệu về Shop</div>
            <div class="sidebar-item">Đại lý ủy quyền và TTBH ủy quyền của Apple</div>
            <a href="policy" class="sidebar-item">Chính sách mạng di động</a>
            <div class="sidebar-item">Chính sách gói cước di động</div>
            <div class="sidebar-item">Danh sách điểm cung cấp dịch vụ viễn thông</div>
            <div class="sidebar-item">Chính sách giao hàng & lắp đặt</div>
            <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
            <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chi bán</div>
            <a href="client" class="sidebar-item">Chính sách khách hàng thân thiết</a>
            <div class="sidebar-item">Chính sách khui hộp sản phẩm</div>
            <div class="sidebar-item">Giới thiệu máy đổi trả</div>
            <div class="sidebar-item">Quy định hỗ trợ kỹ thuật và sao lưu dữ liệu</div>
            <a href="information" class="sidebar-item active">Chính sách bảo mật</a>
            <div class="sidebar-item">Chính sách đổi trả</div>
            <div class="sidebar-item">Chính sách bảo mật dữ liệu cá nhân khách hàng</div>
            <div class="sidebar-item">Hướng dẫn mua hàng và thanh toán online</div>
            <a href="refund" class="sidebar-item">Chính sách đổi trả bảo hành </a>
        </div>
    </div>

    <div class="main-content">
        <div class="breadcrumb">Trang chủ> <span>Chính sách bảo mật</span></div>
        <h1>Chính sách bảo mật</h1>
        <div class="intro-text">
            Shop cam kết sẽ bảo mật những thông tin mang tính riêng tư của bạn. Bạn vui lòng đọc bản “Chính sách bảo mật” dưới đây để hiểu hơn những cam kết mà chúng tôi thực hiện, nhằm tôn trọng và bảo vệ quyền lợi của người truy cập.
        </div>

        <div class="policy-section">
            <h2>1. Mục đích và phạm vi thu thập?</h2>
            <p>Để truy cập và sử dụng một số dịch vụ tại, bạn có thể sẽ được yêu cầu đăng ký với chúng tôi thông tin cá nhân (Email, Họ tên, Số ĐT liên lạc…). Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. Không chịu mọi trách nhiệm liên quan đến pháp luật của thông tin khai báo.
                Chúng tôi cũng có thể thu thập thông tin về số lần viếng thăm, bao gồm số trang bạn xem, số links (liên kết) bạn click và những thông tin khác liên quan đến việc kết nối đến site Chúng tôi cũng thu thập các thông tin mà trình duyệt Web (Browser) bạn sử dụng mỗi khi truy cập vào, bao gồm: địa chỉ IP, loại Browser, ngôn ngữ sử dụng, thời gian và những địa chỉ mà Browser truy xuất đến.</p>
        </div>

        <div class="policy-section">
            <h2>2. Phạm vi sử dụng thông tin?</h2>
            <p>Thu thập và sử dụng thông tin cá nhân bạn với mục đích phù hợp và hoàn toàn tuân thủ nội dung của “Chính sách bảo mật” này. Khi cần thiết, chúng tôi có thể sử dụng những thông tin này để liên hệ trực tiếp với bạn dưới các hình thức như: gởi thư ngỏ, đơn đặt hàng, thư cảm ơn, sms, thông tin về kỹ thuật và bảo mật…</p>
        </div>

        <div class="policy-section">
            <h2>3. Thời gian lưu trữ thông tin?</h2>
            <p>Dữ liệu cá nhân của Thành viên sẽ được lưu trữ cho đến khi có yêu cầu hủy bỏ hoặc tự thành viên đăng nhập và thực hiện hủy bỏ. Còn lại trong mọi trường hợp thông tin cá nhân thành viên sẽ được bảo mật.
                 </p>
        </div>

        <div class="policy-section">
            <h2>4. Quy định bảo mật?</h2>
            <p>Chính sách giao dịch thanh toán bằng thẻ quốc tế và thẻ nội địa (internet banking) đảm bảo tuân thủ các tiêu chuẩn bảo mật của các Đối Tác Cổng Thanh Toán gồm:
                Thông tin tài chính của Khách hàng sẽ được bảo vệ trong suốt quá trình giao dịch bằng giao thức SSL 256-bit (Secure Sockets Layer).
                Mật khẩu sử dụng một lần (OTP) được gửi qua SMS để đảm bảo việc truy cập tài khoản được xác thực.
                Các nguyên tắc và quy định bảo mật thông tin trong ngành tài chính ngân hàng theo quy định của Ngân hàng nhà nước Việt Nam.
                Chính sách bảo mật giao dịch trong thanh toán của Shop áp dụng với Khách hàng:
                Thông tin thẻ thanh toán của Khách hàng mà có khả năng sử dụng để xác lập giao dịch KHÔNG được lưu trên hệ thống của Shop. Đối Tác Cổng Thanh Toán sẽ lưu giữ và bảo mật theo tiêu chuẩn quốc tế PCI DSS.
                Đối với thẻ nội địa (internet banking), Shop chỉ lưu trữ mã đơn hàng, mã giao dịch và tên ngân hàng. Shop cam kết đảm bảo thực hiện nghiêm túc các biện pháp bảo mật cần thiết cho mọi hoạt động thanh toán thực hiện trên trang.</p>
        </div>

        <div class="policy-section">
            <h2>5. Làm cách nào để yêu cầu xóa dữ liệu?</h2>
            <p>Bạn có thể gửi yêu cầu xóa dữ liệu qua email Trung tâm hỗ trợ của chúng.Vui lòng cung cấp càng nhiều thông tin càng tốt về dữ liệu nào bạn muốn xóa. Yêu cầu sẽ được chuyển đến nhóm thích hợp để đánh giá và xử lý. Chúng tôi sẽ liên hệ từng bước để cập nhật cho bạn về tiến trình xóa.</p>
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