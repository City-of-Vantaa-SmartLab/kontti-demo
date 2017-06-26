<?php
/**
 * This file is part of Muuntamo.
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
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Pages/mod/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

class AddResourceFoodConfPage extends ActionPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;
	public function ProcessDataRequest($dataRequest){}
	public function ProcessAction(){}
	public function __construct()
	{
		parent::__construct('AddResourceFoodConf');
	}

	public function ProcessPageLoad()
	{
		if (ServiceLocator::GetServer()->GetUserSession()->IsAdmin){
			if(isset($_POST['resourceFoodConfName'])&&isset($_POST['resourceFoodConfDesc'])&&isset($_POST['resourceFoodConfPrice'])&&isset($_POST['resourceFoodConfContentlist'])){
				$ResourceFoodConfName=$_POST['resourceFoodConfName'];
				$ResourceFoodConfDesc=$_POST['resourceFoodConfDesc'];
				$ResourceFoodConfPrice=$_POST['resourceFoodConfPrice'];
				$ResourceFoodConfContentlist=$_POST['resourceFoodConfContentlist'];
				if($ResourceFoodConfName!=NULL){
					createResourceFoodConf($ResourceFoodConfName,$ResourceFoodConfDesc,$ResourceFoodConfPrice,$ResourceFoodConfContentlist);
				}
			}else{
				
			}
		}else{
			//log this?
		}
		header( "Location: ../manage_resources.php" ) ;
	}
}