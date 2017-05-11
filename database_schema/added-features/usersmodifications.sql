-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

--
-- Database: `booked`
--

ALTER TABLE `users` CHANGE `organization` `organization` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;