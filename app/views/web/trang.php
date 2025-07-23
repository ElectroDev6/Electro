<?php

/**
 * Electro Shop Footer Component
 * File: includes/footer.php
 */

class ElectroFooter
{

    private $contactInfo;
    private $companyInfo;
    private $socialLinks;

    public function __construct()
    {
        $this->initializeData();
    }

    private function initializeData()
    {
        $this->contactInfo = [
            'sales_hotline' => '1800.6601',
            'support_hotline' => '1800.5601',
            'complaint_hotline' => '1800.6777',
            'working_hours' => '8h00 - 22h00'
        ];

        $this->companyInfo = [
            'name' => 'Công ty TNHH Electro Việt Nam',
            'license' => 'Giấy chứng nhận đăng ký kinh doanh số: 0315687679 do Sở Kế hoạch & Đầu tư TP.HCM cấp ngày 22/08/2025',
            'email' => 'ceo@electro.com',
            'phone' => '1900.6777',
            'address' => 'Địa chỉ trụ sở: 50/72 Gò Dầu, Phường Tân Quý, Quận Tân Phú, TP. Hồ Chí Minh'
        ];

        $this->socialLinks = [
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'tiktok' => '#'
        ];
    }

    public function getAboutUsLinks()
    {
        return [
            'Giới thiệu về công ty' => '/about',
            'Quy chế hoạt động' => '/regulations',
            'Dự án Doanh nghiệp' => '/enterprise',
            'Tin tức khuyến mại' => '/news',
            'Giới thiệu máy đổi trả' => '/exchange-machine',
            'Hướng dẫn mua hàng & thanh toán online' => '/purchase-guide',
            'Đại lý ủy quyền và TTBH ủy quyền của Apple' => '/apple-authorized',
            'Tra cứu hoá đơn điện tử' => '/invoice-lookup',
            'Tra cứu bảo hành' => '/warranty-lookup',
            'Câu hỏi thường gặp' => '/faq'
        ];
    }

    public function getPolicyLinks()
    {
        return [
            'Chính sách bảo hành' => '/warranty-policy',
            'Chính sách đổi trả' => '/return-policy',
            'Chính sách bảo mật' => '/privacy-policy',
            'Chính sách trả góp' => '/installment-policy',
            'Chính sách khui hộp sản phẩm' => '/unboxing-policy',
            'Chính sách giao hàng & lắp đặt' => '/delivery-policy',
            'Chính sách mạng di động Electro' => '/mobile-policy',
            'Chính sách thu thập & xử lý dữ liệu cá nhân' => '/data-policy',
            'Quy định về hỗ trợ kỹ thuật & sao lưu dữ liệu' => '/technical-support',
            'Chính sách giao hàng & lắp đặt Điện máy, Gia dụng' => '/appliance-delivery',
            'Chính sách chương trình khách hàng thân thiết' => '/loyalty-program'
        ];
    }

    public function getPaymentMethods()
    {
        return [
            'visa' => 'Visa',
            'mastercard' => 'Mastercard',
            'jcb' => 'JCB',
            'amex' => 'American Express',
            'vnpay' => 'VNPay',
            'zalopay' => 'ZaloPay',
            'napas' => 'Napas',
            'kredivo' => 'Kredivo',
            'momo' => 'MoMo',
            'applepay' => 'Apple Pay',
            'samsungpay' => 'Samsung Pay',
            'googlepay' => 'Google Pay'
        ];
    }

    public function getCertifications()
    {
        return [
            'dmca' => 'DMCA Protected',
            'ssl' => 'SSL Secured',
            'bct' => 'Bộ Công Thương'
        ];
    }

    public function render()
    {
        $aboutLinks = $this->getAboutUsLinks();
        $policyLinks = $this->getPolicyLinks();
        $paymentMethods = $this->getPaymentMethods();
        $certifications = $this->getCertifications();

        ob_start();
?>
        <footer class="electro-footer">
            <div class="footer-top">
                <div class="container">
                    <div class="footer-header">
                        <h2>Hệ thống Electro Shop trên toàn quốc</h2>
                        <p>Bao gồm Cửa hàng chính hãng, Trung tâm bảo hành và hệ thống chi nhánh toàn quốc.</p>
                    </div>
                </div>
            </div>

            <div class="footer-main">
                <div class="container">
                    <div class="footer-grid">
                        <!-- Electro Brand & Contact -->
                        <div class="footer-col footer-brand">
                            <div class="brand-logo">
                                <h3>Electro.</h3>
                                <p>Electro là nhà bán lẻ hàng đầu với mục tiêu tạo sự khác biệt từ chính mình, góp thành toàn quốc.</p>
                            </div>

                            <div class="social-section">
                                <h4>KẾT NỐI VỚI ELECTRO</h4>
                                <div class="social-links">
                                    <a href="<?php echo $this->socialLinks['facebook']; ?>" class="social-link facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="<?php echo $this->socialLinks['twitter']; ?>" class="social-link twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="<?php echo $this->socialLinks['instagram']; ?>" class="social-link instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="<?php echo $this->socialLinks['tiktok']; ?>" class="social-link tiktok">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="contact-section">
                                <h4>TỔNG ĐÀI MIỄN PHÍ</h4>
                                <div class="hotline-list">
                                    <div class="hotline-item">
                                        <span>Tư vấn mua hàng (Miễn phí)</span>
                                        <strong><?php echo $this->contactInfo['sales_hotline']; ?></strong> (Nhánh 1)
                                    </div>
                                    <div class="hotline-item">
                                        <span>Tư vấn mua hàng (Miễn phí)</span>
                                        <strong><?php echo $this->contactInfo['support_hotline']; ?></strong> (Nhánh 1)
                                    </div>
                                    <div class="hotline-item">
                                        <span>Tư vấn mua hàng (Miễn phí)</span>
                                        <strong><?php echo $this->contactInfo['complaint_hotline']; ?></strong> (Nhánh 1)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- About Us -->
                        <div class="footer-col">
                            <h4>VỀ CHÚNG TÔI</h4>
                            <ul class="footer-links">
                                <?php foreach ($aboutLinks as $title => $url): ?>
                                    <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Policies -->
                        <div class="footer-col">
                            <h4>CHÍNH SÁCH</h4>
                            <ul class="footer-links">
                                <?php foreach ($policyLinks as $title => $url): ?>
                                    <li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Payment Support -->
                        <div class="footer-col">
                            <h4>HỖ TRỢ THANH TOÁN</h4>
                            <div class="payment-methods">
                                <?php foreach ($paymentMethods as $method => $name): ?>
                                    <div class="payment-item">
                                        <img src="/assets/images/payments/<?php echo $method; ?>.png" alt="<?php echo $name; ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <h4>CHỨNG NHẬN</h4>
                            <div class="certifications">
                                <?php foreach ($certifications as $cert => $name): ?>
                                    <div class="cert-item">
                                        <img src="/assets/images/certifications/<?php echo $cert; ?>.png" alt="<?php echo $name; ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="company-info">
                        <p>© Bản quyền thuộc về Electro</p>
                        <p><?php echo $this->companyInfo['name']; ?></p>
                        <p><?php echo $this->companyInfo['license']; ?></p>
                        <p>Góp ý & khiếu nại: <?php echo $this->companyInfo['email']; ?></p>
                        <p>Hotline: <?php echo $this->companyInfo['phone']; ?></p>
                        <p><?php echo $this->companyInfo['address']; ?></p>
                    </div>

                    <div class="footer-certification">
                        <div class="certification-logo">
                            <img src="/assets/images/da-thong-bao.png" alt="Đã thông báo Bộ Công Thương">
                        </div>
                    </div>
                </div>
            </div>
        </footer>
<?php
        return ob_get_clean();
    }
}

// Usage
function display_electro_footer()
{
    $footer = new ElectroFooter();
    echo $footer->render();
}
