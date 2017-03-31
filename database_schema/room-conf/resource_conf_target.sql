-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2017 at 12:28 PM
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
-- Table structure for table `resource_conf_target`
--

CREATE TABLE `resource_conf_target` (
  `target_id` smallint(5) UNSIGNED NOT NULL,
  `resource_id` smallint(5) UNSIGNED NOT NULL,
  `conf_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resource_conf_target`
--
ALTER TABLE `resource_conf_target`
  ADD PRIMARY KEY (`target_id`),
  ADD KEY `Resource_id viittaus` (`resource_id`),
  ADD KEY `conf_id viittaus` (`conf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resource_conf_target`
--
ALTER TABLE `resource_conf_target`
  MODIFY `target_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `resource_conf_target`
--
ALTER TABLE `resource_conf_target`
  ADD CONSTRAINT `Resource_id viittaus` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conf_id viittaus` FOREIGN KEY (`conf_id`) REFERENCES `resource_conf` (`conf_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
