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
{include file='globalheader.tpl' cssFiles='css/dashboard.css' Qtip=true}

<div id="page-dashboard">
	<div id="dashboardList">
		{foreach from=$items item=dashboardItem}
			<div>{$dashboardItem->PageLoad()}</div>
		{/foreach}
		<div class="ResourceConfFrontpage">
			<div class="ResourceConfFrontpageInfo">
				<h1 class="ResourceConfFrontpageInfo">{translate key="CreateReservationHeading"}</h1>
				<p class="ResourceConfFrontpageInfo">{translate key="FrontReservationConfSelect"}</p>
			</div>
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
					<div id='arrangement-{$Conf['conf_id']}notinuse' class='ResourceConfInfoBox collapse'>
						<a href='#arrangement-{$Conf['conf_id']}' role='button' data-toggle='collapse'>
								<img class='ResourceConfBig' src="../uploads/arrangements/1.png" alt="{$Conf['name']}">
						</a>
					</div>
					<div class="ResourceConfFrontBottom">
						<a class="btn btn-default" href="./reservation.php?rid=1&roomconf={$Conf['conf_id']}">{translate key="Create"}</a>
					</div>
				</div>
			{/foreach}
		</div>
	</div>

	{jsfile src="dashboard.js"}
	{jsfile src="resourcePopup.js"}
	{jsfile src="ajax-helpers.js"}

	<script type="text/javascript">
		$(document).ready(function () {

			var dashboardOpts = {
				reservationUrl: "{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=",
				summaryPopupUrl: "ajax/respopup.php",
				scriptUrl: '{$ScriptUrl}'
			};

			var dashboard = new Dashboard(dashboardOpts);
			dashboard.init();
		});
	</script>
</div>

{include file='globalfooter.tpl'}