<?php
//Config file for Muuntamo Event listing page
date_default_timezone_set('Europe/Helsinki');
$color = "pink";
function loadTexts(){
	//
	$string['AppTitle'] = "Muuntamo - Tapahtumalistaus";
	$string['OpenForPublicTitle'] = "Muuntamo vapaassa käytössä";
	$string['OpenForPublicDesc'] = "Käy rohkeasti sisään tai nauti ulkopeleistä!";
	$string['EventIsPrivate'] = "Tapahtuma on yksityinen";
	$string['WeekendClosedTitle'] = "Muuntamo kiinni";
	$string['WeekendClosedDesc'] = "Ulkotilat ovat vapaasti käytettävissäsi, nähdään taas arkena!";
	
	$string['HideGUI'] = "Piilota käyttöliittymä";
	$string['Today'] = "Tänään";
	
	$string['Monday'] = "Maanantai";
	$string['Tuesday'] = "Tiistai";
	$string['Wednesday'] = "Keskiviikko";
	$string['Thursday'] = "Torstai";
	$string['Friday'] = "Perjantai";
	$string['Saturday'] = "Lauantai";
	$string['Sunday'] = "Sunnuntai";
	return $string;
}
?>