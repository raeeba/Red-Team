-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 06:51 PM
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
-- Database: `amolinatdb`
CREATE DATABASE amolinatdb;

-- --------------------------------------------------------

USE amolinatdb;

-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `family` varchar(100) NOT NULL,
  `unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`building_id`, `product_id`, `name`, `namefr`, `family`, `unit`) VALUES
(1, 1, '2-inch x 4-inch x 8-ft SPF Select 2Btr Grade Lumber\n', '', 'Plank', 'Unit(s)'),
(2, 6, '1-inch x 2-inch x 10 ft. Select / Clear Pine Board', 'Planche de pin sélectionné/clair de 1 pouce x 2 pouces x 10 pieds', 'Plank', 'Unit(s)');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Building'),
(2, 'Glue'),
(3, 'Isolant');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `family_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `family_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`family_id`, `category_id`, `family_name`) VALUES
(1, 1, 'plank'),
(4, 1, 'lumber'),
(5, 2, 'liquid'),
(6, 2, 'tape'),
(7, 3, 'spray'),
(8, 3, 'physical');

-- --------------------------------------------------------

--
-- Table structure for table `glue`
--

CREATE TABLE `glue` (
  `glue_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `cure_time` varchar(50) DEFAULT NULL,
  `strength` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `family` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `glue`
--

INSERT INTO `glue` (`glue_id`, `product_id`, `name`, `namefr`, `cure_time`, `strength`, `unit`, `family`) VALUES
(1, 2, 'LePage PL Premium Construction Adhesive', 'LePage PL Adhésive de Construction Premium', '30 min', 'Extra ', 'Tube(s)', 'liquid'),
(2, 3, 'Loctite PL Premium Max Construction Adhesive', 'Loctite PL Construction Max Adhésive Premium ', '45 min', 'Medium ', 'Tube(s)', 'liquid');

-- --------------------------------------------------------

--
-- Table structure for table `groupactions`
--

CREATE TABLE `groupactions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groupactions`
--

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
(20, 2, 10),
(21, 2, 11),
(23, 1, 12),
(24, 2, 14);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'super admin');

-- --------------------------------------------------------

--
-- Table structure for table `isolant`
--

CREATE TABLE `isolant` (
  `isolant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `isolant_strength` varchar(10) DEFAULT NULL,
  `unit` varchar(50) NOT NULL,
  `family` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `isolant`
--

INSERT INTO `isolant` (`isolant_id`, `product_id`, `name`, `namefr`, `isolant_strength`, `unit`, `family`) VALUES
(1, 4, 'SANCTUARY Cellulose Blown-In or Spray Applied Insulation (R3.7 per inch)', 'Isolant en cellulose soufflé ou appliqué par pulvérisation SANCTUARY (R3,7 par pouce)', 'Medium', 'Bag(s)', 'spray'),
(2, 5, 'AttiCat Expanding PINK FIBERGLAS Blown-In Insulation (32.6 sq.ft.)', 'Isolant soufflé extensible AttiCat en FIBERGLAS ROSE (32,6 pi²)', 'Extra', 'Bag(s)', 'physical');

-- --------------------------------------------------------

--
-- Table structure for table `miscellaneous`
--

CREATE TABLE `miscellaneous` (
  `misc_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `namefr` varchar(255) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `family` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `family_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `lowstock` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `family_id`, `supplier_id`, `lowstock`, `stock`) VALUES
(1, 1, 1, 1, 10, 50),
(2, 2, 5, 1, 12, 24),
(3, 2, 5, 2, 12, 24),
(4, 3, 7, 1, 10, 20),
(5, 3, 8, 1, 10, 30),
(6, 1, 1, 1, 20, 50);

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE `rights` (
  `id` int(50) NOT NULL,
  `action` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rights`
--

INSERT INTO `rights` (`id`, `action`, `controller`) VALUES
(1, 'list', 'inventory'),
(2, 'add', 'inventory'),
(3, 'delete', 'inventory'),
(5, 'add', 'employee'),
(6, 'delete', 'employee'),
(7, 'modify', 'employee'),
(8, 'mstock', 'inventory'),
(9, 'list', 'employee'),
(10, 'calculate', 'calculator'),
(11, 'modify', 'employee'),
(12, 'view', 'calculator'),
(14, 'modify', 'inventory');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_info`) VALUES
(1, 'Home Depot', 'https://www.homedepot.ca/fr/accueil.html'),
(2, 'Rona', 'https://www.rona.ca/fr');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`id`, `email`, `group_id`) VALUES
(1, 'amirgeorges.haya@icloud.com', 2),
(2, 'kirbywerby482@gmail.com', 1),
(3, 'amirgeorges.haya@icloud.com', 1),
(56, 'hadid@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `email` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`email`, `name`, `birthday`) VALUES
('amirgeorges.haya@icloud.com', 'Amir-Georges Haya', '2005-06-28'),
('hadid@gmail.com', 'Bella Hadid', '2024-10-29'),
('kirbywerby482@gmail.com', 'Kirby Dummy', '1972-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`email`, `password`) VALUES
('amirgeorges.haya@icloud.com', '34db527779e3829fe6a4f17afd6a086ee70fd005'),
('hadid@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005'),
('kirbywerby482@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `building_ibfk_1` (`family`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`family_id`),
  ADD UNIQUE KEY `unique_family_name` (`family_name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `glue`
--
ALTER TABLE `glue`
  ADD PRIMARY KEY (`glue_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_family_name` (`family`);

--
-- Indexes for table `groupactions`
--
ALTER TABLE `groupactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_id` (`action_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `isolant`
--
ALTER TABLE `isolant`
  ADD PRIMARY KEY (`isolant_id`),
  ADD KEY `fk_family_isolant` (`family`),
  ADD KEY `fk_productid_iisolant` (`product_id`);

--
-- Indexes for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD PRIMARY KEY (`misc_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_family_miscellaneous` (`family`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `family_id` (`family_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `glue`
--
ALTER TABLE `glue`
  MODIFY `glue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groupactions`
--
ALTER TABLE `groupactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `isolant`
--
ALTER TABLE `isolant`
  MODIFY `isolant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `fk_buildingproductid` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `families`
--
ALTER TABLE `families`
  ADD CONSTRAINT `families_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `glue`
--
ALTER TABLE `glue`
  ADD CONSTRAINT `fk_family_name` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `glue_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `groupactions`
--
ALTER TABLE `groupactions`
  ADD CONSTRAINT `groupactions_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `rights` (`id`),
  ADD CONSTRAINT `groupactions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `isolant`
--
ALTER TABLE `isolant`
  ADD CONSTRAINT `fk_family_isolant` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `fk_productid_iisolant` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD CONSTRAINT `fk_family_miscellaneous` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `miscellaneous_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `families` (`family_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `usergroup`
--
ALTER TABLE `usergroup`
  ADD CONSTRAINT `usergroup_ibfk_1` FOREIGN KEY (`email`) REFERENCES `userlogin` (`email`),
  ADD CONSTRAINT `usergroup_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`email`) REFERENCES `userlogin` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
