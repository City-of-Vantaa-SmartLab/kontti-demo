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
			$this->EnforceCSRFCheck();
			$reservation = $this->_presenter->BuildReservation();
			$this->_presenter->HandleReservation($reservation);

			if ($this->_reservationSavedSuccessfully)
			{
				$this->Set('Resources', $reservation->AllResources());
				$this->Set('Instances', $reservation->Instances());
				$this->Set('Timezone', ServiceLocator::GetServer()->GetUserSession()->Timezone);
				if(isset($_POST['additionalResources'])){	//if multiple resources have been defined, this variable will be defined
					$ResourceArrangement=$_POST['ResourceArrangement'];
					$ResourceArrangementAR=$_POST['additionalResources'];
					//if(count($ResourceArrangementAR)==count($ResourceArrangement)){
					//for($i=0;count($ResourceArrangementAR)>$i;$i=$i+1){	
					foreach($ResourceArrangementAR as $resource){
						if(is_null($ResourceArrangement[$resource]) || is_null($resource) || is_null($_POST['reservationId'])){
							echo "Missing variables, Resource Configuration could not be saved";
						}else{
							setArrangementWResIID(regexnums($ResourceArrangement[$resource]),regexnums($resource),regexnums($_POST['reservationId'])); //viimeisenä, jos muut jumittuvat
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