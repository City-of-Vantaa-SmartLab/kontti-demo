-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

--
-- Database: `booked`
--

ALTER TABLE `reservation_series` ADD `target_id` SMALLINT(5) UNSIGNED NULL DEFAULT NULL AFTER `status_id`;