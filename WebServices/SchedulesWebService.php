<?php
/**
 * Copyright 2012-2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/SchedulesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ScheduleResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Schedule/ScheduleSlotsResponse.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Pages/SchedulePage.php');

class SchedulesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	public function __construct(IRestServer $server, IScheduleRepository $scheduleRepository, IPrivacyFilter $privacyFilter)
	{
		$this->server = $server;
		$this->scheduleRepository = $scheduleRepository;
		$this->privacyFilter = $privacyFilter;
	}

	/**
	 * @name GetAllSchedules
	 * @description Loads all schedules
	 * @response SchedulesResponse
	 * @return void
	 */
	public function GetSchedules()
	{
		$schedules = $this->scheduleRepository->GetAll();

		$this->server->WriteResponse(new SchedulesResponse($this->server, $schedules));
	}

	/**
	 * @name GetSchedule
	 * @description Loads a specific schedule by id
	 * @response ScheduleResponse
	 * @param $scheduleId
	 * @return void
	 */
	public function GetSchedule($scheduleId)
	{
		$schedule = $this->scheduleRepository->LoadById($scheduleId);

		if ($schedule != null)
		{
			$layout = $this->scheduleRepository->GetLayout($schedule->GetId(), new ScheduleLayoutFactory($this->server->GetSession()->Timezone));
			$this->server->WriteResponse(new ScheduleResponse($this->server, $schedule, $layout));
		}
		else
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
	}

	/**
	 * @name GetSlots
	 * @description Loads slots for a specific schedule
	 * Optional query string parameters:  resourceId, startDateTime, endDateTime.
	 * If no dates are provided the default schedule dates will be returned.
	 * If dates do not include the timezone offset, the timezone of the authenticated user will be assumed.
	 * @response ScheduleSlotsResponse
	 * @param $scheduleId
	 * @return void
	 */
	public function GetSlots($scheduleId)
	{
		$startDate = $this->GetDate(WebServiceQueryStringKeys::START_DATE_TIME);
		$endDate = $this->GetDate(WebServiceQueryStringKeys::END_DATE_TIME);


        $resourceId = $this->server->GetQueryString(WebServiceQueryStringKeys::RESOURCE_ID);

		$scheduleWebServiceView = new ScheduleWebServiceView($scheduleId, $startDate, $resourceId);
		$permissionServiceFactory = new PermissionServiceFactory();
		$scheduleRepository = new ScheduleRepository();
		$userRepository = new UserRepository();
		$resourceService = new ResourceService(new ResourceRepository(), $permissionServiceFactory->GetPermissionService(), new AttributeService(new AttributeRepository()), $userRepository);
		$builder = new ScheduleWebServicePageBuilder($startDate, $endDate, $resourceId);
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();
		$scheduleService = new ScheduleService($scheduleRepository, $resourceService);
		$presenter = new SchedulePresenter($scheduleWebServiceView, $scheduleService, $resourceService, $builder, $reservationService, $dailyLayoutFactory);

		$presenter->PageLoad($this->server->GetSession());

		$layout = $scheduleWebServiceView->GetDailyLayout();
		$isError = $scheduleWebServiceView->IsPermissionError();
		$dates = $scheduleWebServiceView->GetDates();
		$resources = $scheduleWebServiceView->GetResources();

		if ($isError)
		{
			$this->server->WriteResponse(RestResponse::Unauthorized(), RestResponse::UNAUTHORIZED_CODE);
		}
		else
		{
			$response = new ScheduleSlotsResponse($this->server, $scheduleId, $layout, $dates, $resources, $this->privacyFilter);
			$this->server->WriteResponse($response);
		}
	}

	private function GetDate($queryStringKey)
	{
		$dateQueryString = $this->server->GetQueryString($queryStringKey);
		if (empty($dateQueryString))
		{
			return null;
		}

		return WebServiceDate::GetDate($dateQueryString, $this->server->GetSession());
	}
}


class ScheduleWebServicePageBuilder extends SchedulePageBuilder
{
    private $startDate;
    private $endDate;
    private $resourceId;

    public function __construct($startDate, $endDate, $resourceId)
	{
		$this->startDate = is_null($startDate) ? null : $startDate;
		$this->endDate = is_null($endDate) ? null : $endDate;
		$this->resourceId = empty($resourceId) ? null : $resourceId;
	}

	public function BindResourceGroups(ISchedulePage $page, ResourceGroupTree $resourceGroupTree)
	{
		// no op
	}

	public function BindResourceTypes(ISchedulePage $page, $resourceTypes)
	{
		// no op
	}

	public function GetGroupId($scheduleId, ISchedulePage $page)
	{
		// no op
	}

    public function GetResourceIds($scheduleId, ISchedulePage $page)
	{
		return array($this->resourceId);
	}

	public function BindResourceFilter(ISchedulePage $page, ScheduleResourceFilter $filter, $resourceCustomAttributes, $resourceTypeCustomAttributes)
	{
		// no op
	}

	public function GetScheduleDates(UserSession $user, ISchedule $schedule, ISchedulePage $page)
	{
		if ($this->startDate != null && $this->endDate != null)
		{
			return new DateRange($this->startDate, $this->endDate->AddDays(1));
		}
		return parent::GetScheduleDates($user, $schedule, $page);
	}
}

class ScheduleWebServiceView implements ISchedulePage
{
	/**
	 * @var int
	 */
	private $scheduleId;

	/**
	 * @var IDailyLayout
	 */
	private $dailyLayout;

	/**
	 * @var bool
	 */
	private $isPermissionError;

	/**
	 * @var DateRange
	 */
	private $dates;

	/**
	 * @var ResourceDto[]
	 */
	private $resources;


    private $resourceId;

    private $startDate;

    public function __construct($scheduleId, $startDate, $resourceId)
	{
		$this->scheduleId = $scheduleId;
		$this->startDate = $startDate;
        $this->resourceId = $resourceId;
	}

	public function SetSchedules($schedules)
	{
		// no op
	}

	public function SetResources($resources)
	{
		$this->resources = $resources;
	}

	public function SetDailyLayout($dailyLayout)
	{
		$this->dailyLayout = $dailyLayout;
	}

	public function GetScheduleId()
	{
		return $this->scheduleId;
	}

	public function SetScheduleId($scheduleId)
	{
		// no op
	}

	public function SetScheduleName($scheduleName)
	{
		// no op
	}

	public function SetFirstWeekday($firstWeekday)
	{
		// no op
	}

	public function SetDisplayDates($dates)
	{
		$this->dates = $dates;
	}

	public function SetSpecificDates($specificDates)
	{
		// no op
	}

	public function SetPreviousNextDates($previousDate, $nextDate)
	{
		// TODO: Implement SetPreviousNextDates() method.
	}

	public function GetSelectedDate()
	{
		return empty($this->startDate) ? null : $this->startDate->Format("Y-m-d");
	}

	public function GetSelectedDates()
	{
		return array();
	}

	public function ShowInaccessibleResources()
	{
		return false;
	}

	public function ShowFullWeekToggle($showShowFullWeekToggle)
	{
		// no op
	}

	public function GetShowFullWeek()
	{
		return false;
	}

	public function SetLayoutResponse($layoutResponse)
	{
		// no op
	}

	/**
	 * @return string
	 */
	public function GetLayoutDate()
	{
		// TODO: Implement GetLayoutDate() method.
	}

	public function GetScheduleStyle($scheduleId)
	{
		return ScheduleStyle::Standard;
	}

	public function SetScheduleStyle($direction)
	{
		// no op
	}

	public function GetGroupId()
	{
		return null;
	}

	public function GetResourceId()
	{
		return null;
	}

	/**
	 * @return int[]
	 */
	public function GetResourceIds()
	{
		return array($this->resourceId);
	}

	public function SetResourceGroupTree(ResourceGroupTree $resourceGroupTree)
	{
		// no op
	}

	public function SetResourceTypes($resourceTypes)
	{
		// no op
	}

	public function SetResourceCustomAttributes($attributes)
	{
		// no op
	}

	public function SetResourceTypeCustomAttributes($attributes)
	{
		// no op
	}

	public function FilterSubmitted()
	{
		return !empty($this->scheduleId) || !empty($this->resourceId);
	}

	public function GetResourceTypeId()
	{
		return null;
	}

	public function GetMaxParticipants()
	{
		return null;
	}

	public function GetResourceAttributes()
	{
		return array();
	}

	public function GetResourceTypeAttributes()
	{
		return array();
	}

	public function SetFilter($resourceFilter)
	{
		// no op
	}

	public function SetSubscriptionUrl(CalendarSubscriptionUrl $subscriptionUrl)
	{
		// no op
	}

	public function ShowPermissionError($shouldShow)
	{
		$this->isPermissionError = $shouldShow;
	}

	public function GetDisplayTimezone(UserSession $user, Schedule $schedule)
	{
		return $user->Timezone;
	}

	public function TakingAction()
	{
		return false;
	}

	public function GetAction()
	{
		return null;
	}

	public function RequestingData()
	{
		return false;
	}

	public function GetDataRequest()
	{
		return null;
	}

	public function PageLoad()
	{
		// no op
	}

	public function Redirect($url)
	{
		// no op
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		// no op
	}

	public function IsPostBack()
	{
		return false;
	}

	public function IsValid()
	{
		return true;
	}

	public function GetLastPage()
	{
		return null;
	}

	public function RegisterValidator($validatorId, $validator)
	{
		// no op
	}

	/**
	 * @return IDailyLayout
	 */
	public function GetDailyLayout()
	{
		return $this->dailyLayout;
	}

	/**
	 * @return boolean
	 */
	public function IsPermissionError()
	{
		return $this->isPermissionError;
	}

	/**
	 * @return DateRange
	 */
	public function GetDates()
	{
		return $this->dates;
	}

	/**
	 * @return ResourceDto[]
	 */
	public function GetResources()
	{
		return $this->resources;
	}

	public function EnforceCSRFCheck()
	{
		// no-op
	}


    public function GetSortField()
    {
        return null;
    }

    public function GetSortDirection()
    {
        return null;
    }
}