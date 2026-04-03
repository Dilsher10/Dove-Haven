-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 09:44 PM
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
-- Database: `dovehaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `total_orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `balance`, `total_orders`) VALUES
(1, 'Green Grocers Ltd', 'orders@greengrocers.com', '+1 234-567-8900', '123 Market St', 1250.00, 15),
(2, 'Fresh Farms Market', 'buy@freshfarms.com', '+1 234-567-8901', '456 Farm Rd', 450.00, 8),
(3, 'ads', 'demo@gmail.com', '3000000000', 'asdfffff', 0.00, 0),
(4, 'gfhf', '394-2018@hamdard.edu', '3000000000', 'sfhh', 0.00, 0),
(5, '.htaccess', '394-2018@hamdard.edu', '3000000000', 'ssssss', 104.98, 1),
(6, 'ssssss', 'sssssssss@gmail.com', '3000000000', 'ssssssssss', 94.99, 1),
(7, 'Dilsher', 'dilsher@codeanddesigngroup.com', '3000000000', 'ssssssss', 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `lock_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `username`, `password`, `role`, `email`, `status`, `last_login`, `failed_attempts`, `lock_until`) VALUES
(1, 'Administrator', 'admin', 'admin123', 'admin', 'admin@dovehaven.com', 'active', NULL, 0, NULL),
(2, 'Farm Manager 1', 'manager1', 'manager123', 'farm_manager', 'manager1@dovehaven.com', 'active', NULL, 1, NULL),
(3, 'Farm Manager 2', 'manager2', 'manager123', 'farm_manager', 'manager2@dovehaven.com', 'active', NULL, 0, NULL),
(4, 'Supervisor', 'supervisor', 'super123', 'supervisor', 'supervisor@dovehaven.com', 'active', NULL, 0, NULL),
(5, 'Sales Manager', 'sales', 'sales123', 'sales_manager', 'sales@dovehaven.com', 'active', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `growth`
--

CREATE TABLE `growth` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `house_id` varchar(50) DEFAULT NULL,
  `flock_id` varchar(50) DEFAULT NULL,
  `avg_weight` int(11) DEFAULT NULL,
  `bird_count` int(11) DEFAULT NULL,
  `flock_age_weeks` int(11) DEFAULT NULL,
  `water_type` varchar(50) DEFAULT NULL,
  `water_amount` decimal(10,2) DEFAULT NULL,
  `medication_name` varchar(100) DEFAULT NULL,
  `medication_dosage` varchar(100) DEFAULT NULL,
  `next_dose_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `growth`
--

INSERT INTO `growth` (`id`, `date`, `house_id`, `flock_id`, `avg_weight`, `bird_count`, `flock_age_weeks`, `water_type`, `water_amount`, `medication_name`, `medication_dosage`, `next_dose_date`, `created_at`) VALUES
(1, '2026-03-31', 'house1a', '3', 1, 1, 0, 'plain', 0.00, NULL, NULL, NULL, '2026-03-31 18:01:49');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `purchased` decimal(10,2) DEFAULT NULL,
  `used` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `purchased`, `used`, `supplier`, `cost`) VALUES
('corn', 'Corn/Maize', 2489.00, 5015.00, 2521.00, 'GrainCo Ltd', 0.35),
('soybean', 'Soybean Meal', 1800.00, 3000.00, 1200.00, 'ProteinFeeds Inc', 0.45);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_transactions`
--

CREATE TABLE `inventory_transactions` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `ingredient` varchar(50) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_transactions`
--

INSERT INTO `inventory_transactions` (`id`, `date`, `ingredient`, `type`, `quantity`, `purpose`, `notes`, `created_at`) VALUES
(1, '2026-04-01', 'corn', 'purchase', 0.10, '', 'Purchased from John', '2026-04-01 17:46:31'),
(2, '2026-04-01', 'corn', 'usage', 0.10, 'new', 'ff', '2026-04-01 18:00:34'),
(3, '2026-04-01', 'soybean', 'usage', 1.00, 'new', 'ffffff', '2026-04-01 18:22:09'),
(4, '2026-04-16', 'soybean', 'purchase', 1.00, '', 'Purchased from Dilsher', '2026-04-01 18:22:38'),
(5, '2026-04-01', 'corn', 'usage', 5.00, 'new', 'ffffffffff', '2026-04-01 18:30:06'),
(6, '2026-04-01', 'corn', 'usage', 5.00, 'used', 'used', '2026-04-01 18:36:51'),
(7, '2026-04-15', 'corn', 'purchase', 5.00, '', 'Purchased from Dilsher', '2026-04-01 18:45:27'),
(8, '2026-04-02', 'corn', 'purchase', 5.00, '', 'Purchased from new', '2026-04-01 19:04:32'),
(9, '2026-04-01', 'corn', 'usage', 5.00, 'ggggg', 'gg', '2026-04-01 19:05:13'),
(10, '2026-04-02', 'corn', 'usage', 10.00, 'dgd', 'dgsdg', '2026-04-02 13:09:51'),
(11, '2026-04-02', 'corn', 'purchase', 5.00, '', 'Purchased from Uzair', '2026-04-02 18:29:20'),
(12, '2026-04-02', 'corn', 'usage', 1.00, 'fhgdg', 'dsfgdg', '2026-04-02 18:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `mortality`
--

CREATE TABLE `mortality` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `house_id` varchar(50) DEFAULT NULL,
  `deaths` int(11) DEFAULT NULL,
  `cause` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mortality`
--

INSERT INTO `mortality` (`id`, `date`, `house_id`, `deaths`, `cause`, `notes`, `created_at`) VALUES
(1, '2026-03-31', 'house1b', 1, 'disease', 'hhh', '2026-03-31 18:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `items` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `paid` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `date`, `items`, `quantity`, `product`, `total`, `paid`, `balance`, `payment_method`, `payment_status`) VALUES
('ORD-001', 1, '2024-01-15', '15 Crates Large', 15, 'eggs_large', 450.00, 200.00, 250.00, 'mixed', 'partial'),
('ORD-002', 6, '2026-03-31', '1 Crates Large Eggs, 1 Crates Medium Eggs, 1 Crates Small Eggs, 1 x Large Eggs (Tray)', 3, 'various', 95.00, 0.01, 94.99, 'cash', 'partial'),
('ORD-003', 5, '2026-03-31', '1 Crates Large Eggs, 1 Crates Medium Eggs, 1 Crates Small Eggs, 1 Crates Extra Small Eggs, 1 x Manure (Bag)', 4, 'various', 105.01, 0.03, 104.98, 'cash', 'partial');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_ref` varchar(100) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `house_id` varchar(50) DEFAULT NULL,
  `crates` int(11) DEFAULT NULL,
  `loose_eggs` int(11) DEFAULT NULL,
  `total_eggs` int(11) DEFAULT NULL,
  `large_eggs` int(11) DEFAULT NULL,
  `medium_eggs` int(11) DEFAULT NULL,
  `small_eggs` int(11) DEFAULT NULL,
  `pullet_eggs` int(11) DEFAULT NULL,
  `broken_eggs` int(11) DEFAULT NULL,
  `feed` decimal(10,2) DEFAULT NULL,
  `feed_type` varchar(50) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`id`, `date`, `house_id`, `crates`, `loose_eggs`, `total_eggs`, `large_eggs`, `medium_eggs`, `small_eggs`, `pullet_eggs`, `broken_eggs`, `feed`, `feed_type`, `comments`, `employee_id`) VALUES
(1, '2024-03-30', 'house1a', 15, 10, 460, 250, 120, 60, 20, 10, 150.50, 'layer', 'Normal collection', 1),
(2, '2026-03-31', 'house1a', 0, 5, 5, 1, 1, 1, 1, 1, 0.00, '0', 'dffffff', 1),
(3, '2026-03-31', 'house1a', 0, 5, 5, 1, 1, 1, 1, 1, 0.00, '0', 'sssssssssssssss', 1),
(4, '2026-03-31', 'house2c', 0, 1, 1, 1, 0, 0, 0, 0, 0.00, '0', 'gggggggg', 1),
(5, '2026-03-31', 'house2b', 0, 5, 5, 1, 1, 1, 1, 1, 0.00, '0', 'fffffffff', 1),
(6, '2026-03-31', 'house1c', 0, 17, 17, 10, 4, 2, 1, 0, 0.00, '0', 'dddddddd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `item` varchar(100) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `supplier` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `category`, `item`, `quantity`, `unit`, `unit_cost`, `total_cost`, `supplier`) VALUES
(1, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil'),
(2, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil'),
(3, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil'),
(4, '2026-03-31', 'Feed Ingredient', 'corn', 0.10, 'kg', 0.01, 0.01, 'f'),
(5, '2026-03-31', 'feed', 'hhh', 1.00, 'kg', 0.01, 0.01, 'dil'),
(6, '2026-03-31', 'feed', 'new', 1.00, 'units', 0.01, 0.01, 'dil'),
(7, '2026-03-31', 'Feed Ingredient', 'wheat', 4.40, 'kg', 0.25, 0.25, 'John'),
(8, '2026-04-01', 'Feed Ingredient', 'corn', 5.00, 'kg', 1.00, 1.00, 'John');

-- --------------------------------------------------------

--
-- Table structure for table `refresh_tokens`
--

CREATE TABLE `refresh_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refresh_tokens`
--

INSERT INTO `refresh_tokens` (`id`, `user_id`, `token`, `expires_at`, `created_at`) VALUES
(1, 1, '6c89e3b91dc95bfff751897901d0e5e53502bb70f31013c3b94d84dca2ba5aae', '2026-04-09 16:29:59', '2026-04-02 19:29:59'),
(2, 1, '3d87a5a090947749f751e39e5ce719f431b7e733c0682846a37c41add68abf45', '2026-04-09 16:30:52', '2026-04-02 19:30:52'),
(3, 1, 'a8bb9c86fbedf71a2dd5c20893a88ff357679f77d52f865e70fcae57a11cc643', '2026-04-09 17:04:22', '2026-04-02 20:04:22'),
(5, 1, 'b3c774f354d5fd1558458bf14f98ebdbd72e61e1ceef61fd90ef400933f221c8', '2026-04-09 17:09:49', '2026-04-02 20:09:49'),
(6, 1, '770a4c23898f48d9d16c2079e45c38373d37f702cd8396657f709bc6de8583f0', '2026-04-09 17:10:37', '2026-04-02 20:10:37'),
(7, 1, 'ea20818f6033dc8f8b30fd78d3a617e5aa5fb969556f626cd0ef99cfb8c82938', '2026-04-09 17:21:03', '2026-04-02 20:21:03'),
(8, 1, 'ecfca17529cceeffdd672bb7ef470bb092c795bd487c347f80e9e669723e54c7', '2026-04-09 17:22:47', '2026-04-02 20:22:47'),
(9, 1, '94b13f60273b03b9f25169880bb5073a9fdc30d2571f5f4303d43b83f4ea7fe1', '2026-04-09 17:23:10', '2026-04-02 20:23:10'),
(11, 1, '574f6103375bc006e120830010d7174e1503122a4dd42398da08c424f20ba69c', '2026-04-09 17:44:25', '2026-04-02 20:44:25'),
(13, 1, '651ee84ecba06f77804ed44a2ddeddb1674225a7696fae62998701646b310697', '2026-04-09 18:02:05', '2026-04-02 21:02:05'),
(18, 1, '1eb09268635266a4d263608eaff2c7dfc510600d62f0a989a945bda6edc25724', '2026-04-09 18:27:17', '2026-04-02 21:27:17'),
(21, 1, '645d39306c5c95a823fe7c62688d26b19242b96bcaa29e41254f1826b8197cde', '2026-04-09 18:45:18', '2026-04-02 21:45:18'),
(23, 1, '4a26b0d8198a07da606cc950f2de220cf0b1c41326a8c53a468d194dde3edc4d', '2026-04-09 20:07:57', '2026-04-02 23:07:57'),
(24, 1, '00d877d2b970a4702e7926e991baa24268c6622cbc20ee5e6f01c4413a775234', '2026-04-09 20:10:08', '2026-04-02 23:10:08'),
(25, 1, '21a1dfc610fd2569ac8d1e6fe1dedce8c8c38621340db3486cf6d64776136a94', '2026-04-09 20:11:58', '2026-04-02 23:11:58'),
(26, 1, '695c0a26c836b4cb8c8c028d31cb4a58afa90b630f8344c75fa8bf7755eeb07a', '2026-04-09 20:20:35', '2026-04-02 23:20:35'),
(27, 1, 'b4886ab8cc8c8cbb888ab3db5466db15c5577e64adff12e0ac02b6af2121f12e', '2026-04-09 20:20:50', '2026-04-02 23:20:50'),
(28, 1, 'f87cd4719446fb788c2f9a601aedf297050b516f893c4e970e1482182828f26e', '2026-04-09 20:55:02', '2026-04-02 23:55:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `growth`
--
ALTER TABLE `growth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient` (`ingredient`);

--
-- Indexes for table `mortality`
--
ALTER TABLE `mortality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `growth`
--
ALTER TABLE `growth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mortality`
--
ALTER TABLE `mortality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  ADD CONSTRAINT `inventory_transactions_ibfk_1` FOREIGN KEY (`ingredient`) REFERENCES `inventory` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `production_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
