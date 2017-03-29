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

class Mdb2CommandAdapter
{
	private $_values = null;
	private $_query = null;

	public function __construct(&$command)
	{
		$this->_values = array();
		$this->_query = null;

		$this->Convert($command);
	}

	public function GetValues()
	{
		return $this->_values;
	}

	public function GetQuery()
	{
		return $this->_query;
	}

	private function Convert(SqlCommand $command)
	{
		for ($p = 0; $p < $command->Parameters->Count(); $p++)
		{
			$curParam = $command->Parameters->Items($p);

			$value = $curParam->Value;
			if (is_array($value))
			{
				$value = implode("','", $value);
				$value = "'$value'";
			}

			$this->_values[str_replace('@', '', $curParam->Name)] = $value;
		}

		$this->_query = str_replace('@', ':', $command->GetQuery());
	}
}
