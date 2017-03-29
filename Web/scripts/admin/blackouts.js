function BlackoutManagement(opts) {
	var options = opts;

	var elements = {
		startDate: $("#formattedStartDate"),
		endDate: $("#formattedEndDate"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
		blackoutTable: $("#blackoutTable"),
		reservationTable: $("#reservationTable"),

		allResources: $('#allResources'),
		addResourceId: $('#addResourceId'),
		addScheduleId: $('#addScheduleId'),

		deleteDialog: $('#deleteDialog'),
		deleteRecurringDialog: $('#deleteRecurringDialog'),

		deleteForm: $('#deleteForm'),
		deleteRecurringForm: $('#deleteRecurringForm'),
		addBlackoutForm: $('#addBlackoutForm'),

		referenceNumberList: $(':hidden.reservationId')
	};

	var blackoutId;

	BlackoutManagement.prototype.init = function () {

		wireUpUpdateButtons();

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.modal').modal("hide");
		});

		$('#result').delegate('.reload', 'click', function (e) {
			location.reload();
		});

		$('#result').delegate('.unblock', 'click', function (e) {
			$('#result').hide();
			$.unblockUI();
		});

		elements.blackoutTable.find('.edit').click(function (e) {
			$('#update-spinner').show();
			var tr = $(this).parents('tr');
			var id = tr.attr('data-blackout-id');

			$.blockUI({
				message: $('#update-box'),
				css: {textAlign: 'left'}
			});

			var updateDiv = $('#update-contents');

			updateDiv.empty();
			updateDiv.load(opts.editUrl + id, function () {
				$('.blockUI').css('cursor', 'default');

				$('#update-spinner').hide();

				ConfigureAsyncForm($('#editBlackoutForm'), getUpdateUrl, onAddSuccess, null, {
					onBeforeSubmit: onBeforeAddSubmit,
					target: '#result'
				});

				wireUpUpdateButtons();

				$(".save").click(function () {
					$(this).closest('form').submit();
				});

				$('#cancelUpdate').click(function (e) {
					$.unblockUI();
				});

				$('.blackoutResources').click(function (e) {
					if ($(".blackoutResources input:checked").length == 0)
					{
						e.preventDefault();
					}
				});
				wireUpTimePickers();

                $('#update-box').removeClass('no-show');
            });
		});

		handleBlackoutApplicabilityChange();
		wireUpTimePickers();

		elements.blackoutTable.delegate('.update', 'click', function (e) {
			e.preventDefault();

			var tr = $(this).parents('tr');
			var id = tr.attr('data-blackout-id');
			setActiveBlackoutId(id);
		});

		elements.blackoutTable.delegate('.delete', 'click', function () {
			showDeleteBlackout();
		});

		elements.blackoutTable.delegate('.delete-recurring', 'click', function () {
			showDeleteRecurringBlackout();
		});

		$('#showAll').click(function (e) {
			e.preventDefault();
			elements.startDate.val('');
			elements.endDate.val('');
			elements.scheduleId.val('');
			elements.resourceId.val('');

			filterReservations();
		});

		$('#filter').click(function (e) {
			e.preventDefault();
			filterReservations();
		});

		ConfigureAsyncForm(elements.addBlackoutForm, getAddUrl, onAddSuccess, null, {
			onBeforeSubmit: onBeforeAddSubmit,
			target: '#result'
		});
		ConfigureAsyncForm(elements.deleteForm, getDeleteUrl, onDeleteSuccess, null, {
			onBeforeSubmit: onBeforeDeleteSubmit,
			target: '#result'
		});
		ConfigureAsyncForm(elements.deleteRecurringForm, getDeleteUrl, onDeleteSuccess, null, {
			onBeforeSubmit: onBeforeDeleteSubmit,
			target: '#result'
		});
	};

	function showDeleteBlackout() {
		elements.deleteDialog.modal('show');
	}

	function showDeleteRecurringBlackout() {
		elements.deleteRecurringDialog.modal('show');
	}

	function setActiveBlackoutId(id) {
		blackoutId = id;
	}

	function getActiveBlackoutId() {
		return blackoutId;
	}

	function showWaitBox() {
		$.blockUI({message: $('#wait-box')});

		$('#result').hide();
		$('#creatingNotification').show();
	}

	function onBeforeAddSubmit(formData, jqForm, opts) {
		var isValid = BeforeFormSubmit(formData, jqForm, opts);

		if (isValid)
		{
			showWaitBox();
		}
		return isValid;
	}

	function onBeforeDeleteSubmit() {
		$('.modal').modal('hide');
		showWaitBox();
	}

	function onAddSuccess() {
		$('.blockUI').css('cursor', 'default');
		$('#creatingNotification').hide();
		$('#result').show();

		$("#reservationTable").find('.editable').each(function () {
			var refNum = $(this).find('.referenceNumber').text();
			$(this).attachReservationPopup(refNum, options.popupUrl);
		});

		$("#reservationTable").delegate('.editable', 'click', function () {
			$(this).addClass('clicked');
			var td = $(this).find('.referenceNumber');
			viewReservation(td.text());
		});
	}

	function onDeleteSuccess() {
		location.reload();
	}

	function getDeleteUrl() {
		return opts.deleteUrl + getActiveBlackoutId();
	}

	function getAddUrl() {
		return opts.addUrl;
	}

	function getUpdateUrl() {
		return opts.updateUrl;
	}

	function filterReservations() {
		var filterQuery =
				'sd=' + elements.startDate.val() +
				'&ed=' + elements.endDate.val() +
				'&sid=' + elements.scheduleId.val() +
				'&rid=' + elements.resourceId.val();

		window.location = document.location.pathname + '?' + encodeURI(filterQuery);
	}

	function viewReservation(referenceNumber) {
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	function handleBlackoutApplicabilityChange() {
		elements.allResources.change(function () {
			if ($(this).is(':checked'))
			{
				elements.addResourceId.attr('disabled', 'disabled');
				elements.addScheduleId.removeAttr('disabled');
			}
			else
			{
				elements.addScheduleId.attr('disabled', 'disabled');
				elements.addResourceId.removeAttr('disabled');
			}
		});
	}

	function wireUpTimePickers() {
		$('.timepicker').timepicker({
			timeFormat: options.timeFormat
		});
	}

	function ChangeUpdateScope(updateScopeValue) {
		$('.hdnSeriesUpdateScope').val(updateScopeValue);
	}

	function wireUpUpdateButtons() {
		$('.btnUpdateThisInstance').click(function () {
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('.btnUpdateAllInstances').click(function () {
			ChangeUpdateScope(options.scopeOpts.full);
		});
	}
}