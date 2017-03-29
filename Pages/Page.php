<?php
/**
 * Copyright 2011-2016 Nick Korbel
 * Copyright 2014 Jason Gerfen
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

require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/external/MobileDetect/Mobile_Detect.php');

abstract class Page implements IPage
{
	/**
	 * @var SmartyPage
	 */
	protected $smarty = null;

	/**
	 * @var Server
	 */
	protected $server = null;
	protected $path;

	protected $IsMobile = false;
	protected $IsTablet = false;
	protected $IsDesktop = true;

	protected function __construct($titleKey = '', $pageDepth = 0)
	{
		ExceptionHandler::SetExceptionHandler(new WebExceptionHandler(array($this, 'RedirectToError')));

		$this->SetSecurityHeaders();

		$this->path = str_repeat('../', $pageDepth);
		$this->server = ServiceLocator::GetServer();
		$resources = Resources::GetInstance();

		$this->smarty = new SmartyPage($resources, $this->path);

		$userSession = ServiceLocator::GetServer()->GetUserSession();
		$this->smarty->assign('Timezone', $userSession->Timezone);
		$this->smarty->assign('Charset', $resources->Charset);
		$this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->smarty->assign('HtmlLang', $resources->HtmlLang);
		$this->smarty->assign('HtmlTextDirection', $resources->TextDirection);
		$appTitle = Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE);
		$pageTile = $resources->GetString($titleKey);
		$this->smarty->assign('Title', (empty($appTitle) ? 'Booked' : $appTitle) . (empty($pageTile) ? '' : ' - ' . $pageTile));
		$this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);

		$this->smarty->assign('LoggedIn', $userSession->IsLoggedIn());
		$this->smarty->assign('Version', Configuration::VERSION);
		$this->smarty->assign('Path', $this->path);
		$this->smarty->assign('ScriptUrl', Configuration::Instance()->GetScriptUrl());
		$this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
		$this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
		$this->smarty->assign('UserId', $userSession->UserId);
		$this->smarty->assign('CanViewAdmin', $userSession->IsAdmin);
		$this->smarty->assign('CanViewGroupAdmin', $userSession->IsGroupAdmin);
		$this->smarty->assign('CanViewResourceAdmin', $userSession->IsResourceAdmin);
		$this->smarty->assign('CanViewScheduleAdmin', $userSession->IsScheduleAdmin);
		$this->smarty->assign('CanViewResponsibilities',
							  !$userSession->IsAdmin && ($userSession->IsGroupAdmin || $userSession->IsResourceAdmin || $userSession->IsScheduleAdmin));
		$allowAllUsersToReports = Configuration::Instance()->GetSectionKey(ConfigSection::REPORTS, ConfigKeys::REPORTS_ALLOW_ALL, new BooleanConverter());
		$this->smarty->assign('CanViewReports',
				($allowAllUsersToReports || $userSession->IsAdmin || $userSession->IsGroupAdmin || $userSession->IsResourceAdmin || $userSession->IsScheduleAdmin));
		$timeout = Configuration::Instance()->GetKey(ConfigKeys::INACTIVITY_TIMEOUT);
		if (!empty($timeout))
		{
			$this->smarty->assign('SessionTimeoutSeconds', max($timeout, 1) * 60);
		}
		$this->smarty->assign('ShouldLogout', $this->GetShouldAutoLogout());
		$this->smarty->assign('CssExtensionFile', Configuration::Instance()->GetKey(ConfigKeys::CSS_EXTENSION_FILE));
		$this->smarty->assign('UseLocalJquery', Configuration::Instance()->GetKey(ConfigKeys::USE_LOCAL_JQUERY, new BooleanConverter()));
		$this->smarty->assign('EnableConfigurationPage',
							  Configuration::Instance()->GetSectionKey(ConfigSection::PAGES, ConfigKeys::PAGES_ENABLE_CONFIGURATION, new BooleanConverter()));
		$this->smarty->assign('ShowParticipation', !Configuration::Instance()
																 ->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_PREVENT_PARTICIPATION,
																				 new BooleanConverter()));

		$this->smarty->assign('LogoUrl', 'booked.png');
		if (file_exists($this->path . 'img/custom-logo.png'))
		{
			$this->smarty->assign('LogoUrl', 'custom-logo.png');
		}
		if (file_exists($this->path . 'img/custom-logo.gif'))
		{
			$this->smarty->assign('LogoUrl', 'custom-logo.gif');
		}
		if (file_exists($this->path . 'img/custom-logo.jpg'))
		{
			$this->smarty->assign('LogoUrl', 'custom-logo.jpg');
		}

		$this->smarty->assign('CssUrl', 'null-style.css');
		if (file_exists($this->path . 'css/custom-style.css'))
		{
			$this->smarty->assign('CssUrl', 'custom-style.css');
		}

		$logoUrl = Configuration::Instance()->GetKey(ConfigKeys::HOME_URL);
		if (empty($logoUrl))
		{
			$logoUrl = $this->path . Pages::UrlFromId($userSession->HomepageId);
		}
		$this->smarty->assign('HomeUrl', $logoUrl);

		$detect = new Mobile_Detect();
		$this->IsMobile = $detect->isMobile();
		$this->IsTablet = $detect->isTablet();
		$this->IsDesktop = !$this->IsMobile && !$this->IsTablet;
		$this->Set('IsMobile', $this->IsMobile);
		$this->Set('IsTablet', $this->IsTablet);
		$this->Set('IsDesktop', $this->IsDesktop);
		$this->Set('GoogleAnalyticsTrackingId', Configuration::Instance()->GetSectionKey(ConfigSection::GOOGLE_ANALYTICS, ConfigKeys::GOOGLE_ANALYTICS_TRACKING_ID));
	}

	protected function SetTitle($title)
	{
		$this->smarty->assign('Title', $title);
	}

	public function Redirect($url)
	{
		if (!BookedStringHelper::StartsWith($url, $this->path))
		{
			$url = $this->path . $url;
		}

		$url = str_replace('&amp;', '&', $url);
		header("Location: $url");
		die();
	}

	public function RedirectResume($url)
	{
		if (!BookedStringHelper::StartsWith($url, $this->path))
		{
			$url = $this->path . $url;
		}

		header("Location: $url");
		die();
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		$errorMessageKey = ErrorMessages::Instance()->GetResourceKey($errorMessageId);
		$this->Set('ErrorMessage', $errorMessageKey);
		$this->Set('TitleKey', 'Error');
		$this->Display('error.tpl');
		die();
	}

	public function GetLastPage($defaultPage = '')
	{
		$referer = getenv("HTTP_REFERER");
		if (empty($referer))
		{
			return empty($defaultPage) ? Pages::LOGIN : $defaultPage;
		}

		$scriptUrl = Configuration::Instance()->GetScriptUrl();
		$page = str_ireplace($scriptUrl, '', $referer);
		return ltrim($page, '/');
	}

	public function DisplayWelcome()
	{
		return true;
	}

	/**
	 * Returns whether or not the user has been authenticated
	 *
	 * @return bool
	 */
	public function IsAuthenticated()
	{
		return !is_null($this->server->GetUserSession()) && $this->server->GetUserSession()->IsLoggedIn();
	}

	/**
	 * Returns whether or not the page is currently posting back to itself
	 *
	 * @return bool
	 */
	public function IsPostBack()
	{
		return !empty($_POST);
	}

	/**
	 * Registers a Validator with the page
	 *
	 * @param int|string $validatorId
	 * @param IValidator $validator
	 */
	public function RegisterValidator($validatorId, $validator)
	{
		$this->smarty->Validators->Register($validatorId, $validator);
	}

	/**
	 * Whether or not the current page is valid when checked against all registered validators
	 *
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->smarty->IsValid();
	}

	/**
	 * @param string $var
	 * @param string $value
	 * @return void
	 */
	public function Set($var, $value)
	{
		$this->smarty->assign($var, $value);
	}

	public function EnforceCSRFCheck()
	{
		$session = $this->server->GetUserSession();
		if (!$session->IsLoggedIn())
		{
			return;
		}
		$token = $this->GetForm(FormKeys::CSRF_TOKEN);
		$session = $this->server->GetUserSession();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($token) || $token != $session->CSRFToken))
		{
			Log::Error('Possible CSRF attack. Submitted token=%s, Expected token=%s', $token, $session->CSRFToken);
			http_response_code(500);
			die('Insecure request');
		}
	}

	public function GetSortField()
    {
        return $this->GetQuerystring(QueryStringKeys::SORT_FIELD);
    }

    public function GetSortDirection()
    {
        return $this->GetQuerystring(QueryStringKeys::SORT_DIRECTION);
    }

	/**
	 * @param string $var
	 * @return string
	 */
	protected function GetVar($var)
	{
		return $this->smarty->getTemplateVars($var);
	}

	/**
	 * @param string $var
	 * @return null|string
	 */
	protected function GetForm($var)
	{
		return $this->server->GetForm($var);
	}

	/**
	 * @param string $var
	 * @return null|string
	 */
	protected function GetCheckbox($var)
	{
		$val = $this->server->GetForm($var);
		return !empty($val);
	}

	/**
	 * @param string $var
	 * @return null
	 */
	protected function GetRawForm($var)
	{
		return $this->server->GetRawForm($var);
	}

	/**
	 * @param string $key
	 * @return null|string
	 */
	protected function GetQuerystring($key)
	{
		return $this->server->GetQuerystring($key);
	}

	/**
	 * @param string $objectToSerialize
	 * @param string|null $error
	 * @return void
	 */
	protected function SetJson($objectToSerialize, $error = null)
	{
		header('Content-type: application/json');

		if (empty($error))
		{
			$this->Set('data', json_encode($objectToSerialize));
		}
		else
		{
			$this->Set('error', json_encode(array('response' => $objectToSerialize, 'errors' => $error)));
		}
		$this->smarty->display('json_data.tpl');
	}

	/**
	 * @param string $objectToSerialize
	 * @return void
	 */
	protected function SetJsonError($objectToSerialize)
	{
		header('Content-type: application/json');
		header('HTTP/1.1 500 Internal Server Error');

		$this->Set('data', json_encode($objectToSerialize));

		$this->smarty->display('json_data.tpl');
	}

	/**
	 * A template file to be displayed
	 * @param string $templateName
	 */
	protected function Display($templateName)
	{
		if (!$this->InMaintenanceMode())
		{
			$this->smarty->display($templateName);
		}
		else
		{
			$this->smarty->display('maintenance.tpl');
		}
	}

	protected function DisplayCsv($templateName, $fileName)
	{
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$fileName;");
		header("Content-Transfer-Encoding: binary");
		echo chr(239) . chr(187) . chr(191);

		$this->Display($templateName);
	}

	/**
	 * @param string $templateName
	 * @param null $languageCode uses current language is nothing is passed in
	 */
	protected function DisplayLocalized($templateName, $languageCode = null)
	{
		if (empty($languageCode))
		{
			$languageCode = $this->GetVar('CurrentLanguage');
		}
		$localizedPath = ROOT_DIR . 'lang/' . $languageCode;
		$defaultPath = ROOT_DIR . 'lang/en_us/';

		if (file_exists($localizedPath . '/' . $templateName))
		{
			$this->smarty->AddTemplateDirectory($localizedPath);
		}
		else
		{
			$this->smarty->AddTemplateDirectory($defaultPath);
		}

		$this->Display($templateName);
	}

	protected function GetShouldAutoLogout()
	{
		$timeout = $this->GetVar('SessionTimeoutSeconds');

		return !empty($timeout);
	}

	private function InMaintenanceMode()
	{
		return is_file(ROOT_DIR . 'maint.txt');
	}

	private function SetSecurityHeaders()
	{
		$config = Configuration::Instance();
		if ($config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_HEADERS, new BooleanConverter()))
		{
			header('Strict-Transport-Security: ' . $config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_STRICT_TRANSPORT));
			header('X-Frame: ' . $config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_X_FRAME));
			header('X-Xss: ' . $config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_X_XSS));
			header('X-Content-Type: ' . $config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_X_CONTENT_TYPE));
			header('Content-Security-Policy: ' . $config->GetSectionKey(ConfigSection::SECURITY, ConfigKeys::SECURITY_CONTENT_SECURITY_POLICY));
		}
	}
}