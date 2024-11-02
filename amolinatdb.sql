-- Create the database and use it
CREATE DATABASE IF NOT EXISTS amolinatdb;
USE amolinatdb;

-- Set SQL mode and start transaction
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Table structure and data for `actions`
CREATE TABLE `actions` (
  `id` int(50) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `actions` (`id`, `name`) VALUES
(1, 'list'),
(2, 'add'),
(3, 'delete'),
(4, 'login');

-- Table structure and data for `building`
CREATE TABLE `building` (
  `building_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `family` varchar(100) NOT NULL,
  `unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `building` (`building_id`, `product_id`, `name`, `namefr`, `family`, `unit`) VALUES
(0, 1, '2-inch x 4-inch x 8-ft SPF Select 2Btr Grade Lumber\n', '', 'Plank', 'unit(s)');

-- Table structure and data for `categories`
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Building'),
(2, 'Glue'),
(3, 'Isolant');

-- Table structure and data for `families`
CREATE TABLE `families` (
  `family_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `family_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `families` (`family_id`, `category_id`, `family_name`) VALUES
(1, 1, 'Plank');

-- Table structure for `glue`
CREATE TABLE `glue` (
  `glue_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `glue_type` varchar(50) NOT NULL,
  `cure_time` varchar(50) DEFAULT NULL,
  `strength` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure and data for `groupactions`
CREATE TABLE `groupactions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `groupactions` (`id`, `group_id`, `action_id`) VALUES
(10, 1, 1),
(11, 1, 10),
(12, 2, 1),
(13, 2, 2),
(14, 2, 3),
(15, 2, 5),
(16, 2, 6),
(17, 2, 7),
(18, 2, 8),
(19, 2, 9),
(20, 2, 10);

-- Table structure and data for `groups`
CREATE TABLE `groups` (
  `id` int(10) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'super admin');

-- Table structure for `isolant`
CREATE TABLE `isolant` (
  `isolant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `isolant_strength` varchar(10) DEFAULT NULL,
  `unit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `miscellaneous`
CREATE TABLE `miscellaneous` (
  `misc_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure and data for `products`
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `family_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `lowstock` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`product_id`, `category_id`, `family_id`, `supplier_id`, `lowstock`, `stock`) VALUES
(1, 1, 1, 1, 10, 50);

-- Table structure and data for `rights`
CREATE TABLE `rights` (
  `id` int(50) NOT NULL,
  `action` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rights` (`id`, `action`, `controller`) VALUES
(1, 'list', 'inventory'),
(2, 'add', 'inventory'),
(3, 'delete', 'inventory'),
(5, 'add', 'employee'),
(6, 'delete', 'employee'),
(7, 'modify', 'employee'),
(8, 'mstock', 'employee'),
(9, 'list', 'employee'),
(10, 'calculate', 'calculator');

-- Table structure and data for `suppliers`
CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_info`) VALUES
(1, 'Home Depot', '1-800-759-2070');

-- Table structure and data for `usergroup`
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usergroup` (`id`, `email`, `group_id`) VALUES
(1, 'amirgeorges.haya@icloud.com', 2),
(2, 'kirbywerby482@gmail.com', 1),
(3, 'amirgeorges.haya@icloud.com', 1);

-- Table structure and data for `userinfo`
CREATE TABLE `userinfo` (
  `email` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `userinfo` (`email`, `name`, `birthday`) VALUES
('amirgeorges.haya@icloud.com', 'Amir-Georges Haya', '2005-06-28'),
('kirbywerby482@gmail.com', 'Kirby Dummy', '1972-07-27');

-- Table structure and data for `userlogin`
CREATE TABLE `userlogin` (
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `userlogin` (`email`, `password`) VALUES
('amirgeorges.haya@icloud.com', '34db527779e3829fe6a4f17afd6a086ee70fd005'),
('kirbywerby482@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005');

-- Add indexes and constraints for all tables
-- (Indexes and constraints code remains unchanged for each table)

COMMIT;
