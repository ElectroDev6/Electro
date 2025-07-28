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
    <title>Trang người dùng</title>
    <link rel="stylesheet" href="/css/admin/style-admin.css">
</head>
<body>
    <?php echo $htmlHeader; ?>
    <main class="wrapper">
        <?php echo $contentSidebar; ?>
        <div class="profile">
        <div class="profile__container">
            <h1 class="profile__title">Account Settings</h1>
            
            <!-- Personal Information Section -->
            <div class="profile__section">
                <h2 class="profile__section-title">Personal Information</h2>
                
                <div class="profile__avatar-section">
                    <div class="profile__avatar">
                        <span class="profile__avatar-initials">JD</span>
                    </div>
                    <button class="profile__change-avatar-btn">
                        <i class="fas fa-camera"></i>
                        Change Avatar
                    </button>
                </div>
                
                <form class="profile__form">
                    <div class="profile__form-group">
                        <label class="profile__label" for="fullName">Full Name*</label>
                        <input class="profile__input" type="text" id="fullName" value="John Doe">
                    </div>
                    
                    <div class="profile__form-group">
                        <label class="profile__label" for="email">Email Address*</label>
                        <input class="profile__input" type="email" id="email" value="john.doe@example.com">
                    </div>
                    
                    <div class="profile__form-group">
                        <label class="profile__label" for="phone">Phone Number</label>
                        <input class="profile__input" type="tel" id="phone" value="+1 (555) 123-4567">
                    </div>
                    
                    <button class="profile__save-btn profile__save-btn--primary" type="submit">
                        Save Changes
                    </button>
                </form>
            </div>
            
            <!-- Change Password Section -->
            <div class="profile__section">
                <h2 class="profile__section-title">Change Password</h2>
                
                <form class="profile__form">
                    <div class="profile__form-group">
                        <label class="profile__label" for="currentPassword">Current Password*</label>
                        <input class="profile__input" type="password" id="currentPassword">
                    </div>
                    
                    <div class="profile__form-group">
                        <label class="profile__label" for="newPassword">New Password*</label>
                        <input class="profile__input" type="password" id="newPassword">
                    </div>
                    
                    <div class="profile__form-group">
                        <label class="profile__label" for="confirmPassword">Confirm New Password*</label>
                        <input class="profile__input" type="password" id="confirmPassword">
                    </div>
                    
                    <p class="profile__password-note">
                        Password must be at least 8 characters and include uppercase, lowercase, number, and special character.
                    </p>
                    
                    <button class="profile__save-btn profile__save-btn--primary" type="submit">
                        Update Password
                    </button>
                </form>
            </div>
            
            <!-- Notification Preferences Section -->
            <div class="profile__section">
                <h2 class="profile__section-title">Notification Preferences</h2>
                
                <form class="profile__form">
                    <div class="profile__checkbox-group">
                        <label class="profile__checkbox-label">
                            <input class="profile__checkbox" type="checkbox" checked>
                            <span class="profile__checkbox-custom"></span>
                            <span class="profile__checkbox-text">Receive email notifications</span>
                        </label>
                    </div>
                    
                    <div class="profile__checkbox-group">
                        <label class="profile__checkbox-label">
                            <input class="profile__checkbox" type="checkbox">
                            <span class="profile__checkbox-custom"></span>
                            <span class="profile__checkbox-text">Notify me about new comments</span>
                        </label>
                    </div>
                    
                    <div class="profile__checkbox-group">
                        <label class="profile__checkbox-label">
                            <input class="profile__checkbox" type="checkbox" checked>
                            <span class="profile__checkbox-custom"></span>
                            <span class="profile__checkbox-text">Get notified about new post registrations</span>
                        </label>
                    </div>
                    
                    <div class="profile__checkbox-group">
                        <label class="profile__checkbox-label">
                            <input class="profile__checkbox" type="checkbox" checked>
                            <span class="profile__checkbox-custom"></span>
                            <span class="profile__checkbox-text">Receive security alerts</span>
                        </label>
                    </div>
                    
                    <button class="profile__save-btn profile__save-btn--primary" type="submit">
                        Save Preferences
                    </button>
                </form>
            </div>
            
            <!-- Two-Factor Authentication Section -->
            <div class="profile__section">
                <h2 class="profile__section-title">Two-Factor Authentication</h2>
                
                <div class="profile__2fa-status">
                    <span class="profile__2fa-badge profile__2fa-badge--disabled">Not Enabled</span>
                </div>
                
                <p class="profile__2fa-description">
                    Two-factor authentication adds an extra layer of security to your account by requiring more than just a password to sign in.
                </p>
                
                <button class="profile__save-btn profile__save-btn--primary" type="button">
                    Enable Two-Factor
                </button>
            </div>
        </div>
    </div>
    </main>
   
</body>
</html>