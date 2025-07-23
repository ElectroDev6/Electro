<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS chung -->
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
    <!-- CSS riêng cho từng trang -->
    <?php if (isset($pageName)): ?>
        <link rel="stylesheet" href="<?= asset("css/{$pageName}.css") ?>">
    <?php endif; ?>
</head>

<body>
    <header class="header">
        <div class="header__topbar">
            <div class="container-main">
                <div class="header__top">
                    <p class="header__welcome">Chào mừng đến với Cửa hàng điện tử toàn cầu</p>
                    <ul class="header__top-nav">
                        <li class="header__top-item"><a href="#">Tìm kiếm cửa hàng</a></li>
                        <li class="header__top-item"><a href="#">Theo dõi đơn hàng của bạn</a></li>
                        <li class="header__top-item"><a href="#">Cửa hàng</a></li>
                        <li class="header__top-item"><a href="#">Tài khoản của tôi</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-main">
            <div class="header__main">
                <div class="header__logo">
                    <a href="/" class="header-logo-link">
                        <svg width="175.748" height="42.52">
                            <ellipse cx="170.05" cy="36.341" fill="#FDD700" fill-rule="evenodd" class="ellipse-bg" clip-rule="evenodd" rx="5.32" ry="5.367" />
                            <path fill="#333E48" fill-rule="evenodd" d="M30.514.71c-.034.003-.066.008-.056.056-.195.229-.582.415-.668.734-.148.548 0 1.568 0 2.427v36.459c.265.221.506.465.725.734h6.187c.2-.25.423-.477.669-.678V1.387a4.514 4.514 0 0 1-.67-.677h-6.187zm87.003 12.021c-.232-.189-.439-.64-.781-.734-.754-.209-2.039 0-3.121 0h-3.176V4.435c-.232-.189-.439-.639-.781-.733-.719-.2-1.969 0-3.01 0h-3.01c-.238.273-.625.431-.725.847-.203.852 0 2.399 0 3.725 0 1.393.045 2.748-.055 3.725h-6.41c-.184.237-.629.434-.725.791-.178.654 0 1.813 0 2.765v2.766c.232.188.439.64.779.733.777.216 2.109 0 3.234 0 1.154 0 2.291-.045 3.176.057v21.277c.232.189.439.639.781.734.719.199 1.969 0 3.01 0h3.01c1.008-.451.725-1.889.725-3.443-.002-6.164-.047-12.867.055-18.625h6.299c.182-.236.627-.434.725-.79.176-.653 0-1.813 0-2.765v-2.768zm18.334 5.531c.201-.746 0-2.029 0-3.104v-3.104c-.287-.245-.434-.637-.781-.733-.824-.229-1.992-.044-2.898 0-2.158.104-4.506.675-5.74 1.411-.146-.362-.451-.853-.893-.96-.693-.169-1.859 0-2.842 0h-2.842c-.258.319-.625.42-.725.79-.223.82 0 2.338 0 3.443 0 8.109-.002 16.635 0 24.381.232.189.439.639.779.734.707.195 1.93 0 2.955 0h3.01c.918-.463.725-1.352.725-2.822V36.21c-.002-3.902-.242-9.117 0-12.473.297-4.142 3.836-4.877 8.527-4.686.186-.235.631-.445.725-.789zM14.796 11.376c-5.472.262-9.443 3.178-11.76 7.056-2.435 4.075-2.789 10.62-.501 15.126 2.043 4.023 5.91 7.115 10.701 7.9 6.051.992 10.992-1.219 14.324-3.838-.687-1.1-1.419-2.664-2.118-3.951-.398-.734-.652-1.486-1.616-1.467-1.942.787-4.272 2.262-7.134 2.145-3.791-.154-6.659-1.842-7.524-4.91H28.62c.146-2.793.22-5.338-.279-7.563-1.38-6.146-5.838-10.866-13.545-10.498zM9 23.284c.921-2.508 3.033-4.514 6.298-4.627 3.083-.107 4.994 1.976 5.685 4.627-3.864.096-8.118.096-11.983 0zm43.418-11.908c-5.551.266-9.395 3.142-11.76 7.056-2.476 4.097-2.829 10.493-.557 15.069 1.997 4.021 5.895 7.156 10.646 7.957 6.068 1.023 11-1.227 14.379-3.781-.479-.896-.875-1.742-1.393-2.709-.312-.582-1.024-2.234-1.561-2.539-.912-.52-1.428.135-2.23.508a18.65 18.65 0 0 1-1.672.676c-4.768 1.621-10.372.268-11.537-4.176h19.451c.668-5.443-.419-9.953-2.73-13.037-2.257-3.012-5.68-5.28-11.036-5.024zm-5.796 11.967c.708-2.553 3.161-4.578 6.242-4.686 3.08-.107 5.08 1.953 5.686 4.686H46.622zm113.749-7.846c-2.455-2.453-6.143-4.291-10.869-4.064-2.268.109-4.297.65-6.02 1.524a14.45 14.45 0 0 0-4.234 3.217c-2.287 2.519-4.164 6.004-3.902 11.007.248 4.736 1.979 7.813 4.627 10.326 2.568 2.439 6.148 4.254 10.867 4.064 4.457-.18 7.889-2.115 10.199-4.684 2.469-2.746 4.012-5.971 3.959-11.063-.049-4.69-2.266-7.97-4.627-10.327zm-10.813 18.455c-3.246-.221-5.701-2.615-6.41-5.418-.174-.689-.26-1.25-.4-2.166-.035-.234.072-.523-.045-.77.682-3.698 2.912-6.257 6.799-6.547 2.543-.189 4.258.735 5.52 1.863 1.322 1.182 2.303 2.715 2.451 4.967.316 4.788-3.288 8.386-7.915 8.071zM88.812 29.55c-1.232 2.363-2.9 4.307-6.13 4.402-4.729.141-8.038-3.16-8.025-7.563.004-1.412.324-2.65.947-3.726 1.197-2.061 3.507-3.688 6.633-3.612 3.222.079 4.966 1.708 6.632 3.668 1.328-1.059 2.529-1.948 3.9-2.99.416-.315 1.076-.688 1.227-1.072.404-1.031-.365-1.502-.891-2.088-2.543-2.835-6.66-5.377-11.704-5.137-6.02.288-10.218 3.697-12.484 7.846-1.293 2.365-1.951 5.158-1.729 8.408.209 3.053 1.191 5.496 2.619 7.508 2.842 4.004 7.385 6.973 13.656 6.377 5.976-.568 9.574-3.936 11.816-8.354-.141-.271-.221-.604-.336-.902-2.014-.951-4.1-1.83-6.131-2.765z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <button class="header__menu-btn">
                        <span class="header__menu-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke="#333e48" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6H20M4 12H20M4 18H20"></path>
                                </g>
                            </svg>
                        </span>
                    </button>
                </div>

                <form class="header__search">
                    <input type="text" class="header__input" id="header__input" placeholder="Tìm kiếm sản phẩm" />
                    <select class="header__select" id="header__select">
                        <option>Tất cả các danh mục</option>
                    </select>
                    <button type="submit" class="header__search-btn">
                        <span class="header__search-icon">
                            <svg width="16" height="16" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#333e48">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="layer1">
                                        <path d="M 7.5 0 C 3.3637867 0 0 3.3637867 0 7.5 C 0 11.636213 3.3637867 15 7.5 15 C 9.3884719 15 11.109883 14.292492 12.429688 13.136719 L 19.146484 19.853516 A 0.50083746 0.50083746 0 1 0 19.853516 19.146484 L 13.136719 12.429688 C 14.292492 11.109883 15 9.3884719 15 7.5 C 15 3.3637867 11.636213 0 7.5 0 z M 7.5 1 C 11.095773 1 14 3.9042268 14 7.5 C 14 11.095773 11.095773 14 7.5 14 C 3.9042268 14 1 11.095773 1 7.5 C 1 3.9042268 3.9042268 1 7.5 1 z " style="fill:#333e48; fill-opacity:1; stroke:none; stroke-width:0px;"></path>
                                    </g>
                                </g>
                            </svg>
                        </span>
                    </button>
                </form>

                <div class="header__actions">
                    <div class="header__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Arrow / Arrow_Reload_02">
                                    <path id="Vector" d="M14 16H19V21M10 8H5V3M19.4176 9.0034C18.8569 7.61566 17.9181 6.41304 16.708 5.53223C15.4979 4.65141 14.0652 4.12752 12.5723 4.02051C11.0794 3.9135 9.58606 4.2274 8.2627 4.92661C6.93933 5.62582 5.83882 6.68254 5.08594 7.97612M4.58203 14.9971C5.14272 16.3848 6.08146 17.5874 7.29157 18.4682C8.50169 19.3491 9.93588 19.8723 11.4288 19.9793C12.9217 20.0863 14.4138 19.7725 15.7371 19.0732C17.0605 18.374 18.1603 17.3175 18.9131 16.0239" stroke="#333e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        <span class="header__count">0</span>
                    </div>
                    <div class="header__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#333e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                        </svg>
                        <span class="header__count">0</span>
                    </div>
                    <div class="header__icon">
                        <a href="">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <circle cx="12" cy="6" r="4" stroke="#333e48" stroke-width="1.5"></circle>
                                    <path d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" stroke="#333e48" stroke-width="1.5"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                    <div class="header__icon">
                        <a href="/cart">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M16 8H17.1597C18.1999 8 19.0664 8.79732 19.1528 9.83391L19.8195 17.8339C19.9167 18.9999 18.9965 20 17.8264 20H6.1736C5.00352 20 4.08334 18.9999 4.18051 17.8339L4.84718 9.83391C4.93356 8.79732 5.80009 8 6.84027 8H8M16 8H8M16 8L16 7C16 5.93913 15.5786 4.92172 14.8284 4.17157C14.0783 3.42143 13.0609 3 12 3C10.9391 3 9.92172 3.42143 9.17157 4.17157C8.42143 4.92172 8 5.93913 8 7L8 8M16 8L16 12M8 8L8 12" stroke="#333e48" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </a>
                        <span class="header__count">0</span>
                    </div>
                </div>
            </div>
        </div>
    </header>