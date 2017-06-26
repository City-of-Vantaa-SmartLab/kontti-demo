<?php
/**
 * Copyright 2011-2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 * This file has been modified for Muuntamo.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');

interface IReservationUpdatePage extends IReservationSavePage
{
	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return SeriesUpdateScope
	 */
	public function GetSeriesUpdateScope();

	/*
	 * @return array|int[]
	 */
	public function GetRemovedAttachmentIds();
}

class ReservationUpdatePage extends ReservationSavePage implements IReservationUpdatePage
{
	/**
	 * @var ReservationUpdatePresenter
	 */
	private $_presenter;

	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;

	public function __construct()
	{
		parent::__construct();

		$factory = new ReservationPresenterFactory();
		$this->_presenter = $factory->Update($this, ServiceLocator::GetServer()->GetUserSession());
	}

	public function PageLoad()
	{
		try
		{
			$ResourceArrangementAR=$_POST['additionalResources'];
			if(isset($_POST['ResourceFoodArrangementCountSelect'])){
				$tempCount=regexnums($_POST['ResourceFoodArrangementCountSelect']);
				foreach($ResourceArrangementAR as $resource){
					if($tempCount[$resource]>35){
						$tempCount[$resource]=35;
					}elseif($tempCount[$resource]<0){
						$tempCount[$resource]=0;
					}
				}
				
				$_POST['ResourceFoodArrangementCountSelect']=$tempCount;
			}
			$compname=regexUserInfoText($_POST['compname']);
			$personid=regexUserInfoText($_POST['personid']);
			$billingaddress=regexUserInfoText($_POST['billingaddress']);
			$reference=regexUserInfoText($_POST['reference']);
			$additionalInfo=regexUserInfoText($_POST['additionalinfo']);
			$ResourceArrangement=$_POST['ResourceArrangement'];
			if(isset($_POST['ResourceFoodArrangement'])){
				$ResourceFoodArrangement=$_POST['ResourceFoodArrangement'];
			}else{
				$ResourceFoodArrangement=0;
			}
			if(isset($_POST['ResourceFoodArrangementCountSelect'])){
				$ResourceFoodArrangementCountSelect=$_POST['ResourceFoodArrangementCountSelect'];
			}
			$FoodHalfFirst=0;
			$FoodHalfSecond=0;
			if(isset($ResourceArrangementAR)){
				foreach($ResourceArrangementAR as $resource){
					if(isset($_POST['ResourceFoodArrangementCountSelect'])){
						$ResourceFoodArrangementCountSelect=$_POST['ResourceFoodArrangementCountSelect'];
					}else{
						$ResourceFoodArrangementCountSelect[$resource]=0;
					}
						
					
					if(isset($_POST['foodhalffirst'.regexnums($ResourceFoodArrangement[$resource]).''])||isset($_POST['foodhalfsecond'.regexnums($ResourceFoodArrangement[$resource]).''])){
						$FoodHalfFirst=regexnums($_POST['foodhalffirst'.regexnums($ResourceFoodArrangement[$resource]).'']);
						$FoodHalfSecond=regexnums($_POST['foodhalfsecond'.regexnums($ResourceFoodArrangement[$resource]).'']);
						if($FoodHalfFirst==NULL){$FoodHalfFirst=0;}
						if($FoodHalfSecond==NULL){$FoodHalfSecond=0;}
					}
					setAllTemp($resource,timeForDatabase(regexDateIsReal($_POST['beginDate']),$_POST['beginPeriod']),regexnums($ResourceArrangement[$resource]),regexnums($ResourceFoodArrangement[$resource]),regexnums($ResourceFoodArrangementCountSelect[$resource]),$FoodHalfFirst,$FoodHalfSecond,$compname,$personid,$billingaddress,$reference,$additionalInfo);
				}
			}
			$this->EnforceCSRFCheck();
			$reservation = $this->_presenter->BuildReservation();
			$this->_presenter->HandleReservation($reservation);
			$databaseTimeConv=timeForDatabase(regexDateIsReal($_POST['beginDate']),$_POST['beginPeriod']);
			foreach($ResourceArrangementAR as $resource){
				delAllTemp($resource,$databaseTimeConv);
			}
			if ($this->_reservationSavedSuccessfully)
			{
				$this->Set('Resources', $reservation->AllResources());
				$this->Set('Instances', $reservation->Instances());
				$this->Set('Timezone', ServiceLocator::GetServer()->GetUserSession()->Timezone);
				$food=0;				
				$userSession2 = ServiceLocator::GetServer()->GetUserSession();			
				$seriesid=getSeriesIdWResIID(regexnums($_POST['reservationId']));
				if(isset($_POST['additionalResources'])){	//if any resource has been defined, this variable will be defined
					$ResourceArrangement=$_POST['ResourceArrangement'];
					$ResourceArrangementAR=$_POST['additionalResources'];
					$ResourceFoodArrangement=$_POST['ResourceFoodArrangement'];
					$ResourceFoodArrangementCountSelect=$_POST['ResourceFoodArrangementCountSelect'];
					//if(count($ResourceArrangementAR)==count($ResourceArrangement)){
					//for($i=0;count($ResourceArrangementAR)>$i;$i=$i+1){	
					foreach($ResourceArrangementAR as $resource){
						if(is_null($ResourceArrangement[$resource]) || is_null($resource) || is_null($_POST['reservationId'])){
							echo "Missing variables, Resource Configuration could not be saved";
						}else{
							setArrangementWResIID(regexnums($ResourceArrangement[$resource]),regexnums($resource),regexnums($_POST['reservationId'])); //viimeisenä, jos muut jumittuvat
						}
						if(countNonWeekends("",$_POST['beginDate'])>4){
							if(isset($_POST['ResourceFoodArrangementCountSelect'])&&isset($_POST['ResourceFoodArrangement'])&&$ResourceFoodArrangement[$resource]!=0){
								$food=1;
								$ResourceFoodArrangementTemp=$ResourceFoodArrangement[$resource];
								$ResourceFoodArrangementCountSelectTemp=$ResourceFoodArrangementCountSelect[$resource];
								updateFoodConfToReservationWithSeriesId(regexnums($ResourceFoodArrangement[$resource]),regexnums($ResourceFoodArrangementCountSelect[$resource]),$FoodHalfFirst,$FoodHalfSecond,regexnums($resource),regexnums($_POST['reservationId']));
							}else{
								//check if there used to be something set
								$resAddon=getPublicStatus($seriesid);
								if(isset($resAddon['foodtarget_id'])){
									mailToCateringDeleted($seriesid,$userSession2->UserId);
									updateFoodConfToReservationWithSeriesId(NULL,0,0,0,regexnums($resource),regexnums($_POST['reservationId']));
								}
							}
						}
						
					}
				}else{
					echo "Missing something.";
				}
				if(isset($_POST['SelectPublicTime'])&&isset($_POST['SelectPublicEndTime'])){
					$PublicTime=$_POST['SelectPublicTime'];
					$PublicEndTime=$_POST['SelectPublicEndTime'];
				}else{
					$PublicTime="00:00:00";
					$PublicEndTime="00:00:00";
				}
				if(isset($_POST['IsPublicEvent'])){
					$publicStatus=1;
				}else{
					$publicStatus=0;
				}
				if(isset($_POST['RoomForOtherPresenter'])){
					$RoomForOtherPresenter=1;
				}else{
					$RoomForOtherPresenter=0;
				}
				if(isset($PublicTime)&&isset($PublicEndTime)&&isset($publicStatus)&&isset($RoomForOtherPresenter)){
					insertEventPublicWResIID($publicStatus,$PublicTime,$PublicEndTime,$RoomForOtherPresenter,regexnums($resource),regexnums($_POST['reservationId']));
				}
				if (isset($userSession2->UserId)){
					if(isset($_POST['compname'])&&isset($_POST['personid'])&&isset($_POST['billingaddress'])&&isset($_POST['reference'])){
						$compname=regexUserInfoText($_POST['compname']);
						$personid=regexUserInfoText($_POST['personid']);
						$billingaddress=regexUserInfoText($_POST['billingaddress']);
						$reference=regexUserInfoText($_POST['reference']);
						$additionalInfo=regexUserInfoText($_POST['additionalinfo']);
						addUserAddonInfo($userSession2->UserId,$compname,$personid,$billingaddress,$reference,$additionalInfo);
						$daycountlist="";
						if($food==1){
							foreach($reservation->Instances() as $tempInstance){
								$dayCountlist[]=$tempInstance->StartDate(); //make an array of the dates
							}
							$restime=explode(" ",$dayCountlist[0]); //get the reservation start time
							$restime=timeFromDatabase($restime[0],$restime[1]);
							$restime=date('H.i', strtotime($restime));
							$foodInfo=getFoodArrangementInfo($ResourceFoodArrangementTemp);
							mailToCatering(2,$foodInfo,$ResourceFoodArrangementCountSelectTemp,$FoodHalfFirst,$FoodHalfSecond,$userSession2->UserId,$dayCountlist,$restime,$seriesid);
						}
					}else{
					}
						
				}
				$this->Display('Ajax/reservation/update_successful.tpl');
			}
			else
			{
				$this->Display('Ajax/reservation/save_failed.tpl');
			}
		} catch (Exception $ex)
		{
			Log::Error('ReservationUpdatePage - Critical error saving reservation: %s', $ex);
			$this->Display('Ajax/reservation/reservation_error.tpl');
		}
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->_reservationSavedSuccessfully = $succeeded;
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	public function SetErrors($errors)
	{
		$this->Set('Errors', $errors);
	}

	public function SetWarnings($warnings)
	{
		// set warnings variable
	}

	public function GetReservationId()
	{
		return $this->GetForm(FormKeys::RESERVATION_ID);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}

	public function GetRemovedAttachmentIds()
	{
		$fileIds = $this->GetForm(FormKeys::REMOVED_FILE_IDS);
		if (is_array($fileIds))
		{
			return array_keys($fileIds);
		}

		return array();
	}
}