-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2017 at 01:22 PM
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
-- Table structure for table `reservation_addons`
--

CREATE TABLE `reservation_addons` (
  `series_id` int(10) UNSIGNED NOT NULL,
  `PublicStartTime` time NOT NULL,
  `PublicEndTime` time NOT NULL,
  `PublicStatus` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation_addons`
--

INSERT INTO `reservation_addons` (`series_id`, `PublicStartTime`, `PublicEndTime`, `PublicStatus`) VALUES
(165, '08:45:00', '09:30:00', 1),
(200, '16:20:00', '00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation_addons`
--
ALTER TABLE `reservation_addons`
  ADD PRIMARY KEY (`series_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_addons`
--
ALTER TABLE `reservation_addons`
  ADD CONSTRAINT `series_id` FOREIGN KEY (`series_id`) REFERENCES `reservation_series` (`series_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
