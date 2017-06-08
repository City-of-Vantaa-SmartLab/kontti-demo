ALTER TABLE `reservation_addons` ADD `FoodSplitFirst` TINYINT UNSIGNED NULL DEFAULT '0' AFTER `foodcount`, ADD `FoodSplitSecond` TINYINT UNSIGNED NULL DEFAULT '0' AFTER `FoodSplitFirst`; 

ALTER TABLE `reservation_temporary` ADD `FoodSplitFirst` TINYINT UNSIGNED NULL DEFAULT '0' AFTER `ResourceFoodCount`, ADD `FoodSplitSecond` TINYINT UNSIGNED NULL DEFAULT '0' AFTER `FoodSplitFirst`; 