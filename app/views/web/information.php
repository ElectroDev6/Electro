<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chính sách bảo mật</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 20px;
        }

        .sidebar {
            width: 280px;
            background: white;
            border-radius: 8px;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .sidebar-header {
            background: #333;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
            font-size: 16px;
        }

        .sidebar-content {
            padding: 15px 0;
        }

        .sidebar-item {
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 14px;
            color: #333;
        }

        .sidebar-item:hover {
            background-color: #f8f8f8;
        }

        .sidebar-item.active {
            background-color: #333;
            color: white;
        }

        .sidebar-item:last-child {
            border-bottom: none;
        }

        .main-content {
            flex: 1;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb {
            background: #f8f8f8;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #666;
        }

        .breadcrumb span {
            color: #333;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
        }

        .intro-text {
            color: #555;
            margin-bottom: 30px;
            text-align: justify;
            font-size: 15px;
        }

        .policy-section {
            margin-bottom: 25px;
        }

        .policy-section h2 {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .policy-section p {
            color: #555;
            margin-bottom: 12px;
            text-align: justify;
            font-size: 14px;
        }

        .policy-section ul {
            margin-left: 20px;
            margin-bottom: 15px;
        }

        .policy-section li {
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .highlight-box {
            background-color: #f8f9fa;
            border-left: 4px solid #333;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .section-divider {
            border-top: 1px solid #e9ecef;
            margin: 25px 0;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 10px;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .main-content {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                Danh mục chính sách
            </div>
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
                <div class="sidebar-item">Chính sách khui hộp sản phẩm</div>
                <div class="sidebar-item">Giới thiệu máy đổi trả</div>
                <div class="sidebar-item">Quy định hỗ trợ kỹ thuật và sao lưu dữ liệu</div>
                <div class="sidebar-item active">Chính sách bảo mật</div>
                <div class="sidebar-item">Chính sách bảo hành</div>
                <div class="sidebar-item">Chính sách bảo mật dữ liệu cá nhân khách hàng</div>
                <div class="sidebar-item">Hướng dẫn mua hàng và thanh toán online</div>
                <div class="sidebar-item">Chính sách đổi trả</div>
            </div>
        </div>

        <div class="main-content">
            <div class="breadcrumb">
                Có chủ nhà > <span>Có chủ lớn</span>
            </div>

            <h1>Chính sách bảo mật</h1>

            <div class="intro-text">
                Shop cam kết sẽ bảo mật những thông tin mang tính riêng tư của bạn. Bạn vui lòng đọc bản "Chính sách bảo mật" dưới đây để hiểu hơn những cam kết mà chúng tôi thực hiện, nhằm tôn trọng và bảo vệ quyền lợi của người truy cập.
            </div>

            <div class="policy-section">
                <h2>1. Mục đích và phạm vi thu thập?</h2>
                <p>Để truy cập và sử dụng một số dịch vụ tại, bạn có thể sẽ được yêu cầu đăng ký với chúng tôi thông tin cá nhân (Email, Họ tên, Số điện thoại liên lạc...). Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. Những thông tin trùng lặp không chịu trách nhiệm về mọi tổn thất gây nên phát sinh từ việc khai báo thông tin sai lệch.</p>
                <p>Chúng tôi cũng có thể thu thập thông tin về số lần viếng thăm, bao gồm số trang bạn xem, số links (liên kết) bạn click và những thông tin khác liên quan đến việc kết nối đến site Chúng tôi cũng thu thập các thông tin mà trình duyệt Web (Browser) bạn sử dụng khi truy cập vào , bao gồm: địa chỉ IP, loại Browser, ngôn ngữ sử dụng, thời gian và những địa chỉ mà Browser truy xuất đến.</p>
            </div>

            <div class="section-divider"></div>

            <div class="policy-section">
                <h2>2. Phạm vi sử dụng thông tin?</h2>
                <p>Thư thập và sử dụng thông tin cá nhân bạn với mục đích phù hợp và hoàn toàn tuân thủ nội dung của "Chính sách bảo mật" này.</p>
                <p>Khi cần thiết, chúng tôi có thể sử dụng những thông tin này để liên hệ trực tiếp với bạn dưới các hình thức như: gởi thư ngỏ, đơn đặt hàng, thư cảm ơn, sms, thông tin về kỹ thuật và bảo mật...</p>
            </div>

            <div class="section-divider"></div>

            <div class="policy-section">
                <h2>3. Thời gian lưu trữ thông tin?</h2>
                <p>Dữ liệu cá nhân của Thành viên sẽ được lưu trữ cho đến khi có yêu cầu hủy bỏ hoặc tự thành viên đăng nhập và thực hiện hủy bỏ. Còn lại trong mọi trường hợp thông tin cá nhân thành viên sẽ được bảo mật.</p>
            </div>

            <div class="section-divider"></div>

            <div class="policy-section">
                <h2>4. Quy định bảo mật?</h2>
                <p>Chính sách giao dịch thanh toán bằng thẻ quốc tế và thẻ nội địa (internet banking) đảm bảo tuân thủ các tiêu chuẩn bảo mật của các Đối Tác Cổng Thanh Toán gồm:</p>
                <p>Thông tin tài chính của Khách hàng sẽ được bảo vệ trong suốt quá trình giao dịch bằng giao thức SSL 256-bit (Secure Sockets Layer).</p>
                <p>Mật khẩu sử dụng một lần (OTP) được gửi qua SMS để đảm bảo việc truy cập tài khoản được xác thực.</p>
                <p>Các nguyên tắc và quy định bảo mật thông tin trong ngành tài chính ngân hàng theo quy định của Ngân hàng nhà nước Việt Nam.</p>
                <p>Chúng tôi chỉ lưu trữ thông tin cá nhân giao dịch trên trang của ngân hàng. Thông tin tài khoản, mật khẩu sẽ không được lưu trên Server của Shop.</p>
                <p>Đội Tác Cổng Thanh Toán sẽ lưu giữ và bảo mật theo tiêu chuẩn quốc tế PCI DSS.</p>
                <p>Đối với thẻ thanh toán quốc tế: Chúng tôi chỉ lưu trữ mã đơn hàng, mã giao dịch và tên ngân hàng. Shop cam kết đảm bảo thực hiện nghiêm túc các biện pháp bảo mật cần thiết cho mọi hoạt động thanh toán thực hiện trên trang.</p>
            </div>

            <div class="section-divider"></div>

            <div class="policy-section">
                <h2>5. Làm cách nào để yêu cầu xóa dữ liệu?</h2>
                <p>Bạn có thể gửi yêu cầu xóa dữ liệu qua email Trung tâm hỗ trợ của chúng tôi hoặc cùng cấp càng nhiều thông tin càng tốt về dữ liệu bạn muốn xóa. Yêu cầu sẽ được chuyển đến nhóm thích hợp để đánh giá và xử lý. Chúng tôi sẽ liên hệ từng bước để cập nhật cho bạn về tiến trình xóa.</p>
            </div>
        </div>
    </div>

    <script>
        // Thêm hiệu ứng hover cho sidebar items
        document.querySelectorAll('.sidebar-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
            });
        });

        // Smooth scroll effect for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>