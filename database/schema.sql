-- Creating table for users
CREATE TABLE users (
    user_id INT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    role VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) NOT NULL
);

-- Creating table for user_addresses
CREATE TABLE user_addresses (
    address_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    address_line VARCHAR(255) NOT NULL,
    province VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for brands
CREATE TABLE brands (
    brand_id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    logo_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Creating table for categories
CREATE TABLE categories (
    category_id INT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    product_total INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Creating table for categories_description
CREATE TABLE categories_description (
    category_description_id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    display_order INT NOT NULL
);

-- Creating table for category_description_content
CREATE TABLE category_description_content (
    category_description_content_id INT PRIMARY KEY,
    category_description_id INT NOT NULL,
    text TEXT NOT NULL,
    content_order INT NOT NULL,
    FOREIGN KEY (category_description_id) REFERENCES categories_description(category_description_id)
);

-- Creating table for category_description_images
CREATE TABLE category_description_images (
    category_description_image_id INT PRIMARY KEY,
    category_description_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    image_order INT NOT NULL,
    FOREIGN KEY (category_description_id) REFERENCES categories_description(category_description_id)
);

-- Creating table for products
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

-- Creating table for product_descriptions
CREATE TABLE product_descriptions (
    product_description_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    display_order INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Creating table for product_description_content
CREATE TABLE product_description_content (
    product_description_content_id INT PRIMARY KEY,
    product_description_id INT NOT NULL,
    content_text TEXT NOT NULL,
    content_order INT NOT NULL,
    FOREIGN KEY (product_description_id) REFERENCES product_descriptions(product_description_id)
);

-- Creating table for description_images
CREATE TABLE product_description_images (
    description_images_id INT PRIMARY KEY,
    product_description_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    image_order INT NOT NULL,
    FOREIGN KEY (product_description_id) REFERENCES product_descriptions(product_description_id)
);

-- Creating table for colors
CREATE TABLE colors (
    color_id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    hex_code VARCHAR(7),
    is_active BOOLEAN NOT NULL
);

-- Creating table for storage_options
CREATE TABLE storage_options (
    storage_id INT PRIMARY KEY,
    capacity VARCHAR(20) NOT NULL,
    is_active BOOLEAN NOT NULL
);

-- Creating table for product_variants
CREATE TABLE product_variants (
    variant_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    color_id INT NOT NULL,
    storage_id INT NOT NULL,
    original_price DECIMAL(15, 2) NOT NULL,
    discount_percentage DECIMAL(5, 2),
    stock_quantity INT NOT NULL,
    is_available BOOLEAN NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (color_id) REFERENCES colors(color_id),
    FOREIGN KEY (storage_id) REFERENCES storage_options(storage_id)
);

-- Creating table for product_media
CREATE TABLE product_media (
    media_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    media_type VARCHAR(20) NOT NULL,
    url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    display_order INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Creating table for product_specifications
CREATE TABLE product_specifications (
    spec_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    spec_group VARCHAR(100) NOT NULL,
    spec_name VARCHAR(100) NOT NULL,
    spec_value VARCHAR(255) NOT NULL,
    display_order INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Creating table for warranty
CREATE TABLE warranty (
    warranty_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    original_price DECIMAL(15, 2) NOT NULL,
    current_price DECIMAL(15, 2) NOT NULL,
    duration_months INT NOT NULL,
    coverage TEXT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Creating table for payment_methods
CREATE TABLE payment_methods (
    payment_id INT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL,
    provider VARCHAR(100),
    is_active BOOLEAN NOT NULL,
    installment_options JSON,
    interest_rate DECIMAL(5, 2) NOT NULL,
    minimum_amount DECIMAL(15, 2) NOT NULL
);

-- Creating table for promotions
CREATE TABLE product_promotions (
    promotion_id INT PRIMARY KEY,
    product_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    promotion_type VARCHAR(50) NOT NULL,
    discount_value DECIMAL(15, 2) NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_active BOOLEAN NOT NULL,
    terms_conditions TEXT,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Creating table for coupons
CREATE TABLE coupons (
    coupon_id INT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    discount_type VARCHAR(50) NOT NULL,
    discount_value DECIMAL(15, 2) NOT NULL,
    min_order_value DECIMAL(15, 2) NOT NULL,
    usage_limit INT NOT NULL,
    used_count INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    is_active BOOLEAN NOT NULL
);

-- Creating table for reviews
CREATE TABLE reviews (
    review_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    review_content TEXT,
    status VARCHAR(20) NOT NULL,
    is_verified_purchase BOOLEAN NOT NULL,
    helpful_count INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for review_images
CREATE TABLE review_images (
    review_image_id INT PRIMARY KEY,
    review_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    display_order INT NOT NULL,
    FOREIGN KEY (review_id) REFERENCES reviews(review_id)
);

-- Creating table for comments
CREATE TABLE comments (
    comment_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_content TEXT NOT NULL,
    like_count INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for comment_replies
CREATE TABLE comment_replies (
    reply_id INT PRIMARY KEY,
    comment_id INT NOT NULL,
    user_id INT NOT NULL,
    reply_content TEXT NOT NULL,
    like_count INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for product_questions
CREATE TABLE product_questions (
    question_id INT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    question_title VARCHAR(255) NOT NULL,
    question_content TEXT NOT NULL,
    answer_content TEXT,
    question_date DATETIME NOT NULL,
    answer_date DATETIME,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for blogs
CREATE TABLE blogs (
    blog_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    status VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for blog_contents
CREATE TABLE blog_contents (
    blog_content_id INT PRIMARY KEY,
    blog_id INT NOT NULL,
    content_text TEXT NOT NULL,
    content_order INT NOT NULL,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id)
);

-- Creating table for blog_images
CREATE TABLE blog_images (
    blog_image_id INT PRIMARY KEY,
    blog_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    image_order INT NOT NULL,
    FOREIGN KEY (blog_id) REFERENCES blogs(blog_id)
);

-- Creating table for carts
CREATE TABLE carts (
    cart_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Creating table for cart_items
CREATE TABLE cart_items (
    cart_item_id INT PRIMARY KEY,
    cart_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(15, 2) NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cart_id) REFERENCES carts(cart_id)
);

-- Creating table for orders
CREATE TABLE orders (
    order_id INT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(20) NOT NULL UNIQUE,
    status VARCHAR(20) NOT NULL,
    subtotal DECIMAL(15, 2) NOT NULL,
    discount_amount DECIMAL(15, 2) NOT NULL,
    shipping_fee DECIMAL(15, 2) NOT NULL,
    total_amount DECIMAL(15, 2) NOT NULL,
    address_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (address_id) REFERENCES user_addresses(address_id)
);

-- Creating table for order_items
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY,
    order_id INT NOT NULL,
    variant_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(15, 2) NOT NULL,
    discount_amount DECIMAL(15, 2) NOT NULL,
    total_price DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (variant_id) REFERENCES product_variants(variant_id)
);