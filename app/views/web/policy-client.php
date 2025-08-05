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
                <div class="sidebar-item"><a href="customer">Chính sách giao hàng & lắp đặt</a></div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chỉ bán</div>
                <div class="sidebar-item active"><a href="client">Chính sách khách hàng thân thiết tại Shop</a></div>
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
            <div class="breadcrumb">Trang chủ><span>Chính sách Chương trình Khách hàng thân thiết tại Shop</span></div>
            <h1>Chính sách Chương trình Khách hàng thân thiết tại Shop</h1>
            <div class="intro-text"></div>

            <div class="policy-section">
                <h2>1. Tổng quan</h2>
                <p> "Chương trình khách hàng thân thiết” là chương trình ưu đãi dành riêng cho Khách hàng thân thiết của chuỗi cửa hàng trực thuộc Công ty cổ phần bán lẻ kỹ thuật số ( Retail) bao gồm:
                <p> • Chuỗi cửa hàng Shop</p>
                <p> • Chuỗi cửa hàng thương hiệu (F.Studio, S.Studio, Garmin...)</p>
                <p> • Công ty Cổ phần Dược phẩm Long Châu</p>
                <p> • Tiêm chủng Long Châu </p>
            </div>

            <div class="policy-section">
                <h2>2. Đối tượng áp dụng</h2>
                <p>Chỉ áp dụng cho các khách hàng cá nhân, không áp dụng cho khách hàng bán buôn hoặc mua số lượng lớn phục vụ cho doanh nghiệp hoặc đơn hàng nằm trong chương trình ưu đãi dành riêng cho đối tác/dự án/xuất hoá đơn công ty.</p>
                <h2>3. Phạm vị áp dụng</h2>
                <p>Áp dụng cho khách hàng mua hàng trực tiếp tại hệ thống cửa hàng hoặc trên các kênh bán hàng trực tuyến chính thức của chuỗi cửa hàng trực thuộc Công ty cổ phần bán lẻ kỹ thuật số bao gồm:</p>
                <p> • Chuỗi cửa hàng Shop</p>
                <p> • Chuỗi cửa hàng thương hiệu (F.Studio, S.Studio, Garmin...)</p>
                <p> • Công ty Cổ phần Dược phẩm Long Châu</p>
                <p> • Tiêm chủng Long Châu</p>
            </div>
            <div class="policy-section">
                <h2>4. Thời gian diễn ra Chương trình</h2>
                <p>Từ ngày 05/01/2024 có thể thay đổi và sẽ cập nhật khi đang diễn ra chương trình.</p>
            </div>
            <div class="policy-section">
                <h2>5. Chi tiết cách thức và thể lệ tham gia chương trình tại Shop và chuỗi cửa hàng thương hiệu (F.Studio, S.Studio, Garmin...) như sau:</h2>
                <h2>5.1. Thể lệ</h2>
                <p>
                    • Điểm thưởng được tích lũy dựa trên giá trị hóa đơn hàng hóa/dịch vụ của hệ thống bán lẻ Shop (không bao gồm các dịch vụ thu hộ, dịch vụ Shop bán hàng thay cho đối tác không ghi nhận doanh thu trực tiếp Shop, đơn hàng nằm trong chương trình ưu đãi dành riêng cho đối tác/dự án/xuất hoá đơn công ty) và từ hệ thống nhà thuốc Long Châu cùng Tiêm chủng Long Châu.
                     
                    • Cứ mỗi 4.000 đồng trên hóa đơn thanh toán, khách hàng sẽ được tích 01 điểm thưởng. Số điểm thưởng được tích sẽ dựa vào giá trị cuối cùng của hóa đơn khách hàng thanh toán. Ví dụ: Giá trị đơn hàng là 500.000 đồng, khách hàng có áp dụng mã khuyến mãi 100.000 đồng. Giá trị hóa đơn khách hàng cần thanh toán là 400.000 đồng và khách hàng sẽ được tích 100 điểm.
                     
                    • Từ ngày 01/11/2024, khách hàng có thể quy đổi điểm thưởng thành ưu đãi giảm giá với 2 mức giá trị đơn hàng như sau:
                    - Đối với những đơn hàng dưới 1.000.000 đồng, khách hàng sẽ được giảm tối đa 200.000 đồng (tương đương với mức 20.000 điểm).
                    - Đối với những đơn hàng từ 1.000.000 đồng trở lên, khách hàng có thể quy đổi điểm thưởng với mức tối đa 20% giá trị đơn hàng.
                     
                    • Khách hàng cần đổi tối thiểu từ 50 điểm để có thể quy đổi thành Voucher, 1 điểm thưởng = 10 đồng
                    ** Ưu đãi được nhận khi tích đủ điểm
                    Khách hàng khi tích đủ mức điểm sẽ đổi được suất mua đặc quyền với giá 1.000 đồng theo 4 mốc điểm 1.000/3.000/8.000/15.000 tại đây.
                    Mỗi suất mua đặc quyền có hạn sử dụng 30 ngày kể từ ngày đổi.
                    Lưu ý: Điểm đã đổi thành suất mua đặc quyền khi hết hạn thì không hoàn lại.
                    Trường hợp 1: Khách hàng mua trên website
                    * Khách hàng chọn sản phẩm và nhấn “mua ngay” hoặc thêm vào giỏ hàng.
                    * Tại màn hình giỏ hàng, bật toggle đổi điểm.
                     </p>
            </div>
            <img src="https://cdn2.fptshop.com.vn/unsafe/tieu_diem_d47e51879c_2fd4016432.jpg" alt="Loyalty Program" class="loyalty-image">

            <p>Điểm được đổi thành ưu đãi giảm giá sẽ được cộng dồn vào tổng khuyến mại.</p>
            <img src="https://cdn2.fptshop.com.vn/unsafe/tieu_diem_2_df7ec5671c_0ff5563d86.jpg" alt="Loyalty Program" class="loyalty-image">
            <p>Xác nhận đơn hàng và thanh toán để hoàn tất đặt đơn.</p>
            <div class="policy-section">
                <h2>Trường hợp 2:Khách hàng mua hàng qua tổng đài hoặc mua hàng trực tiếp tại Shop:</h2>
                <p>Quý khách liên hệ nhân viên shop hoặc nhân viên tư vấn để được hỗ trợ trực tiếp.
                    Chi tiết cách thức và thể lệ tham gia chương trình tại nhà thuốc Long Châu và Trung tâm tiêm chủng Long Châu tham khảo</p>
            </div>
            <div class="policy-section">
                <h2>6. Các quy định khác</h2>
                <h2>6.1. Quy định về số dư điểm/Hết hạn điểm</h2>
                <p>• Khi điểm thưởng được sử dụng để đổi điểm thưởng thành ưu đãi thì số điểm thưởng có thời gian hết hạn gần nhất sẽ được tự động ưu tiên dùng trước để bảo toàn lợi ích cho khách hàng.</p>
                <p> • Khách hàng vui lòng kiểm tra thời hạn sử dụng của điểm thưởng để mau chóng sử dụng, tránh trường hợp điểm thưởng hết hạn.</p>
                <p> • Khách hàng vui lòng kiểm tra thời hạn sử dụng của điểm thưởng để mau chóng sử dụng, tránh trường hợp điểm thưởng hết hạn.</p>
                <p> • Điểm thưởng có hạn sử dụng trong vòng 12 tháng kể từ lúc tích điểm và hết hạn vào ngày cuối cùng của tháng.</p>
                <p> Ví dụ: Điểm thưởng được tích vào ngày 24/09/2023 sẽ hết hạn vào ngày 30/09/2024.</p>
                <p> • Khách hàng vui lòng kiểm tra thời hạn sử dụng của điểm thưởng để mau chóng sử dụng, tránh trường hợp điểm thưởng hết hạn.</p>
                <p> • Điểm thưởng được tích tại mỗi thời điểm khác nhau sẽ có thời hạn sử dụng khác nhau.</p>
            </div>
            <div class="policy-section">
                <h2>6.2. Quy định về khấu trừ/Hủy điểm</h2>
                <p>• Sau khi khách hàng tiến hành đổi điểm thưởng thành ưu đãi, Shop sẽ khấu trừ các điểm thưởng đã được tích trong hệ thống.</p>
                <p> • Các trường hợp trả sản phẩm sau khi đã được tích điểm, với mỗi giá trị trả là 4.000 đồng, khách hàng sẽ bị giảm 01 điểm thưởng trong hệ thống.</p>
            </div>
            <div class="policy-section">
                <h2>6.3. Các quy định khác</h2>
                <p>• Khi tham gia chương trình, khách hàng hiểu rằng phía Shop có quyền quyết định, hạn chế, tạm ngưng, thu hồi, thay đổi các quy định liên quan của một phần hoặc toàn bộ Chương trình hoặc chấm dứt Chương trình theo quy định của pháp luật.</p>
                <p> • Việc kết thúc chương trình sẽ có hiệu lực trong ngày ghi trong thông báo và khách hàng phải sử dụng điểm đã tích để đổi quà tặng trong thời hạn này (nếu đủ điểm đổi quà tặng). Sau thời gian này, toàn bộ điểm tích lũy chưa đổi quà tặng sẽ không được giải quyết.</p>
                <p> • Thể lệ và thời gian diễn ra chương trình có thể được thay đổi mà không cần thông báo trước.</p>
                <p> • Tất cả các thắc mắc và khiếu nại về chương trình, vui lòng liên hệ với chúng tôi qua hotline: 18006601 (miễn phí).</p>
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