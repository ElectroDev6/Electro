<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electro Header</title>
    <link rel="stylesheet" href="/css/style-admin.css">
</head>
<body>
    <header class="header">
        <div class="header__container">
            <a href="/admin/dashboard" class="header__brand">
                <img src="/img/logo.png" alt="" class="header__logo">
            </a>
            <div class="header__actions">
                <div class="header__notifications">
                    <button class="header__notification-btn">
                       <svg width="20" height="20" fill="none" class="header__notification-icon" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 1 0 6 8c0 7-3 9-3 9h18s-3-2-3-9ZM13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        <span class="header__notification-badge">5</span>
                    </button>
                    <button class="header__notification-btn">
                       <svg width="20" height="20" fill="none" class="header__notification-icon" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z"/></svg>
                        <span class="header__notification-badge">8</span>
                    </button>
                </div>
                <div class="header__user">
                    <div class="header__user-avatar">
                        <img class="header__user-image" src="/img/avatar.png" alt="User avatar" />
                    </div>
                    <span class="header__user-name">Adminshop</span>
                    <svg class="header__user-dropdown" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>
</body>
</html>