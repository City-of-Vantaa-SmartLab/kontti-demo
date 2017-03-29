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

class MySqlReader implements IReader
{
	private $_result = null;

	public function __construct($result)
	{
		$this->_result = $result;
	}

	public function GetRow()
	{
		return mysqli_fetch_assoc($this->_result);
	}

	public function NumRows()
	{
		return mysqli_num_rows($this->_result);
	}

	public function Free()
	{
		mysqli_free_result($this->_result);
	}
}
