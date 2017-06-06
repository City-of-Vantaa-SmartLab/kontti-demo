<?php
/**
	This file contains sql query functions for features relating to resources.
	

*/
require_once(ROOT_DIR . '/Pages/mod/functions.php');

function getSeriesIdFromInstanceId($id){
	$id=regexnums($id);
	$list=pdoExecute("SELECT series_id FROM `reservation_instances` WHERE reservation_instance_id=".$id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['series_id'];
}

function getAllResourceInfo($id){
	//Retrieves all resource info
	$id=regexnums($id);
	$list=pdoExecute("SELECT * FROM `resources` WHERE resource_id=".$id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function getPublicStatus($series_id){
	//used to get everything instead of just PublicStatus...
	$series_id=regexnums($series_id);
	$list=pdoExecute("SELECT * FROM `reservation_addons` WHERE series_id=".$series_id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function insertEventPublicWithDate($PublicStatus,$PublicTime,$PublicEndTime,$RoomForOtherPresenter,$resource_id,$StartDate){
//used when creating a reservation based on time (new reservation)	
	$value=0;	//
	$PublicStatus=regexnums($PublicStatus);
	if($PublicStatus>1||$PublicStatus<0){
		$PublicStatus=0;
	}
	if(is_null($resource_id)&&is_null($StartDate==NULL)){	//pakko olla molemmat, muuten ei voida olla varma oikeasta varauksesta
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$StartDate:".$StartDate."<br>";
	}else{
		if(isset($PublicStatus)&&isset($PublicTime)&&isset($PublicEndTime)){
			$series_id=matchDateAndResource($resource_id,$StartDate);
			if(isset($series_id)){
				updatePublicStatus($PublicStatus,$PublicTime,$PublicEndTime,$series_id,$RoomForOtherPresenter);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:t&#228; ei saatu haettua. \$StartDate: ".$StartDate;
			}
		}else{
			echo "Jotain meni pieleen! Virhe: Annettu huonekonfiguraatio ei ole kyseiselle tilalle.";
		}
	}
	return $value;
}
function insertEventPublicWResIID($PublicStatus,$PublicStartTime,$PublicEndTime,$RoomForOtherPresenter,$resource_id,$reservation_instance_id){ 
	$value=0;	//
	if(isset($resource_id)||isset($reservation_instance_id)){
			$series_id=getSeriesIdWResIID($reservation_instance_id);
			if(isset($series_id)){
				updatePublicStatus($PublicStatus,$PublicStartTime,$PublicEndTime,$series_id,$RoomForOtherPresenter);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:tä ei saatu haettua.";
			}
	}else{
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$reservation_instance_id:".$reservation_instance_id."<br>";
	}
	return $value;
}

function updatePublicStatus($PublicStatus,$PublicStartTime,$PublicEndTime,$series_id,$RoomForOtherPresenter){
	$PublicStatus=regexnums($PublicStatus);
	$PublicStartTime=regexTimeIsReal($PublicStartTime);
	$PublicEndTime=regexTimeIsReal($PublicEndTime);
	$list=pdoExecute("SELECT * FROM `reservation_addons` WHERE series_id = ".$series_id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	if(isset($row['series_id'])){
		$list=pdoExecute("UPDATE `reservation_addons` SET `PublicStatus` = ".$PublicStatus.", `PublicStartTime` = '".$PublicStartTime."', `PublicEndtime` = '".$PublicEndTime."', `RoomForOtherPresenter` = '".$RoomForOtherPresenter."' WHERE series_id = ".regexnums($series_id)."");
	}else{
		InsertPublicStatus($PublicStatus,$PublicStartTime,$PublicEndTime,$series_id,$RoomForOtherPresenter);
	}
}
function InsertPublicStatus($PublicStatus,$PublicStartTime,$PublicEndTime,$series_id,$RoomForOtherPresenter){
	$PublicStatus=regexnums($PublicStatus);
	$PublicStartTime=regexTimeIsReal($PublicStartTime);
	$PublicEndTime=regexTimeIsReal($PublicEndTime);
	$list=pdoExecute("INSERT INTO reservation_addons (series_id,PublicStatus,PublicStartTime,PublicEndTime,RoomForOtherPresenter) VALUES (".$series_id.",".$PublicStatus.",'".$PublicStartTime."','".$PublicEndTime."', '".$RoomForOtherPresenter."')");
}
?>