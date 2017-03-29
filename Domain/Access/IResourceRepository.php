<?php
/**
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
 */

interface IResourceRepository
{
	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId);

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId);

	/**
	 * @param string $publicId
	 * @return BookableResource
	 */
	public function LoadByPublicId($publicId);

    /**
     * @param string $resourceName
     * @return BookableResource
     */
    public function LoadByName($resourceName);

	/**
	 * @param BookableResource $resource
	 * @return int ID of created resource
	 */
	public function Add(BookableResource $resource);

	/**
	 * @param BookableResource $resource
	 */
	public function Update(BookableResource $resource);

	/**
	 * @param BookableResource $resource
	 */
	public function Delete(BookableResource $resource);

	/**
	 * @return array|BookableResource[] array of all resources
	 */
	public function GetResourceList();

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 * @param string|null $sortField
	 * @param string|null $sortDirection
	 * @param ISqlFilter $filter
	 * @return PageableData|BookableResource[]
	 */
	public function GetList($pageNumber, $pageSize, $sortField = null, $sortDirection = null, $filter = null);

    /**
     * @param null|string $sortField
     * @param null|string $sortDirection
     * @return AccessoryDto[]|array all accessories
     */
	public function GetAccessoryList($sortField = null, $sortDirection = null);

	/**
	 * @param int|null $scheduleId
	 * @param IResourceFilter|null $resourceFilter
	 * @return ResourceGroupTree
	 */
	public function GetResourceGroups($scheduleId = null, $resourceFilter = null);

	/**
	 * @param int $resourceId
	 * @param int $groupId
	 */
	public function AddResourceToGroup($resourceId, $groupId);

	/**
	 * @param int $resourceId
	 * @param int $groupId
	 */
	public function RemoveResourceFromGroup($resourceId, $groupId);

	/**
	 * @param ResourceGroup $group
	 * @return ResourceGroup
	 */
	public function AddResourceGroup(ResourceGroup $group);

	/**
	 * @param int $groupId
	 * @return ResourceGroup
	 */
	public function LoadResourceGroup($groupId);

	/**
	 * @param string $publicResourceGroupId
	 * @return ResourceGroup
	 */
	public function LoadResourceGroupByPublicId($publicResourceGroupId);

	/**
	 * @param ResourceGroup $group
	 */
	public function UpdateResourceGroup(ResourceGroup $group);

	/**
	 * @param $groupId
	 */
	public function DeleteResourceGroup($groupId);

	/**
	 * @return ResourceType[]|array
	 */
	public function GetResourceTypes();

	/**
	 * @param int $resourceTypeId
	 * @return ResourceType
	 */
	public function LoadResourceType($resourceTypeId);

	/**
	 * @param ResourceType $type
	 * @return int
	 */
	public function AddResourceType(ResourceType $type);

	/**
	 * @param ResourceType $type
	 */
	public function UpdateResourceType(ResourceType $type);

	/**
	 * @param int $id
	 */
	public function RemoveResourceType($id);

	/**
	 * @return ResourceStatusReason[]
	 */
	public function GetStatusReasons();

	/**
	 * @param int $statusId
	 * @param string $reasonDescription
	 * @return int
	 */
	public function AddStatusReason($statusId, $reasonDescription);

	/**
	 * @param int $reasonId
	 * @param string $reasonDescription
	 */
	public function UpdateStatusReason($reasonId, $reasonDescription);

	/**
	 * @param int $reasonId
	 */
	public function RemoveStatusReason($reasonId);

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @param int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetUsersWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null, $accountStatus = AccountStatus::ACTIVE);

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @param int $accountStatus
	 * @return PageableData|UserItemView[]
	 */
	public function GetUsersWithPermissionsIncludingGroups($resourceId, $pageNumber = null, $pageSize = null, $filter = null, $accountStatus = AccountStatus::ACTIVE);

	/**
	 * @param int $resourceId
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param ISqlFilter|null $filter
	 * @return PageableData|GroupItemView[]
	 */
	public function GetGroupsWithPermission($resourceId, $pageNumber = null, $pageSize = null, $filter = null);

	/**
	 * @param int $resourceId
	 * @param int $userId
	 */
	public function AddResourceUserPermission($resourceId, $userId);

	/**
	 * @param int $resourceId
	 * @param int $userId
	 */
	public function RemoveResourceUserPermission($resourceId, $userId);

	/**
	 * @param $resourceId
	 * @param $groupId
	 */
	public function AddResourceGroupPermission($resourceId, $groupId);

	/**
	 * @param $resourceId
	 * @param $groupId
	 */
	public function RemoveResourceGroupPermission($resourceId, $groupId);

}