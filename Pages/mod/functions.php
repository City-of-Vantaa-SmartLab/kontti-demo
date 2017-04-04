<?php
/**
	Tämä tiedosto sisältää funktioita.
	

*/

require_once('connectors/mysql_connect.php');
$instance = new databaseConnect();
$instance->connect();
		global $dbh;
function getTargetId($series_id){		//hakee ja palauttaa series_id:n perusteella target_id:n
		global $dbh;
		$list=$dbh->prepare("SELECT target_id FROM `reservation_series` WHERE series_id=".regexnums($series_id)." Limit 1");
		$list->execute();
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['target_id'];
}
function getArrangementDescription($conf_id){		//hakee ja palauttaa conf_id:n perusteella huonekonfiguraation kuvauksen
		global $dbh;
		$list=$dbh->prepare("SELECT description FROM `resource_conf` WHERE conf_id=".regexnums($conf_id)." Limit 1");
		$list->execute();
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['description'];
}
function getArrangementName($conf_id){		//hakee ja palauttaa conf_id:n perusteella huonekonfiguraation nimen
		global $dbh;
		$list=$dbh->prepare("SELECT name FROM `resource_conf` WHERE conf_id=".regexnums($conf_id)." Limit 1");
		$list->execute();
		$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['name'];
}

function getArrangements($resource_id){	//Retrieves and returns all of $resource_id's roomconfigurations.
	global $dbh;		
	$resource_id=regexnums($resource_id);
	$list=$dbh->prepare("SELECT * FROM `resource_conf` WHERE conf_id IN(SELECT conf_id FROM `resource_conf_target` WHERE resource_id='".$resource_id."')");
	$list->execute();
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$contents[]=$row['conf_id'].":".$row['name'];
	}
	return $contents;
}
//$StartDate ja $resource_id vaihettava id:seen vaikka mahdoton olla samoja...?
//Päivittää huoneeseen valitun target_id:n $roomconf_id:llä.
function setArrangement($roomconf_id,$resource_id,$StartDate){ 
	$value=0;	//
	if($resource_id==NULL||$StartDate==NULL){	//pakko olla molemmat, muuten ei voida olla varma oikeasta varauksesta
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$StartDate:".$StartDate."<br>";
	}else{
		//tarkista onko kyseinen conf_id ($roomconf_id) ja resource_id ($resource_id) pareina
		global $dbh;
		$list=$dbh->prepare("SELECT target_id FROM `resource_conf_target` WHERE resource_id=".regexnums($resource_id)." AND conf_id=".regexnums($roomconf_id)." LIMIT 1");
		$list->execute();
		if($row=$list->fetch(PDO::FETCH_ASSOC)){	//jos conf_id ja resource_id matchaa, jatka
			$series_id=matchDateAndResource($resource_id,$StartDate);
			if($series_id!=NULL){
				updateTargetId($roomconf_id,$series_id);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:tä ei saatu haettua. \$StartDate: ".$StartDate;
			}
		}else{
			echo "Jotain meni pieleen! Virhe: Annettu huonekonfiguraatio ei ole kyseiselle tilalle.";
		}
	}
	return $value;
}

function setArrangementWResIID($roomconf_id,$resource_id,$reservation_instance_id){ 
	$value=0;	//
	if($resource_id==NULL||$reservation_instance_id==NULL){
		echo "Muuttuja puuttuu! \$resource_id:".$resource_id.", \$reservation_instance_id:".$reservation_instance_id."<br>";
	}else{
		//tarkista onko kyseinen conf_id ($roomconf_id) ja resource_id ($resource_id) pareina
		global $dbh;
		$list=$dbh->prepare("SELECT target_id FROM `resource_conf_target` WHERE resource_id=".regexnums($resource_id)." AND conf_id=".regexnums($roomconf_id)." LIMIT 1");
		$list->execute();
		if($row=$list->fetch(PDO::FETCH_ASSOC)){	//jos conf_id ja resource_id matchaa, jatka
			$series_id=getSeriesIdWResIID($reservation_instance_id);
			if($series_id!=NULL){
				updateTargetId($roomconf_id,$series_id);
				$value=1;
			}else{
				echo "Jotain meni pieleen! Virhe: \$series_id:tä ei saatu haettua.";
			}
		}else{
			echo "Jotain meni pieleen! Virhe: Annettu huonekonfiguraatio ei ole kyseiselle tilalle.";
		}
	}
	return $value;
}
function createRoomConf($name,$description,$resource_id){
	global $dbh;
	$resource_id=regexnums($resource_id);
	$list=$dbh->prepare("INSERT INTO resource_conf(name,description) VALUES ('".$name."','".$description."')");
	$list->execute();
	createRoomConfResourceLink($resource_id);
	
}
function createRoomConfResourceLink($resource_id){
		global $dbh;
		$list=$dbh->prepare("INSERT INTO resource_conf_target(resource_id,conf_id) VALUES (".$resource_id.",".$dbh->lastInsertId().")");
		$list->execute();
}

function updateTargetId($roomconf_id,$series_id){
	global $dbh;
	$list=$dbh->prepare("UPDATE `reservation_series` SET `target_id` = ".regexnums($roomconf_id)." WHERE series_id = ".regexnums($series_id)." ");
	$list->execute();
}
function getSeriesIdWResIID($reservation_instance_id){
	global $dbh;
	$list=$dbh->prepare("SELECT series_id FROM `reservation_instances` WHERE reservation_instance_id = ".regexnums($reservation_instance_id)." LIMIT 1");
	$list->execute();
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['series_id'];
}
function matchDateAndResource($resource_id,$StartDate){
	global $dbh;
	//selvitetään series_id (eli varaustapahtuman id) etsimällä $StartDate:n perusteella 
	//ja tarkistamalla että kyseinen aika on halutun resource_id:n
	$list=$dbh->prepare("SELECT series_id FROM `reservation_instances` WHERE start_date='".$StartDate."' AND series_id IN(SELECT series_id FROM `reservation_resources` WHERE resource_id = ".regexnums($resource_id).")");
	$list->execute();
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row['series_id'];
}

function regexnums($value){ // Poistaa kaiken muun paitsi numerot
	return preg_replace("/[^0-9]/","",$value);
}
function timeForDatabase($time){
	$time=regexLengthIsTwo($time);
	$time=regexTimeIsReal($time);
	$time=convertTimeTo($time);
	return $time;
}
function convertTimeTo($time){
	$time=explode(":", $time);
	$time[0]=$time[0]-3;
	if($time[0]<0){
		$time[0]=24+$time[0];
	}
	if(strlen($time[0])!=2){
		$time[0]="0".$time[0];
	}
	return implode(":", $time);
}
function DateIsReal($date){
	$date=regexDateIsReal($date);
	list($y, $m, $d) = explode("-", $date);
	return checkdate($m, $d, $y);
}
function regexDateIsReal($time){
    return preg_replace("/[^0-9-]/","",$time); //poistaa annetusta $time muut kuin numerot ja - merkit ja palauttaa tuloksen
}
function regexTimeIsReal($time){
    return preg_replace("/[^0-9:]/","",$time); //poistaa annetusta $time muut kuin numerot ja : merkit ja palauttaa tuloksen
}
function regexLengthIsTwo($time){	//poistaa formaatista 00:00:00 ylimääräiset : eroteltuna, [2]:[2]:[2]
	$time=explode(":", $time);
	for($i=0;$i<count($time);$i++){
		$time[$i]=substr($time[$i],0,2);
	}
	return implode(":", $time);
}
?>