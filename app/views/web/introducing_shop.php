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
                <div class="sidebar-item active"><a href="introducing_shop">Giới thiệu về Shop</a></div>
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
            <div class="breadcrumb">Trang chủ> <span> </span>Giới thiệu về Shop</div>
            <h1>Giới thiệu về Shop</h1>
            <div class="policy-section">
                <h2>1. Về chúng tôi</h2>
                <p>Electro Shop là chuỗi chuyên bán lẻ các sản phẩm kỹ thuật số di động bao gồm điện thoại di động, máy tính bảng, laptop, phụ kiện và dịch vụ công nghệ… cùng các mặt hàng gia dụng, điện máy chính hãng, chất lượng cao đến từ các thương hiệu lớn, với mẫu mã đa dạng và mức giá tối ưu nhất cho khách hàng.</p>
                <p>Electro Shop là hệ thống bán lẻ đầu tiên ở Việt Nam được cấp chứng chỉ ISO 9001:2000 về quản lý chất lượng theo tiêu chuẩn quốc tế. Hiện nay, FPT Shop là chuỗi bán lẻ lớn thứ 2 trên thị trường bán lẻ hàng công nghệ.</p>
            </div>

            <div class="policy-section">
                <h2>2. Sứ mệnh</h2>
                <p>Hệ thống Electro Shop kỳ vọng mang đến cho khách hàng những trải nghiệm mua sắm tốt nhất thông qua việc cung cấp các sản phẩm chính hãng, dịch vụ chuyên nghiệp cùng chính sách hậu mãi chu đáo. Electro Shop không ngừng cải tiến và phát triển, hướng tới việc trở thành nhà bán lẻ công nghệ hàng đầu Việt Nam, đồng thời mang lại giá trị thiết thực cho cộng đồng.</p>
            </div>


            <div class="policy-section">
                <h2>3. Giá trị cốt lõi</h2>
                <p>• Chất lượng và Uy tín: Electro Shop cam kết cung cấp các sản phẩm chính hãng, chất lượng cao với chính sách bảo hành uy tín và dịch vụ chăm sóc khách hàng chu đáo, nhằm đem đến cho khách hàng sự an tâm tuyệt đối khi mua sắm các sản phẩm công nghệ, điện máy - gia dụng.</p>
                <p>• Khách hàng là trọng tâm: Phục vụ khách hàng luôn là ưu tiên số 1. Electro Shop luôn chú trọng hoàn thiện chất lượng dịch vụ, bồi dưỡng đội ngũ nhân viên nhiệt tình, trung thực, chân thành, mang lại lợi ích và sự hài lòng tối đa cho khách hàng.</p>
                <p>• Đổi mới và phát triển: Electro Shop luôn cập nhật và đổi mới sản phẩm, công nghệ cũng như dịch vụ để đáp ứng nhu cầu thay đổi liên tục của thị trường và khách hàng.</p>
                <p>• Đồng hành cùng cộng đồng: Electro Shop không chỉ tập trung vào phát triển kinh doanh mà còn chú trọng đến các hoạt động xã hội, đóng góp tích cực cho sự phát triển của cộng đồng và xã hội.</p>
            </div>

            <div class="policy-section">
                <h2>4. Định hướng phát triển</h2>
                <p>Với mục tiêu “Tạo trải nghiệm xuất sắc cho khách hàng”, Electro Shop tiếp tục đẩy mạnh chuyển đổi số để ứng dụng vào công tác bán hàng, quản lý và đào tạo nhân sự... theo chiến lược tận tâm phục vụ nhằm gia tăng trải nghiệm khách hàng. Đầu tư mạnh mẽ kinh doanh trực tuyến đa nền tảng, khai thác và ứng dụng công nghệ để thấu hiểu và tiếp cận khách hàng một cách linh hoạt và hiệu quả nhất, không ngừng khẳng định vị thế là một trong những thương hiệu bán lẻ uy tín tại Việt Nam.</p>
            </div>
            <div class="policy-section">
                <h2>5. Cột mốc phát triển</h2>
                <p>• 2013: Electro Shop chính thức đạt mốc 100 cửa hàng.</p>
                <p>• 2014: Trở thành nhà nhập khẩu trực tiếp của iPhone chính hãng.</p>
                <p>• 2015: Đạt mức tăng trưởng nhanh nhất so với các công ty trực thuộc cùng Công ty Cổ phần Electro.</p>
                <p>• 2016: Doanh thu online tăng gấp đôi. Khai trương 80 khu trải nghiệm Apple corner trên toàn quốc.</p>
                <p>• 08/2024: Đồng loạt khai trương 10 cửa hàng điện máy trên toàn quốc, đánh dấu việc mở rộng lĩnh vực kinh doanh sang điện máy, gia dụng.</p>
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