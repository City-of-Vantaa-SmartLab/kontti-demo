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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Pages/mod/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class UpdateBillingInformationPage extends ActionPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;
	public function ProcessDataRequest($dataRequest){}
	public function ProcessAction(){}
	public function __construct()
	{
		parent::__construct('UpdateBillingInformation');
	}

	public function ProcessPageLoad()
	{
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		if (isset($userSession->UserId)){
			if(isset($_POST['compname'])&&isset($_POST['personid'])&&isset($_POST['billingaddress'])&&isset($_POST['reference'])){
				$compname=regexUserInfoText($_POST['compname']);
				$personid=regexUserInfoText($_POST['personid']);
				$billingaddress=regexUserInfoText($_POST['billingaddress']);
				$reference=regexUserInfoText($_POST['reference']);
				addUserAddonInfo($userSession->UserId,$compname,$personid,$billingaddress,$reference);
				
			}else{
			}
			
		}else{
			//log this?
		}
		header( "Location: ".ROOT_DIR."Web/billing-information.php" ) ;
	}
}