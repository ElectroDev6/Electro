<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <div class="h2">
        <title>Chính sách khui hộp sản phẩm</title>
    </div>
    <link rel="stylesheet" href="css/information.css" />
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">Danh mục chính sách</div>
            <div class="sidebar-content">
                <div class="sidebar-item">Câu hỏi thường gặp</div>
                <div class="sidebar-item">Giới thiệu về Shop</div>
                <div class="sidebar-item">Đại lý ủy quyền và TTBH ủy quyền của Apple</div>
                <div class="sidebar-item">Chính sách mạng di động</div>
                <div class="sidebar-item">Chính sách gói cước di động</div>
                <div class="sidebar-item">Danh sách điểm cung cấp dịch vụ viễn thông</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy</div>
                <div class="sidebar-item">Chính sách giao hàng & lắp đặt Điện máy chi bán</div>
                <div class="sidebar-item">Chính sách khách hàng thân thiết tại Shop</div>
                <div class="sidebar-item active">Chính sách khui hộp sản phẩm</div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item">Quy định hỗ trợ kỹ thuật và sao lưu dữ liệu</div>
                <div class="sidebar-item">Chính sách bảo mật</div>
                <div class="sidebar-item">Chính sách đổi trả và bảo hành tiêu chuẩn</div>
                <div class="sidebar-item">Chính sách bảo mật dữ liệu cá nhân khách hàng</div>
                <div class="sidebar-item">Hướng dẫn mua hàng và thanh toán online</div>
                <div class="sidebar-item">Chính sách đổi trả</div>
            </div>
        </div>

        <div class="main-content">
            <div class="breadcrumb">Trang chủ> <span>Chính sách khui hộp sản phẩm</span></div>
            <h1>Chính sách khui hộp sản phẩm</h1>
            <div class="intro-text">

            </div>

            <div class="policy-section">
                <p>Áp dụng cho các sản phẩm bán ra tại Electro bao gồm ĐTDĐ, MT, MTB, Đồng hồ thông minh.</p>
                <h2>Nội dung chính sách:</h2>
                <p>Sản phẩm bắt buộc phải khui seal/mở hộp và kích hoạt bảo hành điện tử (Active) ngay tại shop hoặc ngay tại thời điểm nhận hàng khi có nhân viên giao hàng tại nhà.
                    Đối với các sản phẩm bán nguyên seal khách hàng cần phải thanh toán trước 100% giá trị đơn hàng trước khi khui seal sản phẩm. </p>
                <h2>Lưu ý:</h2>
                <p>Trước khi kích hoạt bảo hành điện tử (Active) sản phẩm khách hàng cần kiểm tra các lỗi ngoại quan của sản phẩm (Cấn_Trầy thân máy, bụi trong camera, bụi màn hình, hở viền…). Nếu phát hiện các lỗi trên khách hàng sẽ được đổi 1 sản phẩm khác hoặc hoàn tiền.

                    Ngay sau khi kiểm tra lỗi ngoại quan, tiến hành bật nguồn để kiểm tra đến lỗi kỹ thuật; nếu sản phẩm có lỗi kỹ thuật của nhà sản xuất khách hàng sẽ được đổi 1 sản phẩm mới tương đương tại Electron.

                    Nếu quý khách báo lỗi ngoại quan sau khi sản phẩm đã được kích hoạt bảo hành điện tử (Active) hoặc sau khi nhân viên giao hàng rời đi Electron chỉ hỗ trợ chuyển sản phẩm của khách hàng đến hãng để thẩm định và xử lý. </p>
                <img src="https://cdn2.fptshop.com.vn/unsafe/chinh_sach_khui_hop_97039e3365.jpg" alt="Loyalty Program" class="loyalty-image">
                <h2>Một số hình ảnh sản phẩm bị lỗi thẩm mỹ.</h2>
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
</body>

</html>