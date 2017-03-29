<?php
/**
Copyright 2012-2016 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Responses/GroupItemResponse.php');

class GroupsResponse extends RestResponse
{
	/**
	 * @var array|GroupItemResponse[]
	 */
	public $groups;

	/**
	 * @param IRestServer $server
	 * @param array|GroupItemView[] $groups
	 */
	public function __construct(IRestServer $server, $groups)
	{
		foreach($groups as $group)
		{
			$this->groups[] = new GroupItemResponse($server, $group->Id, $group->Name);
		}
	}

	public static function Example()
	{
		return new ExampleGroupsResponse();
	}
}

class ExampleGroupsResponse extends GroupsResponse
{
	public function __construct()
	{
		$this->groups = array(GroupItemResponse::Example());
	}
}
