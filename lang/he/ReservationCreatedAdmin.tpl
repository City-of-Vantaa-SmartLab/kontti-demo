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


	פרטי הזמנה:
	<br/>
	<br/>

	משתמש: {$UserName}
	החל מ-: {formatdate date=$StartDate key=reservation_email}<br/>
	עד: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		משאבים:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		משאב: {$ResourceName}<br/>
	{/if}
	כותר: {$Title}<br/>
	תאור: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		ההזמנה קיימת בתאריכים אלו:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>אביזרים:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
                לאחד או יותר מהמשאבים המוזמנים דרוש אישור לפני שימוש. נא לוודא אישור של בקשת הזמנה זו.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">לצפות בהזמנה זו</a> | <a href="{$ScriptUrl}">כניסה ל-Booked Scheduler</a>


