-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

--
-- Database: `booked`
--

ALTER TABLE `reservation_resources` ADD `target_id` SMALLINT(5) UNSIGNED NULL DEFAULT NULL AFTER `resource_level_id`;