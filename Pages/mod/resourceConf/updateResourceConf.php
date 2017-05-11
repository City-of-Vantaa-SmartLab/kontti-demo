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
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Pages/mod/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

class UpdateResourceConfPage extends ActionPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;
	public function ProcessDataRequest($dataRequest){}
	public function ProcessAction(){}
	public function __construct()
	{
		parent::__construct('UpdateResourceConf');
	}

	public function ProcessPageLoad()
	{
		if (ServiceLocator::GetServer()->GetUserSession()->IsAdmin){
			if(isset($_POST['conf_id'])&&isset($_POST['name'])&&isset($_POST['description'])&&isset($_POST['price'])&&isset($_POST['furni'])){
				$conf_id=$_POST['conf_id'];
				$name=$_POST['name'];
				$description=$_POST['description'];
				$price=$_POST['price'];
				$furni=$_POST['furni'];
				updateResourceArrangement($conf_id,$name,$description,$price,$furni);
			}else{
				
			}
		}else{
			//log this?
		}
		header( "Location: ".ROOT_DIR."Web/admin/manage_resource_confs.php" ) ;
	}
}