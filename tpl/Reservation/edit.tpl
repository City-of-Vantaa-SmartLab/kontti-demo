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

{extends file="Reservation/create.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs='' Qtip=true printCssFiles='css/reservation.print.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=''}
{/block}

{block name=submitButtons}
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			{translate key=More} <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li>
				{assign var=icsUrl value="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
				<a href="{$icsUrl}" download="{$icsUrl}">
					<span class="fa fa-calendar"></span>
					{translate key=AddToOutlook}</a>
			</li>
			<li>
				<a href="#" class="btnPrint">
					<span class="fa fa-print"></span>
					{translate key='Print'}</a>
			</li>
			<li>
				<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::SOURCE_REFERENCE_NUMBER}={$ReferenceNumber}&{QueryStringKeys::REDIRECT}={$ReturnUrl|urlencode}">
					<span class="fa fa-copy"></span>
					{translate key='DuplicateReservation'}</a>
			</li>

			<li class="divider"></li>
			<li>
			{if $IsRecurring}
			    <a href="#" class="delete prompt">
					<span class="fa fa-remove remove icon"></span>
					{translate key='Delete'}
				</a>
            {else}
				<a href="#" class="triggerDeletePrompt delete prompt-single">
                    <span class="fa fa-remove remove icon"></span>
                    {translate key='Delete'}
                </a>
			{/if}
			</li>
		</ul>
	</div>

	{if $CheckInRequired}
		<button type="button" class="btn btn-warning btnCheckin"><i class="fa fa-sign-in"></i> {translate key=CheckIn}<span class="autoReleaseButtonMessage" data-autorelease-minutes="{$AutoReleaseMinutes}"> - {translate key=ReleasedIn} <span class="autoReleaseMinutes"></span> {translate key=minutes}</span></button>
	{/if}
	{if $CheckOutRequired}
		<button type="button" class="btn btn-warning btnCheckout"><i class="fa fa-sign-out"></i> {translate key=CheckOut}</button>
	{/if}
	{if $IsRecurring}
		<button type="button" class="btn btn-success update prompt">
			<span class="glyphicon glyphicon-ok-circle"></span>
			{translate key='Update'}
		</button>
		<div class="modal fade" id="updateButtons" tabindex="-1" role="dialog" aria-labelledby="updateButtonsLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="updateButtonsLabel">{translate key=ApplyUpdatesTo}</h4>
					</div>
					<div class="modal-body">
						<button type="button" class="btn btn-success save btnUpdateThisInstance">
							<span class="fa fa-check"></span>
							{translate key='ThisInstance'}
						</button>
						<button type="button" class="btn btn-success save btnUpdateAllInstances">
							<span class="fa fa-check-square"></span>
							{translate key='AllInstances'}
						</button>
						<button type="button" class="btn btn-success save btnUpdateFutureInstances">
							<span class="fa fa-check-square-o"></span>
							{translate key='FutureInstances'}
						</button>
						<button type="button" class="btn btn-default">
							{translate key='Cancel'}
						</button>
					</div>
				</div>
			</div>
		</div>
	{else}
		<button type="button" class="btn btn-success save update btnCreate">
			<span class="glyphicon glyphicon-ok-circle"></span>
			{translate key='Update'}
		</button>
	{/if}
    <div id="deleteButtonPrompt" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="updateButtonsLabel">{translate key=Delete}</h4>
                </div>
                <div class="modal-body">
                    <div>{translate key=DeleteReminderWarning}</div>
                 </div>
                <div class="modal-footer">
                {cancel_button id="cancelDelete" class="cancel"}
                {delete_button id="confirmDelete" class="delete save"}
               </div>
            </div>
        </div>
    </div>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...
{/block}

{block name='attachments'}
	{if $Attachments|count > 0}
		<div class="col-xs-12">
		<div id="attachmentDiv" class="res-attachments">
			<span class="heading">{translate key=Attachments} ({$Attachments|count})</span>
			<a href="#" class="remove" id="btnRemoveAttachment">({translate key="Remove"})</a>
			<br/>
			{foreach from=$Attachments item=attachment}
				{assign var=attachmentUrl value="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
				<a href="{$attachmentUrl}" download="{$attachmentUrl}"
				   target="_blank">{$attachment->FileName()}</a>
				&nbsp;
				<input style='display: none;' type="checkbox" name="{FormKeys::REMOVED_FILE_IDS}[{$attachment->FileId()}]"/>
				&nbsp;
			{/foreach}
		</div>
		</div>
	{/if}
{/block}

{if $AutoReleaseMinutes != null}
    <input type="hidden" id="autoReleaseMinutes" value="{$AutoReleaseMinutes}"/>
{/if}