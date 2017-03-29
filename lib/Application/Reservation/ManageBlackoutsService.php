<?php
/**
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/BlackoutFilter.php');

interface IManageBlackoutsService
{
    /**
     * @abstract
     * @param $pageNumber int
     * @param $pageSize int
     * @param $sortField string
     * @param $sortDirection string
     * @param $filter BlackoutFilter
     * @param $user UserSession
     * @return PageableData
     */
	public function LoadFiltered($pageNumber, $pageSize, $sortField, $sortDirection, $filter, $user);

	/**
	 * @param DateRange $blackoutDate
	 * @param array|int[] $resourceIds
	 * @param string $title
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @param IRepeatOptions $repeatOptions
	 * @return IBlackoutValidationResult
	 */
	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions);

	/**
	 * @param int $blackoutInstanceId
	 * @param DateRange $blackoutDate
	 * @param array|int[] $resourceIds
	 * @param string $title
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @param IRepeatOptions $repeatOptions
	 * @param SeriesUpdateScope|string $scope
	 * @return IBlackoutValidationResult
	 */
	public function Update($blackoutInstanceId, DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions, $scope);

	/**
	 * @param int $blackoutId
	 * @param string $updateScope
	 */
	public function Delete($blackoutId, $updateScope);

	/**
	 * @param int $blackoutId
	 * @param int $userId
	 * @return BlackoutSeries|null
	 */
	public function LoadBlackout($blackoutId, $userId);
}

class ManageBlackoutsService implements IManageBlackoutsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IBlackoutRepository
	 */
	private $blackoutRepository;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository, IBlackoutRepository $blackoutRepository, IUserRepository $userRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
		$this->blackoutRepository = $blackoutRepository;
		$this->userRepository = $userRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $sortField, $sortDirection, $filter, $user)
	{
		$blackoutFilter = $filter->GetFilter();
		if (!$user->IsAdmin)
		{
			$groups = $this->userRepository->LoadGroups($user->UserId, array(RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN));
			$groupIds = array();
			foreach ($groups as $group)
			{
				$groupIds[] = $group->GroupId;
			}
			$adminFilter = new SqlFilterIn(new SqlFilterColumn('r', ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds);
			$adminFilter->_Or(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupIds));
			$blackoutFilter->_And($adminFilter);
		}

		return $this->reservationViewRepository->GetBlackoutList($pageNumber, $pageSize, $sortField, $sortDirection, $blackoutFilter);
	}

	public function Add(DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions)
	{
		if (!$blackoutDate->GetEnd()->GreaterThan($blackoutDate->GetBegin()))
		{
			return new BlackoutDateTimeValidationResult();
		}

		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

		$blackoutSeries = BlackoutSeries::Create($userId, $title, $blackoutDate);
		$blackoutSeries->Repeats($repeatOptions);

		foreach ($resourceIds as $resourceId)
		{
			$blackoutSeries->AddResourceId($resourceId);
		}

		$conflictingBlackouts = $this->GetConflictingBlackouts($blackoutSeries);

		$conflictingReservations = array();
		if (empty($conflictingBlackouts))
		{
			$conflictingReservations = $this->GetConflictingReservations($blackoutSeries, $reservationConflictResolution);
		}

		$blackoutValidationResult = new BlackoutValidationResult($conflictingBlackouts, $conflictingReservations);

		if ($blackoutValidationResult->CanBeSaved())
		{
			$this->blackoutRepository->Add($blackoutSeries);
		}

		return $blackoutValidationResult;
	}

	/**
	 * @param BlackoutSeries $blackoutSeries
	 * @param IReservationConflictResolution $reservationConflictResolution
	 * @return array|ReservationItemView[]
	 */
	private function GetConflictingReservations($blackoutSeries, $reservationConflictResolution)
	{
		$conflictingReservations = array();

		while ($blackout = $blackoutSeries->NextBlackout())
		{
			$existingReservations = $this->reservationViewRepository->GetReservations($blackout->StartDate(), $blackout->EndDate());

			foreach ($existingReservations as $existingReservation)
			{
				if ($blackoutSeries->ContainsResource($existingReservation->ResourceId) && $blackout->Date()->Overlaps($existingReservation->Date))
				{
					if (!$reservationConflictResolution->Handle($existingReservation, $blackout))
					{
						$conflictingReservations[] = $existingReservation;
					}
				}
			}
		}

		return $conflictingReservations;
	}

	/**
	 * @param BlackoutSeries $blackoutSeries
	 * @return array|BlackoutItemView[]
	 */
	private function GetConflictingBlackouts($blackoutSeries)
	{
		$conflictingBlackouts = array();

		$blackouts = $blackoutSeries->AllBlackouts();
		foreach ($blackouts as $blackout)
		{
			$existingBlackouts = $this->reservationViewRepository->GetBlackoutsWithin($blackout->Date());

			foreach ($existingBlackouts as $existingBlackout)
			{
				if ($existingBlackout->SeriesId == $blackoutSeries->Id())
				{
					continue;
				}

				if ($blackoutSeries->ContainsResource($existingBlackout->ResourceId) && $blackout->Date()->Overlaps($existingBlackout->Date))
				{

					$conflictingBlackouts[] = $existingBlackout;
				}
			}
		}

		return $conflictingBlackouts;
	}

	public function Delete($blackoutId, $updateScope)
	{
		if ($updateScope == SeriesUpdateScope::FullSeries)
		{
			$this->blackoutRepository->DeleteSeries($blackoutId);
		}
		else
		{
			$this->blackoutRepository->Delete($blackoutId);
		}
	}

	public function LoadBlackout($blackoutId, $userId)
	{
		$series = $this->blackoutRepository->LoadByBlackoutId($blackoutId);
		$user = $this->userRepository->LoadById($userId);

		foreach ($series->Resources() as $resource)
		{
			if (!$user->IsResourceAdminFor($resource))
			{
				return null;
			}
		}

		return $series;
	}

	public function Update($blackoutInstanceId, DateRange $blackoutDate, $resourceIds, $title, IReservationConflictResolution $reservationConflictResolution, IRepeatOptions $repeatOptions, $scope)
	{
		if (!$blackoutDate->GetEnd()->GreaterThan($blackoutDate->GetBegin()))
		{
			return new BlackoutDateTimeValidationResult();
		}

		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

		$blackoutSeries = $this->LoadBlackout($blackoutInstanceId, $userId);

		if ($blackoutSeries == null)
		{
			return new BlackoutSecurityValidationResult();
		}

		$blackoutSeries->Update($userId, $scope, $title, $blackoutDate, $repeatOptions, $resourceIds);

		$conflictingBlackouts = $this->GetConflictingBlackouts($blackoutSeries);

		$conflictingReservations = array();
		if (empty($conflictingBlackouts))
		{
			$conflictingReservations = $this->GetConflictingReservations($blackoutSeries, $reservationConflictResolution);
		}

		$blackoutValidationResult = new BlackoutValidationResult($conflictingBlackouts, $conflictingReservations);

		if ($blackoutValidationResult->CanBeSaved())
		{
			$this->blackoutRepository->Update($blackoutSeries);
		}

		return $blackoutValidationResult;
	}
}