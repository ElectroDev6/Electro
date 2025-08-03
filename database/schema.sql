CREATE TABLE brands (
    brand_id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    category_id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    product_id INT PRIMARY KEY,
    brand_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id),
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE product_descriptions (
    product_description_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    section_title VARCHAR(255) NOT NULL,
    content_text TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Tùy chọn (màu sắc, dung lượng, kích thức, ...)
CREATE TABLE product_options (
    option_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Giá trị của từng tùy chọn (đen, trắng, 128GB, XL, ...)
CREATE TABLE product_option_values (
    value_id INT PRIMARY KEY AUTO_INCREMENT,
    option_id INT NOT NULL,
    value VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (option_id) REFERENCES product_options(option_id)
);

-- Biến thể sản phẩm (kết hợp nhiều option như Black - 128GB)
CREATE TABLE product_variants (
    product_variant_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    price_original DECIMAL(10, 2) NOT NULL,
    price_discount DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Liên kết biến thể với từng giá trị option (VD: biến thể #1 gồm Black + 128GB)
CREATE TABLE product_variant_values (
    variant_id INT NOT NULL,
    value_id INT NOT NULL,
    PRIMARY KEY (variant_id, value_id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(product_variant_id),
    FOREIGN KEY (value_id) REFERENCES product_option_values(value_id)
);

-- Ảnh theo từng biến thể (đặc biệt là màu sắc khác nhau)
CREATE TABLE variant_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    variant_id INT NOT NULL,
    default_url VARCHAR(255) NULL,
    thumbnail_url VARCHAR(255) NOT NULL,
    gallery_url VARCHAR(255) NOT NULL,
    is_default BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (variant_id) REFERENCES product_variants(product_variant_id)
);