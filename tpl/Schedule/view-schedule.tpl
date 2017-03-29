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

{extends file="Schedule/schedule.tpl"}

{block name="scripts-common"}

	{jsfile src="js/jquery.qtip.min.js"}
	{jsfile src="js/moment.min.js"}
	{jsfile src="schedule.js"}
	{jsfile src="resourcePopup.js"}
	{jsfile src="js/tree.jquery.js"}
	{jsfile src="js/jquery.cookie.js"}

	<script type="text/javascript">

		$(document).ready(function () {
			var scheduleOptions = {
				reservationUrlTemplate: "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
				summaryPopupUrl: "ajax/respopup.php",
				cookieName: "{$CookieName}",
				scheduleId: "{$ScheduleId}",
				scriptUrl: '{$ScriptUrl}',
				selectedResources: [{','|implode:$ResourceIds}],
				specificDates: [{foreach from=$SpecificDates item=d}'{$d->Format('Y-m-d')}',{/foreach}]
			};
			var schedule = new Schedule(scheduleOptions, {$ResourceGroupsAsJson});
			{if $AllowGuestBooking}
			schedule.init();
			schedule.initUserDefaultSchedule(true);
			{else}
			schedule.initNavigation();
			schedule.initRotateSchedule();
			schedule.initReservations();
			schedule.initResourceFilter();
			schedule.initResources();
			schedule.initUserDefaultSchedule(true);
			{/if}
		});
	</script>
{/block}