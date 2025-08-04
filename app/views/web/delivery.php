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
                <div class="sidebar-item"><a href="client">Chính sách khách hàng thân thiết tại Shop</a></div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item"><a href="refund">Chính sách đổi trả và bảo hành tiêu chuẩn</a></div>
                <div class="sidebar-item"><a href="repair">Chính sách khui hộp sản phẩm</a></div>
                <div class="sidebar-item"><a href="information">Chính sách bảo mật</a></div>
                <div class="sidebar-item">Chính sách bảo hành</div>
                <div class="sidebar-item active"><a href="delivery">Chính sách bảo mật dữ liệu cá nhân khách hàng</a></div>
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
            <div class="breadcrumb">Trang chủ> <span>Chính sách bảo mật dữ liệu cá nhân khách hàng </span></div>
            <h1>Chính sách bảo mật dữ liệu cá nhân khách hàng</h1>
            <div class="policy-section">
                <p>Chính sách bảo mật dữ liệu cá nhân khách hàng (“Chính sách”) này được thực hiện bởi Công ty Cổ phần Bán lẻ Kỹ thuật số FPT (“FRT”, “Công ty”), mô tả các hoạt động liên quan đến việc xử lý dữ liệu cá nhân của Khách hàng để Khách hàng hiểu rõ hơn về mục đích, phạm vi thông tin mà FRT xử lý, các biện pháp FRT áp dụng để bảo vệ thông tin và quyền của Quý Khách hàng đối với các hoạt động này.

                    Chính sách này là một phần không thể tách rời của các hợp đồng, thỏa thuận, điều khoản và điều kiện ràng buộc mối quan hệ giữa FRT và Khách hàng.</p>
            </div>
            <div class="policy-section">
                <h2>Điều 1. Đối tượng và phạm vi áp dụng</h2>
                <p><strong>1.1.</strong> Chính sách này điều chỉnh cách thức mà FRT xử lý dữ liệu cá nhân của Khách hàng và những người có liên quan đến Khách hàng theo các mối quan hệ do pháp luật yêu cầu phải xử lý dữ liệu hoặc người đồng sử dụng các sản phẩm/ dịch vụ của FRT với khách hàng khi sử dụng hoặc tương tác với trang tin điện tử hoặc/và các sản phẩm/ dịch vụ của FRT.</p>
                <p><strong>1.2.</strong>Để tránh nhầm lẫn, Chính sách này chỉ áp dụng cho các Khách hàng cá nhân. FRT khuyến khích Khách hàng đọc kỹ Chính sách này và thường xuyên kiểm tra trang tin điện tử để cập nhật bất kỳ thay đổi nào mà FRT có thể thực hiện theo các điều khoản của Chính sách.</p>
            </div>
            <div class="policy-section">
                <h2>Điều 2. Giải thích từ ngữ</h2>
                <p><strong>1.1. “Khách hàng”</strong> là cá nhân tiếp cận, tìm hiểu, đăng ký, sử dụng hoặc có liên quan trong quy trình hoạt động, cung cấp các sản phẩm, dịch vụ của FRT.</p>
                <p><strong> 1.2. “FRT”</strong> là Công ty Cổ phần Bán lẻ Kỹ thuật số FPT, mã số thuế 0311609355, địa chỉ trụ sở chính: 261 - 263 Khánh Hội, Phường 02, Quận 04, TP. Hồ Chí Minh, Việt Nam.</p>
                <p><strong> 1.3. “Dữ liệu cá nhân” </strong>hay<strong> “DLCN” </strong>là thông tin dưới dạng ký hiệu, chữ viết, chữ số, hình ảnh, âm thanh hoặc dạng tương tự trên môi trường điện tử gắn liền với một con người cụ thể hoặc giúp xác định một con người cụ thể. Dữ liệu cá nhân bao gồm dữ liệu cá nhân cơ bản và dữ liệu cá nhân nhạy cảm.</p>
                <h2>1.4. Dữ liệu cá nhân cơ bản bao gồm:</h2>
                <p><strong>(a) </strong> Họ, chữ đệm và tên khai sinh, tên gọi khác (nếu có);</p>
                <p><strong>(b) </strong>Ngày, tháng, năm sinh; ngày, tháng, năm chết hoặc mất tích;</p>
                <p><strong>(c) </strong>Giới tính;</p>
                <p><strong>(d) </strong>Nơi sinh, nơi đăng ký khai sinh, nơi thường trú, nơi tạm trú, nơi ở hiện tại, quê quán, địa chỉ liên hệ;</p>
                <p><strong>(e) </strong>Quốc tịch;</p>
                <p><strong>(f) </strong>Hình ảnh của cá nhân;</p>
                <p><strong>(g) </strong>Số điện thoại, số chứng minh nhân dân, số định danh cá nhân, số hộ chiếu, số giấy phép lái xe, số biển số xe, số mã số thuế cá nhân, số bảo hiểm xã hội, số thẻ bảo hiểm y tế;</p>
                <p><strong>(h) </strong>Tình trạng hôn nhân;</p>
                <p><strong>(i) </strong>Thông tin về mối quan hệ gia đình (cha mẹ, con cái);</p>
                <p><strong>(j) </strong>Thông tin về tài khoản số của cá nhân; dữ liệu cá nhân phản ánh hoạt động, lịch sử hoạt động trên không gian mạng;</p>
                <p><strong>(k) </strong>Các thông tin khác gắn liền với một con người cụ thể hoặc giúp xác định một con người cụ thể không thuộc Dữ liệu cá nhân nhạy cảm.</p>
                <p><strong>(l) </strong>Các dữ liệu khác theo quy định pháp luật hiện hành</p>
                <p><strong>2.5.</strong> Dữ liệu cá nhân nhạy cảm là dữ liệu cá nhân gắn liền với quyền riêng tư của cá nhân mà khi bị xâm phạm sẽ gây ảnh hưởng trực tiếp tới quyền và lợi ích hợp pháp của cá nhân gồm:</p>
                <p><strong>(a) </strong>Quan điểm chính trị, quan điểm tôn giáo;</p>
                <p><strong>(b) </strong>Tình trạng sức khỏe và đời tư được ghi trong hồ sơ bệnh án, không bao gồm thông tin về nhóm máu;</p>
                <p><strong>(c) </strong> Thông tin liên quan đến nguồn gốc chủng tộc, nguồn gốc dân tộc;</p>
                <p><strong>(d) </strong> Thông tin về đặc điểm di truyền được thừa hưởng hoặc có được của cá nhân;</p>
                <p><strong>(e) </strong>Thông tin về thuộc tính vật lý, đặc điểm sinh học riêng của cá nhân;</p>
                <p><strong>(f) </strong>Thông tin về đời sống tình dục, xu hướng tình dục của cá nhân;</p>
                <p><strong>(g) </strong>Dữ liệu về tội phạm, hành vi phạm tội được thu thập, lưu trữ bởi các cơ quan thực thi pháp luật;</p>
                <p><strong>(h) </strong>Thông tin khách hàng của tổ chức tín dụng, chi nhánh ngân hàng nước ngoài, tổ chức cung ứng dịch vụ trung gian thanh toán, các tổ chức được phép khác, gồm: thông tin định danh khách hàng theo quy định của pháp luật, thông tin về tài khoản, thông tin về tiền gửi, thông tin về tài sản gửi, thông tin về giao dịch, thông tin về tổ chức, cá nhân là bên bảo đảm tại tổ chức tín dụng, chi nhánh ngân hàng, tổ chức cung ứng dịch vụ trung gian thanh toán;</p>
                <p><strong>(i) </strong>Dữ liệu về vị trí của cá nhân được xác định qua dịch vụ định vị;</p>
                <p><strong>(j) </strong> Dữ liệu cá nhân khác được pháp luật quy định là đặc thù và cần có biện pháp bảo mật cần thiết.</p>
                <p><strong>2.6.</strong>Bảo vệ dữ liệu cá nhân: là hoạt động phòng ngừa, phát hiện, ngăn chặn, xử lý hành vi vi phạm liên quan đến dữ liệu cá nhân theo quy định của pháp luật.</p>
                <p><strong>2.7.</strong>Xử lý dữ liệu cá nhân: là một hoặc nhiều hoạt động tác động tới dữ liệu cá nhân, như: thu thập, ghi, phân tích, xác nhận, lưu trữ, chỉnh sửa, công khai, kết hợp, truy cập, truy xuất, thu hồi, mã hóa, giải mã, sao chép, chia sẻ, truyền đưa, cung cấp, chuyển giao, xóa, hủy dữ liệu cá nhân hoặc các hành động khác có liên quan.</p>
                <p><strong>2.8.</strong>Bên thứ ba: là tổ chức, cá nhân khác ngoài FRT và Khách hàng đã được giải thích theo Chính sách này. Để làm rõ hơn, các từ ngữ nào chưa được giải thích tại Điều này sẽ được hiểu và áp dụng theo pháp luật Việt Nam.</p>
                <p><strong>2.9.</strong>Kênh giao dịch FRT: gồm các kênh giao dịch điện tử (website fptshop.com.vn; frt.vn; fstudiobyfpt.com.vn; f-care.com.vn; zalo; …) hoặc các kênh giao dịch khác nhằm cung cấp sản phẩm/ dịch vụ hoặc để phục vụ nhu cầu của FRT và khách hàng.</p>

            </div>
            <div class="policy-section">
                <h2>Điều 3. Mục đích xử lý dữ liệu cá nhân của Khách hàng</h2>
                <p><strong>3.1.</strong> Khách hàng đồng ý cho phép FRT xử lý dữ liệu cá nhân của khách hàng cho một hoặc nhiều mục đích sau đây:</p>
                <p><strong>(a) </strong> Cung cấp sản phẩm hoặc dịch vụ hoặc hỗ trợ khách hàng sử dụng các sản phẩm/ dịch vụ của Công ty và/ hoặc Đối tác của Công ty thông qua thỏa thuận hợp tác được Khách hàng yêu cầu;</p>
                <p><strong>(b) </strong>Thực hiện các hoạt động nhằm chăm sóc khách hàng và thực hiện các chương trình hậu mãi sau bán hàng;</p>
                <p><strong>(c) </strong>Điều chỉnh, cập nhật, bảo mật và cải tiến các sản phẩm, dịch vụ, ứng dụng, thiết bị mà FRT hoặc công ty con của FRT đang cung cấp cho Khách hàng;</p>
                <p><strong>(d) </strong>Xác minh danh tính và đảm bảo tính bảo mật thông tin cá nhân của Khách hàng;</p>
                <p><strong>(e) </strong>Đáp ứng các yêu cầu dịch vụ và nhu cầu hỗ trợ của Khách hàng;</p>
                <p><strong>(f) </strong>Thông báo cho Khách hàng về những thay đổi đối với các chính sách, khuyến mại của các sản phẩm, dịch vụ mà Công ty đang cung cấp;</p>
                <p><strong>(g) </strong>Đo lường, phân tích dữ liệu nội bộ và các xử lý khác để cải thiện, nâng cao chất lượng dịch vụ/sản phẩm của Công ty hoặc thực hiện các hoạt động truyền thông tiếp thị;</p>
                <p><strong>(h) </strong>Tổ chức các hoạt động nghiên cứu thị trường, thăm dò dư luận nhằm cải thiện chất lượng sản phẩm/ dịch vụ hoặc để nghiên cứu phát triển các sản phẩm, dịch vụ mới nhằm đáp ứng tốt hơn nhu cầu của khách hàng;</p>
                <p><strong>(i) </strong>Ngặn chặn và phòng chống gian lận, đánh cắp danh tính và các hoạt động bất hợp pháp khác;</p>
                <p><strong>(j) </strong>Để có cơ sở thiết lập, thực thi các quyền hợp pháp hoặc bảo vệ các khiếu nại pháp lý của FRT, Khách hàng hoặc bất kỳ cá nhân nào. Các mục đích này có thể bao gồm việc trao đổi dữ liệu với các công ty và tổ chức khác để ngăn chặn và phát hiện gian lận, giảm rủi ro về tín dụng;</p>
                <p><strong>(k) </strong>Tuân thủ pháp luật hiện hành, các tiêu chuẩn ngành có liên quan và các chính sách hiện hành khác của Công ty;</p>
                <p><strong>(l) </strong>Bất kỳ mục đích nào khác dành riêng cho hoạt động vận hành của Công ty;</p>
                <p><strong>(m) </strong>Cung cấp thông tin cho Tập đoàn FPT, các công ty liên kết, các công ty con nhằm thực hiện các mục đích nêu trên và với điều kiện bên nhận thông tin sẽ bị ràng buộc bởi các điều khoản bảo mật nghiêm ngặt giống như các điều khoản trong tài liệu này;</p>
                <p><strong>(n) </strong>Bất kỳ mục đích nào khác mà FRT thông báo cho Khách hàng, vào thời điểm thu thập dữ liệu cá nhân của Khách hàng hoặc trước khi bắt đầu xử lý liên quan hoặc theo yêu cầu khác hoặc được pháp luật hiện hành cho phép; và</p>
                <p><strong>3.2. </strong>FRT sẽ yêu cầu sự cho phép của Khách hàng trước khi sử dụng dữ liệu cá nhân của Khách hàng theo bất kỳ mục đích nào khác ngoài các mục đích đã được nêu tại Điều 3.1 trên, vào thời điểm thu thập dữ liệu cá nhân của Khách hàng hoặc trước khi bắt đầu xử lý liên quan hoặc theo yêu cầu khác hoặc được pháp luật hiện hành cho phép.</p>
            </div>
            <div class="policy-section">
                <h2>Điều 4. Bảo mật Dữ liệu cá nhân khách hàng</h2>
                <h2><strong>4.1. </strong>Nguyên tắc bảo mật:</h2>
                <p><strong>(a) </strong>Dữ liệu cá nhân của Khách hàng được cam kết bảo mật theo quy định của FRT và quy định của pháp luật. Việc xử lý Dữ liệu cá nhân của mỗi Khách hàng chỉ được thực hiện khi có sự đồng ý của Khách hàng, trừ trường hợp pháp luật có quy định khác.</p>
                <p><strong>(b) </strong>FRT không sử dụng, chuyển giao, cung cấp hay chia sẻ cho bên thứ ba nào về Dữ liệu cá nhân của Khách hàng khi không có sự đồng ý của Khách hàng, trừ trường hợp pháp luật có quy định khác.</p>
                <p><strong>(c) </strong>FRT sẽ tuân thủ các nguyên tắc bảo mật dữ liệu cá nhân khác theo quy định pháp luật hiện hành.</p>
                <h2>4.2.Hậu quả, thiệt hại không mong muốn có thể xảy ra:</h2>
                <p>FRT sử dụng nhiều công nghệ bảo mật thông tin khác nhau nhằm bảo vệ Dữ liệu cá nhân của Khách hàng không bị truy lục, sử dụng hoặc chia sẻ ngoài ý muốn. Tuy nhiên, không một dữ liệu nào có thể được bảo mật 100%. Do vậy, FRT cam kết sẽ bảo mật một cách tối đa trong khả năng cho phép Dữ liệu cá nhân của Khách hàng. Một số hậu quả, thiệt hại không mong muốn có thể xảy ra bao gồm nhưng không giới hạn:</p>
                <p><strong>(a) </strong>Lỗi phần cứng, phần mềm trong quá trình xử lý dữ liệu làm mất dữ liệu của Khách hàng;</p>
                <p><strong>(b) </strong>Lỗ hổng bảo mật nằm ngoài khả năng kiểm soát của FRT, hệ thống có liên quan bị hacker tấn công gây lộ lọt dữ liệu;</p>
                <p><strong>(c) </strong>Khách hàng tự làm lộ lọt dữ liệu cá nhân do: bất cẩn hoặc bị lừa đảo truy cập các website/tải các ứng dụng có chứa phần mềm độc hại, vv...</p>
                <p><strong>4.3. </strong>FRT khuyến cáo Khách hàng bảo mật các thông tin liên quan đến mật khẩu đăng nhập vào tài khoản của Khách hàng, mã OTP và không chia sẻ mật khẩu đăng nhập, mã OTP này với bất kỳ người nào khác.</p>
                <p><strong>4.4. </strong>Khách hàng nên bảo quản thiết bị điện tử trong quá trình sử dụng; Khách hàng nên khóa, đăng xuất, hoặc thoát khỏi tài khoản trên website hoặc Ứng dụng của FRT khi không sử dụng.</p>
            </div>
            <div class="policy-section">
                <h2>Điều 5. Các loại dữ liệu cá nhân mà FRT xử lý</h2>
                <p>Để FRT có thể cung cấp các sản phẩm, dịch vụ cho Khách hàng và/hoặc xử lý các yêu cầu của Khách hàng, FRT có thể cần phải và/hoặc được yêu cầu phải thu thập dữ liệu cá nhân, bao gồm:</p>
                <p><strong>(a)</strong> Dữ liệu cá nhân cơ bản của Khách hàng và các cá nhân có liên quan của Khách hàng;</p>
                <p><strong>(b) </strong>Dữ liệu cá nhân nhạy cảm của Khách hàng và các cá nhân có liên quan của Khách hàng;</p>
                <p><strong>(c) </strong>Dữ liệu liên quan đến các trang tin điện tử hoặc ứng dụng: dữ liệu kỹ thuật (như đã nêu ở trên, bao gồm loại thiết bị, hệ điều hành, loại trình duyệt, cài đặt trình duyệt, địa chỉ IP, cài đặt ngôn ngữ, ngày và giờ kết nối với trang tin điện tử, thống kê sử dụng ứng dụng, cài đặt ứng dụng, ngày và giờ kết nối với ứng dụng, dữ liệu vị trí và thông tin liên lạc kỹ thuật khác); chi tiết đăng nhập bảo mật; dữ liệu sử dụng;</p>
                <p><strong>(d) </strong>Dữ liệu tiếp thị: các mối quan tâm đối với quảng cáo; dữ liệu cookie; dữ liệu clickstream; lịch sử duyệt web; phản ứng với tiếp thị trực tiếp; và lựa chọn không tham gia tiếp thị trực tiếp.</p>
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