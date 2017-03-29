<?php
/**
Copyright 2012-2016 Nick Korbel

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

class ReservationFilter
{
	/**
	 * @var Date|null
	 */
	private $startDate = null;

	/**
	 * @var Date|null
	 */
	private $endDate = null;

	/**
	 * @var null|string
	 */
	private $referenceNumber = null;

	/**
	 * @var int|null
	 */
	private $scheduleId = null;

	/**
	 * @var int|null
	 */
	private $resourceId = null;

	/**
	 * @var int|null
	 */
	private $userId = null;

	/**
	 * @var int|null
	 */
	private $statusId = null;

	/**
	 * @var int|null
	 */
	private $resourceStatusId = null;

	/**
	 * @var int|null
	 */
	private $resourceStatusReasonId = null;

	/**
	 * @var Attribute[]|null
	 */
	private $attributes = null;

	/**
	 * @var array|ISqlFilter[]
	 */
	private $_and = array();

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @param int $statusId
	 * @param int $resourceStatusId
	 * @param int $resourceStatusReasonId
	 * @param Attribute[] $attributes
	 */
	public function __construct($startDate = null,
								$endDate = null,
								$referenceNumber = null,
								$scheduleId = null,
								$resourceId = null,
								$userId = null,
								$statusId = null,
								$resourceStatusId = null,
								$resourceStatusReasonId = null,
								$attributes = null)
	{
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->referenceNumber = $referenceNumber;
		$this->scheduleId = $scheduleId;
		$this->resourceId = $resourceId;
		$this->userId = $userId;
		$this->statusId = $statusId;
		$this->resourceStatusId = $resourceStatusId;
		$this->resourceStatusReasonId = $resourceStatusReasonId;
		$this->attributes = $attributes;
	}

	/**
	 * @param ISqlFilter $filter
	 * @return ReservationFilter
	 */
	public function _And(ISqlFilter $filter)
	{
		$this->_and[] = $filter;
		return $this;
	}

	public function GetFilter()
	{
		$filter = new SqlFilterNull();
		$surroundFilter = null;
		$startFilter = null;
		$endFilter = null;

		if (!empty($this->startDate) && !empty($this->endDate)) {
			$surroundFilter = new SqlFilterLessThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_START, 1), $this->startDate->ToDatabase(), true);
			$surroundFilter->_And(new SqlFilterGreaterThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_END, 1), $this->endDate->AddDays(1)->ToDatabase(), true));
		}
		if (!empty($this->startDate)) {
			$startFilter = new SqlFilterGreaterThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_START, 2), $this->startDate->ToDatabase(), true);
			$endFilter = new SqlFilterGreaterThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_END, 2), $this->startDate->ToDatabase(), true);
		}
		if (!empty($this->endDate)) {
			if ($startFilter == null)
			{
				$startFilter = new SqlFilterLessThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_START, 3), $this->endDate->AddDays(1)->ToDatabase(), true);
			}
			else
			{
				$startFilter->_And(new SqlFilterLessThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_START, 4), $this->endDate->AddDays(1)->ToDatabase(), true));
			}
			if ($endFilter == null)
			{
				$endFilter = new SqlFilterLessThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_END, 3), $this->endDate->AddDays(1)->ToDatabase(), true);
			}
			else
			{
				$endFilter->_And(new SqlFilterLessThan(new SqlRepeatingFilterColumn(null, ColumnNames::RESERVATION_END, 4), $this->endDate->AddDays(1)->ToDatabase(), true));
			}
		}
		if (!empty($this->referenceNumber)) {
			$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $this->referenceNumber));
		}
		if (!empty($this->scheduleId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::SCHEDULE_ID), $this->scheduleId));
		}
		if (!empty($this->resourceId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ID), $this->resourceId));
		}
		if (!empty($this->userId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::USERS, ColumnNames::USER_ID), $this->userId));
		}
		if (!empty($this->statusId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESERVATION_SERIES_ALIAS, ColumnNames::RESERVATION_STATUS), $this->statusId));
		}
		if (!empty($this->resourceStatusId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_STATUS_ID), $this->resourceStatusId));
		}
		if (!empty($this->resourceStatusReasonId)) {
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_STATUS_REASON_ID), $this->resourceStatusReasonId));
		}
		if (!empty($this->attributes))
		{
			$attributeFilter = AttributeFilter::Create(TableNames::RESERVATION_SERIES_ALIAS . '.' . ColumnNames::SERIES_ID, $this->attributes);

			if ($attributeFilter != null)
			{
				$filter->_And($attributeFilter);
			}
		}

		if ($surroundFilter != null || $startFilter != null || $endFilter != null)
		{
			$dateFilter = new SqlFilterNull(true);
			$dateFilter->_Or($surroundFilter)->_Or($startFilter)->_Or($endFilter);
			$filter->_And($dateFilter);
		}

		foreach ($this->_and as $and)
		{
			$filter->_And($and);
		}

		return $filter;
	}
}