<?php

/**
 * Copyright 2011-2016 Nick Korbel
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
class DateRange
{
	/**
	 * @var Date
	 */
	private $_begin;

	/**
	 * @var Date
	 */
	private $_end;

	/**
	 * @var string
	 */
	private $_timezone;

	/**
	 * @var int
	 */
	private $weekdays = 0;

	/**
	 * @var int
	 */
	private $weekends = 0;

	/**
	 * @param Date $begin
	 * @param Date $end
	 * @param string $timezone
	 */
	public function __construct(Date $begin, Date $end, $timezone = null)
	{
		$this->_begin = $begin;
		$this->_end = $end;

		if (empty($timezone))
		{
			$this->_timezone = $begin->Timezone();
		}
		else
		{
			$this->_timezone = $timezone;
		}

		$this->weekdays = 0;
		$this->weekends = 0;
	}

	/**
	 * @param string $beginString
	 * @param string $endString
	 * @param string $timezoneString
	 * @return DateRange
	 */
	public static function Create($beginString, $endString, $timezoneString)
	{
		return new DateRange(Date::Parse($beginString, $timezoneString), Date::Parse($endString, $timezoneString), $timezoneString);
	}

	/**
	 * Whether or not the $date is within the range.  Range boundaries are inclusive
	 * @param Date $date
	 * @param bool $inclusive
	 * @return bool
	 */
	public function Contains(Date $date, $inclusive = true)
	{
		if ($inclusive)
		{
			return $this->_begin->Compare($date) <= 0 && $this->_end->Compare($date) >= 0;
		}
		else
		{
			return $this->_begin->Compare($date) <= 0 && $this->_end->Compare($date) > 0;
		}
	}

	/**
	 * @param DateRange $dateRange
	 * @return bool
	 */
	public function ContainsRange(DateRange $dateRange)
	{
		return $this->_begin->Compare($dateRange->_begin) <= 0 && $this->_end->Compare($dateRange->_end) >= 0;
	}

	/**
	 * Whether or not the date ranges overlap.  Dates that start or end on boundaries are excluded
	 * @param DateRange $dateRange
	 * @return bool
	 */
	public function Overlaps(DateRange $dateRange)
	{
		return ($this->Contains($dateRange->GetBegin()) || $this->Contains($dateRange->GetEnd()) ||
				$dateRange->Contains($this->GetBegin()) || $dateRange->Contains($this->GetEnd())) &&
		(!$this->GetBegin()->Equals($dateRange->GetEnd()) && !$this->GetEnd()->Equals($dateRange->GetBegin()));

	}

	/**
	 * Whether or not any date within this range occurs on the provided date
	 * @param Date $date
	 * @return bool
	 */
	public function OccursOn(Date $date)
	{
		$timezone = $date->Timezone();
		$compare = $this;

		if ($timezone != $this->_timezone)
		{
			$compare = $this->ToTimezone($timezone);
		}

		$beginMidnight = $compare->GetBegin();

		if ($this->GetEnd()->IsMidnight())
		{
			$endMidnight = $compare->GetEnd();
		}
		else
		{
			$endMidnight = $compare->GetEnd()->AddDays(1);
		}

		return ($beginMidnight->DateCompare($date) <= 0 &&
				$endMidnight->DateCompare($date) > 0);
	}

	/**
	 * @return Date
	 */
	public function GetBegin()
	{
		return $this->_begin;
	}

	/**
	 * @return Date
	 */
	public function GetEnd()
	{
		return $this->_end;
	}

	/**
	 * @return Date[]
	 */
	public function Dates()
	{
		$current = $this->_begin->GetDate();

		if ($this->_end->IsMidnight())
		{
			$end = $this->_end->AddDays(-1)->GetDate();
		}
		else
		{
			$end = $this->_end->GetDate();
		}

		$dates = array($current);

		for ($day = 0; $current->Compare($end) < 0; $day++)
		{
			$current = $current->AddDays(1);
			$dates[] = $current;
		}

		return $dates;
	}

	/**
	 * Get all date times within the range. The first date will include the start time. The last date will include the end time. All other days will be at midnight
	 * @return Date[]
	 */
	public function DateTimes()
	{
		$dates = array($this->_begin);

		$current = $this->_begin->AddDays(1);

		while ($current->LessThan($this->_end))
		{
			$dates[] = $current->GetDate();
			$current = $current->AddDays(1);
		}

		$dates[] = $this->_end;
		return $dates;
	}

	/**
	 * @param DateRange $otherRange
	 * @return bool
	 */
	public function Equals(DateRange $otherRange)
	{
		return $this->_begin->Equals($otherRange->GetBegin()) && $this->_end->Equals($otherRange->GetEnd());
	}

	/**
	 * @param string $timezone
	 * @return DateRange
	 */
	public function ToTimezone($timezone)
	{
		return new DateRange($this->_begin->ToTimezone($timezone), $this->_end->ToTimezone($timezone));
	}

	/**
	 * @return DateRange
	 */
	public function ToUtc()
	{
		return new DateRange($this->_begin->ToUtc(), $this->_end->ToUtc());
	}

	/**
	 * @param int $days
	 * @return DateRange
	 */
	public function AddDays($days)
	{
		return new DateRange($this->_begin->AddDays($days), $this->_end->AddDays($days));
	}

	/**
	 * @return string
	 */
	public function ToString()
	{
		return "\nBegin: " . $this->_begin->ToString() . " End: " . $this->_end->ToString() . "\n";
	}

	public function __toString()
	{
		return $this->ToString();
	}

	/**
	 * @return int
	 */
	public function NumberOfWeekdays()
	{
		$this->CountDays();

		return $this->weekdays;
	}

	/**
	 * @return int
	 */
	public function NumberOfWeekendDays()
	{
		$this->CountDays();

		return $this->weekends;
	}

	private function CountDays()
	{
		if ($this->weekends == 0 && $this->weekdays == 0)
		{
			// only count if it's not cached
			$dates = $this->Dates();

			if (count($dates) == 0)
			{
				// just one day in range
				if ($this->_begin->Weekday() == 0 || $this->_begin->Weekday() == 6)
				{
					$this->weekends = 1;
				}
				else
				{
					$this->weekdays = 1;
				}
			}

			foreach ($dates as $date)
			{
				if ($date->Weekday() == 0 || $date->Weekday() == 6)
				{
					$this->weekends++;
				}
				else
				{
					$this->weekdays++;
				}
			}
		}
	}
}

class NullDateRange extends DateRange
{
	protected static $instance;

	public function __construct()
	{
		parent::__construct(Date::Now(), Date::Now());
	}

	/**
	 * @return NullDateRange
	 */
	public static function Instance()
	{
		if (self::$instance == null)
		{
			self::$instance = new NullDateRange();
		}

		return self::$instance;
	}
}