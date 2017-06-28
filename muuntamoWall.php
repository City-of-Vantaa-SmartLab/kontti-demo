<?php
define('ROOT_DIR', './'); //Root dir of Muuntamo from this file
require_once(ROOT_DIR.'Pages/mod/functions.php');
date_default_timezone_set('Europe/Helsinki');
$curParams = "";//basename($_SERVER['REQUEST_URI']);
$color="pink";
if(isset($_GET['startdate'])){
	if(DateIsReal($_GET['startdate'])){
		$setdateStart=regexDateIsReal($_GET['startdate']);
		$curParams="startdate=".$setdateStart;
	}
}
if(isset($_GET['enddate'])){
	if(DateIsReal($_GET['enddate'])){
		$setdateEnd=regexDateIsReal($_GET['enddate']);
	}
}
if(isset($_GET['nogui'])){
	$nogui=regexSingleNumber($_GET['nogui']);
	if($nogui!=1){
		$nogui=NULL;
	}
}
function retrieveWeek($start_date,$end_date){
	//returns events from the time between $start_date and $end_date
	$result="";
	$thisWeek="";
	$start_date = explode(" ", $start_date);
	$start_date = timeForDatabase($start_date[0],$start_date[1]);
	$end_date = explode(" ", $end_date);
	$end_date = timeForDatabase($end_date[0],$end_date[1]);
	//combines three tables based on date, they're all linked by serires_id
	$list=pdoExecute("SELECT start_date,end_date,reservation_series.*, reservation_addons.* FROM reservation_instances LEFT JOIN reservation_series ON reservation_instances.series_id=reservation_series.series_id LEFT JOIN reservation_addons ON reservation_instances.series_id=reservation_addons.series_id WHERE reservation_series.status_id=1 AND reservation_instances.start_date>'".$start_date."' AND reservation_instances.end_date<'".$end_date."' ORDER BY start_date"); 
	$eventcount=0;
	while($row=$list->fetch(PDO::FETCH_ASSOC)){
		$eventcount=$eventcount+1;
		//goes through all the events
		$publictime="";
		$reservationtime="";
		//I had trouble with Date objects, so I ended up treating dates as strings...
		//Time from database is in UTC
		//Shown time should be in Europe/Helsinki
		$start_date_temp = explode(" ", $row['start_date']);//Format:YYYY-MM-DD HH:SS
		$end_date_temp = explode(" ", $row['end_date']);
		$row['start_date'] = timeFromDatabase($start_date_temp[0],$start_date_temp[1]);
		$row['end_date'] = timeFromDatabase($end_date_temp[0],$end_date_temp[1]);
		$end_date_temp = explode(" ", $row['end_date']);
		$end_date_temp = explode(":", $end_date_temp[1]);
		$end_date_temp = $end_date_temp[0].":".$end_date_temp[1];
		$start_date_temp = explode(" ", $row['start_date']);
		$start_time_temp = explode(":", $start_date_temp[1]);
		$start_time_temp = $start_time_temp[0].":".$start_time_temp[1];
		$reservationtime=$start_time_temp." - ".$end_date_temp."<br/>";
		$result=$result."<div class='eventBox'>\n";
		
		if(isset($row['PublicStartTime'])&&isset($row['PublicEndTime'])&&$row['PublicStartTime']!="00:00:00"){
				$public_start_time_temp = explode(":", $row['PublicStartTime']);
				$public_start_time_temp = $public_start_time_temp[0].":".$public_start_time_temp[1];
				$public_end_time_temp = explode(":", $row['PublicEndTime']);
				$public_end_time_temp = $public_end_time_temp[0].":".$public_end_time_temp[1];
				$reservationtime="";
				$publictime=$publictime.$public_start_time_temp." - ".$public_end_time_temp."<br/>\n";
		}else{
			$publictime="Tapahtuma on yksityinen";
			$row['description']="";
		}
		$result=$result."\t<h2 class='eventBox'>".$row['title']."</h2><p class='eventBox'>".$reservationtime.$publictime.$row['description']."</p>\n";
	
		$result=$result."\t<hr class='eventBox' align='left'/>\n</div>\n";
	}
	$resultarray[0]=$result;
	$resultarray[1]=$eventcount;
	return $resultarray;
}	
//source for weekstart/weekend: https://stackoverflow.com/a/11905818/7785270

	$week_start="2017-06-05 00:00:00";//incase nothing gets set
	$week_end="2017-06-05 23:00:00";//incase nothing gets set
if(isset($setdateStart)){ //if the get is received
	$week_start=$setdateStart." 00:00:00";
	$week_end=$setdateStart." 23:00:00";
}else{
	$week_start="2017-06-05 00:00:00"; //set this date to be the starting point
	if( strtotime($week_start) > strtotime(date("Y-m-d H:i:s")) ) {
		$week_start="2017-06-05 00:00:00";//set this date to be the starting point
		$week_end="2017-06-05 23:00:00";//set this date to be the ending point
	}else{
		$week_start=date("Y-m-d");// H:i:s
		$week_start=$week_start." 00:00:00";
		$week_end=date("Y-m-d");
		$week_end=$week_end." 23:00:00";
	}
}
$currentWeekDay = date('w', strtotime($week_start));
if($currentWeekDay==1){
	$selectedDateString="Maanantai";
}elseif($currentWeekDay==2){
	$selectedDateString="Tiistai";
}elseif($currentWeekDay==3){
	$selectedDateString="Keskiviikko";
}elseif($currentWeekDay==4){
	$selectedDateString="Torstai";
}elseif($currentWeekDay==5){
	$selectedDateString="Perjantai";
}elseif($currentWeekDay==6){
	$selectedDateString="Lauantai";
}elseif($currentWeekDay==0){
	$selectedDateString="Sunnuntai";
}else{
	$selectedDateString="";
}
$resultArray=retrieveWeek($week_start,$week_end);
$thisWeek=$resultArray[0];
$temp=explode(" ",$week_start);
$dateBefore=date('Y-m-d', strtotime($temp[0]. ' - 1 days'));
$dateAfter=date('Y-m-d', strtotime($temp[0]. ' + 1 days'));
$displayDateBefore=date('d.m.', strtotime($dateBefore));
$displayDateAfter=date('d.m.', strtotime($dateAfter));
//$temp=explode("-",$temp[0]);´
$displayDayToday2=date("d.m.");
$displayDayToday=date('d.m.', strtotime($temp[0]));
$selectedDateString=$selectedDateString." ".$displayDayToday;

$guiDateSelect = "<div class='guiContainer'>";
if(isset($nogui)){
	$guiDateSelect=$guiDateSelect."";
}else{
	$guiHideUrl="";
	if(!empty($_GET)){
		$guiHideUrl="?".$curParams;
		$guiHideUrl=$guiHideUrl."&";
	}else{
		$guiHideUrl="?";
	}
	$guiHideUrl=$guiHideUrl."nogui=1";
	$guiDateSelect=$guiDateSelect."<a class='btn center' href='?startdate=".$dateBefore."'><- ".$displayDateBefore."</a> 
					<a class='btn center' href='?startdate=".date("Y-m-d")."'>Tänään ".$displayDayToday2."</a> 
					<a class='btn center' href='?startdate=".$dateAfter."'> ".$displayDateAfter." -></a>
					<br/><a class='hideBtn left' href='".$guiHideUrl."'>Piilota käyttöliittymä</a>";
}
$guiDateSelect=$guiDateSelect."</div>";
$stylesheet = "";

if(strcmp($color,"blue")==0){
	$stylesheet = "<link rel='stylesheet' type='text/css' href='muuntamoWall.css'/>";
}else{
	$stylesheet = "<link rel='stylesheet' type='text/css' href='muuntamoWallpink.css?v9'/>";
}

$logoimg = "";
if(strcmp($color,"blue")==0){
	$logoimg = "<img class='floatyimage' src='muuntamo-logo.png'/>";
}else{
	$logoimg = "<img class='floatyimage' src='Muuntamo-logo-rgb.png?v=7'/>";
}

$refreshermeta = "";
if(isset($nogui)){
	$refreshermeta = "<meta http-equiv='refresh' content='3600'/>";
}
echo "<!DOCTYPE html>

<html lang='fi' dir='ltr'>
		<head>";
		echo $refreshermeta;
		echo "<title>Muuntamo - Tapahtumalistaus</title>";
		echo $stylesheet;
		echo "</head>
<body>";
echo $guiDateSelect;
echo $logoimg;
echo "<div class='eventContainer'>";
echo "<h3 class='eventContainer'>".$selectedDateString."</h3><br/>";
echo $thisWeek;
echo "</div>";
echo "</body></html>";
?>