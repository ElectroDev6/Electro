-- Bảng users
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    gender ENUM('male', 'female', 'other') DEFAULT NULL,
    dob_day TINYINT UNSIGNED NULL,
    dob_month TINYINT UNSIGNED NULL,
    dob_year SMALLINT UNSIGNED NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    avatar_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng user_address
CREATE TABLE user_address (
    user_address_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    address VARCHAR(255) NOT NULL,
    ward_commune VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    province_city VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    INDEX idx_user_address_user_id (user_id)
);

-- Bảng categories
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL UNIQUE,
    image VARCHAR(50),
    description TEXT,
    slug VARCHAR(255) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng subcategories
CREATE TABLE subcategories (
    subcategory_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    subcategory_slug VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    UNIQUE (category_id, name)
);

-- Bảng brands
CREATE TABLE brands (
    brand_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    logo_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng products
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    brand_id INT,
    subcategory_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE,
    is_featured BOOLEAN DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id) ON DELETE
    SET
        NULL ON UPDATE NO ACTION,
        FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id) ON DELETE RESTRICT ON UPDATE NO ACTION
);

-- Bảng product_contents
CREATE TABLE product_contents (
    content_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    description TEXT,
    image_url VARCHAR(255) null,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE product_specs (
    spec_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    spec_name VARCHAR(255) NOT NULL,
    spec_value VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng attributes
CREATE TABLE attributes (
    attribute_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_type VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng attribute_options
CREATE TABLE attribute_options (
    attribute_option_id INT PRIMARY KEY AUTO_INCREMENT,
    attribute_id INT NOT NULL,
    value VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    UNIQUE (attribute_id, value)
);

-- Bảng skus
CREATE TABLE skus (
    sku_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    sku_code VARCHAR(100) UNIQUE,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    stock_quantity INT NOT NULL CHECK (stock_quantity >= 0),
    is_default TINYINT(1) DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng promotions
CREATE TABLE promotions (
    promotion_id INT PRIMARY KEY AUTO_INCREMENT,
    sku_code VARCHAR(50) NOT NULL,
    discount_percent INT CHECK (
        discount_percent BETWEEN 1
        AND 100
    ),
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sku_code) REFERENCES skus(sku_code) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng attribute_option_sku
CREATE TABLE attribute_option_sku (
    sku_id INT NOT NULL,
    attribute_option_id INT NOT NULL,
    PRIMARY KEY (sku_id, attribute_option_id),
    FOREIGN KEY (sku_id) REFERENCES skus(sku_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (attribute_option_id) REFERENCES attribute_options(attribute_option_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng variant_images
CREATE TABLE variant_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    sku_id INT NOT NULL,
    image_set VARCHAR(255),
    is_default BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sku_id) REFERENCES skus(sku_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng cart
CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    INDEX idx_cart_user_id (user_id)
);

-- Bảng cart_items
CREATE TABLE cart_items (
    cart_item_id INT PRIMARY KEY AUTO_INCREMENT,
    cart_id INT NOT NULL,
    sku_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    selected TINYINT(1) DEFAULT 1,
    -- Đổi thành DEFAULT 1 để đồng bộ với INSERT
    color VARCHAR(255),
    warranty_enabled TINYINT(1) DEFAULT 0,
    voucher_code VARCHAR(50),
    image_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (sku_id) REFERENCES skus(sku_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    UNIQUE KEY cart_id_sku_id_color (cart_id, sku_id, color)
);

-- Bảng reviews
CREATE TABLE reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL,
    product_id INT NOT NULL,
    parent_review_id INT,
    rating INT CHECK (
        rating >= 1
        AND rating <= 5
        OR rating IS NULL
    ),
    comment_text TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_viewed BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (parent_review_id) REFERENCES reviews(review_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    INDEX idx_reviews_product_id (product_id),
    INDEX idx_reviews_user_id (user_id)
);

-- Bảng wishlist
CREATE TABLE wishlist (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (user_id, product_id),
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng coupons
CREATE TABLE coupons (
    coupon_id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    discount_percent INT CHECK (
        discount_percent BETWEEN 1
        AND 100
    ),
    start_date DATETIME NOT NULL,
    expires_at DATETIME,
    max_usage INT CHECK (max_usage > 0),
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE coupon_usage (
    usage_id INT PRIMARY KEY AUTO_INCREMENT,
    coupon_id INT NOT NULL,
    cart_id INT NOT NULL,
    used_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id) ON DELETE CASCADE,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE
);

-- Bảng orders
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    user_address_id INT NOT NULL,
    coupon_id INT,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    status ENUM(
        'pending',
        'paid',
        'shipped',
        'completed',
        'cancelled'
    ) DEFAULT 'pending',
    total_price DECIMAL(10, 2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (user_address_id) REFERENCES user_address(user_address_id) ON DELETE RESTRICT ON UPDATE NO ACTION,
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id) ON DELETE
    SET
        NULL ON UPDATE NO ACTION
);

-- Bảng order_items
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    sku_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE ON UPDATE NO ACTION,
    FOREIGN KEY (sku_id) REFERENCES skus(sku_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng payments
CREATE TABLE payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    payment_method ENUM(
        'cod',
        'bank_transfer',
        'credit_card',
        'momo',
        'zalopay'
    ) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_date DATETIME,
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE ON UPDATE NO ACTION
);

-- Bảng shipping
CREATE TABLE shipping (
    shipping_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    carrier VARCHAR(255),
    tracking_number VARCHAR(255),
    estimated_delivery DATETIME,
    status ENUM('waiting', 'in_transit', 'delivered', 'returned') DEFAULT 'waiting',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE ON UPDATE NO ACTION
);