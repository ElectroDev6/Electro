<?php
ob_start();
?>
<aside class="sidebar">
    <div class="sidebar__header">
        <h2 class="sidebar__title">Trang quản trị</h2>
    </div>
    <nav class="sidebar__nav">
        <ul class="sidebar__menu">
            <li class="sidebar__menu-item">
                <a href="/admin/index" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="9,22 9,12 15,12 15,22" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar__menu-text">Trang tổng quan</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/admin/categories" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20.59 13.41L13.42 20.58C13.2343 20.766 13.0137 20.9135 12.7709 21.0141C12.5281 21.1148 12.2678 21.1666 12.005 21.1666C11.7422 21.1666 11.4819 21.1148 11.2391 21.0141C10.9963 20.9135 10.7757 20.766 10.59 20.58L2 12V2H12L20.59 10.59C20.9625 10.9625 21.1716 11.4688 21.1716 12C21.1716 12.5312 20.9625 13.0375 20.59 13.41V13.41Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="7" cy="7" r="1" fill="currentColor" />
                    </svg>
                    <span class="sidebar__menu-text">Danh mục sản phẩm</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/admin/products" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M7 4V2C7 1.46957 7.21071 0.960859 7.58579 0.585786C7.96086 0.210714 8.46957 0 9 0H15C15.5304 0 16.0391 0.210714 16.4142 0.585786C16.7893 0.960859 17 1.46957 17 2V4H20C20.5304 4 21.0391 4.21071 21.4142 4.58579C21.7893 4.96086 22 5.46957 22 6C22 6.53043 21.7893 7.03914 21.4142 7.41421C21.0391 7.78929 20.5304 8 20 8H19V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V8H4C3.46957 8 2.96086 7.78929 2.58579 7.41421C2.21071 7.03914 2 6.53043 2 6C2 5.46957 2.21071 4.96086 2.58579 4.58579C2.96086 4.21071 3.46957 4 4 4H7Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar__menu-text">Sản phẩm</span>
                </a>
            </li>

            <li class="sidebar__menu-item">
                <a href="/admin/orders" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <circle cx="9" cy="21" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <circle cx="20" cy="21" r="1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar__menu-text">Đơn hàng</span>
                </a>
            </li>

            <li class="sidebar__menu-item">
                <a href="/admin/blogs" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="10,9 9,9 8,9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar__menu-text">Bài viết</span>
                </a>
            </li>
            <li class="sidebar__menu-item">
                <a href="/admin/reviews" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20.59 13.41L13.42 20.58C13.2343 20.766 13.0137 20.9135 12.7709 21.0141C12.5281 21.1148 12.2678 21.1666 12.005 21.1666C11.7422 21.1666 11.4819 21.1148 11.2391 21.0141C10.9963 20.9135 10.7757 20.766 10.59 20.58L2 12V2H12L20.59 10.59C20.9625 10.9625 21.1716 11.4688 21.1716 12C21.1716 12.5312 20.9625 13.0375 20.59 13.41V13.41Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="7" cy="7" r="1" fill="currentColor" />
                    </svg>
                    <span class="sidebar__menu-text">Đánh giá</span>
                </a>
            </li>

            <li class="sidebar__menu-item">
                <a href="/admin/users" class="sidebar__menu-link">
                    <svg class="sidebar__menu-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="sidebar__menu-text">Người dùng</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar__menu-item .sidebar__menu-link');
    let isActive = false;
    menuItems.forEach(item => {
        const href = item.getAttribute('href');
        if (!href) return;
        const baseHref = href.split('/').pop();
        // Derive singular form by removing 's' if it exists (basic pluralization handling)
        const singularHref = baseHref.endsWith('s') ? baseHref.slice(0, -1) : baseHref;
        // Construct possible detail path (e.g., '/admin/product' from '/admin/products')
        const detailPath = href.replace(baseHref, singularHref);
        // Check if current path matches the href or the derived detail path
        if (currentPath === href || currentPath.startsWith(detailPath)) {
            item.parentElement.classList.add('sidebar__menu-item--active');
            isActive = true;
        }
    });
    // Fallback to first menu item if no match is found
    if (!isActive && menuItems.length > 0) {
        menuItems[0].parentElement.classList.add('sidebar__menu-item--active');
    }
});
</script>
<?php
$contentSidebar = ob_get_clean();
?>