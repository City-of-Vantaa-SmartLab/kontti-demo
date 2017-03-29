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


{extends file="Schedule/{$ExtendViewPrefix}schedule.tpl"}

{block name="legend"}{/block}

{block name="reservations"}

{function name=displayGeneralReservedMobile}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
	{if $Slot->HasCustomColor()}
		{assign var=color value='style="background-color:'|cat:$Slot->Color()|cat:';color:'|cat:$Slot->TextColor()|cat:';"'}
	{/if}
	<div class="reserved {$class} {$OwnershipClass} clickres"
		resid="{$Slot->Id()}" {$color}
		id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}"><i class="fa fa-info-circle"></i>
		{formatdate date=$Slot->BeginDate() key=period_time} - {formatdate date=$Slot->EndDate() key=period_time}
		{$Slot->Label($SlotLabelFactory)|escapequotes}</div>
{/function}

{function name=displayMyReservedMobile}
	{call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='mine'}
{/function}

{function name=displayMyParticipatingMobile}
	{call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='participating'}
{/function}

{function name=displayReservedMobile}
	{call name=displayGeneralReservedMobile Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass=''}
{/function}

{function name=displayPastTimeMobile}
	&nbsp;
{/function}

{function name=displayReservableMobile}
	&nbsp;
{/function}

{function name=displayRestrictedMobile}
	&nbsp;
{/function}

{function name=displayUnreservableMobile}
	&nbsp;
{/function}

{function name=displaySlotMobile}
	{call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed, 'Mobile') Slot=$Slot Href=$Href SlotRef=$SlotRef}
{/function}

	{assign var=TodaysDate value=Date::Now()}
	<table class="reservations mobile" border="1" cellpadding="0" style="width:100%;">

		{foreach from=$BoundDates item=date}
			{assign var=ts value=$date->Timestamp()}
			{$periods.$ts = $DailyLayout->GetPeriods($date)}
			{if $periods[$ts]|count == 0}{continue}{*dont show if there are no slots*}{/if}
			<tr>
				{assign var=class value=""}
				{if $TodaysDate->DateEquals($date) eq true}
					{assign var=class value="today"}
				{/if}
				<td class="resdate {$class}" colspan="2">{formatdate date=$date key="schedule_daily"}</td>
			</tr>
			{foreach from=$Resources item=resource name=resource_loop}
				<tr>
					{assign var=resourceId value=$resource->Id}
					{assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}"}

					<td class="resourcename" {if $resource->HasColor()}style="background-color:{$resource->GetColor()}"{/if}>
						{if $resource->CanAccess}
							<i resourceId="{$resourceId}" class="resourceNameSelector fa fa-info-circle" {if $resource->HasColor()}style="color:{$resource->GetTextColor()}"{/if}></i>
							<a href="{$href}" resourceId="{$resourceId}" {if $resource->HasColor()}style="color:{$resource->GetTextColor()}"{/if}>{$resource->Name}</a>
						{else}
							<i resourceId="{$resourceId}" class="resourceNameSelector fa fa-info-circle" {if $resource->HasColor()}style="color:{$resource->GetTextColor()}"{/if}></i>
							<span {if $resource->HasColor()}style="color:{$resource->GetTextColor()}"{/if}>{$resource->Name}</span>
						{/if}
					</td>

					{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
					{assign var=summary value=$DailyLayout->GetSummary($date, $resourceId)}
					{if $summary->NumberOfReservations() > 0}
						<td class="slot">
							{foreach from=$slots item=slot}
								{call name=displaySlotMobile Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef}
							{/foreach}
						</td>
					{else}
						{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
						<td class="reservable clickres slot" data-href="{$href}">
							&nbsp;
							<input type="hidden" class="href" value="{$href}"/>
						</td>
					{/if}
				</tr>
			{/foreach}
		{/foreach}
	</table>
{/block}