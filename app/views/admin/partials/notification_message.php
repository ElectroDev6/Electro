<?php
ob_start();
?>
    <div class="notification-panel">
        <div class="notification-panel__header">
            <h2 class="notification-panel__title">Bạn có 4 tin nhắn mới</h2>
        </div>
        <div class="notification-panel__content">
            <ul class="notification-list">
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">30 min. ago</div>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">30 min. ago</div>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">30 min. ago</div>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">30 min. ago</div>
                    </div>
                </li>
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">1 hr. ago</div>
                    </div>
                </li>
                
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
                    </div>
                    <div class="notification-item__content">
                        <div class="notification-item__sender">Nguyễn Văn Đức</div>
                        <div class="notification-item__message">Có một tin nhắn đã gửi cho bạn</div>
                        <div class="notification-item__time">2 hrs. ago</div>
                    </div>
                </li>
                
                <li class="notification-item">
                    <div class="notification-item__avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Anna Nelson" class="notification-item__avatar-img">
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
            <a href="#" class="notification-panel__view-all">Xem tất cả tin nhắn</a>
        </div>
    </div>
<?php
$htmlNotificationMessage = ob_get_clean();
?>