<?php
/**
 * Copyright 2012-2016 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarExportDisplay.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/mod/namespace.php');

abstract class ReservationEmailMessage extends EmailMessage
{
	/**
	 * @var User
	 */
	protected $reservationOwner;

	/**
	 * @var ReservationSeries
	 */
	protected $reservationSeries;

	/**
	 * @var IResource
	 */
	protected $primaryResource;

	/**
	 * @var string
	 */
	protected $timezone;

	/**
	 * @var IAttributeRepository
	 */
	protected $attributeRepository;

	public function __construct(User $reservationOwner, ReservationSeries $reservationSeries, $language = null, IAttributeRepository $attributeRepository)
	{
		if (empty($language))
		{
			$language = $reservationOwner->Language();
		}
		parent::__construct($language);

		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $reservationOwner->Timezone();
		$this->attributeRepository = $attributeRepository;
		$this->primaryResource = $reservationSeries->Resource();
	}

	/**
	 * @abstract
	 * @return string
	 */
	protected abstract function GetTemplateName();

	public function To()
	{
		$address = $this->reservationOwner->EmailAddress();
		$name = $this->reservationOwner->FullName();

		return array(new EmailAddress($address, $name));
	}

	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate($this->GetTemplateName());
	}

	public function From()
	{
		$bookedBy = $this->reservationSeries->BookedBy();
		if ($bookedBy != null)
		{
			$name = new FullName($bookedBy->FirstName, $bookedBy->LastName);
			return new EmailAddress($bookedBy->Email, $name->__toString());
		}
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

	protected function PopulateTemplate()
	{
		$weekendextra = 0; //delivery cost for weekends
		$currentInstance = $this->reservationSeries->CurrentInstance();
		$databaseTimeConv=$currentInstance->StartDate();
		$databaseTimeConvTemp=explode(" ",$currentInstance->StartDate());
		if(strcmp($databaseTimeConvTemp[2],"Europe/Helsinki")==0){
			$databaseTimeConvTemp=convertTimeTo($databaseTimeConvTemp[0],$databaseTimeConvTemp[1]);
			$databaseTimeConv=$databaseTimeConvTemp;
		}
		//Getting resource conf info, with series_id
		$tempdata=getAllTemp($this->reservationSeries->Resource()->GetId(),$databaseTimeConv);
		$this->Set('Tempdata', $tempdata);
		$resourceFoodConfInfo=getFoodArrangementInfo($tempdata['ResourceFoodConf']);
		$resourceConfInfo=getArrangementInfo($tempdata['ResourceConf']);
		$this->Set('Conf', $resourceConfInfo);
		$this->Set('FoodConf', $resourceFoodConfInfo);
		$FoodConfList = explode("\n",$resourceFoodConfInfo['contentlist']);
		$this->Set('FoodConfList',$FoodConfList);
		$alv=round($resourceFoodConfInfo['price']*$tempdata['ResourceFoodCount']*0.14, 2);
		$this->Set('Alv',$alv);
		
		$foodListArray=explode("\n",$resourceFoodConfInfo['contentlist']);
		$foodListString="<ul>";
		foreach($foodListArray as $content){
			$done=0;
			$content = preg_replace( "/\r|\n/", "", $content );//removing any possible newline \n
			if(strcmp($content,"tai")!=0){
				$foodListString=$foodListString."<li>".$content;
				$foodInnerPrevious="";
				foreach($foodListArray as $nextcontent){
					$nextcontent = preg_replace( "/\r|\n/", "", $nextcontent);//removing any possible newline \n
					if(strcmp($nextcontent,"tai")==0&&strcmp($content,$foodInnerPrevious)==0){
						$foodListString=$foodListString." x".$tempdata['FoodSplitFirst']."kpl";
						$done=1;
					}
					$foodInnerPrevious=$nextcontent;
				}
				if(strcmp($foodOuterPrevious,"tai")==0&&$done==0){
						$foodListString=$foodListString." x".$tempdata['FoodSplitSecond']."kpl";
						$done=1;
				}
				if($done==0){
						$foodListString=$foodListString." x".$tempdata['ResourceFoodCount']."kpl";
				}
				$foodListString=$foodListString."</li>";
			}
			$foodOuterPrevious=$content;
		}
		$foodListString=$foodListString."</ul>";
		
		
		$this->Set('FoodListString', $foodListString);
		$this->Set('UserName', $this->reservationOwner->FullName());
		$this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
		$this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
		$this->Set('ResourceName', $this->reservationSeries->Resource()->GetName());
		$img = $this->reservationSeries->Resource()->GetImage();
		if (!empty($img))
		{
			$this->Set('ResourceImage', $this->GetFullImagePath($img));
		}
		$this->Set('Title', $this->reservationSeries->Title());
		$this->Set('Description', $this->reservationSeries->Description());

		$repeatDates = array();
		if ($this->reservationSeries->IsRecurring())
		{
			foreach ($this->reservationSeries->Instances() as $repeated)
			{
				$weekDay = date('w', strtotime($repeated->StartDate()->ToTimezone($this->timezone)));
				if($weekDay == 0 || $weekDay == 6){
					if($tempdata['ResourceFoodConf']!=NULL){
						$weekendextra = $weekendextra+10;
					}
				}
				$repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
			}
		}else{
			$weekDay = date('w', strtotime($currentInstance->StartDate()->ToTimezone($this->timezone)));
			if($weekDay == 0 || $weekDay == 6){
				if($tempdata['ResourceFoodConf']!=NULL){
					$weekendextra = $weekendextra+10;
				}
			}
		}
		$this->Set('WeekendExtra', $weekendextra);
		$this->Set('FoodTotal', $resourceFoodConfInfo['price']*$tempdata['ResourceFoodCount']+$alv);
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
		$icalUrl = sprintf("export/%s?%s=%s", Pages::CALENDAR_EXPORT, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber());
		$this->Set('ICalUrl', $icalUrl);

		$resourceNames = array();
		foreach ($this->reservationSeries->AllResources() as $resource)
		{
			$resourceNames[] = $resource->GetName();
		}
		$this->Set('ResourceNames', $resourceNames);
		$this->Set('Accessories', $this->reservationSeries->Accessories());

		$attributes = $this->attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
		$attributeValues = array();
		foreach ($attributes as $attribute)
		{
			$attributeValues[] = new Attribute($attribute, $this->reservationSeries->GetAttributeValue($attribute->Id()));
		}

		$this->Set('Attributes', $attributeValues);

		$bookedBy = $this->reservationSeries->BookedBy();
		if ($bookedBy != null && ($bookedBy->UserId != $this->reservationOwner->Id()))
		{
			$this->Set('CreatedBy', new FullName($bookedBy->FirstName, $bookedBy->LastName));
		}

		$minimumAutoRelease = null;
		foreach ($this->reservationSeries->AllResources() as $resource)
		{
			if ($resource->IsCheckInEnabled())
			{
				$this->Set('CheckInEnabled', true);
			}

			if ($resource->IsAutoReleased())
			{
				if ($minimumAutoRelease == null || $resource->GetAutoReleaseMinutes() < $minimumAutoRelease)
				{
					$minimumAutoRelease = $resource->GetAutoReleaseMinutes();
				}
			}
		}

        $this->PopulateIcsAttachment($currentInstance, $attributeValues);

		$this->Set('AutoReleaseMinutes', $minimumAutoRelease);
		$this->Set('ReferenceNumber', $this->reservationSeries->CurrentInstance()->ReferenceNumber());
	}

	private function GetFullImagePath($img)
	{
		return Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL) . '/' . $img;
	}

    /**
     * @param Reservation $currentInstance
     * @param Attribute[] $attributeValues
     */
    protected function PopulateIcsAttachment($currentInstance, $attributeValues)
    {
        $rv = new ReservationItemView($currentInstance->ReferenceNumber(),
            $currentInstance->StartDate()->ToUTC(),
            $currentInstance->EndDate()->ToUTC(),
            $this->reservationSeries->Resource()->GetName(),
            $this->reservationSeries->Resource()->GetResourceId(),
            $currentInstance->ReservationId(),
            null,
            $this->reservationSeries->Title(),
            $this->reservationSeries->Description(),
            $this->reservationSeries->ScheduleId(),
            $this->reservationOwner->FirstName(),
            $this->reservationOwner->LastName(),
            $this->reservationOwner->Id(),
            $this->reservationOwner->GetAttribute(UserAttribute::Phone),
            $this->reservationOwner->GetAttribute(UserAttribute::Organization),
            $this->reservationOwner->GetAttribute(UserAttribute::Position)
        );

        $ca = new CustomAttributes();
        /** @var Attribute $attribute */
        foreach ($attributeValues as $attribute) {
            $ca->Add($attribute->Id(), $attribute->Value());
        }
        $rv->Attributes = $ca;
        $rv->UserPreferences = $this->reservationOwner->GetPreferences();
		$rv->OwnerEmailAddress = $this->reservationOwner->EmailAddress();

        $icsView = new iCalendarReservationView($rv, $this->reservationSeries->BookedBy(), new NullPrivacyFilter());

        $display = new CalendarExportDisplay();
        $icsContents = $display->Render(array($icsView));
        $this->AddStringAttachment($icsContents, 'reservation.ics');
    }
}