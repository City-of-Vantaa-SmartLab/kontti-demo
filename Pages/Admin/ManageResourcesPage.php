<?php
/**
 * Copyright 2011-2016 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IUpdateResourcePage
{
	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @return string
	 */
	public function GetResourceName();

	/**
	 * @return UploadedFile
	 */
	public function GetUploadedImage();

	/**
	 * @return string
	 */
	public function GetLocation();

	/**
	 * @return string
	 */
	public function GetContact();

	/**
	 * @return string
	 */
	public function GetDescription();

	/**
	 * @return string
	 */
	public function GetNotes();

	/**
	 * @return string
	 */
	public function GetMinimumDuration();

	/**
	 * @return string
	 */
	public function GetMaximumDuration();

	/**
	 * @return string
	 */
	public function GetBufferTime();

	/**
	 * @return string
	 */
	public function GetAllowMultiday();

	/**
	 * @return string
	 */
	public function GetRequiresApproval();

	/**
	 * @return string
	 */
	public function GetAutoAssign();

	/**
	 * @return string
	 */
	public function GetAutoAssignClear();

	/**
	 * @return string
	 */
	public function GetAllowSubscriptions();

	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetMaxParticipants();

	/**
	 * @return int
	 */
	public function GetAdminGroupId();

	/**
	 * @return int
	 */
	public function GetSortOrder();

	/**
	 * @return int
	 */
	public function GetResourceTypeId();
}

interface IManageResourcesPage extends IUpdateResourcePage, IActionPage, IPageable
{
	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @param array $scheduleList array of (id, schedule name)
	 */
	public function BindSchedules($scheduleList);

	/**
	 * @param Schedule[] $schedules
	 */
	public function AllSchedules($schedules);

	/**
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	public function BindAdminGroups($adminGroups);

	/**
	 * @param $attributeList CustomAttribute[]
	 */
	public function BindAttributeList($attributeList);

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();

	/**
	 * @param $resources AdminResourceJson[]
	 */
	public function SetResourcesJson($resources);

	/**
	 * @param $response mixed
	 */
	public function SetJsonResponse($response);

	/**
	 * @param $resourceTypes ResourceType[]
	 */
	public function BindResourceTypes($resourceTypes);

	/**
	 * @param $reasons ResourceStatusReason[]
	 */
	public function BindResourceStatusReasons($reasons);

	/**
	 * @return int
	 */
	public function GetStatusId();

	/**
	 * @return int
	 */
	public function GetStatusReasonId();

	/**
	 * @return string
	 */
	public function GetNewStatusReason();

	/**
	 * @param Attribute[] $attributeFilters
	 */
	public function BindAttributeFilters($attributeFilters);

	/**
	 * @return bool
	 */
	public function FilterButtonPressed();

	/**
	 * @param ResourceFilterValues $value
	 */
	public function SetFilterValues($value);

	/**
	 * @return ResourceFilterValues
	 */
	public function GetFilterValues();

	/**
	 * @return int[]
	 */
	public function GetBulkUpdateResourceIds();

	/**
	 * @return int
	 */
	public function GetMinimumDurationNone();

	/**
	 * @return int
	 */
	public function GetMaximumDurationNone();

	/**
	 * @return int
	 */
	public function GetBufferTimeNone();

	/**
	 * @return int
	 */
	public function GetStartNoticeNone();

	/**
	 * @return int
	 */
	public function GetEndNoticeNone();

	/**
	 * @return int
	 */
	public function GetPermissionUserId();

	/**
	 * @return int
	 */
	public function GetPermissionGroupId();

	/**
	 * @return string
	 */
	public function GetValue();

	/**
	 * @return string
	 */
	public function GetName();

	/**
	 * @return string
	 */
	public function GetAttributeId();

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedDuration($resource);

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedCapacity($resource);

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedAccess($resource);

	/**
	 * @param BookableResource $resource
	 * @param ResourceGroup[] $groupList
	 */
	public function BindUpdatedResourceGroups($resource, $groupList);

	public function SetAttributeValueAsJson($attributeValue);

	/**
	 * @param ResourceGroupTree $resourceGroups
	 */
	public function BindResourceGroups(ResourceGroupTree $resourceGroups);

	/**
	 * @return int[]
	 */
	public function GetResourceGroupIds();

	/**
	 * @return string
	 */
	public function GetColor();

	/**
	 * @return bool
	 */
	public function GetEnableCheckin();

	/**
	 * @return bool
	 */
	public function GetBulkEnableCheckin();

	/**
	 * @return string
	 */
	public function GetAutoReleaseMinutes();

	/**
	 * @return int
	 */
	public function GetCredits();

	/**
	 * @return int
	 */
	public function GetPeakCredits();

	public function BindUpdatedResourceCredits(BookableResource $resource);

    public function ShowQRCode($qrCodeImageUrl, $resourceName);
}

class ManageResourcesPage extends ActionPage implements IManageResourcesPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $presenter;
	protected $pageablePage;

	public function __construct()
	{
		parent::__construct('ManageResources', 1);
		$this->presenter = new ManageResourcesPresenter(
				$this,
				new ResourceRepository(),
				new ScheduleRepository(),
				new ImageFactory(),
				new GroupRepository(),
				new AttributeService(new AttributeRepository()),
				new UserPreferenceRepository()
		);

		$this->pageablePage = new PageablePage($this);
		$this->Set('YesNoOptions',
				   array('' => '-',
						   '1' => Resources::GetInstance()->GetString('Yes'),
						   '0' => Resources::GetInstance()->GetString('No'))
		);
		$this->Set('YesNoUnchangedOptions',
				   array('-1' => Resources::GetInstance()->GetString('Unchanged'),
						   '1' => Resources::GetInstance()->GetString('Yes'),
						   '0' => Resources::GetInstance()->GetString('No'))
		);

		$this->Set('CreditsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter()));
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/Resources/manage_resources.tpl');
	}

	/**
	 * @return int
	 */
	function GetPageNumber()
	{
		return $this->pageablePage->GetPageNumber();
	}

	/**
	 * @return int
	 */
	function GetPageSize()
	{
		$pageSize = $this->pageablePage->GetPageSize();

		if ($pageSize > 10)
		{
			return 10;
		}
		return $pageSize;
	}

	/**
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	function BindPageInfo(PageInfo $pageInfo)
	{
		$this->pageablePage->BindPageInfo($pageInfo);
	}

	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	public function AllSchedules($schedules)
	{
		$this->Set('AllSchedules', $schedules);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function GetResourceId()
	{
		$id = $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
		if (empty($id))
		{
			$id = $this->GetForm(FormKeys::PK);
		}

		return $id;
	}

	public function GetScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}

	public function GetValue()
	{
		return $this->GetForm(FormKeys::VALUE);
	}

	public function GetName()
	{
		return $this->GetForm(FormKeys::NAME);
	}

	public function GetResourceName()
	{
		return $this->GetForm(FormKeys::RESOURCE_NAME);
	}

	public function GetUploadedImage()
	{
		return $this->server->GetFile(FormKeys::RESOURCE_IMAGE);
	}

	public function GetLocation()
	{
		return $this->GetForm(FormKeys::RESOURCE_LOCATION);
	}

	public function GetContact()
	{
		return $this->GetForm(FormKeys::RESOURCE_CONTACT);
	}

	public function GetDescription()
	{
		return $this->GetForm(FormKeys::RESOURCE_DESCRIPTION);
	}

	public function GetNotes()
	{
		return $this->GetForm(FormKeys::RESOURCE_NOTES);
	}

	/**
	 * @return string
	 */
	public function GetMinimumDuration()
	{
		return $this->GetForm(FormKeys::MIN_DURATION);
	}

	/**
	 * @return string
	 */
	public function GetMaximumDuration()
	{
		return $this->GetForm(FormKeys::MAX_DURATION);
	}

	/**
	 * @return string
	 */
	public function GetBufferTime()
	{
		return $this->GetForm(FormKeys::BUFFER_TIME);
	}

	/**
	 * @return string
	 */
	public function GetAllowMultiday()
	{
		return $this->GetCheckbox(FormKeys::ALLOW_MULTIDAY);
	}

	/**
	 * @return string
	 */
	public function GetRequiresApproval()
	{
		return $this->GetCheckbox(FormKeys::REQUIRES_APPROVAL);
	}

	/**
	 * @return string
	 */
	public function GetAutoAssign()
	{
		return $this->GetCheckbox(FormKeys::AUTO_ASSIGN);
	}

	/**
	 * @return string
	 */
	public function GetAutoAssignClear()
	{
		return $this->GetForm(FormKeys::AUTO_ASSIGN_CLEAR);
	}

	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MIN_NOTICE);
	}

	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MAX_NOTICE);
	}

	/**
	 * @return string
	 */
	public function GetMaxParticipants()
	{
		return $this->GetForm(FormKeys::MAX_PARTICIPANTS);
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ADMIN_GROUP_ID);
	}

	/**
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	function BindAdminGroups($adminGroups)
	{
		$this->Set('AdminGroups', $adminGroups);
		$groupLookup = array();
		foreach ($adminGroups as $group)
		{
			$groupLookup[$group->Id] = $group;
		}
		$this->Set('GroupLookup', $groupLookup);
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest($dataRequest);
	}

	/**
	 * @param $attributeList CustomAttribute[]
	 */
	public function BindAttributeList($attributeList)
	{
		$this->Set('AttributeList', $attributeList);
	}

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @return int
	 */
	public function GetSortOrder()
	{
		return $this->GetForm(FormKeys::RESOURCE_SORT_ORDER);
	}

	/**
	 * @param $resources AdminResourceJson[]
	 */
	public function SetResourcesJson($resources)
	{
		$this->SetJson($resources);
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}

	/**
	 * @param $resourceTypes ResourceType[]
	 */
	public function BindResourceTypes($resourceTypes)
	{
		$this->Set('ResourceTypes', $resourceTypes);
	}

	/**
	 * @return int
	 */
	public function GetResourceTypeId()
	{
		return $this->GetForm(FormKeys::RESOURCE_TYPE_ID);
	}

	/**
	 * @param $reasons ResourceStatusReason[]
	 */
	public function BindResourceStatusReasons($reasons)
	{
		$this->Set('StatusReasons', $reasons);
	}

	public function GetStatusId()
	{
		return $this->GetForm(FormKeys::RESOURCE_STATUS_ID);
	}

	public function GetStatusReasonId()
	{
		return $this->GetForm(FormKeys::RESOURCE_STATUS_REASON_ID);
	}

	/**
	 * @return string
	 */
	public function GetNewStatusReason()
	{
		return $this->GetForm(FormKeys::RESOURCE_STATUS_REASON);
	}

	public function FilterButtonPressed()
	{
		return count($_GET) > 0;
	}

	public function SetFilterValues($values)
	{
		$this->Set('ResourceNameFilter', $values->ResourceNameFilter);
		$this->Set('ScheduleIdFilter', $values->ScheduleIdFilter);
		$this->Set('ResourceTypeFilter', $values->ResourceTypeFilter);
		$this->Set('ResourceStatusFilterId', $values->ResourceStatusFilterId);
		$this->Set('ResourceStatusReasonFilterId', $values->ResourceStatusReasonFilterId);
		$this->Set('CapacityFilter', $values->CapacityFilter);
		$this->Set('RequiresApprovalFilter', $values->RequiresApprovalFilter);
		$this->Set('AutoPermissionFilter', $values->AutoPermissionFilter);
		$this->Set('AllowMultiDayFilter', $values->AllowMultiDayFilter);
	}

	public function GetFilterValues()
	{
		$filterValues = new ResourceFilterValues();

		$filterValues->ResourceNameFilter = $this->GetQuerystring(FormKeys::RESOURCE_NAME);
		$filterValues->ScheduleIdFilter = $this->GetQuerystring(FormKeys::SCHEDULE_ID);
		$filterValues->ResourceTypeFilter = $this->GetQuerystring(FormKeys::RESOURCE_TYPE_ID);
		$filterValues->ResourceStatusFilterId = $this->GetQuerystring(FormKeys::RESOURCE_STATUS_ID);
		$filterValues->ResourceStatusReasonFilterId = $this->GetQuerystring(FormKeys::RESOURCE_STATUS_REASON_ID);
		$filterValues->CapacityFilter = $this->GetQuerystring(FormKeys::MAX_PARTICIPANTS);
		$filterValues->RequiresApprovalFilter = $this->GetQuerystring(FormKeys::REQUIRES_APPROVAL);
		$filterValues->AutoPermissionFilter = $this->GetQuerystring(FormKeys::AUTO_ASSIGN);
		$filterValues->AllowMultiDayFilter = $this->GetQuerystring(FormKeys::ALLOW_MULTIDAY);
		$filterValues->SetAttributes(AttributeFormParser::GetAttributes($this->GetQuerystring(FormKeys::ATTRIBUTE_PREFIX)));

		return $filterValues;
	}

	public function BindAttributeFilters($attributeFilters)
	{
		$this->Set('AttributeFilters', $attributeFilters);
	}

	public function GetBulkUpdateResourceIds()
	{
		$resourceIds = $this->GetForm(FormKeys::RESOURCE_ID);
		if (empty($resourceIds))
		{
			return array();
		}

		return $resourceIds;
	}

	public function GetAllowSubscriptions()
	{
		return $this->GetForm(FormKeys::ALLOW_CALENDAR_SUBSCRIPTIONS);
	}

	public function GetMinimumDurationNone()
	{
		return $this->GetForm(FormKeys::MIN_DURATION_NONE);
	}

	public function GetMaximumDurationNone()
	{
		return $this->GetForm(FormKeys::MAX_DURATION_NONE);
	}

	public function GetBufferTimeNone()
	{
		return $this->GetForm(FormKeys::BUFFER_TIME_NONE);
	}

	public function GetStartNoticeNone()
	{
		return $this->GetForm(FormKeys::MIN_NOTICE_NONE);
	}

	public function GetEndNoticeNone()
	{
		return $this->GetForm(FormKeys::MAX_NOTICE_NONE);
	}

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedDuration($resource)
	{
		$this->Set('resource', $resource);
		$this->Display('Admin/Resources/manage_resources_duration.tpl');
	}

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedCapacity($resource)
	{
		$this->Set('resource', $resource);
		$this->Display('Admin/Resources/manage_resources_capacity.tpl');
	}

	/**
	 * @param BookableResource $resource
	 */
	public function BindUpdatedAccess($resource)
	{
		$this->Set('resource', $resource);
		$this->Display('Admin/Resources/manage_resources_access.tpl');
	}

	/**
	 * @param BookableResource $resource
	 * @param ResourceGroup[] $groupList
	 */
	public function BindUpdatedResourceGroups($resource, $groupList)
	{
		$this->Set('resource', $resource);
		$this->Set('ResourceGroupList', $groupList);
		$this->Display('Admin/Resources/manage_resources_groups.tpl');
	}

	/**
	 * @return string
	 */
	public function GetAttributeId()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTRIBUTE_ID);
	}

	public function SetAttributeValueAsJson($attributeValue)
	{
		$this->SetJson($attributeValue);
	}

	public function GetPermissionUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}

	public function GetPermissionGroupId()
	{
		return $this->GetForm(FormKeys::GROUP_ID);
	}

	/**
	 * @param ResourceGroupTree $resourceGroups
	 */
	public function BindResourceGroups(ResourceGroupTree $resourceGroups)
	{
		$this->Set('ResourceGroups', json_encode($resourceGroups->GetGroups(false)));
		$groupList = $resourceGroups->GetGroupList(false);
		$this->Set('ResourceGroupList', $groupList);
	}

	public function GetResourceGroupIds()
	{
		$groupIds = $this->GetForm(FormKeys::GROUP_ID);
		if (empty($groupIds))
		{
			return array();
		}

		return $groupIds;
	}

	public function GetColor()
	{
		return $this->GetForm(FormKeys::RESERVATION_COLOR);
	}

	public function GetEnableCheckin()
	{
		return $this->GetCheckbox(FormKeys::ENABLE_CHECK_IN);
	}

	public function GetBulkEnableCheckin()
	{
		return $this->GetForm(FormKeys::ENABLE_CHECK_IN);
	}

	public function GetAutoReleaseMinutes()
	{
		return $this->GetForm(FormKeys::AUTO_RELEASE_MINUTES);
	}

	public function GetCredits()
	{
		return $this->GetForm(FormKeys::CREDITS);
	}

	public function GetPeakCredits()
	{
		return $this->GetForm(FormKeys::PEAK_CREDITS);
	}

	public function BindUpdatedResourceCredits(BookableResource $resource)
	{
		$this->Set('resource', $resource);
		$this->Display('Admin/Resources/manage_resources_credits.tpl');
	}

    public function ShowQRCode($qrCodeImageUrl, $resourceName)
    {
        $this->Set('QRImageUrl', $qrCodeImageUrl);
        $this->Set('ResourceName', $resourceName);
        
        $this->Display('Admin/Resources/show_resource_qr.tpl');
    }
}

class ResourceFilterValues
{
	public $ResourceNameFilter;
	public $ScheduleIdFilter;
	public $ResourceTypeFilter;
	public $ResourceStatusFilterId;
	public $ResourceStatusReasonFilterId;
	public $CapacityFilter;
	public $RequiresApprovalFilter;
	public $AutoPermissionFilter;
	public $AllowMultiDayFilter;
	public $Attributes = array();

	/**
	 * @param AttributeFormElement[] $attributeFormElements
	 */
	public function SetAttributes($attributeFormElements)
	{
		foreach ($attributeFormElements as $e)
		{
			$this->SetAttributeValue($e->Id, $e->Value);
		}
	}

	public function SetAttributeValue($id, $value)
	{
		$this->Attributes[$id] = $value;
	}

	public function GetAttributeValue($id)
	{
		if (array_key_exists($id, $this->Attributes))
		{
			return $this->Attributes[$id];
		}

		return null;
	}

	/**
	 * @param CustomAttribute[] $customAttributes
	 * @return ISqlFilter
	 */
	public function AsFilter($customAttributes)
	{
		$filter = new SqlFilterNull();
		if (!empty($this->ResourceNameFilter))
		{
			$filter->_And(new SqlFilterLike(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																ColumnNames::RESOURCE_NAME),
											$this->ResourceNameFilter));
		}
		if (!empty($this->ScheduleIdFilter))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::SCHEDULE_ID), $this->ScheduleIdFilter));
		}
		if (!empty($this->ResourceTypeFilter))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::RESOURCE_TYPE_ID),
											  $this->ResourceTypeFilter));
		}
		if (!empty($this->ResourceStatusFilterId))
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::RESOURCE_STATUS_ID),
											  $this->ResourceStatusFilterId));
		}
		if (!empty($this->CapacityFilter))
		{
			$filter->_And(new SqlFilterGreaterThan(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																	   ColumnNames::RESOURCE_MAX_PARTICIPANTS),
												   $this->CapacityFilter, true));
		}
		if ($this->RequiresApprovalFilter != '')
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::RESOURCE_REQUIRES_APPROVAL),
											  $this->RequiresApprovalFilter));
		}
		if ($this->AutoPermissionFilter != '')
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::RESOURCE_AUTOASSIGN),
											  $this->AutoPermissionFilter));
		}
		if ($this->AllowMultiDayFilter != '')
		{
			$filter->_And(new SqlFilterEquals(new SqlFilterColumn(TableNames::RESOURCES_ALIAS,
																  ColumnNames::RESOURCE_ALLOW_MULTIDAY),
											  $this->AllowMultiDayFilter));
		}

		if (!empty($this->Attributes))
		{
			$filteringAttributes = false;
			$attributeDefinitions = array();
			foreach ($customAttributes as $a)
			{
				$attributeDefinitions[$a->Id()] = $a;
			}

			$f = new SqlFilterFreeForm(ColumnNames::RESOURCE_ID . ' IN (SELECT a0.' . ColumnNames::ATTRIBUTE_ENTITY_ID . ' FROM ' . TableNames::CUSTOM_ATTRIBUTE_VALUES . ' a0 ');

			$attributeFragment = new SqlFilterNull();

			/** @var $attribute Attribute */
			foreach ($this->Attributes as $id => $value)
			{
				if ($value == null || $value == '' || !array_key_exists($id, $attributeDefinitions))
				{
					continue;
				}
				$filteringAttributes = true;
				$attribute = $attributeDefinitions[$id];
				$attributeId = new SqlRepeatingFilterColumn("a$id", ColumnNames::CUSTOM_ATTRIBUTE_ID, $id);
				$attributeValue = new SqlRepeatingFilterColumn("a$id", ColumnNames::CUSTOM_ATTRIBUTE_VALUE, $id);

				$idEquals = new SqlFilterEquals($attributeId, $id);
				$f->AppendSql('LEFT JOIN ' . TableNames::CUSTOM_ATTRIBUTE_VALUES . ' a' . $id . ' ON a0.entity_id = a' . $id . '.entity_id ');
				if ($attribute->Type() == CustomAttributeTypes::MULTI_LINE_TEXTBOX || $attribute->Type() == CustomAttributeTypes::SINGLE_LINE_TEXTBOX)
				{
					$attributeFragment->_And($idEquals->_And(new SqlFilterLike($attributeValue, $value)));
				}
				else
				{
					$attributeFragment->_And($idEquals->_And(new SqlFilterEquals($attributeValue, $value)));
				}
			}

			$f->AppendSql("WHERE [attribute_list_token] )");
			$f->Substitute('attribute_list_token', $attributeFragment);

			if ($filteringAttributes)
			{
				$filter->_And($f);
			}
		}

		return $filter;
	}
}