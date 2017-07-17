<?php
define('ROOT_DIR', './'); //Root dir of Muuntamo from this file
require_once(ROOT_DIR.'Pages/mod/functions.php');
require_once('muuntamoWallConfig.php');
$confTexts = loadTexts();
global $confTexts;
$curParams = "";//basename($_SERVER['REQUEST_URI']);
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
	if($nogui!=1&&$nogui!=2){
		$nogui=NULL;
	}
}
function retrieveWeek($start_date,$end_date){
	//returns events from the time between $start_date and $end_date
	$thisWeek="";
	global $confTexts;
	$currentWeekDay = date('w', strtotime($start_date));
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
		//I had trouble with Date objects (Timezone conversions), so I ended up treating dates as strings...
		//I've replaced some of the strings as date
		//Time from database is in UTC
		//Shown time should be in Europe/Helsinki
		$start_date_temp = explode(" ", $row['start_date']);//Format:YYYY-MM-DD HH:SS
		$end_date_temp = explode(" ", $row['end_date']);
		$row['start_date'] = timeFromDatabase($start_date_temp[0],$start_date_temp[1]);
		$row['end_date'] = timeFromDatabase($end_date_temp[0],$end_date_temp[1]);
		$timeStartTemp = date("H:i",strtotime($row['start_date']));
		$timeEndTemp = date("H:i",strtotime($row['end_date']));
		$reservedTimes[] = $timeStartTemp."-".$timeEndTemp;
		$end_date_temp = $timeEndTemp;
		$start_time_temp = $timeStartTemp;
		$reservationtime=$start_time_temp." - ".$timeEndTemp;
		
		if(isset($row['PublicStartTime'])&&isset($row['PublicEndTime'])&&$row['PublicStartTime']!="00:00:00"){
				$public_start_time_temp = explode(":", $row['PublicStartTime']);
				$public_start_time_temp = $public_start_time_temp[0].":".$public_start_time_temp[1];
				$public_end_time_temp = explode(":", $row['PublicEndTime']);
				$public_end_time_temp = $public_end_time_temp[0].":".$public_end_time_temp[1];
				//$reservationtime=$public_start_time_temp." - ".$public_end_time_temp;
				$publictime=$public_start_time_temp." - ".$public_end_time_temp;
		}else{
			$publictime=FALSE;
			$row['description']=$confTexts['EventIsPrivate'];
		}
		$result[] = eventGenerator($row,$reservationtime,$publictime);
	}
	
	//Creates events for evey available time slot
	$previouslystopped=TRUE;
	if(isset($reservedTimes)){
		for($i=date("H:i",strtotime("08:00"));$i<=date("H:i",strtotime("16:00"));$i=date("H:i", strtotime("+30 minutes",strtotime($i)))){
			$stopped=FALSE;
			foreach($reservedTimes as $temp){
				$temp=explode("-",$temp);
				if($i>=date("H:i",strtotime($temp[0]))&&$i<=date("H:i",strtotime($temp[1]))){
					$stopped=TRUE;
				}
			}
			if(!$stopped){
				$endfreetime=$i;
				if($previouslystopped){
					$startfreetime=$i;
					$previouslystopped=false;
				}
			}else{
				if(isset($startfreetime)&&$startfreetime!=$endfreetime){
					if(!isset($freetimes)||!in_array($startfreetime." - ".$endfreetime,$freetimes)){
						$freetimes[]=$startfreetime." - ".$endfreetime;
					}
				}
				$previouslystopped=true;
			}
			if($i==date("H:i",strtotime("16:00"))&&!$stopped&&isset($startfreetime)){
					$freetimes[]=$startfreetime." - ".$endfreetime;
			}
		}
	}else{
		$freetimes[]="08:00 - 16:00";
	}
	if(isset($freetimes)&&$currentWeekDay!=6&&$currentWeekDay!=0){ //Creates the free time events
		foreach($freetimes as $temp){
			$row['title']=$confTexts['OpenForPublicTitle'];
			$row['description']=$confTexts['OpenForPublicDesc'];
			$result[] = eventGenerator($row,$temp,"");
		}
	}
	if($currentWeekDay==6||$currentWeekDay==0){
		//if it's weekend, generate an event that the establishment is closed
			$row['title']=$confTexts['WeekendClosedTitle'];
			$row['description']=$confTexts['WeekendClosedDesc'];
			$result[] = eventGenerator($row,"","");
	}
	
	$resultarray[0]=$result;		//array containing all of the events
	$resultarray[1]=$eventcount;	//How many events there are
	
	return $resultarray;
}	

//should do events with objects
	function eventGenerator($row,$reservationtime,$publictime){
		//generates html for event
		$event[0][0]="";
		$event[0][1]="";
		$lineadd="";
		if($publictime){
			//if publictime is set, define $reservationtime as it
			$reservationtime=$publictime;
		}
		if($reservationtime!= ''){
			$event[0]=explode(" - ",$reservationtime);
			$lineadd=" - ";
		}
		$reservationtime="<starttime>".$event[0][0]."</starttime>".$lineadd."<endtime>".$event[0][1]."</endtime>";
		
		$event[1]="
		<div class='eventBox'>\n
			\t<h2 class='eventBox'>".$row['title']."</h2>
		<p class='eventBox'>".$reservationtime."<br/><description>".$row['description']."</description></p>\n
		\t<hr class='eventBox' align='left'/>\n
		</div>\n";
		return $event;
	}
//source for weekstart/weekend: https://stackoverflow.com/a/11905818/7785270

//incase nothing is set
		$week_start=date("Y-m-d");// H:i:s
		$week_start=$week_start." 00:00:00";
		$week_end=date("Y-m-d");
		$week_end=$week_end." 23:00:00";
		
if(isset($setdateStart)||isset($setdateEnd)){ //if the get startdate or enddate is received
	if(isset($setdateStart)){
		$week_start=$setdateStart." 00:00:00";
	}else{
		$setdateStart=date("Y-m-d");
	}
	if(isset($setdateEnd)){
		$week_end=$setdateEnd." 23:00:00";
	}else{
		$setdateEnd=$setdateStart;
		$week_end=$setdateEnd." 23:00:00";
	}
	
	//checking if enddate is before startdate or too long period
	$date1 = new DateTime($setdateStart);
	$date2 = new DateTime($setdateEnd);

	$diff = $date1->diff($date2)->format("%r%a");
	if($diff<0||$diff>90){
		if(isset($setdateStart)){
			$week_end=$setdateStart;
		}else{
			$week_end=date("Y-m-d");
		}
		$week_end=$week_end." 23:00:00";
	}
	//$week_end=$setdateStart." 23:00:00";
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

//defining a variable based on the date and giving it the name of the day
//the names of the days are defined in the muuntamoWallConfig.php to allow for translations
if($currentWeekDay==1){
	$selectedDateString=$confTexts['Monday'];
}elseif($currentWeekDay==2){
	$selectedDateString=$confTexts['Tuesday'];
}elseif($currentWeekDay==3){
	$selectedDateString=$confTexts['Wednesday'];
}elseif($currentWeekDay==4){
	$selectedDateString=$confTexts['Thursday'];
}elseif($currentWeekDay==5){
	$selectedDateString=$confTexts['Friday'];
}elseif($currentWeekDay==6){
	$selectedDateString=$confTexts['Saturday'];
}elseif($currentWeekDay==0){
	$selectedDateString=$confTexts['Sunday'];
}else{
	$selectedDateString="";
}
$resultArray=retrieveWeek($week_start,$week_end);
$thisWeek="";

//ordering the events based on date and lumping everything to the same string
usort($resultArray[0], 'date_compare');
foreach($resultArray[0] as $temp){
	//going through each event
	if(isset($nogui)&&$nogui==2){
		//generating json by stripping contents from tags
		$title=everything_in_tags($temp[1], "h2");
		$pparse=everything_in_tags($temp[1], "p");
		$jstart=everything_in_tags($pparse, "starttime");
		$jend=everything_in_tags($pparse, "endtime");
		$description=everything_in_tags($pparse, "description");
		$data[] = array(
			(object)array(
				'Title' => $title,
				'StartTime' => $jstart,
				'EndTime' => $jend,
				'Description' => $description,
			),
		);
		$json = json_encode($data);
	}else{
		//adding event to a string that will be printed
		$thisWeek=$thisWeek.$temp[1];
	}
}

function date_compare($a, $b)
{
    $t1 = strtotime($a[0][0]);
    $t2 = strtotime($b[0][0]);
    return $t1 - $t2;
} 

$temp=explode(" ",$week_start);
$dateBefore=date('Y-m-d', strtotime($temp[0]. ' - 1 days'));
$dateAfter=date('Y-m-d', strtotime($temp[0]. ' + 1 days'));
$displayDateBefore=date('d.m.', strtotime($dateBefore));
$displayDateAfter=date('d.m.', strtotime($dateAfter));
//$temp=explode("-",$temp[0]);´
$displayDayToday2=date("d.m.");
$displayDayToday=date('d.m.', strtotime($temp[0]));
$selectedDateString=$selectedDateString." ".$displayDayToday;

//gui container variables defined
//edit this to edit the gui, or lack of
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
					<a class='btn center' href='?startdate=".date("Y-m-d")."'>".$confTexts['Today']." ".$displayDayToday2."</a> 
					<a class='btn center' href='?startdate=".$dateAfter."'> ".$displayDateAfter." -></a>
					<br/><a class='hideBtn left' href='".$guiHideUrl."'>".$confTexts['HideGUI']."</a>";
}
$guiDateSelect=$guiDateSelect."</div>";

//css selection based on $color variable
$stylesheet = "";
if(strcmp($color,"blue")==0){
	$stylesheet = "<link rel='stylesheet' type='text/css' href='muuntamoWall.css'/>";
}else{
	$stylesheet = "<link rel='stylesheet' type='text/css' href='muuntamoWallpink.css?v9'/>";
}

//selecting the logo based on the $color variable
$logoimg = "";
if(strcmp($color,"blue")==0){
	$logoimg = "<img class='floatyimage' src='muuntamo-logo.png'/>";
}else{
	$logoimg = "<img class='floatyimage' src='Muuntamo-logo-rgb.png?v=7'/>";
}

$refreshermeta = "";
if(isset($nogui)){
	//setting the meta variable to refresh every hour if $nogui is set
	//this will only be used if website is printed
	$refreshermeta = "<meta http-equiv='refresh' content='3600'/>";
}

if(isset($nogui)&&$nogui==2){
	//print the json data
	echo $json;
}else{
	//print the website
	echo "<!DOCTYPE html>

	<html lang='fi' dir='ltr'>
			<head>";
			echo $refreshermeta;
			echo "<title>".$confTexts['AppTitle']."</title>";
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
}


function everything_in_tags($string, $tagname)
{
	//source https://stackoverflow.com/questions/828870/php-regex-how-to-get-the-string-value-of-html-tag
    $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}
?>