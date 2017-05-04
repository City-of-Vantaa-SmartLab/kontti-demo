{*
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
*}

	<div class="ResourceConfFrontpage">
		{foreach from=$ResourceConfs item=Conf}
			<div class="ResourceConfInner">
				<div class="ResourceConfInfo">
					<b>{$Conf['name']}</b><i class="fa fa-info-circle pull-right" aria-hidden="true"></i><br/>
					{$Conf['description']}
				</div>
				<div class="ResourceConfCheckBox">
					<input type="hidden" value="{$Conf['conf_id']}">
				</div>
				<div class="ResourceConfSmallImage">
					<a href='#arrangement-{$Conf['conf_id']}' role='button' data-toggle='collapse'>
						<img class='ResourceConfSmol' src="../uploads/arrangements/1.png" alt="{$Conf['name']}">
					</a>
				</div>
				<div id='arrangement-{$Conf['conf_id']}' class='ResourceConfInfoBox collapse'>
					<a href='#arrangement-{$Conf['conf_id']}' role='button' data-toggle='collapse'>
						<img class='ResourceConfBig' src="../uploads/arrangements/1.png" alt="{$Conf['name']}">
					</a>
				</div>
			</div>
		{/foreach}
	</div>