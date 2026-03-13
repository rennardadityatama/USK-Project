-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 06:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(35, 'Non Fiction'),
(36, 'Bussiness'),
(42, 'Comic');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `product_id` int(11) DEFAULT NULL COMMENT 'Product being discussed',
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `room_id`, `sender_id`, `message`, `product_id`, `is_read`, `created_at`) VALUES
(74, 9, 35, 'tes', 0, 0, '2026-03-09 23:37:15'),
(75, 9, 35, 'tes', 0, 0, '2026-03-10 04:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `last_product_id` int(11) DEFAULT NULL COMMENT 'The last product to talk about',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `customer_id`, `seller_id`, `last_product_id`, `created_at`, `updated_at`) VALUES
(9, 35, 36, 17, '2026-03-09 23:33:32', '2026-03-10 04:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(225) NOT NULL,
  `message` text NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `order_id`, `room_id`, `type`, `title`, `message`, `is_read`, `created_at`) VALUES
(25, 35, 66, NULL, 'order_approved', 'Order Approved', 'Your order #000066 has been approved', 1, '2026-03-09 21:47:19'),
(26, 36, NULL, 9, 'chat', 'New Message', 'rennard sent you a message', 1, '2026-03-09 23:37:15'),
(28, 35, 67, NULL, 'order_approved', 'Order Approved', 'Your order #000067 has been approved', 1, '2026-03-10 03:18:58'),
(30, 35, 68, NULL, 'order_approved', 'Order Approved', 'Your order #000068 has been approved', 1, '2026-03-10 03:32:59'),
(32, 35, 69, NULL, 'order_completed', 'Order Completed', 'Your order #000069 has been approved', 1, '2026-03-10 03:41:56'),
(34, 35, 70, NULL, 'order_completed', 'Order Completed', 'Your order #000070 has been approved', 1, '2026-03-10 04:05:26'),
(36, 35, 71, NULL, 'order_completed', 'Order Completed', 'Your order #000071 has been approved', 1, '2026-03-10 04:10:44'),
(38, 38, 72, NULL, 'order_completed', 'Order Completed', 'Your order #000072 has been approved', 1, '2026-03-10 04:19:13'),
(39, 36, NULL, 9, 'chat', 'New Message', 'rennard sent you a message', 0, '2026-03-10 04:55:54'),
(41, 35, 73, NULL, 'order_completed', 'Order Completed', 'Your order #000073 has been approved', 1, '2026-03-10 04:58:03'),
(42, 36, 74, NULL, 'new_order', 'New Order', 'Order #000074 needs completed payment', 0, '2026-03-10 04:59:34'),
(43, 36, 75, NULL, 'new_order', 'New Order', 'Order #000075 needs completed payment', 0, '2026-03-10 05:09:16'),
(44, 36, 76, NULL, 'new_order', 'New Order', 'Order #000076 needs completed payment', 0, '2026-03-10 05:14:19'),
(46, 35, 77, NULL, 'order_completed', 'Order Completed', 'Your order #000077 has been approved', 0, '2026-03-10 06:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `payment_method` enum('cash','transfer') DEFAULT 'cash',
  `shipping_status` enum('pending','shipped','refund') NOT NULL DEFAULT 'pending',
  `status` enum('completed','refund','pending') NOT NULL DEFAULT 'pending',
  `payment_status` enum('paid','unpaid','waiting_verification') NOT NULL DEFAULT 'waiting_verification',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `cash_paid` decimal(12,2) DEFAULT NULL,
  `cash_change` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `seller_id`, `total_amount`, `payment_method`, `shipping_status`, `status`, `payment_status`, `created_at`, `updated_at`, `cash_paid`, `cash_change`) VALUES
(66, 35, 36, 12000, 'cash', 'pending', 'completed', 'paid', '2026-03-10 04:23:36', '2026-03-10 11:09:21', NULL, NULL),
(67, 35, 36, 100000, 'cash', 'pending', 'completed', 'paid', '2026-03-10 10:16:11', '2026-03-10 11:09:26', NULL, NULL),
(68, 35, 36, 12000, 'cash', 'pending', 'completed', 'paid', '2026-03-10 10:25:25', '2026-03-10 11:09:30', NULL, NULL),
(69, 35, 36, 12000, 'cash', 'pending', 'completed', 'paid', '2026-03-10 10:36:29', '2026-03-10 11:09:35', 12000.00, 0.00),
(70, 35, 36, 12000, 'cash', 'shipped', 'completed', 'paid', '2026-03-10 11:04:57', '2026-03-10 11:09:39', 15000.00, 3000.00),
(71, 35, 36, 112000, 'cash', 'shipped', 'completed', 'paid', '2026-03-10 11:09:02', '2026-03-10 11:10:44', 120000.00, 8000.00),
(72, 38, 36, 100000, 'cash', 'shipped', 'completed', 'paid', '2026-03-10 11:15:52', '2026-03-10 11:19:13', 150000.00, 50000.00),
(73, 35, 36, 24000, 'cash', 'shipped', 'completed', 'paid', '2026-03-10 11:57:16', '2026-03-10 11:58:03', 50000.00, 26000.00),
(74, 35, 36, 12000, 'cash', 'pending', 'pending', 'waiting_verification', '2026-03-10 11:59:34', NULL, NULL, NULL),
(75, 35, 36, 100000, 'cash', 'pending', 'pending', 'waiting_verification', '2026-03-10 12:09:16', NULL, NULL, NULL),
(76, 35, 36, 100000, 'cash', 'pending', 'pending', 'waiting_verification', '2026-03-10 12:14:19', NULL, NULL, NULL),
(77, 35, 36, 100000, 'cash', 'shipped', 'completed', 'paid', '2026-03-10 13:14:03', '2026-03-10 13:16:19', 120000.00, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `qty`, `subtotal`, `created_at`) VALUES
(34, 35, 11, 125000.00, 1, 125000.00, '2026-02-12 07:54:07'),
(35, 35, 12, 120000.00, 2, 240000.00, '2026-02-12 07:54:07'),
(36, 36, 6, 20000.00, 1, 20000.00, '2026-02-12 08:02:35'),
(37, 37, 8, 12000.00, 3, 36000.00, '2026-02-12 08:09:51'),
(38, 38, 10, 120000.00, 2, 240000.00, '2026-02-12 08:16:46'),
(39, 39, 8, 12000.00, 1, 12000.00, '2026-02-12 08:17:21'),
(40, 40, 10, 120000.00, 1, 120000.00, '2026-02-12 11:09:08'),
(41, 40, 6, 20000.00, 1, 20000.00, '2026-02-12 11:09:08'),
(42, 41, 12, 120000.00, 1, 120000.00, '2026-02-12 11:09:38'),
(43, 42, 11, 125000.00, 1, 125000.00, '2026-02-12 11:12:12'),
(44, 43, 11, 125000.00, 1, 125000.00, '2026-02-13 14:16:21'),
(45, 44, 6, 20000.00, 1, 20000.00, '2026-02-13 14:16:37'),
(46, 45, 12, 120000.00, 1, 120000.00, '2026-02-14 08:35:02'),
(49, 48, 15, 12000.00, 1, 12000.00, '2026-02-22 11:42:34'),
(50, 49, 2, 10000.00, 1, 10000.00, '2026-02-22 15:24:29'),
(51, 49, 6, 20000.00, 1, 20000.00, '2026-02-22 15:24:29'),
(53, 51, 15, 12000.00, 1, 12000.00, '2026-03-05 17:51:37'),
(54, 52, 6, 20000.00, 1, 20000.00, '2026-03-05 19:21:42'),
(55, 52, 2, 10000.00, 1, 10000.00, '2026-03-05 19:21:42'),
(56, 53, 15, 12000.00, 1, 12000.00, '2026-03-05 19:21:42'),
(57, 54, 11, 125000.00, 1, 125000.00, '2026-03-07 15:57:25'),
(58, 55, 2, 10000.00, 1, 10000.00, '2026-03-07 15:57:25'),
(59, 56, 11, 125000.00, 1, 125000.00, '2026-03-07 16:01:59'),
(60, 57, 6, 20000.00, 1, 20000.00, '2026-03-07 16:01:59'),
(62, 59, 11, 125000.00, 1, 125000.00, '2026-03-07 16:26:42'),
(63, 60, 8, 12000.00, 1, 12000.00, '2026-03-07 16:26:42'),
(64, 61, 11, 125000.00, 1, 125000.00, '2026-03-07 16:29:22'),
(65, 62, 8, 12000.00, 1, 12000.00, '2026-03-07 16:29:22'),
(66, 63, 11, 125000.00, 1, 125000.00, '2026-03-07 16:38:08'),
(67, 64, 2, 10000.00, 1, 10000.00, '2026-03-07 16:38:08'),
(68, 65, 2, 10000.00, 1, 10000.00, '2026-03-08 14:16:30'),
(69, 66, 17, 12000.00, 1, 12000.00, '2026-03-10 04:23:36'),
(70, 67, 18, 100000.00, 1, 100000.00, '2026-03-10 10:16:11'),
(71, 68, 17, 12000.00, 1, 12000.00, '2026-03-10 10:25:25'),
(72, 69, 17, 12000.00, 1, 12000.00, '2026-03-10 10:36:29'),
(73, 70, 17, 12000.00, 1, 12000.00, '2026-03-10 11:04:57'),
(74, 71, 18, 100000.00, 1, 100000.00, '2026-03-10 11:09:02'),
(75, 71, 17, 12000.00, 1, 12000.00, '2026-03-10 11:09:02'),
(76, 72, 18, 100000.00, 1, 100000.00, '2026-03-10 11:15:52'),
(77, 73, 17, 12000.00, 2, 24000.00, '2026-03-10 11:57:16'),
(78, 74, 17, 12000.00, 1, 12000.00, '2026-03-10 11:59:34'),
(79, 75, 18, 100000.00, 1, 100000.00, '2026-03-10 12:09:16'),
(80, 76, 18, 100000.00, 1, 100000.00, '2026-03-10 12:14:19'),
(81, 77, 18, 100000.00, 1, 100000.00, '2026-03-10 13:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `margin` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `cost_price`, `margin`, `stock`, `image`, `description`, `seller_id`, `category_id`, `is_active`, `deleted_at`) VALUES
(17, 'Castle in The Sky', 12000, 10000, 2000, 3, 'prod_69af33a64699a.png', 'Castle in The Sky', 36, 35, 1, NULL),
(18, 'Time Travel To Dark', 100000, 90000, 10000, 7, 'prod_69af8b0133704.png', 'Time Travel', 36, 35, 1, NULL),
(19, 'Book of Life', 12000, 10000, 2000, 0, 'prod_69afa3bcee467.png', 'Castle', 36, 42, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `reset_token`, `reset_expiry`, `address`, `role_id`, `avatar`) VALUES
(35, 'rennard', 'rennard95@gmail.com', '$2y$10$JbrwATMeTDBWTvQ/SXDAv.cHNSSFuXsLMP7HnIWpgR8pMjKyHrxB6', '082213521461', NULL, NULL, 'Jakarta', 2, ''),
(36, 'admin', 'rennardadit@gmail.com', '$2y$10$zf6hFNbAgx31hMorf9oBeuNWaCKFUSA2v0J3Uy/lnYxg9ECo2paJe', '081284421151', NULL, NULL, 'Bandung', 1, ''),
(38, 'Cella', 'cella@gmail.com', '$2y$10$BIOZN8Go6qT.36mYA8ktw.FDW9DU1EAqbGhmLnuwxmeVgpbADXyne', '082211598715', NULL, NULL, 'Jakarta', 2, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_ibfk_1` (`customer_id`),
  ADD KEY `carts_ibfk_2` (`product_id`),
  ADD KEY `carts_ibfk_3` (`seller_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `idx_room_created` (`room_id`,`created_at`);

--
-- Indexes for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_customer_seller` (`customer_id`,`seller_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `idx_updated` (`updated_at`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`phone`),
  ADD KEY `role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_rooms`
--
ALTER TABLE `chat_rooms`
  ADD CONSTRAINT `chat_rooms_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_rooms_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `chat_rooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
