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
{include file='globalheader.tpl' Validator=true}
<div class="page-profile">
	<div id="profile-box" class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

		<form method="post" action="billinginformation/update_billinginformation.php">

			<h1>{translate key="EditBillingInformation"}</h1>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label>{translate key="compname"}</label><br/>
							<input class="form-control" id="compname" name="compname" type="text" value="{$compname}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label>{translate key="personid"}</label><br/>
							<input class="form-control" id="personid" name="personid" type="text" value="{$personid}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label>{translate key="billingaddress"}</label><br/>
							<input class="form-control" id="billingaddress" name="billingaddress" type="text" value="{$billingaddress}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label>{translate key="reference"}</label><br/>
							<input class="form-control" id="reference" name="reference" type="text" value="{$reference}">
					</div>
				</div>
			</div>
			<div>
				<input type="hidden" name="additionalinfo" value="{$additionalInfo}">
				<input type="submit" value="{translate key="Save"}">
			</div>
		</form>
	</div>
</div>
{include file='globalfooter.tpl'}