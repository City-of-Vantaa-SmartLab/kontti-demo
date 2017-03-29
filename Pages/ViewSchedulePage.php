<?php
/**
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/GuestPermissionServiceFactory.php');

class ViewSchedulePage extends SchedulePage
{

	private $_styles = array(
				ScheduleStyle::Wide => 'Schedule/schedule-days-horizontal.tpl',
				ScheduleStyle::Tall => 'Schedule/schedule-flipped.tpl',
				ScheduleStyle::CondensedWeek => 'Schedule/schedule-week-condensed.tpl',
		);

	public function __construct()
	{
		parent::__construct();
		$scheduleRepository = new ScheduleRepository();
		$userRepository = new UserRepository();
		$resourceService = new ResourceService(
				new ResourceRepository(),
				new GuestPermissionService(),
				new AttributeService(new AttributeRepository()),
				$userRepository,
				new AccessoryRepository());
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();

		$this->_presenter = new SchedulePresenter(
			$this,
			new ScheduleService($scheduleRepository, $resourceService, $dailyLayoutFactory),
			$resourceService,
			$pageBuilder,
			$reservationService);
	}

	public function ProcessPageLoad()
	{
		$user = new NullUserSession();
		$this->_presenter->PageLoad($user);

		$viewReservations = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter());
		$allowGuestBookings = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING,  new BooleanConverter());

		$this->Set('DisplaySlotFactory', new DisplaySlotFactory());
		$this->Set('SlotLabelFactory', $viewReservations || $allowGuestBookings ? new SlotLabelFactory($user) : new NullSlotLabelFactory());
		$this->Set('AllowGuestBooking', $allowGuestBookings);
		$this->Set('CreateReservationPage', Pages::GUEST_RESERVATION);

		$this->Set('ExtendViewPrefix', 'view-');
		if ($this->IsMobile && !$this->IsTablet)
		{
			if ($this->ScheduleStyle == ScheduleStyle::Tall)
			{
				$this->Display('Schedule/schedule-flipped.tpl');
			}
			else
			{
				$this->Display('Schedule/schedule-mobile.tpl');
			}
		}
		else
		{
			if (array_key_exists($this->ScheduleStyle, $this->_styles))
			{
				$this->Display($this->_styles[$this->ScheduleStyle]);
			}
			else
			{
				$this->Display('Schedule/view-schedule.tpl');
			}
		}
	}

    public function ShowInaccessibleResources()
    {
        return true;
    }

	protected function GetShouldAutoLogout()
	{
		return false;
	}

	public function GetDisplayTimezone(UserSession $user, Schedule $schedule)
	{
		$user->Timezone = $schedule->GetTimezone();
		return $schedule->GetTimezone();
	}
}