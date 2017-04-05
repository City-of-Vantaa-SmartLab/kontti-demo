<?php
/**
	Tämä tiedosto sisältää funktioita.
	

*/
function regexnums($value){ // Poistaa kaiken muun paitsi numerot
	return preg_replace("/[^0-9]/","",$value);
}
function timeForDatabase($date,$time){
	$time=regexLengthIsTwo($time);
	$time=regexTimeIsReal($time);
	$time=convertTimeTo($date,$time);
	return $time;
}
function convertTimeTo($date,$time){	//converts the time to database time using booked's Date class
	require_once(ROOT_DIR.'lib/Common/date.php');
	require_once(ROOT_DIR.'lib/Common/time.php');
	
	$databasetime = new Date();
	$databasetime->__construct($date." ".$time, 'Europe/Helsinki');
	return $databasetime->ToDatabase();
	/**
	// Bad way of doing this
	
	$time=explode(":", $time);
	$time[0]=$time[0]-3;
	if($time[0]<0){
		$time[0]=24+$time[0];
	}
	if(strlen($time[0])!=2){
		$time[0]="0".$time[0];
	}
	return implode(":", $time);
	*/
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

function createThumb($address, $conf_id){
		$tempfilename="temp_".$conf_id.".jpg";
		$copyname=ROOT_DIR."/uploads/arrangmenets/thumbnail/".$tempfilename;
		copy($address,$copyname);
		$name=ROOT_DIR."uploads/arrangements/thumbnail/".$tempfilename;
		$thumbname=ROOT_DIR."uploads/arrangements/thumbnail/thumb_".$conf_id.".png";
		
		$thumb = new Imagick();
		$thumb->readImage($name);   
		$aspects=$thumb->getImageGeometry();
		$x=70;
		$y=70;
		if($aspects['height']>$aspects['width']){
			$ratio=$aspects['height']/$aspects['width'];
			$x=70/$ratio;
		}else{
			$ratio=$aspects['width']/$aspects['height'];
			$y=70/$ratio;
		}
		$thumb->resizeImage($x,$y,Imagick::FILTER_LANCZOS,1);
		$thumb->writeImage($thumbname);
		$thumb->clear();
		$thumb->destroy();
		unlink($copyname);
}
?>