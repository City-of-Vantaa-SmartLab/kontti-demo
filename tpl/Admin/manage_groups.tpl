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
{include file='globalheader.tpl'}

<div id="page-manage-groups" class="admin-page">
	<h1>{translate key=ManageGroups}</h1>

	<form id="addGroupForm" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-group-panel">
			<div class="panel-heading">{translate key="AddGroup"} {showhide_icon}</div>
			<div class="panel-body add-contents">
				<div id="addGroupResults" class="error" style="display:none;"></div>
				<div class="form-group has-feedback">
					<label for="addGroupName">{translate key=Name}</label>
					<input {formname key=GROUP_NAME} type="text" id="addGroupName" required class="form-control required"/>
					<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="addGroupName"></i>
				</div>
			</div>
			<div class="panel-footer">
				{add_button class="btn-sm"}
				{reset_button class="btn-sm"}
				{indicator}
			</div>
		</div>
	</form>

	<div id="groupSearchPanel">
		<label for="groupSearch">{translate key='FindGroup'}</label> |  {html_link href=$smarty.server.SCRIPT_NAME key=AllGroups}
		<input type="text" id="groupSearch" class="form-control" size="40"/>
	</div>

	<table class="table" id="groupList">
		<thead>
		<tr>
			<th>{sort_column key=GroupName field=ColumnNames::GROUP_NAME}</th>
			<th>{translate key='GroupMembers'}</th>
			<th>{translate key='Permissions'}</th>
			{if $CanChangeRoles}
				<th>{translate key='GroupRoles'}</th>
			{/if}
			<th>{translate key='GroupAdmin'}</th>
			<th class="action">{translate key='Actions'}</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$groups item=group}
			{cycle values='row0,row1' assign=rowCss}
			<tr class="{$rowCss}" data-group-id="{$group->Id}">
				<td>{$group->Name}</td>
				<td><a href="#" class="update members">{translate key='Manage'}</a></td>
				<td><a href="#" class="update permissions">{translate key='Change'}</a></td>
				{if $CanChangeRoles}
					<td><a href="#" class="update roles">{translate key='Change'}</a></td>
				{/if}
				<td><a href="#" class="update groupAdmin">{$group->AdminGroupName|default:$chooseText}</a></td>
				<td class="action">
					<a href="#" class="update rename"><span class="fa fa-pencil-square-o icon"></a> |
					<a href="#" class="update delete"><span class="fa fa-trash icon remove"></span></a>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

	{pagination pageInfo=$PageInfo}

	<input type="hidden" id="activeId"/>

	<div class="modal fade" id="membersDialog" tabindex="-1" role="dialog" aria-labelledby="membersDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="membersDialogLabel">{translate key=GroupMembers}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="userSearch">{translate key=AddUser}: <a href="#" id="browseUsers">{translate key=Browse}</a></label>
						<input type="text" id="userSearch" class="form-control" size="40"/>
					</div>
					<h4><span id="totalUsers"></span> {translate key=UsersInGroup}</h4>

					<div id="groupUserList"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default cancel" data-dismiss="modal">{translate key='Done'}</button>
				</div>
			</div>
		</div>
	</div>

	<div id="allUsers" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="browseUsersDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="browseUsersDialogLabel">{translate key=AllUsers}</h4>
				</div>
				<div class="modal-body">
					<div id="allUsersList"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="permissionsDialog" tabindex="-1" role="dialog" aria-labelledby="permissionsDialogLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form id="permissionsForm" method="post">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="permissionsDialogLabel">{translate key=Permissions}</h4>
						</div>
						<div class="modal-body">
                            {translate key=Select}
                            <a href="#" id="checkAllResources">{translate key=All}</a> |
                            <a href="#" id="checkNoResources">{translate key=None}</a>
                            {foreach from=$resources item=resource}
								<div class="checkbox">
									<input id="resource{$resource->GetResourceId()}" {formname key=RESOURCE_ID  multi=true} class="form-control resourceId" type="checkbox" value="{$resource->GetResourceId()}">
									<label for="resource{$resource->GetResourceId()}">{$resource->GetName()} </label>
								</div>
							{/foreach}
						</div>
						<div class="modal-footer">
							{cancel_button}
							{update_button}
							{indicator}
						</div>
					</div>
				</form>
			</div>
		</div>

	<form id="removeUserForm" method="post">
		<input type="hidden" id="removeUserId" {formname key=USER_ID} />
	</form>

	<form id="addUserForm" method="post">
		<input type="hidden" id="addUserId" {formname key=USER_ID} />
	</form>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteGroupForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteDialogLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							<div>{translate key=DeleteWarning}</div>
							<div>{translate key=DeleteGroupWarning}</div>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{delete_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="renameDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="renameGroupForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteDialogLabel">{translate key=Rename}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label for="groupName">{translate key=Name}</label>
							<input type="text" id="groupName" class="form-control required" required {formname key=GROUP_NAME} />
							<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="groupName"></i>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	{if $CanChangeRoles}
		<div class="modal fade" id="rolesDialog" tabindex="-1" role="dialog" aria-labelledby="rolesDialogLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form id="rolesForm" method="post">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="rolesDialogLabel">{translate key=WhatRolesApplyToThisGroup}</h4>
						</div>
						<div class="modal-body">
							{foreach from=$Roles item=role}
								<div class="checkbox">
									<input type="checkbox" id="role{$role->Id}" {formname key=ROLE_ID multi=true}" value="{$role->Id}" />
									<label for="role{$role->Id}">{$role->Name}</label>
								</div>
							{/foreach}
						</div>
						<div class="modal-footer">
							{cancel_button}
							{update_button}
							{indicator}
						</div>
					</div>
				</form>
			</div>
		</div>
	{/if}

	<div class="modal fade" id="groupAdminDialog" tabindex="-1" role="dialog" aria-labelledby="groupAdminDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="groupAdminForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="groupAdminDialogLabel">{translate key=WhoCanManageThisGroup}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label for="groupAdmin" class="off-screen">{translate key=WhoCanManageThisGroup}</label>
							<select {formname key=GROUP_ADMIN} class="form-control" id="groupAdmin">
								<option value="">-- {translate key=None} --</option>
								{foreach from=$AdminGroups item=adminGroup}
									<option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	{csrf_token}

	{jsfile src="ajax-helpers.js"}
	{jsfile src="autocomplete.js"}
	{jsfile src="admin/group.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">
		$(document).ready(function () {

			var actions = {
				activate: '{ManageGroupsActions::Activate}',
				deactivate: '{ManageGroupsActions::Deactivate}',
				permissions: '{ManageGroupsActions::Permissions}',
				password: '{ManageGroupsActions::Password}',
				removeUser: '{ManageGroupsActions::RemoveUser}',
				addUser: '{ManageGroupsActions::AddUser}',
				addGroup: '{ManageGroupsActions::AddGroup}',
				renameGroup: '{ManageGroupsActions::RenameGroup}',
				deleteGroup: '{ManageGroupsActions::DeleteGroup}',
				roles: '{ManageGroupsActions::Roles}',
				groupAdmin: '{ManageGroupsActions::GroupAdmin}'
			};

			var dataRequests = {
				permissions: 'permissions',
				roles: 'roles',
				groupMembers: 'groupMembers'
			};

			var groupOptions = {
				userAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::User}",
				groupAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::Group}",
				groupsUrl: "{$smarty.server.SCRIPT_NAME}",
				permissionsUrl: '{$smarty.server.SCRIPT_NAME}',
				rolesUrl: '{$smarty.server.SCRIPT_NAME}',
				submitUrl: '{$smarty.server.SCRIPT_NAME}',
				saveRedirect: '{$smarty.server.SCRIPT_NAME}',
				selectGroupUrl: '{$smarty.server.SCRIPT_NAME}?gid=',
				actions: actions,
				dataRequests: dataRequests
			};

			var groupManagement = new GroupManagement(groupOptions);
			groupManagement.init();

			$('#add-group-panel').showHidePanel();
		});
	</script>
</div>
{include file='globalfooter.tpl'}
