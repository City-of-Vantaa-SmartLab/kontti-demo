function QuotaManagement(opts) {
	var options = opts;

	var elements = {

		addForm: $('#addQuotaForm'),
		deleteForm: $('#deleteQuotaForm'),
		deleteDialog: $('#deleteDialog'),
		enforceAllDayToggle: $('#enforce-all-day'),
		enforceHoursTimes: $('#enforce-hours-times'),
		enforceEveryDayToggle: $('#enforce-every-day'),
		enforceDays: $('#enforce-days'),
		enforceStartTime: $('#enforce-time-start'),
		enforceEndTime: $('#enforce-time-end')
	};

	var activeQuotaId = null;

	QuotaManagement.prototype.init = function () {
		$('.delete').click(function (e) {
			e.preventDefault();
			setActiveQuotaId($(this).attr('quotaId'));
			elements.deleteDialog.modal('show');
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').modal("hide");
		});

		elements.enforceAllDayToggle.click(function (e) {
			handleEnforceAllDayToggle(e);
		});

		elements.enforceEveryDayToggle.click(function (e) {
			handleEnforceEveryDayToggle(e);
		});

		ConfigureAsyncForm(elements.addForm, getSubmitCallback(options.actions.addQuota), null, handleAddError, {onBeforeSubmit: validateTimes});
		ConfigureAsyncForm(elements.deleteForm, getSubmitCallback(options.actions.deleteQuota), null, handleAddError);
	};

	var getSubmitCallback = function (action) {
		return function () {
			return options.submitUrl + "?qid=" + getActiveQuotaId() + "&action=" + action;
		};
	};

	var handleAddError = function (responseText) {
		alert(responseText);
	};

	var setActiveQuotaId = function (quotaId) {
		activeQuotaId = quotaId
	};

	var getActiveQuotaId = function () {
		return activeQuotaId;
	};

	var handleEnforceAllDayToggle = function (e) {
		if (elements.enforceAllDayToggle.is(':checked'))
		{
			elements.enforceHoursTimes.addClass('no-show');
		}
		else
		{
			elements.enforceHoursTimes.removeClass('no-show');
		}
	};

	var handleEnforceEveryDayToggle = function (e) {
		if (elements.enforceEveryDayToggle.is(':checked'))
		{
			elements.enforceDays.addClass('no-show');
		}
		else
		{
			elements.enforceDays.removeClass('no-show');
		}
	};

	var validateTimes = function () {
		$('#timeError').addClass('no-show');
		if (!elements.enforceAllDayToggle.is(':checked'))
		{
			var start = moment('2010-01-01 ' + elements.enforceStartTime.val(), 'YYYY-MM-DD hh:mm a');
			var end = moment('2010-01-01 ' + elements.enforceEndTime.val(), 'YYYY-MM-DD hh:mm a');
			var valid = start.isBefore(end) || (end.hour() == 0 && end.minute() == 0);

			if (!valid)
			{
				$('#timeError').removeClass('no-show');
			}
			return valid;
		}
		return true;
	};
}