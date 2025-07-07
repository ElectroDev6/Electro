-- Tạo bảng categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Tạo bảng brands
CREATE TABLE brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Tạo bảng specification_attributes
CREATE TABLE specification_attributes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Tạo bảng product
CREATE TABLE product (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    brand_id INT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (brand_id) REFERENCES brands(id)
);

-- Tạo bảng product_descriptions
CREATE TABLE product_descriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    description TEXT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng product_promotions
CREATE TABLE product_promotions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    promotion_details VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng product_payment_offers
CREATE TABLE product_payment_offers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    offer_details VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng product_gifts
CREATE TABLE product_gifts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    gift_details VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng reviews
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    rating DECIMAL(2, 1) NOT NULL,
    comment TEXT,
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng product_specification_values
CREATE TABLE product_specification_values (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    specification_attribute_id INT,
    value VARCHAR(100) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (specification_attribute_id) REFERENCES specification_attributes(id)
);

-- Tạo bảng product_variants
CREATE TABLE product_variants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    variant_details VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Tạo bảng product_images
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
);