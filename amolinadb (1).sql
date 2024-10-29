-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 08:42 PM
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
-- Database: `amolinadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(50) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `name`) VALUES
(1, 'add'),
(2, 'list');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Super Admin');

-- --------------------------------------------------------

--
-- Table structure for table `groupsactions`
--

CREATE TABLE `groupsactions` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `action_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groupsactions`
--

INSERT INTO `groupsactions` (`id`, `group_id`, `action_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`) VALUES
('amirgeorges.haya@icloud.com', '34db527779e3829fe6a4f17afd6a086ee70fd005'),
('kirbywerby482@gmail.com', '34db527779e3829fe6a4f17afd6a086ee70fd005');

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `group_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`group_id`, `user_email`) VALUES
(1, 'kirbywerby482@gmail.com'),
(2, 'amirgeorges.haya@icloud.com');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `name`, `birthday`, `email`) VALUES
(1, 'Amir-Georges', '2005-06-28', 'amirgeorges.haya@icloud.com'),
(2, 'Kirby', '1992-04-27', 'kirbywerby482@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groupsactions`
--
ALTER TABLE `groupsactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_id` (`action_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`group_id`,`user_email`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groupsactions`
--
ALTER TABLE `groupsactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groupsactions`
--
ALTER TABLE `groupsactions`
  ADD CONSTRAINT `groupsactions_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `groupsactions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD CONSTRAINT `usergroups_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `login` (`email`),
  ADD CONSTRAINT `usergroups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`email`) REFERENCES `login` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
