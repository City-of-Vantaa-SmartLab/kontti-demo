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
{include file='globalheader.tpl' cssFiles='css/dashboard.css?v=1' Qtip=true}
{*including a css file here seems bad, overwrites custom css*}
<div id="page-dashboard">
	<div id="dashboardList">
		<div class="DashboardBlock">
			{foreach from=$items item=dashboardItem}
				<div>{$dashboardItem->PageLoad()}</div>
			{/foreach}
		</div>
		<div class="DashboardBlock">
			<div class="ResourceConfFrontpage">
				<div class="ResourceConfFrontpageInfoNot">
					<h2 class="ResourceConfFrontpageInfo">{translate key="CreateReservationHeading"}</h1>
					<p class="ResourceConfFrontpageInfo">{translate key="FrontReservationConfSelect"}</p>
				</div>
				{$counter=0}
				{foreach from=$ResourceConfs item=Conf}
					
					{if $counter == 0}
						
						<div class="ResourceConfDashboardDefault">
							<div class="ResourceConfDashboardDefaultLeft col-sm-4 col-xs-4">
								<div class="ResourceConfDashboardDefaultText">
									<h2 class="ResourceConfDashboardDefaultText">{$Conf['name']}</h2>
									<div class="ResourceConfDefaultDashText">
									<p class="ResourceConfDashboardDefaultText">{$Conf['description']}</p>
									{$furniturelist = "\n"|explode:$Conf['furniturelist']}
									{if isset($Conf['furniturelist'])}
										<ul class="Furniturelist">
										{foreach from=$furniturelist item=furniture}
											<li style="clear: left;">{$furniture}</li>
										{/foreach}
										</ul>
									{/if}
									</div>
								</div>
								<div class="ResourceConfDashboardDefaultButton">
									<a class="btn btn-success linkbutton" href="./schedule.php?sd=2017-6-5&roomconf={$Conf['conf_id']}">{translate key="Create"}{if $Conf['price'] != "0"} {$Conf['price']}€{/if}</a>
								</div>
							</div>
							<div class="ResourceConfDashboardDefaultRight col-sm-3 col-xs-3">										
								<img class='ResourceConfDashBig' src="../uploads/arrangements/{$Conf['conf_id']}.png" alt="{$Conf['name']}">
							</div>
						</div>
					{else}
						{if $counter == 1 || $counter == 4}
						<div class="row">
						{/if}
						<div class="ResourceConfInner">
							<div class="ResourceConfInfo">
								{$furniturelist = "\n"|explode:$Conf['furniturelist']}
									{if isset($Conf['furniturelist'])}
										{$furnilist = "<ul>"}
										{foreach from=$furniturelist item=furniture}
											{$furnilist = "`$furnilist`<li>`$furniture`</li>"}
										{/foreach}
										{$furnilist = "`$furnilist`</ul>"}
									{/if}
								<a href="{if strcmp($Conf['name'],"Semmajee")==0}#{$Conf['name']}{else}./schedule.php?sd=2017-6-5&roomconf={$Conf['conf_id']}{/if}" class="furnilistTip"><b>{$Conf['name']}</b></a><div class="infodot inline pull-right"><a title="<div class='furnilistTipInner'>{translate key='Furni'}<div class='furnilistTipInnerText'>{$furnilist}</div></div>" data-html="true" rel="tooltip{$Conf['conf_id']}" href="{if strcmp($Conf['name'],"Semmajee")==0}#{$Conf['name']}{else}./schedule.php?sd=2017-6-5&roomconf={$Conf['conf_id']}{/if}" class="furnilistTip" name="{$Conf['name']}"><i class="fa fa-info-circle pull-right" aria-hidden="true"></i></div></a><br/>
								{$Conf['description']}
							</div>
							
								<script>
									$('.infodot').tooltip({
									  selector: "a[rel=tooltip{$Conf['conf_id']}]"
									})
								</script>
							<div class="ResourceConfCheckBox">
								<input type="hidden" value="{$Conf['conf_id']}">
							</div>
							<div class="ResourceConfSmallImage">
								<a href='#arrangement-{$Conf['conf_id']}' role='button' data-toggle='collapse'>
										<img class='ResourceConfSmol' src="../uploads/arrangements/{$Conf['conf_id']}.png" alt="{$Conf['name']}">
								</a>
							</div>
							{*<div id='arrangement-{$Conf['conf_id']}' class='ResourceConfInfoBox collapse'>
								<a href='#arrangement-{$Conf['conf_id']}' role='button' data-toggle='collapse'>
										<img class='ResourceConfDashBig' src="../uploads/arrangements/1.png" alt="{$Conf['name']}">
								</a>
							</div>*}
							<div class="ResourceConfFrontBottom">
								{if strcmp($Conf['name'],"Semmajee")==0}
									<div style="padding-left:75px;padding-right:75px"><div style="border-style: solid; border-color:#6BC24A;border-width:1px;"><div style="padding: 6px 12px;padding-bottom: 6px;font-size: 14px;color:black;">{translate key="ComingSoon"}</div></div></div>
								{else}
									<a class="btn btn-success linkbutton" href="./schedule.php?sd=2017-6-5&roomconf={$Conf['conf_id']}">{translate key="Create"}{if $Conf['price'] != "0"} {$Conf['price']}€{/if}</a>
								{/if}
								<hr class="ResourceConfFrontBottom"></hr>
							</div>
						</div>
						
						{if $counter == 3 || $counter == 6}
						</div>
						{/if}
					{/if}
					{$counter = $counter + 1}
				{/foreach}
				{*
					<div class="ResourceConfInner">
						<div class="ResourceConfFrontBottom">
							<a class="btn btn-default" href="./schedule.php?sd=2017-6-5">Tee varaus</a>
						</div>
					</div>
				*}
			</div>
		</div>
	</div>

	{jsfile src="dashboard.js?v=1"}
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