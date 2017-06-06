-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2017 at 12:03 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booked`
--

-- --------------------------------------------------------

--
-- Table structure for table `resource_food_conf_target`
--

CREATE TABLE `resource_food_conf_target` (
  `foodtarget_id` smallint(5) UNSIGNED NOT NULL,
  `resource_id` smallint(5) UNSIGNED NOT NULL,
  `foodconf_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resource_food_conf_target`
--
ALTER TABLE `resource_food_conf_target`
  ADD PRIMARY KEY (`foodtarget_id`),
  ADD KEY `foodconf_id viittaus` (`foodconf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resource_food_conf_target`
--
ALTER TABLE `resource_food_conf_target`
  MODIFY `foodtarget_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `resource_food_conf_target`
--
ALTER TABLE `resource_food_conf_target`
  ADD CONSTRAINT `foodconf_id viittaus` FOREIGN KEY (`foodconf_id`) REFERENCES `resource_food_conf` (`foodconf_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
