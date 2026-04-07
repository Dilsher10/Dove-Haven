-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2026 at 08:25 PM
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
(1, 145, '2026-04-07 16:02:16');

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
(1, '2026-04-07 15:53:57', 'Purchase/Return', 5, 'purchased', 155),
(2, '2026-04-07 16:02:16', 'Damage/Loss', -10, 'Saled', 145);

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
(1, 'Green Grocers Ltd', 'orders@greengrocers.com', '+1 234-567-8900', '123 Market St', 3055.00, 21),
(2, 'Fresh Farms Market', 'buy@freshfarms.com', '+1 234-567-8901', '456 Farm Rd', 2115.00, 13),
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
(1, 'Administrator', 'admin', '$2y$12$WsICFROoteOg/BiaNvb1MOqKVlveD6rLqjp.R6tr3Qr1dIComOdbS', 'admin', 'admin@dovehaven.com', 'active', '2026-04-07 23:17:31', 0, NULL),
(2, 'Farm Manager 1', 'manager1', '$2y$12$GhOtqLjRwI2XXL5sePoL/uf15XUKFteuvKLXSMRA3mmaqcISC9WtO', 'farm_manager', 'manager1@dovehaven.com', 'active', '2026-04-06 21:57:58', 0, NULL),
(3, 'Farm Manager 2', 'manager2', '$2y$12$Wm.qIxbkn84arCFyQzsp4uTqaZFNnzKCjyJKrV0N/UFBPNw3MGyIy', 'farm_manager', 'manager2@dovehaven.com', 'active', '2026-04-06 23:55:33', 0, NULL),
(4, 'Supervisor', 'supervisor', '$2y$12$DsvCAtcvf3ulUJs7W.tcv.B/TrRgIad4sl3WU/AAke.xSB5uBV.AK', 'supervisor', 'supervisor@dovehaven.com', 'active', '2026-04-07 16:31:00', 0, NULL),
(5, 'Sales Manager', 'sales', '$2y$12$azk20ztho7uxVoirPv1WCu/iieH/3bA7CFc95i9.Df4cL4ql/uSWy', 'sales_manager', 'dilsher@codeanddesigngroup.com', 'active', '2026-04-07 23:15:04', 0, NULL);

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
('corn', 'Corn/Maize', 502.00, 5028.00, 4521.00, 'GrainCo Ltd', 0.35),
('dcp', 'DCP', 200.00, 500.00, 300.00, 'MineralSupply', 0.65),
('developer', 'Developer Feed', 600.00, 1200.00, 600.00, 'In-House', 0.50),
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
(16, '2026-04-03', 'corn', 'purchase', 1.00, '', 'Purchased from John', '2026-04-03 15:31:28'),
(17, '2026-04-07', 'corn', 'usage', 2000.00, 'new', 'adada', '2026-04-07 17:39:06');

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
('ORD-001', 1, '2026-04-07', '110 Crates Large Eggs, 50 Crates Medium Eggs, 30 Crates Small Eggs, 10 Crates Extra Small Eggs, 10 x Large Eggs (Tray)', 200, 'various', 5790.00, 5740.00, 0.00, 'cash', 'paid'),
('ORD-002', 2, '2026-04-07', '50 Crates Large Eggs, 30 Crates Medium Eggs, 20 Crates Small Eggs, 10 Crates Extra Small Eggs, 10 x Medium Eggs (Tray)', 110, 'various', 3170.00, 2770.00, 400.00, 'cash', 'partial'),
('ORD-003', 1, '2026-04-07', '10 Crates Large Eggs, 10 Crates Medium Eggs, 10 Crates Small Eggs, 10 Crates Extra Small Eggs, 10 x Large Eggs (Tray)', 40, 'various', 1170.00, 1170.00, 0.00, 'cash', 'paid'),
('ORD-004', 2, '2026-04-07', '30 Crates Large Eggs, 10 Crates Medium Eggs, 10 Crates Small Eggs, 10 x Small Eggs (Tray)', 50, 'various', 1530.00, 1530.00, 0.00, 'cash', 'paid'),
('ORD-005', 2, '2026-04-07', '10 Crates Large Eggs, 10 Crates Medium Eggs, 10 Crates Small Eggs, 10 Crates Extra Small Eggs, 10 x Live Bird', 40, 'various', 1200.00, 1200.00, 0.00, 'cash', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(1, 'dilsher@codeanddesigngroup.com', 'ff43e50dde5c55deb3977e0d2d926265e52d1945f9b2a587fa3556cd73534394', '2026-04-07 21:08:05', '2026-04-07 18:08:05'),
(2, 'dilsher@codeanddesigngroup.com', '99516d6a079c4ce2b784fa3e5afeb2dd44b0616a70a795ce71fc1803e771e0e3', '2026-04-07 21:09:53', '2026-04-07 18:09:53'),
(3, 'dilsher@codeanddesigngroup.com', '3e12d34bc17984d9a66614be94e1da8201a8716e5fbdb2045fa56612cb1dfab0', '2026-04-07 21:11:03', '2026-04-07 18:11:03'),
(4, 'dilsher@codeanddesigngroup.com', '2734e4f5c9b3cc7deff5b5927e858833332462ba66dbb473d32260f802146a25', '2026-04-07 21:12:52', '2026-04-07 18:12:52'),
(5, 'dilsher@codeanddesigngroup.com', '83af58572b87891ce22f4957cc399a3d54c2320f2a391457d6f92be2768ff5dc', '2026-04-07 21:13:32', '2026-04-07 18:13:32');

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

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `payment_method`, `payment_ref`, `date`) VALUES
(1, 'ORD-002', 100.00, 'cash', 'paid', '2026-04-07 20:25:19'),
(2, 'ORD-003', 20.00, 'cash', 'paid', '2026-04-07 20:25:39'),
(3, 'ORD-002', 20.00, 'cash', 'paid', '2026-04-07 20:26:09');

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
(6, '2026-03-31', 'house1c', 0, 17, 17, 10, 4, 2, 1, 0, 0.00, '0', 'dddddddd', 1),
(7, '2026-04-07', 'house1a', 19, 10, 580, 250, 150, 100, 50, 30, 50.00, '0', 'Today\'s', 1);

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

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `category`, `item`, `quantity`, `unit`, `unit_cost`, `total_cost`, `supplier`, `invoice`) VALUES
(1, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil', ''),
(2, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil', ''),
(3, '2026-03-31', 'feed', 'hhh', 1.00, 'units', 0.01, 0.01, 'dil', ''),
(4, '2026-03-31', 'Feed Ingredient', 'corn', 0.10, 'kg', 0.01, 0.01, 'f', ''),
(5, '2026-03-31', 'feed', 'hhh', 1.00, 'kg', 0.01, 0.01, 'dil', ''),
(6, '2026-03-31', 'feed', 'new', 1.00, 'units', 0.01, 0.01, 'dil', ''),
(7, '2026-03-31', 'Feed Ingredient', 'wheat', 4.40, 'kg', 0.25, 0.25, 'John', ''),
(8, '2026-04-01', 'Feed Ingredient', 'corn', 5.00, 'kg', 1.00, 1.00, 'John', ''),
(9, '2026-04-07', 'feed', 'ddddd', 11.00, 'units', 1.00, 1.00, 'dddddddddd', 'Logo English.jpeg'),
(10, '2026-04-07', 'feed', 'hhhsdasd', 34.00, 'units', 1.00, 1.00, 'sadfsdf', 'logo-white.png');

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
(53, 3, 'd3c6bd7dc9de16a7b2ce6695ab978abf7a22e4b3aef06547a61e32deae24f210', '2026-04-13 19:14:06', '2026-04-06 22:14:06'),
(54, 1, '5826b92f4c730d76a2b5f59f205e7749600de19885e6a68bf9c8e55564b5f1f0', '2026-04-13 20:00:30', '2026-04-06 23:00:30'),
(55, 1, 'c2b681db8e90943d0951f649aa65269e95b552a9fd452ea7b6543c50bca03ea3', '2026-04-13 20:31:15', '2026-04-06 23:31:15'),
(59, 4, '28da11e0cd73c3820768fed89b0bf25a6d6634311fb67e94f12cb2de5cd993f3', '2026-04-14 13:29:20', '2026-04-07 16:29:20'),
(60, 4, 'da22f87de67d7089efeb8d7f68f11620dc06750a441ad75421a206dbdff82e0e', '2026-04-14 13:29:42', '2026-04-07 16:29:42'),
(65, 4, 'ef8d1afe7c0df26ca296c17934161538ca1771c18856af9cf649edb6b3b1ce22', '2026-04-14 13:31:00', '2026-04-07 16:31:00'),
(69, 1, '32ce7ea7c959fde9103f1e907ad53a859fc452a0416927091263b907caea0bff', '2026-04-14 13:43:05', '2026-04-07 16:43:05'),
(70, 1, '416349517e76f95f4f4745de2e757d7d9bd3b80fbcee320c8600b965940a4db1', '2026-04-14 13:58:30', '2026-04-07 16:58:30'),
(71, 1, '563825a381f9c7a16a73fac7f52f3fa054980fd530fb66aa497f9178d98bc82b', '2026-04-14 14:17:48', '2026-04-07 17:17:48'),
(72, 1, '711db06d629d8bdbf460279b91929134612fc5daa0007cbef25cb4e8e344e2ea', '2026-04-14 14:32:57', '2026-04-07 17:32:57'),
(73, 1, '42533daf44c9d9afd01583ce3635620f7a7d65c89a083c2ba61ce3eb65a4d0e5', '2026-04-14 14:50:15', '2026-04-07 17:50:15'),
(74, 1, '52f2219d132f8669dc97c2f907def928effa45661d04abd696500d1e6727a005', '2026-04-14 15:06:17', '2026-04-07 18:06:17'),
(75, 1, '654c724092b441b7c3404f3b1758ec31eda04edcd279c82d991efc24ba1b5d74', '2026-04-14 15:35:46', '2026-04-07 18:35:46'),
(76, 1, 'e970f9b1e006b68d79a019b0a94d26212bcf0296a0a8d738208a065751ae2a19', '2026-04-14 15:52:39', '2026-04-07 18:52:39'),
(77, 1, '359af3a81407aa5a1f931991f229ada0a23475d2060f2fa3559f9c0664e10942', '2026-04-14 16:11:20', '2026-04-07 19:11:20'),
(78, 1, 'd4d0279554b5fdf6dccc127126c61b5966a1a3e882ad5731b6ded3151cfadd4c', '2026-04-14 16:27:13', '2026-04-07 19:27:13'),
(79, 1, 'd4f9b8368740e60504aaf5c3c5d02d16432634ddf1aa45d065780cf160538155', '2026-04-14 16:43:50', '2026-04-07 19:43:50'),
(80, 1, '43a2c2bdb10f0c800af75d268097e14b9812eca15e61b4c22b48b20beb88cf3b', '2026-04-14 17:02:08', '2026-04-07 20:02:08'),
(81, 1, 'a48bd6929eee7ada09de26a509a1863be7326add1e32260fdc442eea54d47d1f', '2026-04-14 17:24:53', '2026-04-07 20:24:53'),
(82, 1, 'f3461e6eb15f6abf737b479cb65e8af771391aa8caa329a168fefd8b1e50ed1c', '2026-04-14 17:53:33', '2026-04-07 20:53:33'),
(83, 1, 'f6646d41263845ea6fab8e1a93f0d03cc2a757e285c28e41e8a5709fcbc5d5de', '2026-04-14 18:19:59', '2026-04-07 21:19:59'),
(84, 1, 'a6deecb67485ff103ad6e5c580700e3a7ac8058513bfe0062a34a6c6e42b3596', '2026-04-14 18:38:34', '2026-04-07 21:38:34'),
(85, 1, '647765800e240edbeca31a4e2d3b163a2696063ab2566670d81d1e92045f2b29', '2026-04-14 18:53:56', '2026-04-07 21:53:56'),
(86, 1, '587f34cae1d5fbc3c752ee80260c766a15d6d3dec992b9956bbf4d5fd65ae01d', '2026-04-14 19:09:02', '2026-04-07 22:09:02'),
(87, 1, '79c67e128ced5408640200dd8d5b9e8efddd40a6fe27799cf31238fef69e361d', '2026-04-14 19:24:20', '2026-04-07 22:24:20'),
(90, 1, 'fec3dd89efb68bc1b22f75c38b344b02130ed7b42e23e825da9708261c672b79', '2026-04-14 20:17:31', '2026-04-07 23:17:31');

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
-- Dumping data for table `user_house_assignments`
--

INSERT INTO `user_house_assignments` (`id`, `employee_id`, `house_id`, `assigned_at`) VALUES
(6, 2, 'house1a', '2026-04-06 20:06:48'),
(7, 2, 'house1b', '2026-04-06 20:06:48'),
(11, 3, 'house2a', '2026-04-06 22:13:50');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mortality`
--
ALTER TABLE `mortality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_house_assignments`
--
ALTER TABLE `user_house_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
