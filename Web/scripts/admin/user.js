function UserManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),
		userList: $('#userList'),

		userAutocomplete: $('#userSearch'),
		filterStatusId: $('#filterStatusId'),

		permissionsDialog: $('#permissionsDialog'),
		passwordDialog: $('#passwordDialog'),

		attributeForm: $('.attributesForm'),

		permissionsForm: $('#permissionsForm'),
		passwordForm: $('#passwordForm'),

		userDialog: $('#userDialog'),
		userForm: $('#userForm'),

		groupsDialog: $('#groupsDialog'),
		addedGroups: $('#addedGroups'),
		removedGroups: $('#removedGroups'),
		groupList: $('#groupList'),
		addGroupForm: $('#addGroupForm'),
		removeGroupForm: $('#removeGroupForm'),
        groupCount: $('#groupCount'),

		colorDialog: $('#colorDialog'),
		colorValue: $('#reservationColor'),
		colorForm: $('#colorForm'),

		addUserForm: $('#addUserForm'),

		importUsersForm: $('#importUsersForm'),
		importUsersDialog: $('#importUsersDialog'),

		deleteDialog: $('#deleteDialog'),
		deleteUserForm: $('#deleteUserForm'),

		addDialog: $('#addUserDialog'),

		invitationDialog: $('#invitationDialog'),
		invitationForm: $('#invitationForm'),
		inviteEmails: $('#inviteEmails'),

        checkAllResources: $('#checkAllResources'),
        checkNoResources: $('#checkNoResources')
	};

	var users = {};

	UserManagement.prototype.init = function () {
		elements.userList.delegate('.update', 'click', function (e) {
			setActiveUserElement($(this));
			e.preventDefault();
		});

		elements.userList.delegate('.changeStatus', 'click', function (e) {
			changeStatus($(this));
		});

		elements.userList.delegate('.changeGroups', 'click', function (e) {
			changeGroups();
		});

		elements.userList.delegate('.changePermissions', 'click', function (e) {
			changePermissions();
		});

		elements.userList.delegate('.resetPassword', 'click', function (e) {
			elements.passwordDialog.find(':password').val('');
			elements.passwordDialog.modal('show');
		});

		elements.userList.delegate('.changeColor', 'click', function (e) {
			var user = getActiveUser();
			elements.colorValue.val(user.reservationColor);
			elements.colorDialog.modal('show');
		});

		elements.userList.delegate('.edit', 'click', function () {
			changeUserInfo();
		});

		elements.userList.delegate('.delete', 'click', function (e) {
			deleteUser();
		});

		elements.userList.delegate('.viewReservations', 'click', function (e) {
			var user = getActiveUser();
			var name = encodeURI(user.first + ' ' + user.last);
			var url = options.manageReservationsUrl + '?uid=' + user.id + '&un=' + name;
			window.location.href = url;
		});

		elements.userList.delegate('.changeAttribute', 'click', function (e) {
			//e.preventDefault();
			e.stopPropagation();
			$(e.target).closest('.updateCustomAttribute').find('.inlineAttribute').editable('toggle');
		});

		elements.userList.find('.changeCredits').click(function (e) {
			e.stopPropagation();
			$(this).editable('toggle');
		});

		elements.userAutocomplete.userAutoComplete(options.userAutocompleteUrl, function (ui) {
			elements.userAutocomplete.val(ui.item.label);
			window.location.href = options.selectUserUrl + ui.item.value
		});

		elements.filterStatusId.change(function () {
			var statusid = $(this).val();
			window.location.href = options.filterUrl + statusid;
		});

		elements.addedGroups.delegate('div', 'click', function (e) {
			e.preventDefault();
			$('#removeGroupId').val($(this).attr('groupId'));
			$('#removeGroupUserId').val(getActiveUserId());
			elements.removeGroupForm.submit();

            var count = elements.groupCount.text();
            elements.groupCount.text(--count);

            $(this).appendTo(elements.removedGroups);
		});

		elements.removedGroups.delegate('div', 'click', function (e) {
			e.preventDefault();
			$('#addGroupId').val($(this).attr('groupId'));
			$('#addGroupUserId').val(getActiveUserId());
			elements.addGroupForm.submit();

            var count = elements.groupCount.text();
            elements.groupCount.text(++count);

			$(this).appendTo(elements.addedGroups);
		});

        elements.checkAllResources.click(function(e){
            e.preventDefault();
            elements.permissionsDialog.find('input:checkbox').prop('checked', true);
        });

        elements.checkNoResources.click(function(e){
            e.preventDefault();
            elements.permissionsDialog.find('input:checkbox').prop('checked', false);
        });

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		$('.clearform').click(function () {
			$(this).closest('form')[0].reset();
		});

		$('#add-user').click(function (e) {
			e.preventDefault();
			elements.addDialog.modal('show');
		});

		$('#invite-users').click(function (e) {
			e.preventDefault();
			elements.invitationDialog.modal('show');
		});

		$('#import-users').click(function (e) {
			e.preventDefault();
            $('#importErrors').empty().addClass('no-show');
			elements.importUsersDialog.modal('show');
		});

		var hidePermissionsDialog = function () {
			hideDialog(elements.permissionsDialog);
		};

		var hidePasswordDialog = function () {
			hideDialog(elements.passwordDialog);
		};

		var hideDialog = function (dialogElement) {
			dialogElement.modal('hide');
		};

		var hideDialogCallback = function (dialogElement) {
			return function () {
				hideDialog(dialogElement);
				window.location.reload();
			}
		};

		var error = function (errorText) {
			alert(errorText);
		};

		var importHandler = function (responseText, form) {
			if (!responseText)
			{
				return;
			}

			$('#importCount').text(responseText.importCount);
			$('#importSkipped').text(responseText.skippedRows.length > 0 ? responseText.skippedRows.join(',') : '0');
			$('#importResult').removeClass('no-show');

			var errors = $('#importErrors');
			errors.empty();
			if (responseText.messages && responseText.messages.length > 0)
			{
				var messages = responseText.messages.join('</li><li>');
				errors.html('<div>' + messages + '</div>').removeClass('no-show');
			}
		};

		var inviteHandler = function(responseText, form) {
			elements.inviteEmails.val('');
			elements.invitationDialog.modal('hide');
		};

		ConfigureAsyncForm(elements.permissionsForm, defaultSubmitCallback(elements.permissionsForm), hidePermissionsDialog, error);
		ConfigureAsyncForm(elements.passwordForm, defaultSubmitCallback(elements.passwordForm), hidePasswordDialog, error);
		ConfigureAsyncForm(elements.userForm, defaultSubmitCallback(elements.userForm), hideDialogCallback(elements.userDialog));
		ConfigureAsyncForm(elements.deleteUserForm, defaultSubmitCallback(elements.deleteUserForm), hideDialogCallback(elements.deleteDialog), error);
		ConfigureAsyncForm(elements.addUserForm, defaultSubmitCallback(elements.addUserForm), hideDialogCallback(elements.addDialog));
		ConfigureAsyncForm(elements.colorForm, defaultSubmitCallback(elements.colorForm));
		ConfigureAsyncForm(elements.importUsersForm, defaultSubmitCallback(elements.importUsersForm), importHandler);
		ConfigureAsyncForm(elements.addGroupForm, changeGroupUrlCallback(elements.addGroupForm), function(){});
		ConfigureAsyncForm(elements.removeGroupForm, changeGroupUrlCallback(elements.removeGroupForm), function(){});
		ConfigureAsyncForm(elements.invitationForm, defaultSubmitCallback(elements.invitationForm), inviteHandler);
	};

	UserManagement.prototype.addUser = function (user) {
		users[user.id] = user;
	};

	var getSubmitCallback = function (action) {
		return function () {
			return options.submitUrl + "?uid=" + getActiveUserId() + "&action=" + action;
		};
	};

	var defaultSubmitCallback = function (form) {
		return function () {
			return options.submitUrl + "?action=" + form.attr('ajaxAction') + '&uid=' + getActiveUserId();
		};
	};

	var changeGroupUrlCallback = function (form) {
		return function () {
			return options.groupManagementUrl + "?action=" + form.attr('ajaxAction') + '&uid=' + getActiveUserId();
		};
	};

	function setActiveUserElement(activeElement) {
		var id = activeElement.closest('tr').attr('data-userId');
		setActiveUserId(id);
	}

	function setActiveUserId(id) {
		elements.activeId.val(id);
	}

	function getActiveUserId() {
		return elements.activeId.val();
	}

	function getActiveUser() {
		return users[getActiveUserId()];
	}

	var changeStatus = function (statusButtonElement) {
		var user = getActiveUser();

		function changeStatusResultCallback(resultStatusText) {
			user.isActive = !user.isActive;
			elements.userList.find('[data-userId="' + user.id + '"]').find('.changeStatus').text(resultStatusText);
		}

		if (user.isActive)
		{
			PerformAsyncAction(statusButtonElement, getSubmitCallback(options.actions.deactivate), $('#userStatusIndicator'), changeStatusResultCallback);
		}
		else
		{
			PerformAsyncAction(statusButtonElement, getSubmitCallback(options.actions.activate), $('#userStatusIndicator'), changeStatusResultCallback);
		}
	};

	var changeGroups = function () {
		elements.addedGroups.find('.group-item').remove();
		elements.removedGroups.find('.group-item').remove();

		var user = getActiveUser();
		var data = {dr: 'groups', uid: user.id};
		$.get(opts.groupsUrl, data, function (groupIds) {
			elements.groupList.find('.group-item').clone().appendTo(elements.removedGroups);

            var count = 0;

            $.each(groupIds, function (index, value) {
				var groupLine = elements.removedGroups.find('div[groupId=' + value + ']');
				groupLine.appendTo(elements.addedGroups);
                count++;
			});

            elements.groupCount.text(count);
		});

		elements.groupsDialog.modal('show');
	};

	var changeGroup = function (action, groupId) {
		var url = opts.groupManagementUrl + '?action=' + action + '&gid=' + groupId;

		var data = {userId: getActiveUserId()};
		$.post(url, data);
	};

	var changePermissions = function () {
		var user = getActiveUser();
		var data = {dr: 'permissions', uid: user.id};
		$.get(opts.permissionsUrl, data, function (resourceIds) {
			elements.permissionsForm.find(':checkbox').prop('checked', false);
			$.each(resourceIds, function (index, value) {
				elements.permissionsForm.find(':checkbox[value="' + value + '"]').prop('checked', true);
			});

			elements.permissionsDialog.modal('show');
		});
	};

	var changeColor = function () {
		var user = getActiveUser();
		var data = {dr: 'color', uid: user.id};
		$.get(opts.colorUrl, data, function (colorIds) {

		});
	};

	var changeUserInfo = function () {
		var user = getActiveUser();

		ClearAsyncErrors(elements.userDialog);

		$('#username').val(user.username);
		$('#fname').val(user.first);
		$('#lname').val(user.last);
		$('#email').val(user.email);
		$('#timezone').val(user.timezone);

		$('#phone').val(user.phone);
		$('#organization').val(user.organization);
		$('#position').val(user.position);

		elements.userDialog.modal('show');
	};

	var deleteUser = function () {
		elements.deleteDialog.modal('show');
	};
}