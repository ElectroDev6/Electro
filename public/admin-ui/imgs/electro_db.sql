-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th7 26, 2025 lúc 02:29 PM
-- Phiên bản máy phục vụ: 8.0.41
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `electro_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `content_html` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `create_at`, `content_html`) VALUES
(1, 'Điện thoại', '2025-07-26 13:29:26', '<p>Các sản phẩm điện thoại thông minh</p>'),
(2, 'Máy tính bảng', '2025-07-26 13:34:49', '<p>Tablet cho công việc và giải trí</p>'),
(3, 'Laptop', '2025-07-26 13:34:49', '<p>Laptop cho học tập và làm việc</p>'),
(4, 'Đồng hồ thông minh', '2025-07-26 13:34:49', '<p>Smartwatch theo dõi sức khỏe</p>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `hex_code` varchar(7) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `name`, `hex_code`, `is_active`) VALUES
(1, 'Đen', '#000000', 1),
(2, 'Trắng', '#FFFFFF', 1),
(3, 'Titan', '#A9A9A9', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `group_color_img`
--

CREATE TABLE `group_color_img` (
  `id` int NOT NULL,
  `variant_color_id` int NOT NULL,
  `url` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `group_color_img`
--

INSERT INTO `group_color_img` (`id`, `variant_color_id`, `url`, `alt_text`, `sort_order`) VALUES
(1, 1, '/admin/imgs/iphone-15-256gb-black-1.png', 'iPhone 15 Pro Max 256GB Đen - Mặt trước', 1),
(2, 1, '/admin/imgs/iphone-15-256gb-black-2.png', 'iPhone 15 Pro Max 256GB Đen - Mặt sau', 2),
(3, 1, '/admin/imgs/iphone-15-256gb-black-3.png', 'iPhone 15 Pro Max 256GB Đen - Cạnh bên', 3),
(4, 1, '/admin/imgs/iphone-15-256gb-black-4.png', 'iPhone 15 Pro Max 256GB Đen - Camera', 4),
(5, 2, '/admin/imgs/iphone-15-256gb-white-1.png', 'iPhone 15 Pro Max 256GB Trắng - Mặt trước', 1),
(6, 2, '/admin/imgs/iphone-15-256gb-white-2.png', 'iPhone 15 Pro Max 256GB Trắng - Mặt sau', 2),
(7, 2, '/admin/imgs/iphone-15-256gb-white-3.png', 'iPhone 15 Pro Max 256GB Trắng - Cạnh bên', 3),
(8, 2, '/admin/imgs/iphone-15-256gb-white-4.png', 'iPhone 15 Pro Max 256GB Trắng - Camera', 4),
(9, 3, '/admin/imgs/iphone-15-256gb-titan-1.png', 'iPhone 15 Pro Max 256GB Titan - Mặt trước', 1),
(10, 3, '/admin/imgs/iphone-15-256gb-titan-2.png', 'iPhone 15 Pro Max 256GB Titan - Mặt sau', 2),
(11, 3, '/admin/imgs/iphone-15-256gb-titan-3.png', 'iPhone 15 Pro Max 256GB Titan - Cạnh bên', 3),
(12, 3, '/admin/imgs/iphone-15-256gb-titan-4.png', 'iPhone 15 Pro Max 256GB Titan - Camera', 4),
(13, 4, '/admin/imgs/iphone-15-512gb-black-1.png', 'iPhone 15 Pro Max 512GB Đen - Mặt trước', 1),
(14, 4, '/admin/imgs/iphone-15-512gb-black-2.png', 'iPhone 15 Pro Max 512GB Đen - Mặt sau', 2),
(15, 4, '/admin/imgs/iphone-15-512gb-black-3.png', 'iPhone 15 Pro Max 512GB Đen - Cạnh bên', 3),
(16, 4, '/admin/imgs/iphone-15-512gb-black-4.png', 'iPhone 15 Pro Max 512GB Đen - Camera', 4),
(17, 5, '/admin/imgs/iphone-15-512gb-white-1.png', 'iPhone 15 Pro Max 512GB Trắng - Mặt trước', 1),
(18, 5, '/admin/imgs/iphone-15-512gb-white-2.png', 'iPhone 15 Pro Max 512GB Trắng - Mặt sau', 2),
(19, 5, '/admin/imgs/iphone-15-512gb-white-3.png', 'iPhone 15 Pro Max 512GB Trắng - Cạnh bên', 3),
(20, 5, '/admin/imgs/iphone-15-512gb-white-4.png', 'iPhone 15 Pro Max 512GB Trắng - Camera', 4),
(21, 6, '/admin/imgs/iphone-15-512gb-titan-1.png', 'iPhone 15 Pro Max 512GB Titan - Mặt trước', 1),
(22, 6, '/admin/imgs/iphone-15-512gb-titan-2.png', 'iPhone 15 Pro Max 512GB Titan - Mặt sau', 2),
(23, 6, '/admin/imgs/iphone-15-512gb-titan-3.png', 'iPhone 15 Pro Max 512GB Titan - Cạnh bên', 3),
(24, 6, '/admin/imgs/iphone-15-512gb-titan-4.png', 'iPhone 15 Pro Max 512GB Titan - Camera', 4),
(25, 7, '/admin/imgs/iphone-15-1tb-black-1.png', 'iPhone 15 Pro Max 1TB Đen - Mặt trước', 1),
(26, 7, '/admin/imgs/iphone-15-1tb-black-2.png', 'iPhone 15 Pro Max 1TB Đen - Mặt sau', 2),
(27, 7, '/admin/imgs/iphone-15-1tb-black-3.png', 'iPhone 15 Pro Max 1TB Đen - Cạnh bên', 3),
(28, 7, '/admin/imgs/iphone-15-1tb-black-4.png', 'iPhone 15 Pro Max 1TB Đen - Camera', 4),
(29, 8, '/admin/imgs/iphone-15-1tb-white-1.png', 'iPhone 15 Pro Max 1TB Trắng - Mặt trước', 1),
(30, 8, '/admin/imgs/iphone-15-1tb-white-2.png', 'iPhone 15 Pro Max 1TB Trắng - Mặt sau', 2),
(31, 8, '/admin/imgs/iphone-15-1tb-white-3.png', 'iPhone 15 Pro Max 1TB Trắng - Cạnh bên', 3),
(32, 8, '/admin/imgs/iphone-15-1tb-white-4.png', 'iPhone 15 Pro Max 1TB Trắng - Camera', 4),
(33, 9, '/admin/imgs/iphone-15-1tb-titan-1.png', 'iPhone 15 Pro Max 1TB Titan - Mặt trước', 1),
(34, 9, '/admin/imgs/iphone-15-1tb-titan-2.png', 'iPhone 15 Pro Max 1TB Titan - Mặt sau', 2),
(35, 9, '/admin/imgs/iphone-15-1tb-titan-3.png', 'iPhone 15 Pro Max 1TB Titan - Cạnh bên', 3),
(36, 9, '/admin/imgs/iphone-15-1tb-titan-4.png', 'iPhone 15 Pro Max 1TB Titan - Camera', 4),
(37, 10, '/admin/imgs/example1-front.png', 'Mặt trước', 1),
(38, 10, '/admin/imgs/example1-back.png', 'Mặt sau', 2),
(39, 10, '/admin/imgs/example1-side.png', 'Cạnh bên', 3),
(40, 10, '/admin/imgs/example1-camera.png', 'Camera', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description_html` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `create_at`, `update_date`, `description_html`) VALUES
(1, 1, 'iPhone 15 Pro Max', '2025-07-26 13:29:26', '2025-07-26 13:29:26', '<p>iPhone 15 Pro Max với chip A17 Pro mạnh mẽ và camera tiên tiến</p>'),
(2, 1, 'iPhone 14', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPhone 14 với chip A15 Bionic và camera kép</p>'),
(3, 1, 'iPhone 13', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPhone 13 mạnh mẽ, thiết kế hiện đại</p>'),
(4, 2, 'iPad Air 5', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPad Air 5 với chip M1 mạnh mẽ</p>'),
(5, 2, 'iPad Pro 2022', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPad Pro với chip M2</p>'),
(6, 3, 'MacBook Air M2', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>MacBook Air M2 mỏng nhẹ, hiệu năng cao</p>'),
(7, 3, 'MacBook Pro M3', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>MacBook Pro M3 mạnh mẽ cho dân chuyên</p>'),
(8, 4, 'Apple Watch SE', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>Đồng hồ thông minh SE giá tốt</p>'),
(9, 4, 'Apple Watch Series 9', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>Series 9 với màn hình Always-On</p>'),
(10, 1, 'iPhone 15', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPhone 15 bản thường với nhiều màu sắc mới</p>'),
(11, 1, 'iPhone 15 Plus', '2025-07-26 13:34:55', '2025-07-26 13:34:55', '<p>iPhone 15 Plus pin trâu hơn</p>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variants`
--

CREATE TABLE `variants` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `capacity_group` varchar(50) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `original_price` decimal(12,2) NOT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `media_url` varchar(500) DEFAULT NULL,
  `media_alt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `variants`
--

INSERT INTO `variants` (`id`, `product_id`, `capacity_group`, `price`, `original_price`, `stock_quantity`, `media_url`, `media_alt`) VALUES
(1, 1, '256GB', 28490000.00, 30390000.00, 50, '/admin/imgs/iphone-15-img-2.png', 'iPhone 15 Pro Max 256GB'),
(2, 1, '512GB', 34900000.00, 36900000.00, 30, '/admin/imgs/iphone-15-img-3.png', 'iPhone 15 Pro Max 512GB'),
(3, 1, '1TB', 45900000.00, 47900000.00, 20, '/admin/imgs/iphone-15-img-4.png', 'iPhone 15 Pro Max 1TB'),
(10, 2, '128GB', 18900000.00, 20900000.00, 100, '/admin/imgs/iphone-14-128.png', 'iPhone 14 128GB'),
(11, 2, '256GB', 21400000.00, 23900000.00, 50, '/admin/imgs/iphone-14-256.png', 'iPhone 14 256GB'),
(12, 4, '64GB', 14500000.00, 15900000.00, 40, '/admin/imgs/ipad-air-64.png', 'iPad Air 64GB'),
(13, 4, '256GB', 17900000.00, 19900000.00, 25, '/admin/imgs/ipad-air-256.png', 'iPad Air 256GB'),
(14, 6, '256GB', 27900000.00, 28900000.00, 30, '/admin/imgs/macbook-air-256.png', 'MacBook Air M2 256GB'),
(15, 6, '512GB', 32900000.00, 34900000.00, 20, '/admin/imgs/macbook-air-512.png', 'MacBook Air M2 512GB'),
(16, 10, '128GB', 22900000.00, 24900000.00, 45, '/admin/imgs/iphone-15-128.png', 'iPhone 15 128GB'),
(17, 10, '256GB', 26400000.00, 28400000.00, 35, '/admin/imgs/iphone-15-256.png', 'iPhone 15 256GB');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variant_colors`
--

CREATE TABLE `variant_colors` (
  `id` int NOT NULL,
  `variant_id` int NOT NULL,
  `color_id` int NOT NULL,
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `variant_colors`
--

INSERT INTO `variant_colors` (`id`, `variant_id`, `color_id`, `stock`) VALUES
(1, 1, 1, 20),
(2, 1, 2, 15),
(3, 1, 3, 15),
(4, 2, 1, 10),
(5, 2, 2, 10),
(6, 2, 3, 10),
(7, 3, 1, 5),
(8, 3, 2, 5),
(9, 3, 3, 10),
(10, 10, 1, 30),
(11, 10, 2, 20),
(12, 10, 3, 50),
(13, 11, 1, 15),
(14, 11, 2, 15),
(15, 11, 3, 20),
(16, 12, 1, 20),
(17, 12, 2, 10),
(18, 12, 3, 10),
(19, 13, 1, 10),
(20, 13, 2, 10),
(21, 13, 3, 5),
(22, 14, 1, 15),
(23, 14, 2, 5),
(24, 14, 3, 10),
(25, 15, 1, 10),
(26, 15, 2, 5),
(27, 15, 3, 5),
(28, 16, 1, 20),
(29, 16, 2, 15),
(30, 16, 3, 10),
(31, 17, 1, 10),
(32, 17, 2, 10),
(33, 17, 3, 15);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `group_color_img`
--
ALTER TABLE `group_color_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_variant_color_sort` (`variant_color_id`,`sort_order`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `variant_colors`
--
ALTER TABLE `variant_colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_variant_color` (`variant_id`,`color_id`),
  ADD KEY `color_id` (`color_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `group_color_img`
--
ALTER TABLE `group_color_img`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `variant_colors`
--
ALTER TABLE `variant_colors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `group_color_img`
--
ALTER TABLE `group_color_img`
  ADD CONSTRAINT `group_color_img_ibfk_1` FOREIGN KEY (`variant_color_id`) REFERENCES `variant_colors` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ràng buộc cho bảng `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `variant_colors`
--
ALTER TABLE `variant_colors`
  ADD CONSTRAINT `variant_colors_ibfk_1` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variant_colors_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
