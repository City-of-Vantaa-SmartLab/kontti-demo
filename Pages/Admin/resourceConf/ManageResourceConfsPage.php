<?php
/**
 * This file is part of Muuntamo.
 *
 * Muuntamo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Muuntamo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Muuntamo.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/mod/namespace.php');

class ResourceConfPage extends AdminPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $presenter;
	protected $pageablePage;
	public function ProcessDataRequest($dataRequest){}
	public function ProcessAction(){}

	public function __construct()
	{
		parent::__construct('ResourceConfigurations');
		$this->pageablePage = new PageablePage($this);
		$this->Set('ResourceConfs', getAllResourceArrangements());
		$this->Set('ConfResources', getAllConfResources());
	}

	
	public function PageLoad()
	{ 
		$this->Display('Resources/manage_resource_confs.tpl');
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
}