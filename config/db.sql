-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2026 at 07:35 PM
-- Server version: 10.5.29-MariaDB-cll-lve
-- PHP Version: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeanddesign_dovehaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `crate_inventory`
--

CREATE TABLE `crate_inventory` (
  `id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crate_inventory`
--

INSERT INTO `crate_inventory` (`id`, `stock`, `updated_at`) VALUES
(1, 79, '2026-04-23 13:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `crate_movements`
--

CREATE TABLE `crate_movements` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crate_movements`
--

INSERT INTO `crate_movements` (`id`, `date`, `type`, `quantity`, `reason`, `balance`) VALUES
(1, '2026-04-23 13:37:04', 'Production', 7, 'Collection from HOUSE1A', 79);

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
(1, 'Green Grocers Ltd', 'orders@greengrocers.com', '+1 234-567-8900', '123 Market St', 3205.00, 22),
(2, 'Fresh Farms Market', 'buy@freshfarms.com', '+1 234-567-8901', '456 Farm Rd', 2115.00, 13);

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
(1, 'Administrator', 'admin', '$2y$12$WsICFROoteOg/BiaNvb1MOqKVlveD6rLqjp.R6tr3Qr1dIComOdbS', 'admin', 'admin@dovehaven.com', 'active', '2026-04-23 18:52:21', 0, NULL),
(2, 'Farm Manager 1', 'manager1', '$2y$12$GhOtqLjRwI2XXL5sePoL/uf15XUKFteuvKLXSMRA3mmaqcISC9WtO', 'farm_manager', 'manager1@dovehaven.com', 'active', '2026-04-15 18:26:51', 0, NULL),
(3, 'Farm Manager 2', 'manager2', '$2y$12$Wm.qIxbkn84arCFyQzsp4uTqaZFNnzKCjyJKrV0N/UFBPNw3MGyIy', 'farm_manager', 'manager2@dovehaven.com', 'active', '2026-04-06 23:55:33', 0, NULL),
(4, 'Supervisor', 'supervisor', '$2y$12$DsvCAtcvf3ulUJs7W.tcv.B/TrRgIad4sl3WU/AAke.xSB5uBV.AK', 'supervisor', 'supervisor@dovehaven.com', 'active', '2026-04-15 18:27:39', 0, NULL),
(5, 'Sales Manager', 'sales', '$2y$10$ehs1Z3FJKxJGm.MnPX6v3uAZONvMwbiJvadej6/UgPP421eviJ/wK', 'sales_manager', 'sales@dovehaven.com', 'active', '2026-04-10 03:10:19', 0, NULL);

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
(1, '2026-04-23', 'house1a', 'FOO1-H1A', 500, 350, 4, 'plain', 500.00, NULL, NULL, NULL, '2026-04-23 12:49:17'),
(2, '2026-04-23', 'house1a', 'FOO12-H1A', 1000, 100, 5, 'plain', 100.00, NULL, NULL, NULL, '2026-04-23 13:01:25'),
(3, '2026-04-23', 'house2a', 'FOO1-H2A', 550, 100, 5, 'plain', 50.00, NULL, NULL, NULL, '2026-04-23 13:21:35');

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
('house10a', 'House 10A', 'active'),
('house10b', 'House 10B', 'active'),
('house10c', 'House 10C', 'active'),
('house10d', 'House 10D', 'active'),
('house10e', 'House 10E', 'active'),
('house10f', 'House 10F', 'active'),
('house1a', 'House 1A', 'active'),
('house1b', 'House 1B', 'active'),
('house1c', 'House 1C', 'active'),
('house1d', 'House 1D', 'active'),
('house1e', 'House 1E', 'active'),
('house1f', 'House 1F', 'active'),
('house2a', 'House 2A', 'active'),
('house2b', 'House 2B', 'active'),
('house2c', 'House 2C', 'active'),
('house2d', 'House 2D', 'active'),
('house2e', 'House 2E', 'active'),
('house2f', 'House 2F', 'active'),
('house3a', 'House 3A', 'active'),
('house3b', 'House 3B', 'active'),
('house3c', 'House 3C', 'active'),
('house3d', 'House 3D', 'active'),
('house3e', 'House 3E', 'active'),
('house3f', 'House 3F', 'active'),
('house4a', 'House 4A', 'active'),
('house4b', 'House 4B', 'active'),
('house4c', 'House 4C', 'active'),
('house4d', 'House 4D', 'active'),
('house4e', 'House 4E', 'active'),
('house4f', 'House 4F', 'active'),
('house5a', 'House 5A', 'active'),
('house5b', 'House 5B', 'active'),
('house5c', 'House 5C', 'active'),
('house5d', 'House 5D', 'active'),
('house5e', 'House 5E', 'active'),
('house5f', 'House 5F', 'active'),
('house6a', 'House 6A', 'active'),
('house6b', 'House 6B', 'active'),
('house6c', 'House 6C', 'active'),
('house6d', 'House 6D', 'active'),
('house6e', 'House 6E', 'active'),
('house6f', 'House 6F', 'active'),
('house7a', 'House 7A', 'active'),
('house7b', 'House 7B', 'active'),
('house7c', 'House 7C', 'active'),
('house7d', 'House 7D', 'active'),
('house7e', 'House 7E', 'active'),
('house7f', 'House 7F', 'active'),
('house8a', 'House 8A', 'active'),
('house8b', 'House 8B', 'active'),
('house8c', 'House 8C', 'active'),
('house8d', 'House 8D', 'active'),
('house8e', 'House 8E', 'active'),
('house8f', 'House 8F', 'active'),
('house9a', 'House 9A', 'active'),
('house9b', 'House 9B', 'active'),
('house9c', 'House 9C', 'active'),
('house9d', 'House 9D', 'active'),
('house9e', 'House 9E', 'active'),
('house9f', 'House 9F', 'active');

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
('corn', 'Corn/Maize', 500.00, 5038.00, 4533.00, 'GrainCo Ltd', 0.35),
('dcp', 'DCP', 200.00, 500.00, 300.00, 'MineralSupply', 0.65),
('developer', 'Developer Feed', 600.00, 1200.00, 600.00, 'In-House', 0.50),
('enzymes', 'Enzymes', 1200.00, 2000.00, 800.00, 'GrainCo Ltd', 0.32),
('fishmeal', 'Fish Meal', 400.00, 800.00, 400.00, 'SeaFeed Co', 0.85),
('galdus', 'Galdus Feed', 400.00, 800.00, 400.00, 'Galdus Ltd', 0.70),
('grower', 'Grower Feed', 800.00, 1500.00, 700.00, 'In-House', 0.55),
('layer', 'Layer Feed', 3500.00, 6000.00, 2500.00, 'In-House', 0.52),
('limestone', 'Limestone', 600.00, 1000.00, 400.00, 'MineralSupply', 0.12),
('lysine', 'Lysine', 50.00, 100.00, 50.00, 'AminoFeed Ltd', 2.50),
('methionine', 'Methionine', 30.00, 80.00, 50.00, 'AminoFeed Ltd', 3.20),
('oil', 'Vegetable Oil', 150.00, 300.00, 150.00, 'OilMills Inc', 1.20),
('premix', 'Vitamin Premix', 80.00, 150.00, 70.00, 'VitaChem', 4.00),
('salt', 'Salt', 100.00, 200.00, 100.00, 'GrainCo Ltd', 0.08),
('soybean', 'Soybean Meal', 1800.00, 3000.00, 1200.00, 'ProteinFeeds Inc', 0.45),
('starter', 'Starter Feed', 500.00, 1000.00, 500.00, 'In-House', 0.60),
('wheat', 'Wheat', 1200.00, 2000.00, 800.00, 'GrainCo Ltd', 0.32);

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
(1, '2026-04-23', 'house1a', 5, 'disease', 'ddd', '2026-04-23 13:24:31'),
(2, '2026-04-23', 'house1a', 100, 'unknown', 'dddd', '2026-04-23 13:31:43');

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

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, '2026-04-23', 'house1a', 7, 0, 210, 100, 50, 30, 20, 10, 500.00, '0', 'ffffffff', 1);

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
  `supplier` varchar(100) DEFAULT NULL,
  `invoice` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 'ab41f176b64d478a7481cc94cf094a9d1217b315fbbff9d60b4ae7345fefab85', '2026-04-30 12:46:46', '2026-04-23 17:46:46'),
(2, 1, 'a0e496166b74c90b9815eb51e060a1ef52a672e38fbc5dd91d92b017c8b80aeb', '2026-04-30 13:02:21', '2026-04-23 18:02:21'),
(3, 1, 'e46baf77dfcaac0688369c7d7cdffee5f061ff276e0b67797e959aa22f7a8c1b', '2026-04-30 13:20:19', '2026-04-23 18:20:19'),
(4, 1, '3b60d1630e6b5d6602a6fc2d78c451a7baad4ee08d2e1f2418a28041ab7a527c', '2026-04-30 13:35:53', '2026-04-23 18:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'eggsPerCrate', '30'),
(2, 'stockThreshold', '494');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `crate_inventory`
--
ALTER TABLE `crate_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crate_movements`
--
ALTER TABLE `crate_movements`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

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
-- AUTO_INCREMENT for table `crate_inventory`
--
ALTER TABLE `crate_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `crate_movements`
--
ALTER TABLE `crate_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `growth`
--
ALTER TABLE `growth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventory_transactions`
--
ALTER TABLE `inventory_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mortality`
--
ALTER TABLE `mortality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1157;

--
-- AUTO_INCREMENT for table `user_house_assignments`
--
ALTER TABLE `user_house_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
