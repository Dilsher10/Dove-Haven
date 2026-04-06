-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 06:42 PM
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
(7, 'Dilsher', 'dilsher@codeanddesigngroup.com', '3000000000', 'ssssssss', 0.00, 0),
(8, 'f', 'fffffff@gmail.com', '3000000000', 'ffffffff', 0.00, 0);

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
(1, 'Administrator', 'admin', '$2y$12$WsICFROoteOg/BiaNvb1MOqKVlveD6rLqjp.R6tr3Qr1dIComOdbS', 'admin', 'admin@dovehaven.com', 'active', '2026-04-06 21:38:10', 0, NULL),
(2, 'Farm Manager 1', 'manager1', '$2y$12$GhOtqLjRwI2XXL5sePoL/uf15XUKFteuvKLXSMRA3mmaqcISC9WtO', 'farm_manager', 'manager1@dovehaven.com', 'active', '2026-04-06 21:22:17', 0, NULL),
(3, 'Farm Manager 2', 'manager2', '$2y$12$Wm.qIxbkn84arCFyQzsp4uTqaZFNnzKCjyJKrV0N/UFBPNw3MGyIy', 'farm_manager', 'manager2@dovehaven.com', 'active', '2026-04-06 20:31:50', 0, NULL),
(4, 'Supervisor', 'supervisor', '$2y$12$DsvCAtcvf3ulUJs7W.tcv.B/TrRgIad4sl3WU/AAke.xSB5uBV.AK', 'supervisor', 'supervisor@dovehaven.com', 'active', '2026-04-03 23:53:37', 0, NULL),
(5, 'Sales Manager', 'sales', '$2y$12$azk20ztho7uxVoirPv1WCu/iieH/3bA7CFc95i9.Df4cL4ql/uSWy', 'sales_manager', 'sales@dovehaven.com', 'active', '2026-04-03 19:49:24', 0, NULL);

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
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`id`, `name`, `status`) VALUES
('house1a', 'House 1A', 'active'),
('house1b', 'House 1B', 'active'),
('house1c', 'House 1C', 'active'),
('house2a', 'House 2A', 'active'),
('house2b', 'House 2B', 'active'),
('house2c', 'House 2C', 'active');

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
('corn', 'Corn/Maize', 2502.00, 5028.00, 2521.00, 'GrainCo Ltd', 0.35),
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
(12, '2026-04-02', 'corn', 'usage', 1.00, 'fhgdg', 'dsfgdg', '2026-04-02 18:29:45'),
(13, '2026-04-03', 'corn', 'purchase', 6.00, '', 'Purchased from ddddd', '2026-04-02 19:55:41'),
(14, '2026-04-03', 'corn', 'purchase', 5.00, '', 'Purchased from Uzair', '2026-04-03 12:50:19'),
(15, '2026-04-03', 'corn', 'purchase', 1.00, '', 'Purchased from John', '2026-04-03 14:08:54'),
(16, '2026-04-03', 'corn', 'purchase', 1.00, '', 'Purchased from John', '2026-04-03 15:31:28');

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
(2, 1, '5b4450abafa2302982a01bdc84475861caacfb879a26c70fdb594041398e2cb2', '2026-04-10 14:47:01', '2026-04-03 17:47:01'),
(3, 1, 'b5600311ba489ff44f9acb83a806beb13c59749e5e5e19ea520dd68a1277aa00', '2026-04-10 15:03:20', '2026-04-03 18:03:20'),
(4, 1, 'b3dc8fa90e9626b6907fe89e9fc2312f78a47e9c2e6a128d3912613ad4460287', '2026-04-10 15:39:45', '2026-04-03 18:39:45'),
(9, 4, 'd9c2377c2be0b417f929f9e3b7eca4a75a423b583d13be22a4396b3b319a91e6', '2026-04-10 16:25:07', '2026-04-03 19:25:07'),
(18, 1, '220926c7c612388f1a4869ad34ab28aafbf04ea4145f0c8a17ef54a9c4047f42', '2026-04-10 19:23:08', '2026-04-03 22:23:08'),
(19, 1, '12e9a4e553f559026d9d09d362786408ec7cba8d87d906c182163c46a43e908c', '2026-04-10 20:08:02', '2026-04-03 23:08:02'),
(24, 1, '637c902575d4f688dcb3872e85ed75622cabe234584e8f2a20fc9674eff14ce7', '2026-04-13 14:24:51', '2026-04-06 17:24:51'),
(27, 1, '9ee40211830c8bbe70ececf350f0997f1bbf86c7b228679c0ccf0ee346c21a0c', '2026-04-13 14:50:49', '2026-04-06 17:50:49'),
(28, 1, '306a896f01bd5cf9b7018dfe7d72afb566ea9ccb03ef41ea44303d25f7db6d19', '2026-04-13 15:08:03', '2026-04-06 18:08:03'),
(29, 1, 'ced3ff90beaeeaa147b4dcb2e3dde070b0a3e320d071bbedc4f861675548be27', '2026-04-13 15:24:18', '2026-04-06 18:24:18'),
(30, 1, 'ad1ff76fa6297d97ccb6448b8d79ed1e2c7eec8379aeccf2460606e9bcab7a7f', '2026-04-13 15:40:33', '2026-04-06 18:40:33'),
(31, 1, 'b97e9470b8a72155564298440bc20c6221926c68521620a8d60a02fc36daf043', '2026-04-13 16:00:10', '2026-04-06 19:00:10'),
(32, 1, '6e12ee0ccf24c5763720c3c3983bd3417ddca353a38090df3c6e365755b95c13', '2026-04-13 16:18:04', '2026-04-06 19:18:04'),
(33, 1, 'ea31923af15d3d2fd50ca3025898ae685a77d8ebaed491534c44ccc565bcf5ba', '2026-04-13 16:33:32', '2026-04-06 19:33:32'),
(34, 1, '9d948f3f6d5e79ef024807bc3ce9d92b164006c6a6f4b595b4be6e75eebb1a4c', '2026-04-13 16:49:19', '2026-04-06 19:49:19'),
(35, 1, 'eb448f9e21b92d1058d217cc8079daa31d02742e774b6c39c6550c1ba31218c4', '2026-04-13 17:05:12', '2026-04-06 20:05:12'),
(38, 1, '01a610a94f5eceecb31c9e6c51b873e7996b1d7a863dc353f772c8e483b1cff4', '2026-04-13 17:36:25', '2026-04-06 20:36:25'),
(39, 1, '0c82a4d4e19089395f66f63ba8876532ad087c6ed5882ecd80091adf92318af5', '2026-04-13 17:53:13', '2026-04-06 20:53:13'),
(41, 2, 'c34d7b7a1c319087a59b5a81159315613763aeac482426931312fb3943052f3d', '2026-04-13 18:22:17', '2026-04-06 21:22:17'),
(42, 1, '4171f0948fb815f43b6f9e4448a6acde6bc6b3555c2f4d209442f73b7e703943', '2026-04-13 18:38:10', '2026-04-06 21:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_house_assignments`
--

CREATE TABLE `user_house_assignments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `house_id` varchar(50) NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_house_assignments`
--

INSERT INTO `user_house_assignments` (`id`, `employee_id`, `house_id`, `assigned_at`) VALUES
(6, 2, 'house1a', '2026-04-06 20:06:48'),
(7, 2, 'house1b', '2026-04-06 20:06:48'),
(9, 3, 'house2a', '2026-04-06 20:30:27'),
(10, 3, 'house2c', '2026-04-06 20:30:27');

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
-- Indexes for table `houses`
--
ALTER TABLE `houses`
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
-- Indexes for table `user_house_assignments`
--
ALTER TABLE `user_house_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`,`house_id`),
  ADD KEY `user_house_assignments_ibfk_2` (`house_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_house_assignments`
--
ALTER TABLE `user_house_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- Constraints for table `user_house_assignments`
--
ALTER TABLE `user_house_assignments`
  ADD CONSTRAINT `user_house_assignments_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_house_assignments_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
