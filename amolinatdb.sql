-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 07:15 PM
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
--
CREATE DATABASE amolinatdb;

USE amolinatdb;
-- --------------------------------------------------------

--
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
(2, 6, '1-inch x 2-inch x 10 ft. Select / Clear Pine Board', 'Planche de pin sélectionné/clair de 1 pouce x 2 pouces x 10 pieds', 'Plank', 'Unit(s)'),
(64, 120, 'popopo', 'popopo', 'plank', 'pop');

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
(3, 'Isolant'),
(4, 'Miscellaneous');

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
(8, 3, 'physical'),
(9, 4, 'nails'),
(10, 4, 'screws');

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
  `lowstock` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `family_id`, `lowstock`, `stock`) VALUES
(1, 1, 1, 10, 50000),
(2, 2, 5, 120, 240),
(3, 2, 5, 211, 421),
(4, 3, 7, 100, 200),
(5, 3, 8, 10, 30),
(6, 1, 1, 20, 8),
(120, 1, 1, 9, 20);

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_list_view`
-- (See below for the actual view)
--
CREATE TABLE `product_list_view` (
`product_id` int(11)
,`Name` varchar(255)
,`Unit` varchar(50)
,`Family` varchar(100)
,`category_name` varchar(100)
,`lowstock` int(11)
,`stock` int(11)
,`Supplier Names` mediumtext
);

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `ps_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_supplier`
--

INSERT INTO `product_supplier` (`ps_id`, `product_id`, `supplier_id`) VALUES
(18, 1, 1),
(19, 1, 2),
(20, 2, 1),
(21, 3, 1),
(22, 4, 1),
(23, 4, 2),
(24, 5, 2),
(25, 6, 2),
(34, 120, 1),
(35, 120, 2);

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
(2, 'Rona', 'https://www.rona.ca/en');

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
(57, 'raeerahm@gmail.com', 2),
(58, 'raeerahm@gmail.com', 1),
(60, 'llecopower@gmail.com', 1);

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
('kirbywerby482@gmail.com', 'Kirby Dummy', '1972-07-27'),
('llecopower@gmail.com', 'Alex Hadid', '2011-02-13'),
('raeerahm@gmail.com', 'Raeeba Rahman', '2024-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `authentication_code` varchar(16) DEFAULT NULL,
  `authentication_code_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`email`, `password`, `reset_token_hash`, `reset_token_expires_at`, `authentication_code`, `authentication_code_expires_at`) VALUES
('amirgeorges.haya@icloud.com', '34db527779e3829fe6a4f17afd6a086ee70fd005', NULL, NULL, 'a64bf69b', '2024-12-05 20:44:44'),
('kirbywerby482@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005', 'b707f9f905e9752eefd2ec8b192e24d680b4c3e8b39bbe2b42cfbbf705911cba', '2024-12-05 04:16:43', '836fcb70', '2024-12-05 21:36:58'),
('llecopower@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL),
('raeerahm@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005', 'fbaaa91c04c4a5cc86eee2cd7f42e80bf46ca42c5ff75e3c07925350ea838226', '2024-12-05 03:55:10', 'c131b30d', '2024-12-05 21:25:55');

-- --------------------------------------------------------

--
-- Structure for view `product_list_view`
--
DROP TABLE IF EXISTS `product_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_list_view`  AS SELECT `p`.`product_id` AS `product_id`, coalesce(`b`.`name`,`g`.`name`,`i`.`name`,`m`.`name`) AS `Name`, coalesce(`b`.`unit`,`g`.`unit`,`i`.`unit`,`m`.`unit`) AS `Unit`, coalesce(`b`.`family`,`g`.`family`,`i`.`family`,`m`.`family`) AS `Family`, `c`.`category_name` AS `category_name`, `p`.`lowstock` AS `lowstock`, `p`.`stock` AS `stock`, group_concat(`s`.`supplier_name` separator ', ') AS `Supplier Names` FROM (((((((`products` `p` left join `building` `b` on(`b`.`product_id` = `p`.`product_id`)) left join `glue` `g` on(`g`.`product_id` = `p`.`product_id`)) left join `isolant` `i` on(`i`.`product_id` = `p`.`product_id`)) left join `categories` `c` on(`c`.`category_id` = `p`.`category_id`)) left join `miscellaneous` `m` on(`m`.`product_id` = `p`.`product_id`)) left join `product_supplier` `ps` on(`ps`.`product_id` = `p`.`product_id`)) left join `suppliers` `s` on(`s`.`supplier_id` = `ps`.`supplier_id`)) GROUP BY `p`.`product_id`, `c`.`category_name`, `p`.`lowstock`, `p`.`stock` ;

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
  ADD KEY `family_id` (`family_id`);

--
-- Indexes for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`ps_id`),
  ADD KEY `psproduct_idfk` (`product_id`),
  ADD KEY `pssupplier_idfk` (`supplier_id`);

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
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `families`
--
ALTER TABLE `families`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `glue`
--
ALTER TABLE `glue`
  MODIFY `glue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `isolant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  MODIFY `misc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `building`
--
ALTER TABLE `building`
  ADD CONSTRAINT `building_ibfk_1` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `fk_buildingproductid` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `glue_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `fk_productid_iisolant` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  ADD CONSTRAINT `fk_family_miscellaneous` FOREIGN KEY (`family`) REFERENCES `families` (`family_name`),
  ADD CONSTRAINT `miscellaneous_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `families` (`family_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `psproduct_idfk` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pssupplier_idfk` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE NO ACTION;

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
