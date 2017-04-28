<?php
/**
	This file contains sql query functions for the feature "Resource configurations".
	

*/
require_once(ROOT_DIR . '/Pages/mod/connectors/mysql_connect.php');
$instance = new databaseConnect();
$instance->connect();
		global $dbh;
		
function pdoExecute($query){
		global $dbh;
		$list=$dbh->prepare($query);
		$list->execute();
	return $list;
}

function getArrangementDescription($conf_id){		//hakee ja palauttaa conf_id:n perusteella huonekonfiguraation kuvauksen
		$list=pdoExecute("SELECT description FROM `resource_conf` WHERE conf_id=".regexnums($conf_id)." Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['description'];
}

function getArrangementName($conf_id){		//hakee ja palauttaa conf_id:n perusteella huonekonfiguraation nimen
		$list=pdoExecute("SELECT name FROM `resource_conf` WHERE conf_id=".regexnums($conf_id)." Limit 1");
		$row=$list->fetch(PDO::FETCH_ASSOC);
		return $row['name'];
}

function getArrangement($resource_id,$series_id){ 
	//Retrieves and return the given $resource_id and $series_id combination's 
	//resourceconfiguration (target_id in the table reservation_resources).
	$resource_id=regexnums($resource_id);
	$series_id=regexnums($series_id);
	$list=pdoExecute("SELECT target_id FROM `reservation_resources` WHERE series_id = ".$series_id." AND resource_id = ".$resource_id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['target_id'];
}

function defineArrangements($resource_id){	//Retrieves and returns all of $resource_id's resourceconfigurations.	
	$resource_id=regexnums($resource_id);
	$list=pdoExecute("SELECT * FROM `resource_conf` WHERE conf_id IN(SELECT conf_id FROM `resource_conf_target` WHERE resource_id='".$resource_id."')");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$contents[]=$row['conf_id'].":".$row['name'];
	}
	return $contents;
}

//$StartDate ja $resource_id vaihettava id:seen vaikka mahdoton olla samoja...?
//P‰ivitt‰‰ huoneeseen valitun target_id:n $resourceconf_id:ll‰.
function setArrangement($resourceconf_id,$resource_id,$StartDate){ 
	$value=0;	//
	if(is_null($resource_id)||is_null($StartDate==NULL)){	//pakko olla molemmat, muuten ei voida olla varma oikeasta varauksesta
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$StartDate:".$StartDate."<br>";
	}else{
		//tarkista onko kyseinen conf_id ($resourceconf_id) ja resource_id ($resource_id) pareina
		$list=pdoExecute("SELECT target_id FROM `resource_conf_target` WHERE resource_id=".regexnums($resource_id)." AND conf_id=".regexnums($resourceconf_id)." LIMIT 1");
		if($row=$list->fetch(PDO::FETCH_ASSOC)){	//jos conf_id ja resource_id matchaa, jatka
			$series_id=matchDateAndResource($resource_id,$StartDate);
			if($series_id!=NULL){
				updateTargetId($resourceconf_id,$series_id,$resource_id);
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

function setArrangementWResIID($resourceconf_id,$resource_id,$reservation_instance_id){ 
	$value=0;	//
	if($resourceconf_id&&$resource_id==NULL||$reservation_instance_id==NULL){
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$reservation_instance_id:".$reservation_instance_id."<br>";
	}else{
		//tarkista onko kyseinen conf_id ($resourceconf_id) ja resource_id ($resource_id) pareina
		$list=pdoExecute("SELECT target_id FROM `resource_conf_target` WHERE resource_id=".regexnums($resource_id)." AND conf_id=".regexnums($resourceconf_id)." LIMIT 1");
		if($row=$list->fetch(PDO::FETCH_ASSOC)){	//jos conf_id ja resource_id matchaa, jatka
			$series_id=getSeriesIdWResIID($reservation_instance_id);
			if($series_id!=NULL){
				updateTargetId($resourceconf_id,$series_id,$resource_id);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:t‰ ei saatu haettua.";
			}
		}else{
			echo "Jotain meni pieleen! Virhe: Annettu huonekonfiguraatio ei ole kyseiselle tilalle.";
		}
	}
	return $value;
}

function removeResourceConf($conf_id){	//removes a resource configuration from the database based on conf_id
	$conf_id=regexnums($conf_id);
	$list=pdoExecute("DELETE FROM resource_conf WHERE `conf_id` = ".$conf_id." LIMIT 1");
}

function removeResourceConfResourceLinkWTarget($target_id){	//removes a link between a resource and a resource configuration
	$target_id=regexnums($target_id);
	if(isset($target_id)){
		$list=pdoExecute("DELETE FROM resource_conf_target WHERE `target_id` = ".$target_id." LIMIT 1");
	}
}

function createResourceConf($name,$description,$resource_id){	//Creates a resource configuration
	$resource_id=regexnums($resource_id);
	$list=pdoExecute("INSERT INTO resource_conf(name,description) VALUES ('".$name."','".$description."')");
	//createResourceConfResourceLink($resource_id,$dbh->lastInsertId()); //temp
}

function createResourceConfResourceLink($resource_id,$conf_id){	
	//Creates a link between resource configuration and a resource
	$resource_id=regexnums($resource_id);
	$conf_id=regexnums($conf_id);
	if(isset($resource_id)&&isset($conf_id)){
		$link = checkForLink($resource_id,$conf_id);
		if(isset($link)){
			echo "A link exists between this resource and this resource configuration.";
		}else{
			$list=pdoExecute("INSERT INTO resource_conf_target(resource_id,conf_id) VALUES (".$resource_id.",".$conf_id.")");
		}
	}else{
		echo "Missing variables.";
	}
}

function removeResourceConfResourceLink($resource_id,$conf_id){	
	//Removes a link between resource configuration and a resource based on $resource_id,$conf_id variables 
	//and their database counterparts in the linking table (bookedDB.resource_conf_target)
	$resource_id=regexnums($resource_id);
	$conf_id=regexnums($conf_id);
	if(isset($resource_id)&&isset($conf_id)){
		$link = checkForLink($resource_id,$conf_id);
		if(isset($link)){			
			$link=regexnums($link);
			removeResourceConfResourceLinkWTarget($link);
		}else{
			echo "A link does not exists between this resource and this resource configuration.";
		}
	}else{
		echo "Missing variables.";
	}
}

function checkForLink($resource_id,$conf_id){
	//Checks if a link exists between the $resource_id and $conf_id, returns target_id from the linking table (bookedDB.resource_conf_target)
	$resource_id=regexnums($resource_id);
	$conf_id=regexnums($conf_id);
	if(isset($resource_id)&&isset($conf_id)){
		$link=pdoExecute("SELECT target_id FROM `resource_conf_target` WHERE `resource_id`=".$resource_id." AND `conf_id`=".$conf_id." LIMIT 1");
		$row=$link->fetch(PDO::FETCH_ASSOC);
	}else{
		echo "Missing variables.";
	}
	return $row['target_id'];
}

function updateTargetId($resourceconf_id,$series_id,$resource_id){
	$list=pdoExecute("UPDATE `reservation_resources` SET `target_id` = ".regexnums($resourceconf_id)." WHERE series_id = ".regexnums($series_id)." AND resource_id = ".regexnums($resource_id)."");
}

function getSeriesIdWResIID($reservation_instance_id){
	$list=pdoExecute("SELECT series_id FROM `reservation_instances` WHERE reservation_instance_id = ".regexnums($reservation_instance_id)." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['series_id'];
}

function matchDateAndResource($resource_id,$StartDate){
	//selvitet‰‰n series_id (eli varaustapahtuman id) etsim‰ll‰ $StartDate:n perusteella 
	//ja tarkistamalla ett‰ kyseinen aika on halutussa resource_id:ss‰
	$list=pdoExecute("SELECT series_id FROM reservation_instances WHERE start_date='".$StartDate."' AND series_id IN(SELECT series_id FROM reservation_resources WHERE resource_id = ".regexnums($resource_id).") LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['series_id'];
}

function getAllConfResources(){
	//Retrieves all resources for a resource configuration
	//Returns them in an array
	$list=pdoExecute("SELECT * FROM `resource_conf_target`");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$result[]=$row;
	}
	return $result;
}
function getAllResourceArrangements(){
	//Retrieves all resource configurations
	//Returns them in an array
	$list=pdoExecute("SELECT * FROM `resource_conf`");
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$result[]=$row;
	}
	return $result;
}


function updateResourceArrangement($conf_id,$name,$description){
	//Updates a resource configuration
	$conf_id = regexnums($conf_id);
	$name = $name;
	$description = $description;
	$list=pdoExecute("UPDATE `resource_conf` SET `name`='".$name."', `description`='".$description."' WHERE `conf_id`=".$conf_id."");
	$row=$list->fetch(PDO::FETCH_ASSOC);
}

?>