{*
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler.
This file has been modified for Muuntamo.

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
{block name="header"}{include file='globalheader.tpl' Qtip=true printCssFiles='css/reservation.print.css'}
{/block}

{function name="displayResource"} {*display for each resource based on their ResourceTypeId*}
	{if $selectedResourceGroup == $resource->GetResourceTypeId()}
		<div class="resourceName reservationResourceBox container">
			<span class="resourceDetails">
				<div class="resourceContainerLeft">
					<span><input id="CheckRes" type="hidden" name="{FormKeys::ADDITIONAL_RESOURCES}[]" value="{$resource->Id}"{if $checked==1} checked{/if}></span>
					<span data-resourceId="{$resource->GetId()}"><label>{translate key="ResourcesDescription"}:</label>{*{$resource->Name}*}</span>
				</div>
				<div class="resourceContainerRight" style="color:Black}">
					<span>
						
						<select id="ResourceArrangement[{$resource->GetId()}]" name="ResourceArrangement[{$resource->GetId()}]" class="form-control input-sm resourceContainerRight">
							{foreach from=$availableResourcesArrangements item=temp}{*Each resource configuration*}
											{$Arrangementsplit = ":"|explode:$temp}{*[0] is id, [1] is name*}
											{if isset($smarty.get.roomconf)} {*If the get roomconf has been set*}
												{$checkerId=$smarty.get.roomconf}
											{else}							 {*otherwise use the set one (not set if not retrieved from db (new reservations))*}
												{$checkerId=$arrangementIds}
											{/if}
											<option value="{$Arrangementsplit[0]}"{if $checkerId == $Arrangementsplit[0]} selected="selected"{/if}>{$Arrangementsplit[1]}</option>
							{/foreach}
						</select>
						<script>
							document
								.getElementById('ResourceArrangement[{$resource->GetId()}]')
								.addEventListener('change', function () {
									var e = document.getElementById("ResourceArrangement[{$resource->GetId()}]");
									var value = e.options[e.selectedIndex].value;
									var text = e.options[e.selectedIndex].text;
									var test = [];
									var prices = [];
									{foreach from=$ResourceConfs item=Conf}
										{$furniturelist = "\n"|explode:$Conf['furniturelist']}
										{if isset($Conf['furniturelist'])}
											{$temp="<ul>"}
											{foreach from=$furniturelist item=furniture}
												{$temp="`$temp`<li>`$furniture`</li>"}
											{/foreach}
											{$temp="`$temp`</ul>"}
											{$temp = preg_replace( "/\r|\n/", "", $temp )}
										{/if}

										test[{$Conf['conf_id']}] = "{$temp}";
										prices[{$Conf['conf_id']}] = "{$Conf['price']}";
									{/foreach}
									var n = text.localeCompare("Kehotila");
									var MaxCapString;
									if(n==0){
										MaxCapString="{translate key="MaxParticipantsPt1"} 27 {translate key="MaxParticipantsPt2"}.";
									}else{
										MaxCapString="{translate key="MaxParticipantsPt1"} 18 {translate key="MaxParticipantsPt2"}.";
									}
									document.getElementById("selectedResourceConfImage").innerHTML = "<img class='ResourceConfBig' src='../uploads/arrangements/"+value+".png' alt='"+text+"'>";
									document.getElementById("selectedResourceConfFurni").innerHTML = ""+test[value]+"";
									document.getElementById("selectedResourceConfMaxCap").innerHTML = MaxCapString;
									document.getElementById("selectedResourceConfName").innerHTML = "{translate key="ResourceConfiguration"}: "+text+"";
									calcTotalPrice(0,"");
							});
							
						</script>
						{*<input type=hidden name="ResourceFoodArrangement[{$resource->GetId()}]" value="1">*}
					</span>
					{if $resource->GetRequiresApproval()}<span class="fa fa-lock" data-tooltip="approval"></span>{/if}
					{if $resource->IsCheckInEnabled()}<i class="fa fa-sign-in" data-tooltip="checkin"></i>{/if}
					{if $resource->IsAutoReleased()}<i class="fa fa-clock-o" data-tooltip="autorelease"
													   data-autorelease="{$resource->GetAutoReleaseMinutes()}"></i>{/if}
				</div>
			</span>
		</div><br/>
		{capture name="foodSelect"}
		<div class="ResourceFoodConfSelection">
		
					<hr class='pricetag'/>
				<div class="resourceContainerLeft">
					<span><label>{translate key="ResourcesFood"}:</label></p></span>
				</div>
				<div class="resourceContainerRight" style="color:Black}">
					<span>
						{$foodcheckerId=$PublicStatus['foodtarget_id']}
						<select id="ResourceFoodArrangement[{$resource->GetId()}]" name="ResourceFoodArrangement[{$resource->GetId()}]" class="form-control input-sm inline-block resourceContainerRight">
							<option value="0"{if $checkerId == 0} selected="selected"{/if}>Ei tarjoilua</option>
							{foreach from=$availableResourcesFoodArrangements item=Foodtemp}{*Each resource configuration*}
											{*$FoodArrangementsplit = ":"|explode:$Foodtemp*}{*[0] is id, [1] is name, [2] is description, [3] is price*}
											<option value="{$Foodtemp['foodconf_id']}"{if $foodcheckerId == $Foodtemp['foodconf_id']} selected="selected"{/if}>{$Foodtemp['name']} {$Foodtemp['price']}€/{translate key='peopleShort'}</option>
							{/foreach}
						</select>
						<div id="ResourceFoodArrangementCount"{if $PublicStatus==0} class="hidden"{/if}>
							{*<input type="text" id='ResourceFoodArrangementCountSelect[{$resource->GetId()}]' name='ResourceFoodArrangementCountSelect[{$resource->GetId()}]' value="{if $PublicStatus==0}1{else}{$PublicStatus['foodcount']}{/if}">*}
						</div>
						<script>
						
							{*document
								.getElementById('ResourceFoodArrangementCountSelect[{$resource->GetId()}]')
								.addEventListener('change', function () {	
									calcTotalPrice(0,"");
							});*}
							document
								.getElementById('ResourceFoodArrangement[{$resource->GetId()}]')
								.addEventListener('change', function () {
									var e = document.getElementById("ResourceFoodArrangement[{$resource->GetId()}]");
									var value = e.options[e.selectedIndex].value;
									var text = e.options[e.selectedIndex].text;
									var test = [];
									var prices = [];
									var FoodArrangementCountString;
									if(value!=0){
										document.getElementById("ResourceFoodArrangementCount").classList.remove('hidden');
									}else{
										document.getElementById("ResourceFoodArrangementCount").classList.add('hidden');
									}
									{foreach from=$ResourceFoodConfs item=Food}
										{$contentlist = PHP_EOL|explode:$Food['contentlist']}
										{if isset($Food['contentlist'])}
											{$foodtemp="<ul>"}
											{foreach from=$contentlist item=content}
												{$foodtemp="`$foodtemp`<li>`$content`</li>"}
											{/foreach}
											{$foodtemp="`$foodtemp`</ul>"}
											{$foodtemp = preg_replace( "/\r|\n/", "", $foodtemp )}{*removes linebreaks so javascript understands it*}
										{/if}

										test[{$Food['foodconf_id']}] = "{$foodtemp}";
										prices[{$Food['foodconf_id']}] = "{$Food['price']}";
									{/foreach}
									calcTotalPrice(0,"");
							});
							
						</script>
						{*<input type=hidden name="ResourceFoodArrangement[{$resource->GetId()}]" value="1">*}
					</span>
					{if $resource->GetRequiresApproval()}<span class="fa fa-lock" data-tooltip="approval"></span>{/if}
					{if $resource->IsCheckInEnabled()}<i class="fa fa-sign-in" data-tooltip="checkin"></i>{/if}
					{if $resource->IsAutoReleased()}<i class="fa fa-clock-o" data-tooltip="autorelease"
													   data-autorelease="{$resource->GetAutoReleaseMinutes()}"></i>{/if}
				</div>
		</div>
		<div class="col-xs-12 noPadLeft ResourceFoodArrangementWarning"><br/>{translate key="ResourceFoodArrangementWarning"}, <a href="mailto:henkilostoravintola.57@vantti.fi?Subject=Muuntamo{if isset($SeriesId)}-ID{$SeriesId}{/if}">henkilostoravintola.57@vantti.fi</a>.<br/><br/><br/></div>
		<div id='hiddenResourceFoodArrangementPlaceholder'></div>
		{/capture}
	{/if}
{/function}

<div id="page-reservation">
	<div id="reservation-box">
		<form id="form-reservation" method="post" enctype="multipart/form-data" role="form">
			<div class="row">
				<div class="col-md-6 col-xs-12 col-top reservationHeader">
					<h3>{block name=reservationHeader}{translate key="CreateReservationHeading"}{/block}</h3>
				</div>
				<div class="col-md-6 col-xs-12 col-top">
					<div class="pull-right">
						<button type="button" class="btn btn-default" onclick="window.location='{$ReturnUrl}'">
							{translate key='Cancel'}
						</button>
						{block name="submitButtons"}
							<button type="button" class="btn btn-success save create">
								{*<span class="glyphicon glyphicon-ok-circle"></span>*}
								{translate key='Create'}
							</button>
						{/block}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 inline-block">
					{assign var="detailsCol" value="col-xs-12"}
					{assign var="participantCol" value="col-xs-12"}
					<div id="reservationDetails" class="col-md-5 inline-block">{*$detailsCol*}
						{if $ShowParticipation && $AllowParticipation && $ShowReservationDetails}
							{assign var="detailsCol" value="col-xs-12 col-sm-6"}
							{assign var="participantCol" value="col-xs-12 col-sm-6"}
						{/if}
						<div class="col-xs-12">
							<div class="form-group">
								{if $ShowUserDetails && $ShowReservationDetails}
								{else}
									{translate key=Private}
								{/if}
								<input id="userId" type="hidden" {formname key=USER_ID} value="{$UserId}"/>
								{if $CanChangeUser}
									<a href="#" id="userName" data-userid="{$UserId}">{$ReservationUserName}</a>
									<a href="#" id="showChangeUsers" class="small-action">{translate key=Change} <i
												class="fa fa-user"></i></a>
									<div class="modal fade" id="changeUserDialog" tabindex="-1" role="dialog"
										 aria-labelledby="usersModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"
															aria-hidden="true">&times;</button>
													<h4 class="modal-title"
														id="usersModalLabel">{translate key=ChangeUser}</h4>
												</div>
												<div class="modal-body">
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default"
															data-dismiss="modal">{translate key='Cancel'}</button>
													<button type="button"
															class="btn btn-primary">{translate key='Done'}</button>
												</div>
											</div>
										</div>
									</div>
								{/if}
								<div id="availableCredits" {if !$CreditsEnabled}style="display:none" }{/if}>{translate key=AvailableCredits} <span
											id="availableCreditsCount">{$CurrentUserCredits}</span></div>
							</div>
						</div>

						<div id="changeUsers">
							<div class="form-group">
								<input type="text" id="changeUserAutocomplete"
									   class="form-control inline-block user-search"/>
								|
								<button id="promptForChangeUsers" type="button" class="btn inline">
									<i class="fa fa-users"></i>
									{translate key='AllUsers'}
								</button>
							</div>
						</div>

						<div id="reservation-resources">
							<div class="form-group">
								<div class="pull-left">
									<div>
										{*<p>{translate key="ResourcesDescription"}</p>*}
											{$SelectedResourceGroup=$Resource->ResourceTypeId}
											{$resource->Id}
									</div>
									{$Checked=True}

									<div id="primaryResourceContainer" class="col-sm-4 inline nopaddingleft">
											{$resource->Id}
										<input type="hidden" id="scheduleId" {formname key=SCHEDULE_ID}
											   value="{$ScheduleId}"/>
										<input class="resourceId" type="hidden"
											   id="primaryResourceId" {formname key=RESOURCE_ID} value="{$ResourceId}"/>{if isset($smarty.get.roomconf)}{$temp=$smarty.get.roomconf}{else}{$temp=getConfId(getArrangement($ResourceId,$SeriesId))}{/if}
										{displayResource checked=$Checked resource=$Resource arrangementIds={$temp} availableResourcesArrangements=$AvailableResourcesArrangements[$ResourceId] selectedResourceGroup=$SelectedResourceGroup availableResourcesFoodArrangements=$AvailableResourcesFoodArrangements[$ResourceId]}
									</div>

									<div id="additionalResources">
										{foreach from=$AvailableResources item=resource}
											{if $resource->Id!=$ResourceId}
											{if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
												{$Checked=True}
											{else}
												{$Checked=False}
											{/if}
											{*
												{for $i=0 to $AdditionalResourceIds|count}
													{if $resource->Id == $AdditionalResourceIds[$i]}*}
														{$arrangementIds = $AdditionalResourceArrangements[$resource->Id]}
														{*{$i = $AdditionalResourceIds|count}
													{/if}
												{/for}*}
												{*<input class="resourceId" type="hidden" name="{FormKeys::ADDITIONAL_RESOURCES}[]" value="{$resource->Id}"/>*}
												
												{displayResource checked=$Checked resource=$resource arrangementIds=$arrangementIds availableResourcesArrangements=$AvailableResourcesArrangements[$resource->Id] selectedResourceGroup=$SelectedResourceGroup ResourceFoodConfs=getAllResourceFoodArrangements}
											{/if}
										{/foreach}
									</div>
								</div>
								<div class="pull-right">
									{if $ShowReservationDetails && $AvailableAccessories|count > 0}
										<label>{translate key="Accessories"}</label>
										<a href="#" id="addAccessoriesPrompt"
										   class="small-action" data-toggle="modal"
										   data-target="#dialogAddAccessories">{translate key='Add'} <span
													class="fa fa-plus-square"></span></a>
										<div id="accessories"></div>
									{/if}
								</div>
							</div>
						</div>
						
						<div class="reservationDatesBox">
							<div class="reservationDatesBox">
								<p>{translate key = "SelectTime"}:</p>
								<div class="reservationDatesBoxLeft">
									<label for="BeginDate" class="reservationDate">{translate key='BeginDate'}</label>
								</div>
								<div class="inline-block">
									<div class="reservationDatesBoxMid">
										<input type="text" id="BeginDate" class="dateform-control input-sm dateinput"
										   value="{formatdate date=$StartDate}"/>
										<input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE}
											value="{formatdate date=$StartDate key=system}"/>
									</div>
									<div class="reservationDatesBoxRight">
												<select id="BeginPeriod" {formname key=BEGIN_PERIOD}
														class="form-control input-sm timeinput" title="Begin time">
													{foreach from=$StartPeriods item=period}
														{if $period->IsReservable()}
															{assign var='selected' value=''}
															{if $period eq $SelectedStart}
																{assign var='selected' value=' selected="selected"'}
															{/if}
															<option value="{$period->Begin()}"{$selected}>{$period->Label()}</option>
														{/if}
													{/foreach}
												</select>
									</div>
								</div>
							</div><br/>
							<div class="reservationDatesBox">
								<div class="reservationDatesBoxLeft">
									<label for="EndDate" class="reservationDate">{translate key='EndDate'}</label>
								</div>
								<div class="inline-block">
									<div class="reservationDatesBoxMid">
											<input type="text" id="EndDate" class="form-control input-sm inline-block dateinput"
												   value="{formatdate date=$EndDate}"/>
											<input type="hidden" id="formattedEndDate" {formname key=END_DATE}
												   value="{formatdate date=$EndDate key=system}"/>
									</div>
									<div class="reservationDatesBoxRight">
										<select id="EndPeriod" {formname key=END_PERIOD}
											class="form-control input-sm inline-block timeinput" title="End time">
										{foreach from=$EndPeriods item=period name=endPeriods}
											{if $period->IsReservable()}
												{assign var='selected' value=''}
												{if $period eq $SelectedEnd}
													{assign var='selected' value=' selected="selected"'}
												{/if}
												<option value="{$period->End()}"{$selected}>{$period->LabelEnd()}</option>
											{/if}
										{/foreach}
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="reservationLength">
							<div class="form-group">
								<span class="like-label">{translate key=ReservationLength}</span>
								<div class="durationText">
									{*<span id="durationDays">0</span> {translate key=days}*}
									<span id="durationHours">0</span> {translate key=hours}
									<span id="durationMinutes">0</span> {translate key=minutes}
								</div>
							</div>
						</div>
					{if !$HideRecurrence}
						<div class="col-xs-12 noPadLeft">
							{if isset($HideRepeat)}
								{translate key='RecurrenceDisabledBugPt1'} <a href="{$Path}{Pages::SCHEDULE}?sd={formatdate date=$StartDate key=system}" target="_blank">{translate key='RecurrenceDisabledBugLink'}</a> {translate key='RecurrenceDisabledBugPt2'}
								<div class="hidden">
							{/if}
							
							{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate}
							
							{if isset($HideRepeat)}
								</div>
							{/if}
							
						</div>
					{/if}
						{$smarty.capture.foodSelect}
						<div class="col-xs-12 noPadLeft">
							<div class="reservationPublicDatesBox">
								<div class="reservationPublicDatesBoxInner">
									<div id="ReservationTotalPrice">
										<div class='row col-xs-12 reservationPriceError' id="ReservationPriceError">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 noPadLeft">
							<div class="reservationPublicDatesBox">
								<div class="reservationPublicDatesBoxInner">
									<div id="ReservationBillingInfo" class=" form-group">
										<label>{translate key="compname"}</label><br/><input class="form-control billinginfo" id="compname" name="compname" maxlength="500" type="text" value="{$UserBillingInfo['compname']}"><br/>
										<label>{translate key="personid"}</label><br/><input class="form-control billinginfo" id="personid" name="personid" maxlength="500" type="text" value="{$UserBillingInfo['personid']}"><br/>
										<label>{translate key="billingaddress"}</label><br/><textarea class="form-control billinginfo" id="billingaddress" name="billingaddress" maxlength="500" type="text" value="{$UserBillingInfo['billingaddress']}">{$UserBillingInfo['billingaddress']}</textarea><br/>
										<label>{translate key="reference"}</label><br/><input class="form-control billinginfo" id="reference" name="reference" maxlength="500" type="text" value="{$UserBillingInfo['reference']}"><br/>
										<label>{translate key="additionalInfo"}</label><br/><textarea class="form-control billinginfo" id="additionalinfo" name="additionalinfo" maxlength="500" type="text" value="{$UserBillingInfo['additionalinfo']}">{$UserBillingInfo['additionalinfo']}</textarea><br/>
									</div>
									<div id='MenuOrderInfo' class='MenuOrderInfo'>{translate key="MenuOrderInfo"}</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3 inline-block selectedResourceConf">
								<div class="selectedResourceConfImage" id="selectedResourceConfImage">
									<img class='ResourceConfBig' src="../uploads/arrangements/{if isset($smarty.get.roomconf)}{$smarty.get.roomconf}{else}1{/if}.png" alt="Tilaratkaisun kuva">
								</div>
					</div>
					
					<div class="col-md-4 inline-block selectedResourceConf">
								<div class="ResourceAndConfInfo">
									{translate key="Resource"}: {$Resource->Name}<br/>
									{translate key="Location"}: {$locationInformation}<br/>
									<div class="inline-block" id="selectedResourceConfMaxCap">
										{if strcmp(getArrangementName($smarty.get.roomconf),"Kehotila")==0}
											{translate key="MaxParticipantsPt1"} 27 {translate key="MaxParticipantsPt2"}.
										{else}
											{translate key="MaxParticipantsPt1"} 18 {translate key="MaxParticipantsPt2"}.
										{/if}
									</div><br/>
									<div class="inline-block" id="selectedResourceConfName">{translate key="ResourceConfiguration"}: Valittu tilaratkaisu näkyy valittuna vasemmalla</div><br/>
									Varustelut:
									<div id="selectedResourceConfFurni">
										{$tempconfid=1}
										{if isset($smarty.get.roomconf)}{$tempconfid = getArrangementInfo($smarty.get.roomconf)}{/if}
										{$furniturelist = "\n"|explode:$tempconfid['furniturelist']}
										{if isset($tempconfid['furniturelist'])}
											<ul>
											{foreach from=$furniturelist item=furniture}
												<li>{$furniture}</li>
											{/foreach}
											</ul>
										{/if}
									</div>
								</div>
					</div>
					<div class="col-xs-12 reservationTitle">
						<div class="form-group has-feedback">
							<label for="reservationTitle">{translate key="ReservationTitle"}</label>
							<div class="reservationInfoBox">
								<p>
								{translate key="reservationNameInfo"}
								</p>
							</div>
							<div id="charcountTitle" class="charcount inline-block">{translate key='CharactersLeft'}: 85</div>
							{textbox name="RESERVATION_TITLE" class="form-control" value="ReservationTitle" id="reservationTitle" maxlength="85"}
								<script>
									document.getElementById('reservationTitle').onkeyup = function () {
									  document.getElementById('charcountTitle').innerHTML = "{translate key='CharactersLeft'}: " + (85 - this.value.length);
									};

								</script>
							{*<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="reservationTitle"></i>*}
						</div>
					</div>

					<div class="col-xs-12">
						<div class="form-group">
							<label for="description">{translate key="ReservationDescription"}</label>
							<div class="reservationInfoBox">
								<p>
								{translate key="reservationDescriptionInfo"}
								</p>
								<div id="charcountDesc" class="charcount inline-block">{translate key='CharactersLeft'}: 500</div>
							</div>
							<textarea maxlength="500" id="description" name="{FormKeys::DESCRIPTION}"
									  class="form-control" required>{$Description}</textarea>
									  
								<script>
									document.getElementById('description').onkeyup = function () {
									  document.getElementById('charcountDesc').innerHTML = "{translate key='CharactersLeft'}: " + (500 - this.value.length);
									};

								</script>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="reservationPublicDatesBox">
							<div class="reservationPublicDatesBoxInner">
								<div class="checkbox">
									<input type="checkbox" id="IsPublicEvent" name="IsPublicEvent"> <label for="IsPublicEvent">{translate key="SelectPublic"}</label>
								</div>
								<div id="PublicTimeStart">
								</div>
								<div id="PublicTimeEnd">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="reservationPublicDatesBox">
							<div class="reservationPublicDatesBoxInner">
								<div class="checkbox">
									<input type="checkbox" id="RoomForOtherPresenter" name="RoomForOtherPresenter"{if $PublicStatus['RoomForOtherPresenter']==1} checked{/if}> <label for="RoomForOtherPresenter">{translate key="RoomForOtherPresenter"}</label>
								</div>
							</div>
						</div>
					</div>
					{if !empty($ReferenceNumber)}
					<div class="col-xs-12">
						<div class="form-group">
							<label>{translate key=ReferenceNumber}</label>
							{$ReferenceNumber}
						</div>
					</div>
					{/if}
				</div>

				<div class="{$participantCol}">
					{if $ShowParticipation && $AllowParticipation && $ShowReservationDetails}
						{include file="Reservation/participation.tpl"}
					{else}
						{include file="Reservation/private-participation.tpl"}
					{/if}
				</div>
			</div>

			<div class="row col-xs-12 same-height">
				<div id="custom-attributes-placeholder" class="col-xs-12">
				</div>
			</div>
						
			{if $RemindersEnabled}
				<div class="row col-xs-12">
					<div class="col-xs-12 reservationReminders">
						<div>
							<label for="startReminderEnabled">{translate key=SendReminder}</label>
						</div>
						<div id="reminderOptionsStart">
							<div class="checkbox">
								<input type="checkbox" id="startReminderEnabled"
									   class="reminderEnabled" {formname key=START_REMINDER_ENABLED}/>
								<label for="startReminderEnabled">
									<input type="number" min="0" max="999" size="3" maxlength="3" value="15"
										   class="reminderTime form-control input-sm inline-block" {formname key=START_REMINDER_TIME}/>
									<select class="reminderInterval form-control input-sm inline-block" {formname key=START_REMINDER_INTERVAL}>
										<option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
										<option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
										<option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
									</select>
									<span class="reminderLabel">{translate key=ReminderBeforeStart}</span></label>
							</div>
						</div>
						<div id="reminderOptionsEnd">
							<div class="checkbox">
								<input type="checkbox" id="endReminderEnabled"
									   class="reminderEnabled" {formname key=END_REMINDER_ENABLED}/>
								<label for="endReminderEnabled">
									<input type="number" min="0" max="999" size="3" maxlength="3" value="15"
										   class="reminderTime form-control input-sm inline-block" {formname key=END_REMINDER_TIME}/>
									<select class="reminderInterval form-control input-sm inline-block" {formname key=END_REMINDER_INTERVAL}>
										<option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
										<option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
										<option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
									</select>
									<span class="reminderLabel">{translate key=ReminderBeforeEnd}</span></label>
							</div>

						</div>
						<div class="clear">&nbsp;</div>
					</div>
				</div>
			{/if}

			{if $UploadsEnabled}
				<div class="row col-xs-12">
					<div class="col-xs-12 reservationAttachments">

						<label>{translate key=AttachFile} <span class="note">({$MaxUploadSize}
								MB {translate key=Maximum})</span>
						</label>

						<div id="reservationAttachments">
							<div class="attachment-item">
								<input type="file" {formname key=RESERVATION_FILE multi=true} />
								<a class="add-attachment" href="#">{translate key=Add} <i class="fa fa-plus-square"></i></a>
								<a class="remove-attachment" href="#"><i class="fa fa-minus-square"></i></a>
							</div>
						</div>
					</div>
				</div>
			{/if}


			<input type="hidden" {formname key=RESERVATION_ID} value="{$ReservationId}"/>
			<input type="hidden" {formname key=REFERENCE_NUMBER} value="{$ReferenceNumber}" id="referenceNumber"/>
			<input type="hidden" {formname key=RESERVATION_ACTION} value="{$ReservationAction}"/>

			<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope"
				   value="{SeriesUpdateScope::FullSeries}"/>

			<div class="row">
				<div class="reservationButtons col-m-6 col-m-offset-6 col-xs-12">
					<div class="reservationSubmitButtons">
						<button type="button" class="btn btn-default" onclick="window.location='{$ReturnUrl}'">
							{translate key='Cancel'}
						</button>
						{block name="submitButtons"}
							<button type="button" class="btn btn-success save create">
								{*<span class="glyphicon glyphicon-ok-circle"></span>*}
								{translate key='Create'}
							</button>
						{/block}
					</div>
				</div>
			</div>

			{csrf_token}

			{if $UploadsEnabled}
				{block name='attachments'}
				{/block}
			{/if}


			<div id="retrySubmitParams" class="no-show"></div>
		</form>
	</div>

	<div class="modal fade" id="dialogResourceGroups" tabindex="-1" role="dialog" aria-labelledby="resourcesModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="resourcesModalLabel">{translate key=AddResources}</h4>
				</div>
				<div class="modal-body">
					<div id="resourceGroups"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btnClearAddResources"
							data-dismiss="modal">{translate key='Cancel'}</button>
					<button type="button" class="btn btn-primary btnConfirmAddResources">{translate key='Done'}</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="dialogAddAccessories" tabindex="-1" role="dialog" aria-labelledby="accessoryModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="accessoryModalLabel">{translate key=AddAccessories}</h4>
				</div>
				<div class="modal-body">
					<table class="table table-condensed">
						<thead>
						<tr>
							<th>{translate key=Accessory}</th>
							<th>{translate key=QuantityRequested}</th>
							<th>{translate key=QuantityAvailable}</th>
						</tr>
						</thead>
						<tbody>
						{foreach from=$AvailableAccessories item=accessory}
							<tr accessory-id="{$accessory->GetId()}">
								<td>{$accessory->GetName()}</td>
								<td>
									<input type="hidden" class="name" value="{$accessory->GetName()}"/>
									<input type="hidden" class="id" value="{$accessory->GetId()}"/>
									<input type="hidden" class="resource-ids"
										   value="{','|implode:$accessory->ResourceIds()}"/>
									{if $accessory->GetQuantityAvailable() == 1}
										<input type="checkbox" name="accessory{$accessory->GetId()}" value="1"
											   size="3"/>
									{else}
										<input type="number" min="0" max="999"
											   class="form-control input-sm accessory-quantity"
											   name="accessory{$accessory->GetId()}"
											   value="0" size="3"/>
									{/if}
								</td>
								<td accessory-quantity-id="{$accessory->GetId()}"
									accessory-quantity-available="{$accessory->GetQuantityAvailable()}">{$accessory->GetQuantityAvailable()|default:'&infin;'}</td>
							</tr>
						{/foreach}
						</tbody>
					</table>

				</div>
				<div class="modal-footer">
					<button id="btnCancelAddAccessories" type="button" class="btn btn-default"
							data-dismiss="modal">{translate key='Cancel'}</button>
					<button id="btnConfirmAddAccessories" type="button"
							class="btn btn-primary">{translate key='Done'}</button>
				</div>
			</div>
		</div>
	</div>

	<div id="wait-box" class="wait-box">
		<div id="creatingNotification">
			<h3 id="createUpdateMessage" class="no-show">
				{block name="ajaxMessage"}
					{translate key=CreatingReservation}
				{/block}
			</h3>
			<h3 id="checkingInMessage" class="no-show">
				{translate key=CheckingIn}
			</h3>
			<h3 id="checkingOutMessage" class="no-show">
				{translate key=CheckingOut}
			</h3>
			<h3 id="joiningWaitingList" class="no-show">
				{translate key=AddingToWaitlist}
			</h3>
			{html_image src="reservation_submitting.gif"}
		</div>
		<div id="result"></div>
	</div>

</div>

{control type="DatePickerSetupControl" ControlId="BeginDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" AltId="formattedEndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat" DefaultDate=$RepeatTerminationDate}

{jsfile src="js/jquery.autogrow.js"}
{jsfile src="js/moment.min.js"}
{jsfile src="resourcePopup.js"}
{jsfile src="userPopup.js"}
{jsfile src="date-helper.js"}
{jsfile src="recurrence.js"}
{jsfile src="reservation.js"}
{jsfile src="autocomplete.js"}
{jsfile src="force-numeric.js"}
{jsfile src="reservation-reminder.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="js/tree.jquery.js"}

<script type="text/javascript">

	$(function () {
		var scopeOptions = {
			instance: '{SeriesUpdateScope::ThisInstance}', full: '{SeriesUpdateScope::FullSeries}', future: '{SeriesUpdateScope::FutureInstances}'
		};

		var reservationOpts = {
			additionalResourceElementId: '{FormKeys::ADDITIONAL_RESOURCES}',
			accessoryListInputId: '{FormKeys::ACCESSORY_LIST}[]',
			returnUrl: '{$ReturnUrl}',
			scopeOpts: scopeOptions,
			createUrl: 'ajax/reservation_save.php',
			updateUrl: 'ajax/reservation_update.php',
			deleteUrl: 'ajax/reservation_delete.php',
			checkinUrl: 'ajax/reservation_checkin.php?action={ReservationAction::Checkin}',
			checkoutUrl: 'ajax/reservation_checkin.php?action={ReservationAction::Checkout}',
			waitlistUrl: 'ajax/reservation_waitlist.php',
			userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}",
			groupAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::Group}",
			changeUserAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::MyUsers}",
			maxConcurrentUploads: '{$MaxUploadCount}',
			guestLabel: '({translate key=Guest})',
			accessoriesUrl: 'ajax/available_accessories.php?{QueryStringKeys::START_DATE}=[sd]&{QueryStringKeys::END_DATE}=[ed]&{QueryStringKeys::START_TIME}=[st]&{QueryStringKeys::END_TIME}=[et]&{QueryStringKeys::REFERENCE_NUMBER}=[rn]'
		};

		var reminderOpts = {
			reminderTimeStart: '{$ReminderTimeStart}',
			reminderTimeEnd: '{$ReminderTimeEnd}',
			reminderIntervalStart: '{$ReminderIntervalStart}',
			reminderIntervalEnd: '{$ReminderIntervalEnd}'
		};

		var reservation = new Reservation(reservationOpts);
		reservation.init('{$UserId}', '{format_date date=$StartDate key=system_datetime timezone=$Timezone}', '{format_date date=$EndDate key=system_datetime timezone=$Timezone}');

		var reminders = new Reminder(reminderOpts);
		reminders.init();

		{foreach from=$Participants item=user}
		reservation.addParticipant("{$user->FullName|escape:'javascript'}", "{$user->UserId|escape:'javascript'}");
		{/foreach}

		{foreach from=$Invitees item=user}
		reservation.addInvitee("{$user->FullName|escape:'javascript'}", '{$user->UserId}');
		{/foreach}

		{foreach from=$ParticipatingGuests item=guest}
		reservation.addParticipatingGuest('{$guest}');
		{/foreach}

		{foreach from=$InvitedGuests item=guest}
		reservation.addInvitedGuest('{$guest}');
		{/foreach}

		{foreach from=$Accessories item=accessory}
		reservation.addAccessory({$accessory->AccessoryId}, {$accessory->QuantityReserved}, "{$accessory->Name|escape:'javascript'}");
		{/foreach}
		reservation.addResourceGroups({$ResourceGroupsAsJson});

		var recurOpts = {
			repeatType: '{$RepeatType}',
			repeatInterval: '{$RepeatInterval}',
			repeatMonthlyType: '{$RepeatMonthlyType}',
			repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}]
		};
		
		var recurrence = new Recurrence(recurOpts);
		recurrence.init();

		var ajaxOptions = {
			target: '#result', // target element(s) to be updated with server response
			beforeSubmit: reservation.preSubmit, // pre-submit callback
			success: reservation.showResponse  // post-submit callback
		};

		$('#form-reservation').submit(function () {
			$(this).ajaxSubmit(ajaxOptions);
			return false;
		});

		$('#description').autogrow();
		$('#userName').bindUserDetails();

		$.blockUI.defaults.css.width = '60%';
		$.blockUI.defaults.css.left = '20%';

		var resources = $('#reservation-resources');
		resources.tooltip({
			selector: '[data-tooltip]', title: function () {
				var tooltipType = $(this).data('tooltip');
				if (tooltipType === 'approval')
				{
					return "{translate key=RequiresApproval}";
				}
				if (tooltipType === 'checkin')
				{
					return "{translate key=RequiresCheckInNotification}";
				}
				if (tooltipType === 'autorelease')
				{
					var text = "{translate key=AutoReleaseNotification args='%s'}";
					return text.replace('%s', $(this).data('autorelease'));
				}
			}
		});
	});
</script>
{*<script type="text/javascript">
var cbs = document.querySelectorAll('input[id=CheckRes][type=checkbox]');
var testi = [];
for(var i = 0; i < cbs.length; i++) {
    cbs[i].addEventListener('change', function() {
        if(this.checked){
			testi[this.value] = this.value;
			$.ajax(
			{	
				url: "about.php",
				dataType: "HTML",
				success: function(data) { $('#testingthings').html(data);},
				error: function(e){ alert('Error: ' + e);}
			});
            //console.log(this.value);
            //console.log(testi);
			//console.log($);
			return false;
		}
    });
}
</script>*}
<script>
	$('#formattedBeginDate').change(function () {
		calcTotalPrice(0,"");
		produceDateError();
	});
	function produceDateError(){
		var selectedDate = new Date(document.getElementById("formattedBeginDate").value);
		var curDate = new Date("{date("Y-m-d")}");
		var inputString = "";
		var weekendCount=countNonWeekends(curDate, selectedDate);
		console.log(weekendCount<5);
		console.log(weekendCount>5);
		if(weekendCount<5){
			//set menu selection to disabled and no menu/menu selected before the date
			document.getElementById("ResourceFoodArrangement[{$resource->GetId()}]").disabled = true;
			document.getElementById("ResourceFoodArrangement[{$resource->GetId()}]").value = {if isset($PublicStatus['foodtarget_id'])}{$PublicStatus['foodtarget_id']}{else}0{/if};
			inputString=inputString+"<input type='hidden' name='ResourceFoodArrangement[{$resource->GetId()}]' value='{if isset($PublicStatus['foodtarget_id'])}{$PublicStatus['foodtarget_id']}{else}0{/if}'>";
			var myElemTwo = document.getElementById('foodhalfsecond');
			if (myElemTwo !== null){
				inputString=inputString+"<input type='hidden' name='"+myElemTwo.getAttribute("name")+"' value='{if isset($PublicStatus['FoodSplitSecond'])}{$PublicStatus['FoodSplitSecond']}{else}0{/if}'>";
				document.getElementById("foodhalfsecond").disabled = true;
			}
			var myElemTwo = document.getElementById('foodhalffirst');
			if (myElemTwo !== null){
				inputString=inputString+"<input type='hidden' name='"+myElemTwo.getAttribute("name")+"' value='{if isset($PublicStatus['FoodSplitFirst'])}{$PublicStatus['FoodSplitFirst']}{else}0{/if}'>";
				document.getElementById("foodhalffirst").disabled = true;
			}
			//document.getElementById("ResourceFoodArrangementWarning").innerHTML = warning;
		}else{
			document.getElementById("ResourceFoodArrangement[{$resource->GetId()}]").disabled = false;
			var myElemTwo = document.getElementById('foodhalfsecond');
			if (myElemTwo !== null){
				document.getElementById("foodhalfsecond").disabled = false;
			}
			var myElemTwo = document.getElementById('foodhalffirst');
			if (myElemTwo !== null){
				document.getElementById("foodhalffirst").disabled = false;
			}
			document.getElementById("hiddenResourceFoodArrangementPlaceholder").innerHTML = inputString;
		}
		document.getElementById("hiddenResourceFoodArrangementPlaceholder").innerHTML = inputString;
	}
	function countNonWeekends(curDate,selectedDate){
		var weekDays=0;
		curDate.setDate(curDate.getDate()+1);
		var daydiffr=daydiff(curDate, selectedDate);
		for(var i=0;daydiffr>i;i++){
			if(parseInt(curDate.getDay())!=0&&parseInt(curDate.getDay())!=6){
				weekDays=weekDays+1;
			}
			curDate.setDate(curDate.getDate()+1);
		}
		return weekDays;
	}
	
	function daydiff(first, second) {
		//source for daydiff() https://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
		return Math.round((second-first)/(1000*60*60*24));
	}
	
	calcTotalPrice(1,"");
	{for $i=0 to 6}
		document
		.getElementById('repeatDay{$i}')
		.addEventListener('change', function () {
			//console.log("Day changed {$i}");
			calcTotalPrice(0,"");
		});
	{/for}
							document
								.getElementById('repeatOptions')
								.addEventListener('change', function () {
									calcTotalPrice(0,"");
								});
							document
								.getElementById('repeatInterval')
								.addEventListener('change', function () {
									calcTotalPrice(0,"");
								});
							document
								.getElementById('EndRepeat')
								.addEventListener('onpropertychange', function () {
									calcTotalPrice(0,"");
								});
							 $("#EndRepeat").on("click", function(){
									calcTotalPrice(0,"");
							});
							 $("#formattedEndRepeat").on("click", function(){
									calcTotalPrice(0,"");
							});
							document
								.getElementById('IsPublicEvent')
								.addEventListener('change', function () {
									createTimegenerator(1);
									createTimegenerator(2);
							});
							document
								.getElementById('BeginPeriod')
								.addEventListener('change', function () {
									createTimegenerator(1);
									createTimegenerator(2);
									calcTotalPrice(0,"");
								});
							document
								.getElementById('EndPeriod')
								.addEventListener('change', function () {
									createTimegenerator(1);
									createTimegenerator(2);
									calcTotalPrice(0,"");
								});
								
							String.prototype.replaceAt=function(index, replacement) { //source: http://stackoverflow.com/questions/1431094/how-do-i-replace-a-character-at-a-particular-index-in-javascript
								return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
							}
							function createTimegenerator(type){
									if(document.getElementById("IsPublicEvent").checked){
										pushPublicTimePeriods(PublicTimeStartStringGenerator(type),type);
									}else{
										pushPublicTimePeriods("",type);
									}
							}
							function PublicTimeStartStringGenerator(type){
										if(type==1){
											PublicTimeStartString="<div class='reservationDatesBoxLeft'><label class='reservationDate' for='SelectPublicTime'>{translate key='BeginTime2'}</label></div><div class='reservationDatesBoxRight'><select id='SelectPublicTime' name='SelectPublicTime' class='form-control input-sm timeinput'>";
										}else{
											PublicTimeStartString="<div class='reservationDatesBoxLeft'><label class='reservationDate' for='SelectPublicEndTime'>{translate key='EndTime2'}</label></div><div class='reservationDatesBoxRight'><select id='SelectPublicEndTime' name='SelectPublicEndTime' class='form-control input-sm timeinput'>";
										}
										var PublicTimeStartTimes = publicTimePeriodList(type);
										var PreSetTime="00:00:00";
										var e = document.getElementById("EndPeriod");
										var EndPeriodValue = e.options[e.selectedIndex].value;
										PublicTimeStartTimes.forEach(function(element) {
										
											{if isset($SeriesId)}
												{if isset($PublicStatus)}
													if(type==1){
														PreSetTime="{$PublicStatus['PublicStartTime']}";
													}else{
														PreSetTime="{$PublicStatus['PublicEndTime']}";
													}
												{/if}
											{else}
												if(type==1){
												
												}else{
													PreSetTime=EndPeriodValue;
												}
											{/if}
											PublicTimeStartString=PublicTimeStartString+"<option value='"+element+"'";
											if(PreSetTime.localeCompare(element)==0){
												PublicTimeStartString=PublicTimeStartString+" selected";
											}else if(type==2){
												PublicTimeStartString=PublicTimeStartString+" selected";
											}
											//console.log(element);
											element=element.replaceAt(2,".") //changing the : to a .
											PublicTimeStartString=PublicTimeStartString+">"+element.slice(0, -3)+"</option>";
										});
										PublicTimeStartString=PublicTimeStartString+"</select></div>";
										return PublicTimeStartString;
							}
							
							function publicTimePeriodList(type){
								var a = document.getElementById("BeginPeriod");
								var BeginPeriodValue = a.options[a.selectedIndex].value;
								var e = document.getElementById("EndPeriod");
								var EndPeriodValue = e.options[e.selectedIndex].value;
								var compbegin;
								var compend;
								var PublicTimeStartTimes = [];
								var temp; 
								//change this to use javascript instead of php...?
								{foreach from=$StartPeriods item=period}
									{if $period->IsReservable()}
										{assign var='selected' value=''}
										compbegin = BeginPeriodValue.localeCompare("{$period->Begin()}");
										compend = EndPeriodValue.localeCompare("{$period->End()}");
										if(compbegin != 1 && compend != -1){		//checking if the time is within the 
											PublicTimeStartTimes.push("{$period->Begin()}");
											{$BeginPeriodArray = ":"|explode:$period->Begin()}	{*explodes to 3, example: "13":"00":"00"*}
											{if strcmp($BeginPeriodArray[1],"00")==0} {**}
												{$BeginPeriodArray[1]="15"}
											{else}
												{$BeginPeriodArray[1]="45"}
											{/if}
											PublicTimeStartTimes.push("{$BeginPeriodArray[0]}:{$BeginPeriodArray[1]}:{$BeginPeriodArray[2]}");
											{if strcmp($BeginPeriodArray[1],"15")==0}
												{$BeginPeriodArray[1]="30"}
											{else}
												{$BeginPeriodArray[0]=$BeginPeriodArray[0]+1}
												{if $BeginPeriodArray[0]<10}
													{$BeginPeriodArray[0]="0`$BeginPeriodArray[0]`"}
												{/if}
												{$BeginPeriodArray[1]="00"}
											{/if}
											temp = "{$BeginPeriodArray[0]}:{$BeginPeriodArray[1]}:{$BeginPeriodArray[2]}";
										}
									{/if}
								{/foreach}
								if(type == 2){		//removing first and last elements from the ending times
											PublicTimeStartTimes.shift(); 				
											PublicTimeStartTimes.push(temp);
								}
								return PublicTimeStartTimes;
							}
							function pushPublicTimePeriods(PublicTimeStartString,type){
								if(type==1){
									document.getElementById("PublicTimeStart").innerHTML = ""+PublicTimeStartString+"";
								}else{
									document.getElementById("PublicTimeEnd").innerHTML = ""+PublicTimeStartString+"";
								}
							}
							{if isset($SeriesId)}
								{if isset($PublicStatus)}
									{if $PublicStatus['PublicStatus'] == 1}
										document.getElementById("IsPublicEvent").checked = true;
										createTimegenerator(1);
										createTimegenerator(2);
									{/if}
								{/if}
							{/if}
							
							//from this point onward there are alot of commented out code because
							//of the changed specifications required for the system.
		//listeners for menu's splitting selectors
		$('#ReservationTotalPrice').on('change', '#foodhalffirst', function() {		
			var value = parseInt($(this).val());
			var FoodCount = parseInt(35);//document.getElementById("ResourceFoodArrangementCountSelect[{$resource->GetId()}]").value);
			var lowerFoodCount=0;
			var myElemTwo = document.getElementById('foodhalfsecond');
			var errorTextFromOutside="";
			if (myElemTwo !== null){
				lowerFoodCount=parseInt(document.getElementById("foodhalfsecond").value);
			}
			/*if(FoodCount<1){
				FoodCount = 1;
			}else if(FoodCount>35){
				FoodCount = 35;
			}*/
			if((value+lowerFoodCount)>35){
				value=FoodCount-lowerFoodCount;
				errorTextFromOutside = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
				//document.getElementById("ReservationPriceError").innerHTML = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
			}
			if(value<0){
				value = 0;
			}else if(value>35){
				value = 35;
			}
			if(value==0&&lowerFoodCount==0){
				if (myElemTwo !== null){
					document.getElementById("foodhalffirst").value = 1;
				}else{
					value=1;
				}
				errorTextFromOutside = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
				//document.getElementById("ReservationPriceError").innerHTML = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
			}
			//var lowerFoodcount = FoodCount-value;
			//document.getElementById("foodhalfcounter-{$Conf['foodconf_id']}-1").innerHTML = " x"+value;
			//document.getElementById("foodhalfcounter-{$Conf['foodconf_id']}-2").innerHTML = " x"+lowerFoodcount;
			document.getElementById("foodhalffirst").value = value;
			//document.getElementById("foodhalfsecond{$Conf['foodconf_id']}").value = lowerFoodcount;
			
			calcTotalPrice(0,errorTextFromOutside);
		});			
		
		$('#ReservationTotalPrice').on('change', '#foodhalfsecond', function() {
			var value = parseInt($(this).val());
			var FoodCount = parseInt(35);//document.getElementById("ResourceFoodArrangementCountSelect[{$resource->GetId()}]").value);
			var higherFoodcount=parseInt(document.getElementById("foodhalffirst").value);
			var myElemThree = document.getElementById('foodhalfsecond');
			var errorTextFromOutside="";
			/*if(FoodCount<1){
				FoodCount = 1;
			}else if(FoodCount>35){
				FoodCount = 35;
			}*/
			if((value+higherFoodcount)>35){
				value=FoodCount-higherFoodcount;
				errorTextFromOutside = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
				//document.getElementById("ReservationPriceError").innerHTML = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
			}
			if(value<0){
				value = 0;
			}else if(value>35){
				value = 35;
			}
			if(value==0&&higherFoodcount==0){
				if (myElemThree !== null){
					document.getElementById("foodhalfsecond").value = 1;
				}else{
					value=1;
				}
				document.getElementById("foodhalfsecond").value = 1;
				errorTextFromOutside = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
				//document.getElementById("ReservationPriceError").innerHTML = "<font color='red'>{translate key="IsMinMaxAllowed"}</font>";
			}
			//var higherFoodcount = FoodCount-value;
			//document.getElementById("foodhalfcounter-{$Conf['foodconf_id']}-1").innerHTML = " x"+higherFoodcount;
			//document.getElementById("foodhalfcounter-{$Conf['foodconf_id']}-2").innerHTML = " x"+value;
			document.getElementById("foodhalfsecond").value = value;
			//document.getElementById("foodhalffirst{$Conf['foodconf_id']}").value = higherFoodcount;
			calcTotalPrice(0,errorTextFromOutside);
		});
		
	function calcTotalPrice(firsttime,errorTextFromOutside){
		
		var e = document.getElementById("ResourceArrangement[{$resource->GetId()}]");
		var value = e.options[e.selectedIndex].value;
		var e = document.getElementById("ResourceFoodArrangement[{$resource->GetId()}]");
		var FoodId = e.options[e.selectedIndex].value;
		
		var theDate = document.getElementById("formattedBeginDate").value;
		theDate = new Date(theDate);
		
		var endRepeat = document.getElementById("formattedEndRepeat").value;
		endRepeat = new Date(endRepeat);
		
		var e = document.getElementById("repeatInterval");
		var repeatInterval = e.options[e.selectedIndex].value;
			
		var e = document.getElementById("repeatOptions");
		var repeatOptions = e.options[e.selectedIndex].value;
		var dayCounter=1;
		var prices = [];
		var confnames = [];
		var foodnames = [];
		var foodprices = [];
		var fooddescs = [];
		var total=0;
		var weekendIncrease=0;
		var FoodCount=35; 
		var FoodCountTotal;
		var string; 
		var foodstring;
		var fooddescstring = [];
		var confstring = "";
		var weekendIncreaseString = "";
		var ErrorText = "";
		var repeatString = "";
		var FoodSplitFirst;
		var FoodSplitSecond;
		// WeekendIncStr contains what is added for every weekend if a menu order has been set
		// and the reservation contains a weekend
		var WeekendIncStr = "<div class='priceItemContainer'><label>{translate key="weekendAdditionalCost"}</label><p class='priceItemContainer'> 10 €</p></div>";
		var weeks=parseInt(moment(endRepeat).format('w'))-parseInt(moment(theDate).format('w'));
		/*console.log("Endrp:"+parseInt(moment(endRepeat).format('w')));
		console.log("Start:"+parseInt(moment(theDate).format('w')));
		console.log("weeks:"+weeks);
		console.log("repeatOptions:"+repeatOptions);
		console.log("repeatInterval:"+repeatInterval);*/
		if(repeatOptions.localeCompare("weekly")==0){
			weeks=weeks+1;
			if(weeks<1){
				weeks=1;
			}
			var repeatDays=0;
			var weeksPassed=1;
			for(b=0;b<weeks;b++){
				var weekStart=0;
				var weekEnd=7;
				if(b==0){
					weekStart=theDate.getDay();
				}
				if(b==weeks-1){
					weekEnd=endRepeat.getDay()+1;
				}
				for(i=weekStart;i<weekEnd;i++){
					var x = document.getElementById("repeatDay"+i).checked; 
					//x true if checked
					if(x&&weeksPassed%repeatInterval==0||x&&weeksPassed==1){
						repeatDays++;
						if(FoodId!=0){
							if(i==0||i==6){				
								weekendIncreaseString = weekendIncreaseString+WeekendIncStr;
								weekendIncrease=weekendIncrease+10;
							}
						}
					}
				}
				weeksPassed=weeksPassed+1;
			}
			dayCounter=repeatDays;
		}else if(repeatOptions.localeCompare("daily")==0){
			dayCounter=0;
			var repeatDays=0;
			var daysPassed=1;
			for(b=0;b<=weeks;b++){
				var weekStart=0;
				var weekEnd=6;
				if(b==0){
					//console.log("First week");
					weekStart=theDate.getDay();
				}
				if(b==weeks){
					//console.log("Last week");
					weekEnd=endRepeat.getDay();
				}
				/*console.log("Weekstart:"+weekStart);
				console.log("weekEnd:"+weekEnd);*/
				for(i=weekStart;i<=weekEnd;i++){
					if((daysPassed-1)%repeatInterval==0||daysPassed==1||repeatInterval==1){
						repeatDays++;
						/*console.log("daysPassed:"+daysPassed);
						console.log("repeatDays:"+repeatDays);*/
						if(FoodId!=0){
							if(i==0||i==6){				
								weekendIncreaseString = weekendIncreaseString+WeekendIncStr;
								weekendIncrease=weekendIncrease+10;
							}
						}
					}
					daysPassed=daysPassed+1;
				}
			}
			dayCounter=repeatDays;
		}
		
			//console.log("dayCounter:"+dayCounter);
	
		if(FoodId!=0){ //get the selected food conf's ID
			//var e = document.getElementById("ResourceFoodArrangementCountSelect[{$resource->GetId()}]");
			FoodCount = parseInt(35);//document.getElementById("ResourceFoodArrangementCountSelect[{$resource->GetId()}]").value);
			if(repeatOptions.localeCompare("none")==0){
				if(theDate.getDay() == 6 || theDate.getDay() == 0){
					weekendIncreaseString = WeekendIncStr;
					weekendIncrease=10;
				}
			}
		}else{	
			FoodCount = 35;
			FoodId = 0;
			foodprices[0] = 0;
			fooddescstring[0] = 0;
		}
		/*
		if(FoodCount<1){
			ErrorText = "1 {translate key="IsMinAllowed"}<br/>";
			FoodCount = 1;
		}else if(FoodCount>35){
			ErrorText = "35 {translate key="IsMaxAllowed"}<br/>";
			FoodCount = 35;
		}else{
			ErrorText="";
		}*/
		//generated with a php foreach loop from smarty variables
		{foreach from=$ResourceConfs item=Conf}
			confnames[{$Conf['conf_id']}] = "{$Conf['name']}";
			prices[{$Conf['conf_id']}] = parseFloat("{$Conf['price']}");
		{/foreach}
		//generated with a php foreach loop from smarty variables
		{foreach from=$ResourceFoodConfs item=Conf}
			var temporaryFoodString="";
			var addedBR = "";
			FoodCount=35;
			foodnames[{$Conf['foodconf_id']}] = "{$Conf['name']}";
			{$contentlist = "\n"|explode:$Conf['contentlist']}
			temporaryFoodString="";
			{$previousfood=""}
			{if count($contentlist)==1}
				{$content=$contentlist[0]}
				{$content = preg_replace( "/\r|\n/", "", $content )}{*removes linebreaks*}
				temporaryFoodString=temporaryFoodString+"<div class='priceItemContainer'>{$content}";
				temporaryFoodString=temporaryFoodString+"";
				var FirstSplit={if isset($PublicStatus['FoodSplitFirst'])}{$PublicStatus['FoodSplitFirst']}{else}1{/if};
				
				var myElem = document.getElementById('foodhalffirst');
				if (myElem !== null){
						FirstSplit=document.getElementById("foodhalffirst").value;
				}
				if(FirstSplit>FoodCount){ //Don't allow them to exceed FoodCount (35)
					FirstSplit=FoodCount;
				}
				temporaryFoodString=temporaryFoodString+"<p class='priceItemContainer'><input class='form-control inline-block foodSplit' type='number' id='foodhalffirst' name='foodhalffirst{$Conf['foodconf_id']}' max='"+FoodCount+"' min='0' value="+FirstSplit+"> kpl</p></div>";
				temporaryFoodString=temporaryFoodString+"<br/>";
			{else}
				{foreach from=$contentlist item=content}
					var addedBR = "";
					{$content = preg_replace( "/\r|\n/", "", $content )}{*removes linebreaks*}
					{if strcmp($content,'tai')!==0}
						temporaryFoodString=temporaryFoodString+"<div class='priceItemContainer'>{$content}";
						{$previousnextfood=""}
						{foreach from=$contentlist item=nextcontent}
						
							if(firsttime==1){
								{if isset($PublicStatus['FoodSplitFirst'])}
									FoodSplitFirst=parseInt({$PublicStatus['FoodSplitFirst']});
								{/if}
								{if isset($PublicStatus['FoodSplitSecond'])}
									FoodSplitSecond=parseInt({$PublicStatus['FoodSplitSecond']});
								{/if}
							}
							{$nextcontent = preg_replace( "/\r|\n/", "", $nextcontent )}{*removes linebreaks*}						
							{if strcmp($nextcontent,'tai')==0&&strcmp($content,$previousnextfood)==0}
								var FirstSplit={if isset($PublicStatus['FoodSplitFirst'])}{$PublicStatus['FoodSplitFirst']}{else}1{/if};
			

								var myElem = document.getElementById('foodhalffirst');
								if (myElem !== null){
									FirstSplit=document.getElementById("foodhalffirst").value;
								}
								if(FirstSplit>FoodCount){
									FirstSplit=FoodCount;
								}
									var zerocheck=0;
									{if isset($PublicStatus['FoodSplitFirst'])}
										zerocheck=parseInt(zerocheck)+parseInt({$PublicStatus['FoodSplitFirst']});
									{/if}
									{if isset($PublicStatus['FoodSplitSecond'])}
										zerocheck=parseInt(zerocheck)+parseInt({$PublicStatus['FoodSplitSecond']});
									{/if}
									
									var myElem = document.getElementById('foodhalfsecond');
									if (myElem !== null){
										zerocheck=zerocheck+document.getElementById("foodhalfsecond").value;
									}
									if(parseInt(FirstSplit)==0&&zerocheck==0){
										FirstSplit=1;
									}
								temporaryFoodString=temporaryFoodString+" ";
								temporaryFoodString=temporaryFoodString+"<p class='priceItemContainer'><input class='form-control inline-block foodSplit' type='number' id='foodhalffirst' name='foodhalffirst{$Conf['foodconf_id']}' max='"+FoodCount+"' min='0' value="+FirstSplit+"> kpl</p>";
								addedBR="<br/>";
							{/if}
							{$previousnextfood=$nextcontent}
						{/foreach}
						{if strcmp($previousfood,'tai')==0}
								var SecondSplit=0;
								if(firsttime==1){
									SecondSplit={if isset($PublicStatus['FoodSplitSecond'])}{$PublicStatus['FoodSplitSecond']}{else}0{/if};
								}
								if(SecondSplit>FoodCount){
									SecondSplit=FoodCount;
								}
								var myElemTwo = document.getElementById('foodhalfsecond');
								if (myElemTwo !== null){
									SecondSplit=document.getElementById("foodhalfsecond").value;
								}
								temporaryFoodString=temporaryFoodString+"";
								temporaryFoodString=temporaryFoodString+"<p class='priceItemContainer'><input class='form-control inline-block foodSplit' type='number' id='foodhalfsecond' name='foodhalfsecond{$Conf['foodconf_id']}' max='"+FoodCount+"' min='0' value="+SecondSplit+"> kpl</p>";
						{/if}
					{else}
					{/if}
					temporaryFoodString=temporaryFoodString+"</div>"+addedBR;
					{$previousfood=$content}
				{/foreach}
				
					FoodCountTotal=parseInt(SecondSplit)+parseInt(FirstSplit);
			{/if}
			fooddescstring[{$Conf['foodconf_id']}]=temporaryFoodString+errorTextFromOutside;
			{$foodtemp = preg_replace( "/\r|\n/", "", $foodtemp )}{*removes linebreaks so javascript understands it*}
			foodprices[{$Conf['foodconf_id']}] = parseFloat("{$Conf['price']}");
		{/foreach}
		
		
		var myElem = document.getElementById('foodhalffirst');
		if (myElem !== null){
			FirstSplit=document.getElementById("foodhalffirst").value;
		}
		FoodCountTotal=parseInt(SecondSplit)+parseInt(FirstSplit);
		total=foodprices[FoodId]*FoodCountTotal;
		if(foodnames[FoodId] == null){
			foodstring = "";
		}else{
			foodstring=fooddescstring[FoodId]+"<br/><div class='priceItemContainer'><label><input class='form-control inline-block' type=hidden name='ResourceFoodArrangementCountSelect[{$resource->GetId()}]' value='"+FoodCountTotal+"'>"+FoodCountTotal+"x "+foodnames[FoodId]+" - "+foodprices[FoodId]+" €/{translate key='peopleShort'}</label><p class='priceItemContainer'>"+total.toFixed(2)+" €</p></div>";
			var temp=total*0.14;
			total=total+temp; //adding price of food
			foodstring=foodstring+"<div class='priceItemContainer'><label class='priceItemContainer'>14% alv</label><p class='priceItemContainer'> "+temp.toFixed(2)+" €</p></div>";
		}
		confstring="<br/><div class='priceItemContainer'><label>{translate key="ResourceConfiguration"}:</label>"+confnames[value]+"<p class='priceItemContainer'>"+prices[value].toFixed(2)+" €</p></div>";
		total=total+prices[value]; //adding price of roomconf
		if(dayCounter>1){
			repeatString="<div class='priceItemContainer'><label>Päiväkerroin</label><p class='priceItemContainer'>"+dayCounter+"</p></div>";
		}
		total=total*dayCounter;		//multiplying by days
		total=total+weekendIncrease; //adding weekend increases
		if(total>0){
			document.getElementById("ReservationBillingInfo").classList.remove('hidden');
			document.getElementById("MenuOrderInfo").classList.remove('hidden');
		}else{
			document.getElementById("ReservationBillingInfo").classList.add('hidden');
			document.getElementById("MenuOrderInfo").classList.add('hidden');
		}
		document.getElementById("ReservationTotalPrice").innerHTML = ErrorText+"<div id='ErrorTextPricing'></div>"+foodstring+weekendIncreaseString+confstring+repeatString+"<br/><hr class='pricetag'><div class='priceItemContainer'><p class='priceItemContainer'>{translate key="Total"} "+total.toFixed(2)+" €</p></div><input type='hidden' name='dayCounter' value='"+dayCounter+"'/>";
	}
	
							var e = document.getElementById("ResourceArrangement[{$resource->GetId()}]");
									var value = e.options[e.selectedIndex].value;
									var text = e.options[e.selectedIndex].text;
									var test = [];
									{foreach from=$ResourceConfs item=Conf}
										{$furniturelist = "\n"|explode:$Conf['furniturelist']}
										{if isset($Conf['furniturelist'])}
											{$temp="<ul>"}
											{foreach from=$furniturelist item=furniture}
												{$temp="`$temp`<li>`$furniture`</li>"}
											{/foreach}
											{$temp="`$temp`</ul>"}
											{$temp = preg_replace( "/\r|\n/", "", $temp )}
										{/if}

										test[{$Conf['conf_id']}] = "{$temp}";
									{/foreach}
									document.getElementById("selectedResourceConfImage").innerHTML = "<img class='ResourceConfBig' src='../uploads/arrangements/"+value+".png' alt='"+text+"'>";
									document.getElementById("selectedResourceConfFurni").innerHTML = ""+test[value]+"";
									document.getElementById("selectedResourceConfName").innerHTML = "{translate key="ResourceConfiguration"}: "+text+"";

	produceDateError();
</script>
<div id="testingthings"></div>
{include file='globalfooter.tpl'}
