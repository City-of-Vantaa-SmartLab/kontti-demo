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
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IManageResourceTypesPage extends IActionPage
{
	/**
	 * @param ResourceType[]|array $types
	 */
	public function BindResourceTypes($types);

	/**
	 * @return int
	 */
	public function GetId();

	/**
	 * @return string
	 */
	public function GetResourceTypeName();

	/**
	 * @return string
	 */
	public function GetName();

	/**
	 * @return string
	 */
	public function GetDescription();

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();

	/**
	 * @param CustomAttribute[] $attributeList
	 */
	public function BindAttributeList($attributeList);

	/**
	 * @param ResourceTypeJson[] $resourceTypes
	 */
	public function SetResourceTypesJson($resourceTypes);

	/**
	 * @return string
	 */
	public function GetValue();
}

class ManageResourceTypesPage extends ActionPage implements IManageResourceTypesPage
{
	/**
	 * @var ManageResourceTypesPresenter
	 */
	protected $presenter;

	public function __construct()
	{
		parent::__construct('ManageResourceTypes', 1);
		$this->presenter = new ManageResourceTypesPresenter($this,
															ServiceLocator::GetServer()
																		  ->GetUserSession(),
															new ResourceRepository(),
															new AttributeService(new AttributeRepository()));
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/Resources/manage_resource_types.tpl');
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest($dataRequest);
	}

	/**
	 * @param ResourceType[]|array $types
	 */
	public function BindResourceTypes($types)
	{
		$this->Set('ResourceTypes', $types);
	}

	/**
	 * @return string
	 */
	public function GetResourceTypeName()
	{
		return $this->GetForm(FormKeys::RESOURCE_TYPE_NAME);
	}

	public function GetName()
	{
		return $this->GetForm(FormKeys::NAME);
	}

	/**
	 * @return string
	 */
	public function GetDescription()
	{
		return $this->GetForm(FormKeys::RESOURCE_TYPE_DESCRIPTION);
	}

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @param IEntityAttributeList $attributeList
	 */
	public function BindAttributeList($attributeList)
	{
		$this->Set('AttributeList', $attributeList);
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		$id = $this->GetQuerystring(QueryStringKeys::RESOURCE_TYPE_ID);
		if (empty($id))
		{
			$id = $this->GetForm(FormKeys::PK);
		}

		return $id;
	}

	/**
	 * @param ResourceTypeJson[] $resourceTypes
	 */
	public function SetResourceTypesJson($resourceTypes)
	{
		$this->SetJson($resourceTypes);
	}

	public function GetValue()
	{
		return $this->GetForm(FormKeys::VALUE);
	}
}