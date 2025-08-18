<?php
    include dirname(__DIR__) . '/admin/partials/sidebar.php';
?>
<?php
    include dirname(__DIR__) . '/admin/partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân - Admin</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="profile">
            <div class="profile__container">
                <!-- Header Section -->
                <div class="profile__header">
                    <div class="profile__avatar-wrapper">
                        <div class="profile__avatar">
                            <?php if (!empty($user['avatar_url'])): ?>
                                <img src="<?php echo htmlspecialchars($user['avatar_url']); ?>" alt="Avatar">
                            <?php else: ?>
                                <div class="profile__avatar-placeholder">
                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            <button class="profile__change-avatar" type="button">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <div class="profile__user-info">
                        <h1 class="profile__name"><?php echo htmlspecialchars($user['name']); ?></h1>
                        <span class="profile__role">
                            <i class="fas fa-crown"></i>
                            <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                        </span>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="profile__content">
                    <!-- Tabs -->
                    <div class="profile__tabs">
                        <button class="profile__tab active" data-tab="personal">
                            <i class="fas fa-user"></i>
                            Thông tin cá nhân
                        </button>
                        <button class="profile__tab" data-tab="account">
                            <i class="fas fa-cog"></i>
                            Tài khoản
                        </button>
                        <button class="profile__tab" data-tab="security">
                            <i class="fas fa-shield-alt"></i>
                            Bảo mật
                        </button>
                        <button class="profile__tab" data-tab="notifications">
                            <i class="fas fa-bell"></i>
                            Thông báo
                        </button>
                    </div>

                    <!-- Personal Information Tab -->
                    <div class="profile__tab-content active" id="personal">
                        <form class="profile__form" id="personalForm">
                            <div class="profile__section">
                                <h2 class="profile__section-title">
                                    <i class="fas fa-user-circle"></i>
                                    Thông tin cá nhân
                                </h2>
                                <div class="profile__form-grid">
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="name">Họ và tên *</label>
                                        <input class="profile__input" type="text" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="email">Email *</label>
                                        <input class="profile__input" type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="phone">Số điện thoại</label>
                                        <input class="profile__input" type="tel" id="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="gender">Giới tính</label>
                                        <select class="profile__select" id="gender" disabled>
                                            <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Nam</option>
                                            <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Nữ</option>
                                            <option value="other" <?php echo $user['gender'] === 'other' ? 'selected' : ''; ?>>Khác</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="profile__form-group">
                                    <label class="profile__label">Ngày sinh</label>
                                    <div class="profile__date-group">
                                        <select class="profile__select" id="dobDay" disabled>
                                            <option value="">Ngày</option>
                                            <?php for($i = 1; $i <= 31; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php echo $user['dob_day'] == $i ? 'selected' : ''; ?>>
                                                    <?php echo $i; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <select class="profile__select" id="dobMonth" disabled>
                                            <option value="">Tháng</option>
                                            <?php 
                                                $months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 
                                                          'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
                                                for($i = 1; $i <= 12; $i++): 
                                            ?>
                                                <option value="<?php echo $i; ?>" <?php echo $user['dob_month'] == $i ? 'selected' : ''; ?>>
                                                    <?php echo $months[$i-1]; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <select class="profile__select" id="dobYear" disabled>
                                            <option value="">Năm</option>
                                            <?php for($i = 2024; $i >= 1950; $i--): ?>
                                                <option value="<?php echo $i; ?>" <?php echo $user['dob_year'] == $i ? 'selected' : ''; ?>>
                                                    <?php echo $i; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="profile__section">
                                <h2 class="profile__section-title">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Địa chỉ
                                </h2>
                                <div class="profile__form-grid">
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="address">Địa chỉ cụ thể</label>
                                        <input class="profile__input" type="text" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="ward">Phường/Xã</label>
                                        <input class="profile__input" type="text" id="ward" value="<?php echo htmlspecialchars($user['ward_commune']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="district">Quận/Huyện</label>
                                        <input class="profile__input" type="text" id="district" value="<?php echo htmlspecialchars($user['district']); ?>" disabled>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="province">Tỉnh/Thành phố</label>
                                        <input class="profile__input" type="text" id="province" value="<?php echo htmlspecialchars($user['province_city']); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="profile__actions">
                                <button class="profile__btn profile__btn--secondary" type="button" id="cancelBtn" style="display: none;">
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>
                                <button class="profile__btn profile__btn--primary" type="button" id="editBtn">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </button>
                                <button class="profile__btn profile__btn--primary" type="submit" id="saveBtn" style="display: none;">
                                    <i class="fas fa-save"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Account Tab -->
                    <div class="profile__tab-content" id="account">
                        <div class="profile__section">
                            <h2 class="profile__section-title">
                                <i class="fas fa-info-circle"></i>
                                Thông tin tài khoản
                            </h2>
                            <div class="profile__form-grid">
                                <div class="profile__form-group">
                                    <label class="profile__label">ID tài khoản</label>
                                    <input class="profile__input" type="text" value="<?php echo $user['user_id']; ?>" disabled>
                                </div>
                                <div class="profile__form-group">
                                    <label class="profile__label">Trạng thái</label>
                                    <input class="profile__input" type="text" value="<?php echo $user['is_active'] ? 'Đang hoạt động' : 'Tạm khóa'; ?>" disabled>
                                </div>
                                <div class="profile__form-group">
                                    <label class="profile__label">Ngày tạo</label>
                                    <input class="profile__input" type="text" value="<?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?>" disabled>
                                </div>
                                <div class="profile__form-group">
                                    <label class="profile__label">Cập nhật lần cuối</label>
                                    <input class="profile__input" type="text" value="<?php echo date('d/m/Y H:i', strtotime($user['updated_at'])); ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="profile__section">
                            <h2 class="profile__section-title">
                                <i class="fas fa-key"></i>
                                Đổi mật khẩu
                            </h2>
                            <form class="profile__form" id="passwordForm">
                                <div class="profile__form-grid">
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="currentPassword">Mật khẩu hiện tại *</label>
                                        <input class="profile__input" type="password" id="currentPassword" required>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="newPassword">Mật khẩu mới *</label>
                                        <input class="profile__input" type="password" id="newPassword" required>
                                    </div>
                                    <div class="profile__form-group">
                                        <label class="profile__label" for="confirmPassword">Xác nhận mật khẩu mới *</label>
                                        <input class="profile__input" type="password" id="confirmPassword" required>
                                    </div>
                                </div>
                                <div class="profile__actions">
                                    <button class="profile__btn profile__btn--primary" type="submit">
                                        <i class="fas fa-save"></i>
                                        Đổi mật khẩu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="profile__tab-content" id="security">
                        <div class="profile__section">
                            <h2 class="profile__section-title">
                                <i class="fas fa-shield-alt"></i>
                                Cài đặt bảo mật
                            </h2>
                            <div class="profile__security-item">
                                <div class="profile__security-info">
                                    <h4>Xác thực hai yếu tố (2FA)</h4>
                                    <p>Tăng cường bảo mật tài khoản bằng xác thực hai bước</p>
                                </div>
                                <div>
                                    <span class="profile__status-badge profile__status-badge--disabled">Chưa kích hoạt</span>
                                    <button class="profile__btn profile__btn--primary" style="margin-left: 12px;">
                                        <i class="fas fa-mobile-alt"></i>
                                        Kích hoạt
                                    </button>
                                </div>
                            </div>
                            
                            <div class="profile__security-item">
                                <div class="profile__security-info">
                                    <h4>Phiên đăng nhập</h4>
                                    <p>Quản lý các phiên đăng nhập từ các thiết bị khác nhau</p>
                                </div>
                                <div>
                                    <button class="profile__btn profile__btn--secondary">
                                        <i class="fas fa-list"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Tab -->
                    <div class="profile__tab-content" id="notifications">
                        <div class="profile__section">
                            <h2 class="profile__section-title">
                                <i class="fas fa-bell"></i>
                                Cài đặt thông báo
                            </h2>
                            <form class="profile__form" id="notificationForm">
                                <div class="profile__checkbox-group">
                                    <input class="profile__checkbox" type="checkbox" id="emailNotifications" checked>
                                    <label for="emailNotifications">
                                        <strong>Thông báo qua email</strong><br>
                                        <small>Nhận thông báo quan trọng qua email</small>
                                    </label>
                                </div>
                                
                                <div class="profile__checkbox-group">
                                    <input class="profile__checkbox" type="checkbox" id="commentNotifications">
                                    <label for="commentNotifications">
                                        <strong>Thông báo bình luận mới</strong><br>
                                        <small>Được thông báo khi có bình luận mới trên bài viết</small>
                                    </label>
                                </div>
                                
                                <div class="profile__checkbox-group">
                                    <input class="profile__checkbox" type="checkbox" id="postNotifications" checked>
                                    <label for="postNotifications">
                                        <strong>Thông báo đăng ký bài viết mới</strong><br>
                                        <small>Thông báo khi có người đăng ký bài viết mới</small>
                                    </label>
                                </div>
                                
                                <div class="profile__checkbox-group">
                                    <input class="profile__checkbox" type="checkbox" id="securityNotifications" checked>
                                    <label for="securityNotifications">
                                        <strong>Cảnh báo bảo mật</strong><br>
                                        <small>Nhận thông báo về các hoạt động đăng nhập bất thường</small>
                                    </label>
                                </div>

                                <div class="profile__actions">
                                    <button class="profile__btn profile__btn--primary" type="submit">
                                        <i class="fas fa-save"></i>
                                        Lưu cài đặt
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Tab switching functionality
        document.querySelectorAll('.profile__tab').forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                document.querySelectorAll('.profile__tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.profile__tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Edit mode functionality
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const personalForm = document.getElementById('personalForm');
        
        let originalValues = {};

        function enableEditMode() {
            // Store original values
            const inputs = personalForm.querySelectorAll('input:not([type="submit"]), select');
            inputs.forEach(input => {
                originalValues[input.id] = input.value;
                input.disabled = false;
            });
            
            personalForm.classList.add('profile__edit-mode');
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-flex';
            cancelBtn.style.display = 'inline-flex';
        }

        function disableEditMode() {
            const inputs = personalForm.querySelectorAll('input:not([type="submit"]), select');
            inputs.forEach(input => {
                input.disabled = true;
            });
            
            personalForm.classList.remove('profile__edit-mode');
            editBtn.style.display = 'inline-flex';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        }

        function cancelEdit() {
            // Restore original values
            const inputs = personalForm.querySelectorAll('input:not([type="submit"]), select');
            inputs.forEach(input => {
                if (originalValues[input.id] !== undefined) {
                    input.value = originalValues[input.id];
                }
            });
            
            disableEditMode();
            originalValues = {};
        }

        editBtn.addEventListener('click', enableEditMode);
        cancelBtn.addEventListener('click', cancelEdit);

        // Form submissions
        personalForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData();
            formData.append('action', 'update_profile');
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('dob_day', document.getElementById('dobDay').value);
            formData.append('dob_month', document.getElementById('dobMonth').value);
            formData.append('dob_year', document.getElementById('dobYear').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('ward', document.getElementById('ward').value);
            formData.append('district', document.getElementById('district').value);
            formData.append('province', document.getElementById('province').value);
            
            // Show loading state
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang lưu...';
            saveBtn.disabled = true;
            
            // Simulate API call (replace with actual endpoint)
            setTimeout(() => {
                // Reset button state
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Lưu thay đổi';
                saveBtn.disabled = false;
                
                // Show success message
                showNotification('Cập nhật thông tin thành công!', 'success');
                
                // Disable edit mode
                disableEditMode();
                originalValues = {};
            }, 1500);
        });

        // Password form submission
        document.getElementById('passwordForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Validate passwords
            if (newPassword !== confirmPassword) {
                showNotification('Mật khẩu xác nhận không khớp!', 'error');
                return;
            }
            
            if (newPassword.length < 8) {
                showNotification('Mật khẩu phải có ít nhất 8 ký tự!', 'error');
                return;
            }
            
            // Validate password strength
            const hasUpperCase = /[A-Z]/.test(newPassword);
            const hasLowerCase = /[a-z]/.test(newPassword);
            const hasNumber = /\d/.test(newPassword);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(newPassword);
            
            if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
                showNotification('Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt!', 'error');
                return;
            }
            
            // Submit password change
            const formData = new FormData();
            formData.append('action', 'change_password');
            formData.append('current_password', currentPassword);
            formData.append('new_password', newPassword);
            
            // Show loading and submit (simulate API call)
            setTimeout(() => {
                showNotification('Đổi mật khẩu thành công!', 'success');
                document.getElementById('passwordForm').reset();
            }, 1000);
        });

        // Notification form submission
        document.getElementById('notificationForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'update_notifications');
            formData.append('email_notifications', document.getElementById('emailNotifications').checked);
            formData.append('comment_notifications', document.getElementById('commentNotifications').checked);
            formData.append('post_notifications', document.getElementById('postNotifications').checked);
            formData.append('security_notifications', document.getElementById('securityNotifications').checked);
            
            // Submit notification preferences (simulate API call)
            setTimeout(() => {
                showNotification('Cập nhật cài đặt thông báo thành công!', 'success');
            }, 800);
        });

        // Avatar change functionality
        document.querySelector('.profile__change-avatar').addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const avatarImg = document.querySelector('.profile__avatar img');
                        const avatarPlaceholder = document.querySelector('.profile__avatar-placeholder');
                        
                        if (avatarImg) {
                            avatarImg.src = e.target.result;
                        } else {
                            // Replace placeholder with image
                            document.querySelector('.profile__avatar').innerHTML = `
                                <img src="${e.target.result}" alt="Avatar">
                                <button class="profile__change-avatar" type="button">
                                    <i class="fas fa-camera"></i>
                                </button>
                            `;
                            // Re-attach event listener
                            document.querySelector('.profile__change-avatar').addEventListener('click', arguments.callee);
                        }
                        
                        showNotification('Cập nhật avatar thành công!', 'success');
                    };
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        });

        // Notification system
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(n => n.remove());
            
            const notification = document.createElement('div');
            notification.className = `notification notification--${type}`;
            notification.innerHTML = `
                <div class="notification__content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="notification__close">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add styles
            const style = document.createElement('style');
            style.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    border-left: 4px solid;
                    padding: 16px;
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    max-width: 400px;
                    animation: slideIn 0.3s ease;
                }
                
                .notification--success {
                    border-left-color: #10b981;
                }
                
                .notification--error {
                    border-left-color: #ef4444;
                }
                
                .notification--info {
                    border-left-color: #3b82f6;
                }
                
                .notification__content {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    flex: 1;
                }
                
                .notification__content i {
                    color: inherit;
                }
                
                .notification--success .notification__content i {
                    color: #10b981;
                }
                
                .notification--error .notification__content i {
                    color: #ef4444;
                }
                
                .notification--info .notification__content i {
                    color: #3b82f6;
                }
                
                .notification__close {
                    background: none;
                    border: none;
                    color: #6b7280;
                    cursor: pointer;
                    padding: 4px;
                    border-radius: 4px;
                }
                
                .notification__close:hover {
                    background: #f3f4f6;
                    color: #374151;
                }
                
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                
                @keyframes slideOut {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
            
            if (!document.querySelector('#notification-styles')) {
                style.id = 'notification-styles';
                document.head.appendChild(style);
            }
            
            document.body.appendChild(notification);
            
            // Close button functionality
            notification.querySelector('.notification__close').addEventListener('click', () => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            });
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }

        // Initialize tooltips for better UX
        function initTooltips() {
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', (e) => {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = e.target.getAttribute('data-tooltip');
                    tooltip.style.cssText = `
                        position: absolute;
                        background: #1f2937;
                        color: white;
                        padding: 8px 12px;
                        border-radius: 6px;
                        font-size: 12px;
                        z-index: 1000;
                        pointer-events: none;
                        white-space: nowrap;
                    `;
                    document.body.appendChild(tooltip);
                    
                    const rect = e.target.getBoundingClientRect();
                    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
                    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
                });
                
                element.addEventListener('mouseleave', () => {
                    document.querySelectorAll('.tooltip').forEach(t => t.remove());
                });
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            initTooltips();
            
            // Add smooth scrolling to tab changes
            document.querySelectorAll('.profile__tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelector('.profile__content').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                // Escape key to cancel edit mode
                if (e.key === 'Escape' && personalForm.classList.contains('profile__edit-mode')) {
                    cancelEdit();
                }
                
                // Ctrl+S to save (prevent default browser save)
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    if (personalForm.classList.contains('profile__edit-mode')) {
                        saveBtn.click();
                    }
                }
            });
        });

        // Add loading states for better UX
        function addLoadingState(button, originalText) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            
            return () => {
                button.disabled = false;
                button.innerHTML = originalText;
            };
        }

        // Enhanced form validation
        function validateForm(form) {
            const inputs = form.querySelectorAll('input[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                input.classList.remove('error');
                if (!input.value.trim()) {
                    input.classList.add('error');
                    isValid = false;
                }
            });
            
            return isValid;
        }

        // Add CSS for error states
        const errorStyles = document.createElement('style');
        errorStyles.textContent = `
            .profile__input.error {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            }
            
            .profile__select.error {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            }
        `;
        document.head.appendChild(errorStyles);
    </script>
</body>
</html>