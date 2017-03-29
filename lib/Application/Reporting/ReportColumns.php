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
class ReportColumns implements IReportColumns
{
	private $knownColumns = array();
	private $attributeColumns = array();

	/**
	 * @param $columnName string
	 */
	public function Add($columnName)
	{
		$this->knownColumns[] = $columnName;
	}

	/**
	 * @param $attributeTypeId int|CustomAttributeCategory
	 * @param $attributeId int
	 * @param $label string
	 */
	public function AddAttribute($attributeTypeId, $attributeId, $label)
	{
		$this->attributeColumns[] = new AttributeReportColumn("{$attributeTypeId}attribute{$attributeId}", $label);
	}

	public function Exists($columnName)
	{
		return in_array($columnName, $this->knownColumns);
	}

	/**
	 * @return string[]
	 */
	public function GetAll()
	{
		return $this->knownColumns;
	}

	/**
	 * @return string[]
	 */
	public function GetCustomAttributes()
	{
		return $this->attributeColumns;
	}
}