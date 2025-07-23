<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán Laptop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="banner">
        <img src="/img/anh1.jpg" alt="Banner">
    </div>

    <div class="container">
        <aside class="filter">
            <h3>Bộ lọc tìm kiếm</h3>
            <div class="filter-group">
                <h4>Hãng sản xuất</h4>
                <div class="brand-logos">
                    <a href="https://www.asus.com/vn/">
                        <div class="brand-logo-card">
                            <img src="/img/asus.jpg" alt="ASUS">
                        </div>
                    </a>
                    <a href="https://www.apple.com/vn/">
                        <div class="brand-logo-card" data-brand="Apple">
                            <img src="/img/apple.jpg" alt="Apple">
                        </div>
                    </a>
                    <a href="https://www.dell.com/vn/">
                        <div class="brand-logo-card" data-brand="Dell">
                            <img src="/img/dell.jpg" alt="Dell">
                        </div>
                    </a>
                    <a href="https://www.hp.com/vn/">
                        <div class="brand-logo-card" data-brand="HP">
                            <img src="/img/hp.jpg" alt="HP">
                        </div>
                    </a>
                    <a href="https://www.lenovo.com/vn/">
                        <div class="brand-logo-card" data-brand="Lenovo">
                            <img src="/img/lenovo.jpg" alt="Lenovo">
                        </div>
                    </a>
                    <a href="https://www.acer.com/vn-vi/">
                        <div class="brand-logo-card" data-brand="Acer">
                            <img src="/img/acer.jpg" alt="Acer">
                        </div>
                    </a>
                </div>
            </div>

            <div class="filter-group">
                <h4>Mức giá</h4>
                <label><input type="radio" name="price" value="all" checked> Tất cả</label>
                <label><input type="radio" name="price" value="25-30"> Từ 25 đến 30 triệu</label>
                <label><input type="radio" name="price" value="20-25"> Từ 20 đến 25 triệu</label>
                <label><input type="radio" name="price" value="15-20"> Từ 15 đến 20 triệu</label>
                <label><input type="radio" name="price" value="10-15"> Từ 10 đến 15 triệu</label>
                <label><input type="radio" name="price" value="duoi10"> Dưới 10 triệu</label>

                <p style="margin-top:8px; font-size:13px;">Nhập khoảng giá phù hợp với bạn:</p>
                <input type="number" id="min-price" placeholder="Từ" style="width:90px;"> ~
                <input type="number" id="max-price" placeholder="Đến" style="width:90px;">
            </div>

            <div class="filter-group">
                <h4>CPU</h4>
                <label><input type="checkbox" value="Apple M4 series"> Apple M4 series</label>
                <label><input type="checkbox" value="Apple M3 series"> Apple M3 series</label>
                <label><input type="checkbox" value="Apple M2 series"> Apple M2 series</label>
                <label><input type="checkbox" value="Apple M1 series"> Apple M1 series</label>
                <label><input type="checkbox" value="Intel Celeron"> Intel Celeron</label>
            </div>

            <div class="filter-ram">
                <h4>RAM</h4>
                <div class="brand-ram">
                    <a href="">
                        <div class="brand-logo-ram">
                            <p>4GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Apple">
                            <p>8GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Dell">
                            <p>12GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="HP">
                            <p>16GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Lenovo">
                            <p>32GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Acer">
                            <p>48GB</p>
                        </div>
                    </a>
                    <a href="">
                        <div class="brand-logo-ram" data-brand="Acer">
                            <p>64GB</p>
                        </div>
                    </a>
                </div>
                <!-- </div>
                <label><input type="checkbox" value="4GB"> 4GB</label>
                <label><input type="checkbox" value="8GB"> 8GB</label>
                <label><input type="checkbox" value="12GB"> 12GB</label>
                <label><input type="checkbox" value="16GB"> 16GB</label>
                <label><input type="checkbox" value="32GB"> 32GB</label>
                <label><input type="checkbox" value="48GB"> 48GB</label>
                <label><input type="checkbox" value="64GB"> 64GB</label>
            </div> -->
        </aside>

        <main class="products" id="product-list">
            <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
             <div class="product-card">
                <img src="/img/iphone223.jpg" alt="Sản phẩm 1">
                <p>Trả góp 0%</p>
                <h4>Tên sản phẩm Laptop A</h4>
                <h3 class="price">25.000.000 VNĐ</h3> 
                <button>Xem chi tiết</button>
            </div>
            

        </main>
    </div>

    <script src="script.js"></script>
</body>

</html>