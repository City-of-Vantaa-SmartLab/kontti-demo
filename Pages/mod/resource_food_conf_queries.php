<?php
/**
	This file contains sql query functions for the feature "Resource food configurations".
	

*/
require_once(ROOT_DIR . '/Pages/mod/functions.php');

function getSeriesFoodConfInfo($series_id){ //used?
		$addoninfo=getPublicStatus($series_id);
		$list=pdoExecute("SELECT * FROM `resource_food_conf` WHERE foodconf_id IN ( SELECT foodconf_id FROM `resource_food_conf_target` WHERE foodtarget_id IN (SELECT foodtarget_id FROM `reservation_addons` WHERE series_id = ".$series_id." )) Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
		$addoninfo['name']=$row['name'];
		$addoninfo['description']=$row['description'];
		$addoninfo['price']=$row['price'];
	return $addoninfo;
}

function getFoodArrangementInfo($foodconf_id){		//hakee ja palauttaa foodconf_id:n perusteella 
		$list=pdoExecute("SELECT * FROM `resource_food_conf` WHERE foodconf_id=".regexnums($foodconf_id)." Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}

function getFoodArrangementDescription($foodconf_id){		//hakee ja palauttaa foodconf_id:n perusteella huonekonfiguraation kuvauksen
		$list=pdoExecute("SELECT description FROM `resource_food_conf` WHERE foodconf_id=".regexnums($foodconf_id)." Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['description'];
}

function getFoodArrangementName($foodconf_id){		//hakee ja palauttaa foodconf_id:n perusteella huonekonfiguraation nimen
		$foodconf_id=regexnums($foodconf_id);
		$list=pdoExecute("SELECT name FROM `resource_food_conf` WHERE foodconf_id=".$foodconf_id." Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
		return $row['name'];
}

function getFoodArrangement($resource_id,$series_id){ 
	//Retrieves and return the given $resource_id and $series_id combination's 
	//resourceconfiguration (target_id in the table reservation_resources).
	$resource_id=regexnums($resource_id);
	$series_id=regexnums($series_id);
	$list=pdoExecute("SELECT foodtarget_id FROM `reservation_addons` WHERE series_id = ".$series_id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['foodtarget_id'];
}
function getFoodTargetId($resource_id,$foodconf_id){
	$list=pdoExecute("SELECT foodtarget_id FROM `resource_food_conf_target` WHERE foodconf_id=".$foodconf_id." AND resource_id=".$resource_id." LIMIT 1");
	$foodtarget_id=$list->fetch(PDO::FETCH_ASSOC);
	return $foodtarget_id['foodtarget_id'];
}
function getFoodConfId($foodtarget_id){
	$list=pdoExecute("SELECT foodconf_id FROM `resource_food_conf_target` WHERE target_id=".$foodtarget_id." LIMIT 1");
	$foodconf_id=$list->fetch(PDO::FETCH_ASSOC);
	return $foodconf_id['foodconf_id'];
}
function defineFoodArrangements($resource_id){	
	//Retrieves and returns all of $resource_id's resourcefoodconfigurations.
	//foodconf_id,name,description
	$resource_id=regexnums($resource_id);
	$list=pdoExecute("SELECT * FROM `resource_food_conf` WHERE foodconf_id IN(SELECT foodconf_id FROM `resource_food_conf_target` WHERE resource_id=".$resource_id.")");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$contents[]=$row['foodconf_id'].":".$row['name'].":".$row['description'].":".$row['price'];
	}
	return $contents;
}

function removeResourceFoodConf($foodconf_id){	//removes a resource configuration from the database based on foodconf_id
	$foodconf_id=regexnums($foodconf_id);
	$list=pdoExecute("DELETE FROM resource_food_conf WHERE `foodconf_id` = ".$foodconf_id." LIMIT 1");
}

function removeResourceFoodConfResourceLinkWTarget($foodtarget_id){	//removes a link between a resource and a resource configuration
	$foodtarget_id=regexnums($foodtarget_id);
	if(isset($foodtarget_id)){
		$list=pdoExecute("DELETE FROM resource_food_conf_target WHERE `foodtarget_id` = ".$foodtarget_id." LIMIT 1");
	}
}

function createResourceFoodConf($name,$description,$price,$contentlist){	//Creates a resource configuration
	$list=pdoExecute("INSERT INTO resource_food_conf(name,description,price,contentlist) VALUES ('".$name."','".$description."',".$price.",'".$contentlist."')");
}

function createResourceFoodConfResourceLink($resource_id,$foodconf_id){	
	//Creates a link between resource configuration and a resource
	$resource_id=regexnums($resource_id);
	$foodconf_id=regexnums($foodconf_id);
	if(isset($resource_id)&&isset($foodconf_id)){
		$link = checkForFoodLink($resource_id,$foodconf_id);
		if(isset($link)){
			echo "A link exists between this resource and this resource configuration.";
		}else{
			$list=pdoExecute("INSERT INTO resource_food_conf_target(resource_id,foodconf_id) VALUES (".$resource_id.",".$foodconf_id.")");
		}
	}else{
		echo "Missing variables.";
	}
}

function removeResourceFoodConfResourceLink($resource_id,$foodconf_id){	
	//Removes a link between resource configuration and a resource based on $resource_id,$foodconf_id variables 
	//and their database counterparts in the linking table (bookedDB.resource_food_conf_target)
	$resource_id=regexnums($resource_id);
	$foodconf_id=regexnums($foodconf_id);
	if(isset($resource_id)&&isset($foodconf_id)){
		$link = checkForFoodLink($resource_id,$foodconf_id);
		if(isset($link)){			
			$link=regexnums($link);
			removeResourceFoodConfResourceLinkWTarget($link);
		}else{
			echo "A link does not exists between this resource and this resource configuration.";
		}
	}else{
		echo "Missing variables.";
	}
}

function checkForFoodLink($resource_id,$foodconf_id){
	//Checks if a link exists between the $resource_id and $foodconf_id, returns target_id from the linking table (bookedDB.resource_food_conf_target)
	$resource_id=regexnums($resource_id);
	$foodconf_id=regexnums($foodconf_id);
	if(isset($resource_id)&&isset($foodconf_id)){
		$link=pdoExecute("SELECT target_id FROM `resource_food_conf_target` WHERE `resource_id`=".$resource_id." AND `foodconf_id`=".$foodconf_id." LIMIT 1");
		$row=$link->fetch(PDO::FETCH_ASSOC);
	}else{
		echo "Missing variables.";
	}
	return $row['target_id'];
}

function getAllFoodConfResources(){
	//Retrieves all resources for a resource configuration
	//Returns them in an array
	$list=pdoExecute("SELECT * FROM `resource_food_conf_target`");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$result[]=$row;
	}
	return $result;
}
function getAllResourceFoodArrangements(){
	//Retrieves all resource configurations
	//used in dashboard, manage_resource_food_confs
	//Returns them in an array
	$list=pdoExecute("SELECT * FROM `resource_food_conf`");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$result[$row['foodconf_id']]=$row;
	}
	return $result;
}
function insertFoodConfToReservationWithDate($resourcefoodconf_id,$count,$FoodHalfFirst,$FoodHalfSecond,$resource_id,$StartDate){
		//new reservation, series id retrieved with start date/resource_id
	if(isset($count)&&isset($resourcefoodconf_id)&&isset($resource_id)){
		//tarkista onko kyseinen resourcefoodconf_id ($resourcefoodconf_id) ja resource_id ($resource_id) pareina
		$list=getFoodTargetId(regexnums($resource_id),regexnums($resourcefoodconf_id));
		if(isset($list)){	//jos resourcefoodconf_id ja resource_id matchaa, jatka
			$series_id=matchDateAndResource($resource_id,$StartDate);
			if(isset($series_id)){
				updateReservationFoodConf($count,$resourcefoodconf_id,$FoodHalfFirst,$FoodHalfSecond,$series_id);
				$value=1;
			}else{
				echo "Ateria: Jotain meni pieleen! Virhe: \$series_id:tä ei saatu haettua.";
			}
		}else{
			echo "Ateria: Jotain meni pieleen! Virhe: Annettu ateriaratkaisu ei ole kyseiselle tilalle.".$resourcefoodconf_id;
		}
	}else{
		echo "Ateria: Muuttuja puuttuu! \$resource_id:".$resource_id.", \reservation info:".$resource_id.":".$StartDate."<br>";
	}
}
function updateFoodConfToReservationWithSeriesId($resourcefoodconf_id,$count,$FoodHalfFirst,$FoodHalfSecond,$resource_id,$reservation_instance_id){ 
	//used when changing an existing reservation
	$value=0;	//
	if(isset($resource_id)&&isset($reservation_instance_id)){
		//tarkista onko kyseinen resourcefoodconf_id ($resourcefoodconf_id) ja resource_id ($resource_id) pareina
		$list=getFoodTargetId(regexnums($resource_id),regexnums($resourcefoodconf_id));
		if(isset($list)||$resourcefoodconf_id==NULL){	//jos resourcefoodconf_id ja resource_id matchaa, jatka
			$series_id=getSeriesIdWResIID($reservation_instance_id);
			if(isset($series_id)){
				updateReservationFoodConf($count,$resourcefoodconf_id,$FoodHalfFirst,$FoodHalfSecond,$series_id);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:tä ei saatu haettua.";
			}
		}else{
			echo "Jotain meni pieleen! Virhe: Annettu ateriaratkaisu ei ole kyseiselle tilalle.".$resourcefoodconf_id;
		}
	}else{
		echo "Ateria: Muuttuja puuttuu! \$resource_id:".$resource_id.", \$reservation_instance_id:".$reservation_instance_id."<br>";
	}
	return $value;
}

function updateReservationFoodConf($count,$foodconf_id,$FoodHalfFirst,$FoodHalfSecond,$series_id){
	$count=regexnums($count);
	if($foodconf_id!=NULL){$foodconf_id=regexnums($foodconf_id);}else{$foodconf_id=NULL;}
	$series_id=regexnums($series_id);
	$list=pdoExecute("SELECT * FROM `reservation_addons` WHERE series_id = ".$series_id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	//if a row is found, that means a reservation_addons line exists with the series id
	if(isset($row['series_id'])){ 	//updating
		if($foodconf_id==NULL){ 
			//the query will not use a variable with null for some reason
			//checking if foodconf is null
			$list=pdoExecute("UPDATE `reservation_addons`  SET `foodcount` = ".regexnums($count).", `foodtarget_id` = NULL,`FoodSplitFirst` = ".$FoodHalfFirst.",`FoodSplitSecond` = ".$FoodHalfSecond." WHERE series_id = ".regexnums($series_id)."");
		}else{
			$list=pdoExecute("UPDATE `reservation_addons`  SET `foodcount` = ".regexnums($count).", `foodtarget_id` = ".$foodconf_id.",`FoodSplitFirst` = ".$FoodHalfFirst.",`FoodSplitSecond` = ".$FoodHalfSecond." WHERE series_id = ".regexnums($series_id)."");
		}
	}else{							//creating a new entry in db
		InsertReservationFoodConf($count,$foodconf_id,$FoodHalfFirst,$FoodHalfSecond,$series_id);
	}
}
function InsertReservationFoodConf($count,$foodconf_id,$FoodHalfFirst,$FoodHalfSecond,$series_id){
	$count=regexnums($count);
	$foodconf_id=regexnums($foodconf_id);
	$series_id=regexnums($series_id);
	$list=pdoExecute("INSERT INTO reservation_addons (foodcount,foodtarget_id,FoodSplitFirst,FoodSplitSecond,series_id) VALUES (".$count.",".$foodconf_id.",".$FoodHalfFirst.",".$FoodHalfSecond.",".$series_id.")");
}






function updateResourceFoodArrangement($foodconf_id,$name,$description,$price,$contentlist){
	//Updates a resource configuration
	$foodconf_id = regexnums($foodconf_id);
	$name = $name;
	$description = $description;
	$list=pdoExecute("UPDATE `resource_food_conf` SET `name`='".$name."', `description`='".$description."', `price`=".$price.",`contentlist`='".$contentlist."' WHERE `foodconf_id`=".$foodconf_id."");
	$row=$list->fetch(PDO::FETCH_ASSOC);
}

?>