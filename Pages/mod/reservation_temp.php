<?php
/**
	temporary storager.
	

*/

require_once(ROOT_DIR . '/Pages/mod/functions.php');

function getAllTemp($resource_id,$StartDate){
		$list=pdoExecute("SELECT * FROM `reservation_temporary` WHERE resource_id = ".$resource_id." AND start_date = '".$StartDate."'");
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function setAllTemp($resource_id,$StartDate,$ResourceArrangement,$ResourceFoodConf,$ResourceFoodConfCountSelect,$compname,$personid,$billingaddress,$reference){
		$list=pdoExecute("INSERT INTO reservation_temporary (resource_id,start_date,ResourceConf,ResourceFoodConf,ResourceFoodCount,compname,personid,billingaddress,reference) VALUES (".$resource_id.",'".$StartDate."',".$ResourceArrangement.",".$ResourceFoodConf.",".$ResourceFoodConfCountSelect.",'".$compname."','".$personid."','".$billingaddress."','".$reference."')");
}
function delAllTemp($resource_id,$StartDate){
		$row=getAllTemp($resource_id,$StartDate);
		$list=pdoExecute("DELETE FROM `reservation_temporary` WHERE id = ".$row['id']." LIMIT 1");
}
?>