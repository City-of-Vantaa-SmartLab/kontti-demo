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
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourcesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributes/CustomAttributeResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceStatusResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceStatusReasonsResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceAvailabilityResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceReference.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceTypesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Resource/ResourceGroupsResponse.php');

class ResourcesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationRepository;

	public function __construct(IRestServer $server,
								IResourceRepository $resourceRepository,
								IAttributeService $attributeService,
								IReservationViewRepository $reservationRepository)
	{
		$this->server = $server;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;
		$this->reservationRepository = $reservationRepository;
	}

	/**
	 * @name GetAllResources
	 * @description Loads all resources
	 * @response ResourcesResponse
	 * @return void
	 */
	public function GetAll()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$resourceIds = array();
		foreach ($resources as $resource)
		{
			$resourceIds[] = $resource->GetId();
		}
		$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, $resourceIds);
		$this->server->WriteResponse(new ResourcesResponse($this->server, $resources, $attributes));
	}

	/**
	 * @name GetResource
	 * @description Loads a specific resource by id
	 * @param int $resourceId
	 * @response ResourceResponse
	 * @return void
	 */
	public function GetResource($resourceId)
	{
		$resource = $this->resourceRepository->LoadById($resourceId);

		$resourceId = $resource->GetResourceId();
		if (empty($resourceId))
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
		else
		{
			$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, array($resourceId));
			$this->server->WriteResponse(new ResourceResponse($this->server, $resource, $attributes));
		}

	}

	/**
	 * @name GetStatuses
	 * @description Returns all available resource statuses
	 * @response ResourceStatusResponse
	 * @return void
	 */
	public function GetStatuses()
	{
		$this->server->WriteResponse(new ResourceStatusResponse());
	}

	/**
	 * @name GetStatusReasons
	 * @description Returns all available resource status reasons
	 * @response ResourceStatusReasonsResponse
	 * @return void
	 */
	public function GetStatusReasons()
	{
		$reasons = $this->resourceRepository->GetStatusReasons();

		$this->server->WriteResponse(new ResourceStatusReasonsResponse($this->server, $reasons));
	}

	/**
	 * @name GetResourceTypes
	 * @description Returns all available resource types
	 * @response ResourceTypesResponse
	 * @return void
	 */
	public function GetTypes()
	{
		$types = $this->resourceRepository->GetResourceTypes();
		$this->server->WriteResponse(new ResourceTypesResponse($this->server, $types));
	}

	/**
	 * @name GetAvailability
	 * @description Returns resource availability for the requested resource (optional). "availableAt" and "availableUntil" will include availability through the next 7 days
	 * Optional query string parameter: dateTime. If no dateTime is requested the current datetime will be used.
	 * @response ResourcesAvailabilityResponse
	 * @return void
	 */
	public function GetAvailability($resourceId = null)
	{
		$dateQueryString = $this->server->GetQueryString(WebServiceQueryStringKeys::DATE_TIME);

		if (!empty($dateQueryString))
		{
			$requestedTime = WebServiceDate::GetDate($dateQueryString, $this->server->GetSession());
		}
		else
		{
			$requestedTime = Date::Now();
		}

		if (empty($resourceId))
		{
			$resources = $this->resourceRepository->GetResourceList();
		}
		else
		{
			$resources[] = $this->resourceRepository->LoadById($resourceId);
		}

		$lastDateSearched = $requestedTime->AddDays(30);
		$reservations = $this->GetReservations($this->reservationRepository->GetReservations($requestedTime, $lastDateSearched, null, null, null, $resourceId));

		$resourceAvailability = array();

		foreach ($resources as $resource)
		{
			$reservation = $this->GetOngoingReservation($resource, $reservations);

			if ($reservation != null)
			{
				$lastReservationBeforeOpening = $this->GetLastReservationBeforeAnOpening($resource, $reservations);

				if ($lastReservationBeforeOpening == null)
				{
					$lastReservationBeforeOpening = $reservation;
				}

				$resourceAvailability[] = new ResourceAvailabilityResponse($this->server, $resource, $lastReservationBeforeOpening, null, $lastReservationBeforeOpening->EndDate, $lastDateSearched);
			}
			else
			{
				$resourceId = $resource->GetId();
				if (array_key_exists($resourceId, $reservations))
				{
					$resourceAvailability[] = new ResourceAvailabilityResponse($this->server, $resource, null, $reservations[$resourceId][0], null, $lastDateSearched);
				}
				else
				{
					$resourceAvailability[] = new ResourceAvailabilityResponse($this->server, $resource, null, null, null, $lastDateSearched);
				}
			}
		}

		$this->server->WriteResponse(new ResourcesAvailabilityResponse($this->server, $resourceAvailability));
	}

    /**
     * @name GetGroups
     * @description Returns the full resource group tree
     * @response ResourceGroupsResponse
     * @return void
     */
    public function GetGroups()
    {
        $groups = $this->resourceRepository->GetResourceGroups();

        $this->server->WriteResponse(new ResourceGroupsResponse($this->server, $groups));
    }

	/**
	 * @param BookableResource $resource
	 * @param ReservationItemView[][] $reservations
	 * @return ReservationItemView|null
	 */
	private function GetOngoingReservation($resource, $reservations)
	{
		if (array_key_exists($resource->GetId(), $reservations) && $reservations[$resource->GetId()][0]->StartDate->LessThan(Date::Now()))
		{
			return $reservations[$resource->GetId()][0];
		}

		return null;
	}

	/**
	 * @param ReservationItemView[] $reservations
	 * @return ReservationItemView[][]
	 */
	private function GetReservations($reservations)
	{
		$indexed = array();
		foreach ($reservations as $reservation)
		{
			$indexed[$reservation->ResourceId][] = $reservation;
		}

		return $indexed;
	}

	/**
	 * @param BookableResource $resource
	 * @param ReservationItemView[][] $reservations
	 * @return null|ReservationItemView
	 */
	private function GetLastReservationBeforeAnOpening($resource, $reservations)
	{
		$resourceId = $resource->GetId();
		if (!array_key_exists($resourceId, $reservations))
		{
			return null;
		}

		$resourceReservations = $reservations[$resourceId];
		for ($i = 0; $i < count($resourceReservations) - 1; $i++)
		{
			$current = $resourceReservations[$i];
			$next = $resourceReservations[$i + 1];

			if ($current->EndDate->Equals($next->StartDate))
			{
				continue;
			}

			return $current;
		}

		return $resourceReservations[count($resourceReservations) - 1];
	}
}
