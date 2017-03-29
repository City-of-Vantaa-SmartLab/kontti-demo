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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAttributesPresenter.php');

interface IManageAttributesPage extends IActionPage
{
	/**
	 * @abstract
	 * return string
	 */
	public function GetLabel();

	/**
	 * @abstract
	 * return int|CustomAttributeTypes
	 */
	public function GetType();

	/**
	 * return int|CustomAttributeCategory
	 */
	public function GetCategory();

	/**
	 * return string
	 */
	public function GetValidationExpression();

	/**
	 * return bool
	 */
	public function GetIsRequired();

	/**
	 * @return int[]
	 */
	public function GetEntityIds();

	/**
	 * return string
	 */
	public function GetPossibleValues();

	/**
	 * return int|CustomAttributeCategory
	 */
	public function GetRequestedCategory();

	/**
	 * @return int
	 */
	public function GetSortOrder();

	/**
	 * return bool
	 */
	public function GetIsAdminOnly();

	/**
	 * @param $attributes CustomAttribute[]|array
	 */
	public function BindAttributes($attributes);

	/**
	 * @param $categoryId int|CustomAttributeCategory
	 */
	public function SetCategory($categoryId);

	/**
	 * @return int
	 */
	public function GetAttributeId();

	/**
	 * @return int|null
	 */
	public function GetSecondaryEntityIds();

	/**
	 * @return CustomAttributeCategory|int|null
	 */
	public function GetSecondaryCategory();

	/**
	 * @return bool
	 */
	public function GetLimitAttributeScope();

	/**
	 * @return bool
	 */
	public function GetIsPrivate();
}

class ManageAttributesPage extends ActionPage implements IManageAttributesPage
{
	/**
	 * @var ManageAttributesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('CustomAttributes', 1);
		$this->presenter = new ManageAttributesPresenter($this, new AttributeRepository());
	}

	public function PageLoad()
	{
		$typeLookup = array(
				CustomAttributeTypes::SINGLE_LINE_TEXTBOX => 'SingleLineTextbox',
				CustomAttributeTypes::MULTI_LINE_TEXTBOX => 'MultiLineTextbox',
				CustomAttributeTypes::CHECKBOX => 'Checkbox',
				CustomAttributeTypes::SELECT_LIST => 'SelectList',
				CustomAttributeTypes::DATETIME => 'DateTime',
		);

		$this->Set('Types', $typeLookup);

		parent::PageLoad();
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('Admin/Attributes/manage_attributes.tpl');
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function GetLabel()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_LABEL);
	}

	public function GetType()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_TYPE);
	}

	public function GetCategory()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_CATEGORY);
	}

	public function GetValidationExpression()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_VALIDATION_EXPRESSION);
	}

	public function GetIsRequired()
	{
		$required = $this->GetForm(FormKeys::ATTRIBUTE_IS_REQUIRED);
		return !empty($required);
	}

	public function GetEntityIds()
	{
		$ids = $this->GetForm(FormKeys::ATTRIBUTE_ENTITY);
		if (is_null($ids))
		{
			return array();
		}

		if (!is_array($ids))
		{
			return array($ids);
		}

		return $ids;
	}

	public function GetPossibleValues()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_POSSIBLE_VALUES);
	}

	public function GetSortOrder()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_SORT_ORDER);
	}

	public function GetRequestedCategory()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTRIBUTE_CATEGORY);
	}

	public function GetIsAdminOnly()
	{
		$adminOnly = $this->GetForm(FormKeys::ATTRIBUTE_IS_ADMIN_ONLY);
		return !empty($adminOnly);
	}

	public function BindAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
		$this->Display('Admin/Attributes/attribute-list.tpl');
	}

	public function SetCategory($categoryId)
	{
		$this->Set('Category', $categoryId);
	}

	public function GetAttributeId()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTRIBUTE_ID);
	}

	public function GetSecondaryEntityIds()
	{
		$ids = $this->GetForm(FormKeys::ATTRIBUTE_SECONDARY_ENTITY_IDS);
		if (is_null($ids))
		{
			return array();
		}

		if (!is_array($ids))
		{
			return array($ids);
		}

		return $ids;
	}

	public function GetSecondaryCategory()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_SECONDARY_CATEGORY);
	}

	public function GetLimitAttributeScope()
	{
		$limit = $this->GetForm(FormKeys::ATTRIBUTE_LIMIT_SCOPE);
		return !empty($limit);
	}

	public function GetIsPrivate()
	{
		$isPrivate = $this->GetForm(FormKeys::ATTRIBUTE_IS_PRIVATE);
		return !empty($isPrivate);
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->HandleDataRequest($dataRequest);
	}
}