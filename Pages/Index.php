<?php
/**
This file is part of Muuntamo.

Muuntamo is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Muuntamo is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Muuntamo.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/LoginPage.php');

class IndexPage extends Page
{
	public function __construct()
	{
		parent::__construct('Index');
	}

	public function PageLoad()
	{
		$this->Set('RemindersPath', realpath(ROOT_DIR . 'Jobs/sendreminders.php'));
		$this->Set('AutoReleasePath', realpath(ROOT_DIR . 'Jobs/autorelease.php'));
		$this->Set('WaitListPath', realpath(ROOT_DIR . 'Jobs/sendwaitlist.php'));
		$this->Set('ServerTimezone', date_default_timezone_get());
		$this->DisplayLocalized('index.tpl');
	}
}
