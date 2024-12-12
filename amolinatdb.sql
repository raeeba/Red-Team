-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 04:09 AM
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

-- --------------------------------------------------------

CREATE DATABASE amolinatdb;

USE amolinatdb;
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
(2, 6, '1-inch x 2-inch x 10 ft. Select / Clear Pine Board', 'Planche de pin sélectionné/clair de 1 pouce x 2 pouces x 10 pieds', 'Plank', 'Unit(s)'),
(65, 128, '2-in x 4-in x 8-ft SPF Stud Grade Lumber', '2-po x 4-po x 8-pi Bois d\'épinette Grade Stud', 'lumber', 'Unit(s)'),
(66, 129, '1 x 6 x 6\' Pressure Treated Wood Fence Board (Above Ground Use Only)', '1 x 6 x 6\' Planche de clôture en Bois Traité Sous Pression', 'plank', 'Unit(s)'),
(67, 130, '4 x 4 x 6\' Pressure Treated Wood', '4 x 4 x 6\' Bois Traité Sous Pression', 'lumber', 'Unit(s)'),
(68, 131, '2-inch x 4-inch x 8-ft SPF Select 2Btr Grade Lumber', 'Bois d\'uvre de classe Select Structural, 2 po x 4 po x 8 pi', 'lumber', 'Unit(s)');

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
(2, 3, 'Loctite PL Premium Max Construction Adhesive', 'Loctite PL Construction Max Adhésive Premium ', '45 min', 'Medium ', 'Tube(s)', 'liquid'),
(15, 132, 'No More Nails All Purpose Construction Adhesive, Instant Grab', 'No More Nails Adhésif de construction multi-usages, Tient immédiatement', '2 min', 'Medium', 'Tube(s)', 'liquid'),
(16, 133, '1.88 inch x 10yd. Waterproofing and Repair Tape', ' le Ruban Détanchéité et de Réparation', 'Instant', 'High', 'Tape(s)', 'tape'),
(17, 134, 'All Purpose Duct Tape, Silver, 1.88 inch x 45 yds.', 'Ruban adhésif tout usage de marque Duct Tape Argenté, 48 mm x 41m (1,88po x 45verges)', 'Instant', 'Extreme', 'Tape(s)', 'tape');

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
(24, 2, 14),
(25, 1, 15),
(26, 2, 15);

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
(2, 5, 'AttiCat Expanding PINK FIBERGLAS Blown-In Insulation (32.6 sq.ft.)', 'Isolant soufflé extensible AttiCat en FIBERGLAS ROSE (32,6 pi²)', 'Extra', 'Bag(s)', 'physical'),
(11, 135, 'Cool Shield Thermal Bubble Roll - 12\" x 125\'', 'Rouleau d\'isolation thermique à bulles – 12 po x 125 pi', 'High', 'Roll(s)', 'physical'),
(12, 136, 'Multi-Purpose PINK NEXT GEN FIBERGLAS Insulation for Small Projects 2-inch x 16-inch x 48-inch', 'Isolant utilitaire ROSE FIBERGLAS EcoTouch pour petits projets 2 po x 16 po x 48 po', 'Medium', 'Bag(s)', 'physical'),
(13, 137, 'Tite Foam Gaps & Cracks Spray Foam Insulation Sealant, Interior/Exterior, 340g', 'ite Foam Trous & Fissures Mastic Isolation en Mousse Pulvérisée, Intérieur/Extérieur, 340g', 'Very Stron', 'Can(s)', 'spray');

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

--
-- Dumping data for table `miscellaneous`
--

INSERT INTO `miscellaneous` (`misc_id`, `product_id`, `name`, `namefr`, `unit`, `family`) VALUES
(9, 122, ' 1-1/2 Smooth Finishing Nails Bright Finish', '1-1/2 pouce (4d) clous à finition lisse Finition brillante', 'nails', 'nails'),
(10, 123, '3-1/2-inch (16d) Spiral Framing Nails Hot Galvanized', 'Clous pour charpente en spirale de 3-1/2 pouces (16d) galvanisés à chaud', 'nails', 'nails'),
(11, 124, '8 x 3-inch Flat Head Square Drive Construction Screws in Yellow Zinc', 'Vis de construction à tête plate carrée #8 x 3 pouces en zinc jaune', 'screws', 'screws'),
(12, 125, '10 x 3-1/2-inch Square Drive Flat Head Deck Screw UNC in Brown', '10 x 3-1/2\" Vis à tête carrée à tête plate pour terrasse UNC en brun', 'screws', 'screws'),
(13, 126, '1-1/2-inch (N8) Joist Hanger Nails Bright Finish', 'Clous de suspension pour solives 1-1/2 pouce', 'nails', 'nails'),
(14, 127, 'Blued Steel Diamond-Head Forged Nails from Clouterie Rivierre', 'Clous forgés à tête diamant en acier bleui de la Clouterie Rivierre', 'nails', 'nails');

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
(2, 2, 5, 120, 240),
(3, 2, 5, 211, 421),
(4, 3, 7, 100, 200),
(5, 3, 8, 10, 30),
(6, 1, 1, 20, 8),
(122, 4, 9, 50, 190),
(123, 4, 9, 30, 170),
(124, 4, 10, 30, 90),
(125, 4, 10, 10, 100),
(126, 4, 9, 30, 172),
(127, 4, 9, 50, 140),
(128, 1, 4, 10, 50),
(129, 1, 1, 15, 45),
(130, 1, 4, 30, 68),
(131, 1, 4, 10, 50),
(132, 2, 5, 30, 50),
(133, 2, 6, 5, 23),
(134, 2, 6, 5, 1),
(135, 3, 8, 40, 28),
(136, 3, 8, 60, 80),
(137, 3, 7, 60, 80);

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_list_view`
-- (See below for the actual view)
--
CREATE TABLE `product_list_view` (
`product_id` int(11)
,`Name` varchar(255)
,`NameFr` varchar(255)
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
(20, 2, 1),
(21, 3, 1),
(22, 4, 1),
(23, 4, 2),
(24, 5, 2),
(25, 6, 2),
(37, 122, 1),
(38, 122, 2),
(39, 123, 1),
(40, 124, 1),
(41, 125, 1),
(42, 125, 2),
(43, 125, 77),
(44, 126, 78),
(45, 127, 2),
(46, 127, 79),
(47, 128, 1),
(48, 128, 2),
(49, 128, 77),
(50, 129, 77),
(51, 129, 79),
(52, 130, 77),
(53, 130, 78),
(54, 131, 1),
(55, 132, 1),
(56, 132, 77),
(57, 132, 79),
(58, 133, 77),
(59, 134, 1),
(60, 134, 2),
(61, 134, 79),
(62, 135, 2),
(63, 135, 77),
(64, 135, 79),
(65, 136, 1),
(66, 136, 2),
(67, 137, 2),
(68, 137, 79);

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
(14, 'modify', 'inventory'),
(15, 'authenticate', 'employee');

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
(2, 'Rona', 'https://www.rona.ca/en'),
(77, 'Patrick Morin', 'https://patrickmorin.com'),
(78, 'Canac', 'https://www.canac.ca'),
(79, 'Lee Valley', 'https://www.leevalley.com/fr-ca');

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
('grechelleuy@yahoo.com', 'G', '2024-12-11'),
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
  `reset_token_hash` text DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `authentication_code` text DEFAULT NULL,
  `authentication_code_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`email`, `password`, `reset_token_hash`, `reset_token_expires_at`, `authentication_code`, `authentication_code_expires_at`) VALUES
('amirgeorges.haya@icloud.com', '34db527779e3829fe6a4f17afd6a086ee70fd005', NULL, NULL, 'a48132d4203dbe6182f40e54b53159bc53d11e0b', '2024-12-12 04:12:51'),
('grechelleuy@yahoo.com', '464da6997bd496be3ff3dcf9f96eaf9d00a9c644', NULL, NULL, NULL, NULL),
('kirbywerby482@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005', 'b707f9f905e9752e', '2024-12-05 04:16:43', '836fcb70', '2024-12-05 21:36:58'),
('llecopower@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', NULL, NULL, NULL, NULL),
('raeerahm@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure for view `product_list_view`
--
DROP TABLE IF EXISTS `product_list_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_list_view`  AS SELECT `p`.`product_id` AS `product_id`, coalesce(`b`.`name`,`g`.`name`,`i`.`name`,`m`.`name`) AS `Name`, coalesce(`b`.`namefr`,`g`.`namefr`,`i`.`namefr`,`m`.`namefr`) AS `NameFr`, coalesce(`b`.`unit`,`g`.`unit`,`i`.`unit`,`m`.`unit`) AS `Unit`, coalesce(`b`.`family`,`g`.`family`,`i`.`family`,`m`.`family`) AS `Family`, `c`.`category_name` AS `category_name`, `p`.`lowstock` AS `lowstock`, `p`.`stock` AS `stock`, group_concat(`s`.`supplier_name` separator ', ') AS `Supplier Names` FROM (((((((`products` `p` left join `building` `b` on(`b`.`product_id` = `p`.`product_id`)) left join `glue` `g` on(`g`.`product_id` = `p`.`product_id`)) left join `isolant` `i` on(`i`.`product_id` = `p`.`product_id`)) left join `categories` `c` on(`c`.`category_id` = `p`.`category_id`)) left join `miscellaneous` `m` on(`m`.`product_id` = `p`.`product_id`)) left join `product_supplier` `ps` on(`ps`.`product_id` = `p`.`product_id`)) left join `suppliers` `s` on(`s`.`supplier_id` = `ps`.`supplier_id`)) GROUP BY `p`.`product_id`, `c`.`category_name`, `p`.`lowstock`, `p`.`stock` ;

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
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
  MODIFY `glue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `groupactions`
--
ALTER TABLE `groupactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `isolant`
--
ALTER TABLE `isolant`
  MODIFY `isolant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `miscellaneous`
--
ALTER TABLE `miscellaneous`
  MODIFY `misc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

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
