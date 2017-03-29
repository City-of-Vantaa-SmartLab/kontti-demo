<?php
/**
 * Copyright 2012-2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Controllers/ReservationSaveController.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Requests/ReservationRequest.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');

class ReservationWriteWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IReservationSaveController
	 */
	private $controller;

	public function __construct(IRestServer $server, IReservationSaveController $controller)
	{
		$this->server = $server;
		$this->controller = $controller;
	}

	/**
	 * @name CreateReservation
	 * @description Creates a new reservation
	 * @request ReservationRequest
	 * @response ReservationCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request ReservationRequest */
		$request = $this->server->GetRequest();

		Log::Debug('ReservationWriteWebService.Create() User=%s, Request=%s', $this->server->GetSession()->UserId,
				   json_encode($request));

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Create() - Reservation Created. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new ReservationCreatedResponse($this->server, $result->CreatedReferenceNumber(), $result->RequiresApproval()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Create() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name UpdateReservation
	 * @description Updates an existing reservation.
	 * Pass an optional updateScope query string parameter to restrict changes. Possible values for updateScope are this|full|future
	 * @request ReservationRequest
	 * @response ReservationUpdatedResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Update($referenceNumber)
	{
		/** @var $request ReservationRequest */
		$request = $this->server->GetRequest();

		Log::Debug('ReservationWriteWebService.Update() User=%s, ReferenceNumber=%s, Request=%s', $referenceNumber,
				   $this->server->GetSession()->UserId,
				   json_encode($request));

		$updateScope = $this->server->GetQueryString(WebServiceQueryStringKeys::UPDATE_SCOPE);
		$result = $this->controller->Update($request, $this->server->GetSession(), $referenceNumber, $updateScope);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Update() - Reservation Updated. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new ReservationUpdatedResponse($this->server, $result->CreatedReferenceNumber(), $result->RequiresApproval()),
										 RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Update() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name ApproveReservation
	 * @description Approves a pending reservation.
	 * @response ReservationApprovedResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Approve($referenceNumber)
	{
		Log::Debug('ReservationWriteWebService.Approve() User=%s, ReferenceNumber=%s', $referenceNumber, $this->server->GetSession()->UserId);

		$result = $this->controller->Approve($this->server->GetSession(), $referenceNumber);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Approve() - Reservation Approved. ReferenceNumber=%s', $referenceNumber);

			$this->server->WriteResponse(new ReservationApprovedResponse($this->server, $referenceNumber), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Approve() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()), RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name CheckinReservation
	 * @description Checks in to a reservation.
	 * @response ReservationCheckedInResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Checkin($referenceNumber)
	{
		Log::Debug('ReservationWriteWebService.Checkin() User=%s, ReferenceNumber=%s', $referenceNumber, $this->server->GetSession()->UserId);

		$result = $this->controller->Checkin($this->server->GetSession(), $referenceNumber);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Checkin() - Reservation checked in. ReferenceNumber=%s', $referenceNumber);

			$this->server->WriteResponse(new ReservationCheckedInResponse($this->server, $referenceNumber), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Checkin() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()), RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name CheckoutReservation
	 * @description Checks out of a reservation.
	 * @response ReservationCheckedOutResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Checkout($referenceNumber)
	{
		Log::Debug('ReservationWriteWebService.Checkout() User=%s, ReferenceNumber=%s', $referenceNumber, $this->server->GetSession()->UserId);

		$result = $this->controller->Checkout($this->server->GetSession(), $referenceNumber);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Checkout() - Reservation checked out. ReferenceNumber=%s', $referenceNumber);

			$this->server->WriteResponse(new ReservationCheckedOutResponse($this->server, $referenceNumber), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Checkout() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()), RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name DeleteReservation
	 * @description Deletes an existing reservation.
	 * Pass an optional updateScope query string parameter to restrict changes. Possible values for updateScope are this|full|future
	 * @response DeletedResponse
	 * @param string $referenceNumber
	 * @return void
	 */
	public function Delete($referenceNumber)
	{
		Log::Debug('ReservationWriteWebService.Delete() User=%s, ReferenceNumber=%s',
				   $this->server->GetSession()->UserId, $referenceNumber);

		$updateScope = $this->server->GetQueryString(WebServiceQueryStringKeys::UPDATE_SCOPE);
		$result = $this->controller->Delete($this->server->GetSession(), $referenceNumber, $updateScope);

		if ($result->WasSuccessful())
		{
			Log::Debug('ReservationWriteWebService.Delete() - Reservation Deleted. ReferenceNumber=%s',
					   $result->CreatedReferenceNumber());

			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('ReservationWriteWebService.Delete() - Reservation Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}