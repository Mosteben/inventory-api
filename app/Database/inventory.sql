-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2026 at 07:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `entity` varchar(50) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity`, `entity_id`, `description`, `created_at`) VALUES
(1, 4, 'CREATE', 'PRODUCT', 15, 'Created product: Gaming Mouse', '2026-07-03 16:18:16'),
(2, 4, 'CREATE', 'PRODUCT', 16, 'Created product: HP Mouse', '2026-07-03 17:27:55'),
(3, 4, 'UPDATE', 'PRODUCT', 16, 'Updated product: HP Mouse', '2026-07-03 17:28:24'),
(4, 4, 'DELETE', 'PRODUCT', 16, 'Deleted product: HP Mouse', '2026-07-03 17:28:33'),
(5, 4, 'STOCK_IN', 'PRODUCT', 13, 'Stock In: +5 for product Keyboard', '2026-07-03 18:46:05'),
(6, 4, 'STOCK_OUT', 'PRODUCT', 13, 'Stock Out: -5 for product Keyboard', '2026-07-03 18:51:25'),
(7, 4, 'STOCK_OUT', 'PRODUCT', 14, 'Stock Out: -5 for product Keyboard', '2026-07-03 18:54:11'),
(8, 4, 'STOCK_OUT', 'PRODUCT', 14, 'Stock Out: -5 for product Keyboard', '2026-07-03 18:54:14'),
(9, 4, 'CREATE', 'ORDER', 19, 'Created Order #19', '2026-07-03 20:38:32'),
(10, 4, 'UPDATE', 'ORDER', 19, 'Cancelled Order #19', '2026-07-03 20:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(4, 'Electronics', 'sdfgg', '2026-07-01 00:01:22', '2026-07-01 00:24:00'),
(5, 'Computers', NULL, '2026-07-01 00:01:22', '2026-07-01 00:01:22'),
(6, 'Mobiles', NULL, '2026-07-01 00:01:22', '2026-07-01 00:01:22'),
(7, 'Accessories', NULL, '2026-07-01 00:01:22', '2026-07-01 00:01:22'),
(8, 'Networking', NULL, '2026-07-01 00:01:22', '2026-07-01 00:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('IN','OUT') NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_transactions`
--

INSERT INTO `inventory_transactions` (`id`, `product_id`, `user_id`, `type`, `quantity`, `note`, `created_at`) VALUES
(10, 14, 4, 'OUT', 2, 'Order #18', '2026-07-03 14:18:11'),
(11, 14, 4, 'IN', 2, 'Cancel Order #18', '2026-07-03 14:29:54'),
(13, 13, 3, 'IN', 5, 'Purchase from supplier', '2026-07-03 18:46:05'),
(14, 13, 3, 'OUT', 5, 'Purchase from supplier', '2026-07-03 18:51:25'),
(15, 14, 3, 'OUT', 5, 'Purchase from supplier', '2026-07-03 18:54:11'),
(16, 14, 3, 'OUT', 5, 'Purchase from supplier', '2026-07-03 18:54:14'),
(17, 15, 4, 'OUT', 1, 'Order #19', '2026-07-03 20:38:32'),
(18, 15, 4, 'IN', 1, 'Cancel Order #19', '2026-07-03 20:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT 0.00,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`, `updated_at`) VALUES
(14, 4, 1600.00, 'pending', '2026-07-02 16:55:13', '2026-07-02 16:55:13'),
(15, 4, 2400.00, 'pending', '2026-07-02 17:06:32', '2026-07-02 17:06:32'),
(16, 4, 1600.00, 'pending', '2026-07-03 14:00:10', '2026-07-03 14:00:10'),
(17, 4, 1600.00, 'pending', '2026-07-03 14:02:32', '2026-07-03 14:02:32'),
(18, 4, 10000.00, 'cancelled', '2026-07-03 14:18:11', '2026-07-03 14:29:54'),
(19, 4, 3600.00, 'cancelled', '2026-07-03 20:38:32', '2026-07-03 20:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(18, 14, 13, 2, 800.00),
(19, 15, 13, 3, 800.00),
(20, 16, 13, 2, 800.00),
(21, 17, 13, 2, 800.00),
(22, 18, 14, 2, 5000.00),
(23, 19, 15, 2, 1200.00),
(24, 19, 15, 1, 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sku` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `sku`, `price`, `quantity`, `category_id`, `supplier_id`, `status`, `created_at`, `updated_at`) VALUES
(13, 'Keyboard', 'is very nice keyboard', 'KB001', 800.00, 0, 5, 5, 'active', '2026-07-01 00:12:04', '2026-07-03 18:51:25'),
(14, 'Keyboard', NULL, 'KB006', 5000.00, 0, 4, 5, 'active', '2026-07-01 00:12:45', '2026-07-03 18:54:14'),
(15, 'Gaming Mouse', 'RGB Mouse', 'GM001', 1200.00, 20, 4, 5, 'active', '2026-07-03 16:18:16', '2026-07-03 20:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(5, 'Dell Egypt', NULL, '01011111111', 'Cairo', '2026-07-01 00:01:41', '2026-07-01 00:01:41'),
(6, 'HP Egypt', NULL, '01022222222', 'Giza', '2026-07-01 00:01:41', '2026-07-01 00:01:41'),
(7, 'Samsung', NULL, '01033333333', 'Alex', '2026-07-01 00:01:41', '2026-07-01 00:01:41'),
(8, 'Lenovo', NULL, '01044444444', 'Nasr City', '2026-07-01 00:01:41', '2026-07-01 00:01:41'),
(9, 'Canon', NULL, '01055555555', '6 October', '2026-07-01 00:01:41', '2026-07-01 00:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('admin','employee','customer') NOT NULL,
  `status` enum('active','inactive','blocked') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `address`, `password`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Mostafa', 'mostafa@gmail.com', 'Cairo', '$2y$10$brzQzfFQzwExQCi8yf1Ih.7LTgIix4tqCxqlMOOAuCPbQjcGMILWS', '01012345678', 'admin', 'active', '2026-06-30 23:35:20', '2026-07-01 00:09:20'),
(4, 'System Admin', 'admin@gmail.com', 'Cairo', '$2y$10$aAOhI9fa4fI/cJKmn.aYYucBb82xdDz3.4IUt4eEVSlwhpmN3PN8O', '01000000001', 'admin', 'active', '2026-06-30 23:45:27', '2026-07-03 20:45:43'),
(5, 'Ahmed Employee', 'employee@gmail.com', 'Giza', '$2y$10$pE5u8JhrL/HD7r2VTkDVoe/J3rxjkpnT.BAgoyNqJdM498da214wm', '01000000002', 'customer', 'active', '2026-06-30 23:45:48', '2026-06-30 23:45:48'),
(6, 'Mostafa Customer', 'customer@gmail.com', 'Alexandria', '$2y$10$kdhRxc4R5YCX149tA.xwAul27WjQiQ6U2KmJFaDL2hB4Uokno6gLK', '01000000003', 'customer', 'active', '2026-06-30 23:46:03', '2026-06-30 23:46:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_order` (`order_id`),
  ADD KEY `fk_item_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_supplier` (`supplier_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `inventory_transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_item_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
