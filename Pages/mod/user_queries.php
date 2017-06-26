<?php
/**
	This file contains sql query functions for features relating to users.
	

*/
require_once(ROOT_DIR . '/Pages/mod/functions.php');

function getAllUserAddonInfo($id){
	//Retrieves all resource info
	$id=regexnums($id);
	$list=pdoExecute("SELECT * FROM `users_addon` WHERE user_id=".$id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}
function getUserNormalInfo($id){
	//Retrieves all resource info
	$id=regexnums($id);
	$list=pdoExecute("SELECT fname,lname,email,phone FROM `users` WHERE user_id=".$id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	return $row;
}
function addUserAddonInfo($id,$compname,$personid,$billingaddress,$reference,$additionalInfo){
	//Inserts to users_addon
	$id=regexnums($id);
	$compname=regexUserInfoText($compname);
	$personid=regexUserInfoText($personid);
	$billingaddress=regexUserInfoText($billingaddress);
	$reference=regexUserInfoText($reference);
	$additionalInfo=regexUserInfoText($additionalInfo);
	$list=pdoExecute("SELECT * FROM `users_addon` WHERE user_id = ".$id." LIMIT 1");
	$row=$list->fetch(PDO::FETCH_ASSOC);
	if(isset($row['user_id'])){
		updateUserAddonInfo($id,$compname,$personid,$billingaddress,$reference,$additionalInfo);
	}else{
		insertUserAddonInfo($id,$compname,$personid,$billingaddress,$reference,$additionalInfo);
	}
}
function insertUserAddonInfo($id,$compname,$personid,$billingaddress,$reference,$additionalInfo){
	//Inserts to users_addon
	$id=regexnums($id);
	$compname=regexUserInfoText($compname);
	$personid=regexUserInfoText($personid);
	$billingaddress=regexUserInfoText($billingaddress);
	$reference=regexUserInfoText($reference);
	$additionalInfo=regexUserInfoText($additionalInfo);
	$list=pdoExecute("INSERT INTO users_addon (user_id,compname,personid,billingaddress,reference,additionalinfo) VALUES (".$id.",'".$compname."','".$personid."','".$billingaddress."','".$reference."','".$additionalInfo."')");
	
	}
function updateUserAddonInfo($id,$compname,$personid,$billingaddress,$reference,$additionalInfo){
	//Updates users_addon
	$id=regexnums($id);		
	$compname=regexUserInfoText($compname);
	$personid=regexUserInfoText($personid);
	$billingaddress=regexUserInfoText($billingaddress);
	$reference=regexUserInfoText($reference);
	$additionalInfo=regexUserInfoText($additionalInfo);
	$list=pdoExecute("UPDATE users_addon SET compname='".$compname."',personid='".$personid."',billingaddress='".$billingaddress."',reference='".$reference."', additionalinfo='".$additionalInfo."' WHERE user_id=".$id."");
}
?>