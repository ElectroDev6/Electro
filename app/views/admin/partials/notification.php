<?php
ob_start();
?>
    <div class="notification-panel">
        <div class="notification-panel__header">
            <h2 class="notification-panel__title">Bạn có 4 thông báo mới</h2>
        </div>
        <div class="notification-panel__content">
            <ul class="notification-list">
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="/icons/warning_icon.svg" alt="warning-icon" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Thông tin mua hàng</div>
                        <div class="notification-item__message">@Nguyễn Văn Đức đã mua 5 sản phẩm</div>
                        <div class="notification-item__time">30 min. ago</div>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="/icons/error_icon.svg" alt="error_icon" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">1 hr. ago</div>
                    </div>
                </li>
                
                <li class="notification-item">
                    <div class="notification-item__avatar">
                         <img src="/icons/success_icon.svg" alt="error_icon" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">2 hrs. ago</div>
                    </div>
                </li>
                
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="/icons/info_icon.svg" alt="error_icon" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">30 m. ago</div>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="notification-panel__footer">
            <a href="#" class="notification-panel__view-all">Xem tất cả thông tin</a>
        </div>
    </div>
<?php
$htmlNotification = ob_get_clean();
?>