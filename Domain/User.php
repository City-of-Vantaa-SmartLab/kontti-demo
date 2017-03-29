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

require_once(ROOT_DIR . 'Domain/Values/RoleLevel.php');
require_once(ROOT_DIR . 'Domain/Values/EmailPreferences.php');

class User
{
	public function __construct()
	{
		$this->emailPreferences = new EmailPreferences();
		$this->preferences = new UserPreferences();
	}

	/**
	 * @var IEmailPreferences
	 */
	protected $emailPreferences;

	protected $id;

	public function Id()
	{
		return $this->id;
	}

	protected $firstName;

	public function FirstName()
	{
		return $this->firstName;
	}

	protected $lastName;

	public function LastName()
	{
		return $this->lastName;
	}

	public function FullName()
	{
		return $this->FirstName() . ' ' . $this->LastName();
	}

	protected $emailAddress;

	public function EmailAddress()
	{
		return $this->emailAddress;
	}

	protected $username;

	public function Username()
	{
		return $this->username;
	}

	protected $language;

	public function Language()
	{
		return $this->language;
	}

	protected $timezone;

	public function Timezone()
	{
		return $this->timezone;
	}

	protected $homepageId;

	public function Homepage()
	{
		return $this->homepageId;
	}

	protected $statusId;

	/**
	 * @return int|null|AccountStatus
	 */
	public function StatusId()
	{
		return $this->statusId;
	}

	/**
	 * @var string
	 */
	private $lastLogin;

	/**
	 * @return string
	 */
	public function LastLogin()
	{
		return $this->lastLogin;
	}

	/**
	 * @var array|UserGroup[]
	 */
	protected $groups = array();

	/**
	 * @var UserGroup[]
	 */
	private $_addedGroups = array();

	/**
	 * @var UserGroup[]
	 */
	private $_removedGroups = array();

	/**
	 * @var array|UserGroup[]
	 */
	protected $groupsICanAdminister = array();

	/**
	 * @return array|UserGroup[]
	 */
	public function Groups()
	{
		return $this->groups;
	}

	/**
	 * @return UserGroup[]
	 */
	public function GetAddedGroups()
	{
		return $this->_addedGroups;
	}

	/**
	 * @return UserGroup[]
	 */
	public function GetRemovedGroups()
	{
		return $this->_removedGroups;
	}

	/**
	 * @param int $groupId
	 * @return bool
	 */
	public function IsInGroup($groupId)
	{
		foreach ($this->groups as $group)
		{
			if ($group->GroupId == $groupId)
			{
				return true;
			}
		}

		return false;
	}

	private $isCalendarSubscriptionAllowed = false;

	/**
	 * @param bool $isAllowed
	 */
	protected function SetIsCalendarSubscriptionAllowed($isAllowed)
	{
		$this->isCalendarSubscriptionAllowed = $isAllowed;
	}

	/**
	 * @return bool
	 */
	public function GetIsCalendarSubscriptionAllowed()
	{
		return $this->isCalendarSubscriptionAllowed;
	}

	private $publicId;

	/**
	 * @param string $publicId
	 */
	protected function SetPublicId($publicId)
	{
		$this->publicId = $publicId;
	}

	/**
	 * @return string
	 */
	public function GetPublicId()
	{
		return $this->publicId;
	}

	public function EnablePublicProfile()
	{
		if (empty($this->publicId))
		{
			$this->SetPublicId(uniqid());
		}
	}

	public function EnableSubscription()
	{
		$this->SetIsCalendarSubscriptionAllowed(true);
		$this->EnablePublicProfile();
	}

	public function DisableSubscription()
	{
		$this->SetIsCalendarSubscriptionAllowed(false);
	}

	public function Activate()
	{
		$this->statusId = AccountStatus::ACTIVE;
	}

	public function Deactivate()
	{
		$this->statusId = AccountStatus::INACTIVE;
	}

	protected $preferences;

	public function GetPreferences()
	{
		return $this->preferences;
	}

	/**
	 * @return bool
	 */
	public function IsRegistered()
	{
		return !empty($this->id);
	}

	public function ChangePreference($name, $value)
	{
		$this->preferences->Update($name, $value);
	}

	/**
	 * @var bool
	 */
	private $permissionsChanged = false;
	private $removedPermissions = array();
	private $addedPermissions = array();

	/**
	 * @var array
	 */
	protected $allowedResourceIds = array();

	/**
	 * @var string
	 * @internal
	 */
	public $encryptedPassword;

	/**
	 * @var string
	 * @internal
	 */
	public $passwordSalt;

	private $attributes = array();
	private $attributesChanged = false;

	private $isGroupAdmin = false;
	private $isApplicationAdmin = false;
	private $isResourceAdmin = false;
	private $isScheduleAdmin = false;

	/**
	 * @param array|int[] $allowedResourceIds
	 * @return void
	 */
	public function WithPermissions($allowedResourceIds = array())
	{
		$this->permissionsChanged = false;
		$this->allowedResourceIds = $allowedResourceIds;
	}

	public function WithPreferences(UserPreferences $preferences)
	{
		$this->preferences = $preferences;
	}

	/**
	 * @param array|UserGroup[] $groups
	 * @return void
	 */
	public function WithGroups($groups = array())
	{
		foreach ($groups as $group)
		{
			if ($group->IsGroupAdmin)
			{
				$this->isGroupAdmin = true;
			}
			if ($group->IsApplicationAdmin)
			{
				$this->isApplicationAdmin = true;
			}
			if ($group->IsResourceAdmin)
			{
				$this->isResourceAdmin = true;
			}
			if ($group->IsScheduleAdmin)
			{
				$this->isScheduleAdmin = true;
			}
		}

		$this->groups = $groups;
	}

	/**
	 * @param array|UserGroup[] $ownedGroups
	 */
	public function WithOwnedGroups($ownedGroups = array())
	{
		$this->groupsICanAdminister = $ownedGroups;
	}

	public function ChangePermissions($allowedResourceIds = array())
	{
		$removed = array_diff($this->allowedResourceIds, $allowedResourceIds);
		$added = array_diff($allowedResourceIds, $this->allowedResourceIds);

		if (!empty($removed) || !empty($added))
		{
			$this->permissionsChanged = true;
			$this->removedPermissions = $removed;
			$this->addedPermissions = $added;

			$this->allowedResourceIds = $allowedResourceIds;
		}
	}

	/**
	 * @return array
	 */
	public function AllowedResourceIds()
	{
		return $this->allowedResourceIds;
	}

	/**
	 * @internal
	 * @param IEmailPreferences $emailPreferences
	 * @return void
	 */
	public function WithEmailPreferences(IEmailPreferences $emailPreferences)
	{
		$this->emailPreferences = $emailPreferences;
	}

	/**
	 * @param IDomainEvent $event
	 * @return bool
	 */
	public function WantsEventEmail(IDomainEvent $event)
	{
		return $this->emailPreferences->Exists($event->EventCategory(), $event->EventType());
	}

	/**
	 * @param IDomainEvent $event
	 * @param bool $turnedOn
	 */
	public function ChangeEmailPreference(IDomainEvent $event, $turnedOn)
	{
		if ($turnedOn)
		{
			$this->emailPreferences->AddPreference($event);
		}
		else
		{
			$this->emailPreferences->RemovePreference($event);
		}
	}

	/**
	 * @param string $loginTime
	 * @param string $language
	 */
	public function Login($loginTime, $language)
	{
		$this->lastLogin = $loginTime;
		$this->language = $language;
		$this->EnablePublicProfile();
	}

	/**
	 * @return array|IDomainEvent[]
	 */
	public function GetAddedEmailPreferences()
	{
		return $this->emailPreferences->GetAdded();
	}

	/**
	 * @return array|IDomainEvent[]
	 */
	public function GetRemovedEmailPreferences()
	{
		return $this->emailPreferences->GetRemoved();
	}

	public static function FromRow($row)
	{
		$user = new User();
		$user->id = $row[ColumnNames::USER_ID];
		$user->firstName = $row[ColumnNames::FIRST_NAME];
		$user->lastName = $row[ColumnNames::LAST_NAME];
		$user->emailAddress = $row[ColumnNames::EMAIL];
		$user->username = $row[ColumnNames::USERNAME];
		$user->language = $row[ColumnNames::LANGUAGE_CODE];
		$user->timezone = $row[ColumnNames::TIMEZONE_NAME];
		$user->statusId = $row[ColumnNames::USER_STATUS_ID];
		$user->encryptedPassword = $row[ColumnNames::PASSWORD];
		$user->passwordSalt = $row[ColumnNames::SALT];
		$user->homepageId = $row[ColumnNames::HOMEPAGE_ID];
		$user->lastLogin = $row[ColumnNames::LAST_LOGIN];
		$user->isCalendarSubscriptionAllowed = $row[ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION];
		$user->publicId = $row[ColumnNames::PUBLIC_ID];
		$user->defaultScheduleId = $row[ColumnNames::DEFAULT_SCHEDULE_ID];

		$user->attributes[UserAttribute::Phone] = $row[ColumnNames::PHONE_NUMBER];
		$user->attributes[UserAttribute::Position] = $row[ColumnNames::POSITION];
		$user->attributes[UserAttribute::Organization] = $row[ColumnNames::ORGANIZATION];

		$user->isApplicationAdmin = Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL) == $row[ColumnNames::EMAIL];

		return $user;
	}

	/**
	 * @static
	 * @return User
	 */
	public static function Create($firstName, $lastName, $emailAddress, $userName, $language, $timezone, $password,
								  $passwordSalt, $homepageId = Pages::DEFAULT_HOMEPAGE_ID)
	{
		$user = new User();
		$user->firstName = $firstName;
		$user->lastName = $lastName;
		$user->emailAddress = $emailAddress;
		$user->username = $userName;
		$user->language = $language;
		$user->timezone = $timezone;
		$user->encryptedPassword = $password;
		$user->passwordSalt = $passwordSalt;
		$user->homepageId = $homepageId;
		$user->statusId = AccountStatus::ACTIVE;
		return $user;
	}

	/**
	 * @static
	 * @return User
	 */
	public static function CreatePending($firstName, $lastName, $emailAddress, $userName, $language, $timezone,
										 $password, $passwordSalt, $homepageId = Pages::DEFAULT_HOMEPAGE_ID)
	{
		$user = self::Create($firstName, $lastName, $emailAddress, $userName, $language, $timezone, $password,
							 $passwordSalt, $homepageId);
		$user->statusId = AccountStatus::AWAITING_ACTIVATION;
		return $user;
	}

	/**
	 * @param int $userId
	 */
	public function WithId($userId)
	{
		$this->id = $userId;
	}

	/**
	 * @param string $loginTime
	 */
	public function WithLastLogin($loginTime)
	{
		$this->lastLogin = $loginTime;
	}

	/**
	 * @internal
	 * @return array
	 */
	public function GetAddedPermissions()
	{
		return $this->addedPermissions;
	}

	/**
	 * @internal
	 * @return array
	 */
	public function GetRemovedPermissions()
	{
		return $this->removedPermissions;
	}

	/**
	 * @param string $encryptedPassword
	 * @param string $salt
	 */
	public function ChangePassword($encryptedPassword, $salt)
	{
		$this->encryptedPassword = $encryptedPassword;
		$this->passwordSalt = $salt;
	}

	public function ChangeName($firstName, $lastName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}

	public function ChangeEmailAddress($emailAddress)
	{
		$this->emailAddress = $emailAddress;
	}

	public function ChangeUsername($username)
	{
		$this->username = $username;
	}

	public function ChangeDefaultHomePage($homepageId)
	{
		$this->homepageId = $homepageId;
	}

	public function ChangeTimezone($timezoneName)
	{
		$this->timezone = $timezoneName;
	}

	public function ChangeAttributes($phone, $organization, $position)
	{
		$this->attributesChanged = true;

		$this->attributes[UserAttribute::Phone] = $phone;
		$this->attributes[UserAttribute::Organization] = $organization;
		$this->attributes[UserAttribute::Position] = $position;
	}

	public function HaveAttributesChanged()
	{
		return $this->attributesChanged;
	}

	/**
	 * @param UserAttribute|string $attributeName
	 * @return string
	 */
	public function GetAttribute($attributeName)
	{
		if (array_key_exists($attributeName, $this->attributes))
		{
			return $this->attributes[$attributeName];
		}
		return null;
	}

	/**
	 * @return bool
	 */
	public function IsGroupAdmin()
	{
		return $this->isGroupAdmin;
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function IsAdminFor(User $user)
	{
		if ($this->isApplicationAdmin)
		{
			return true;
		}

		if (!$this->isGroupAdmin)
		{
			return false;
		}

		$adminIdsForUser = array();
		foreach ($user->Groups() as $userGroup)
		{
			if (!empty($userGroup->AdminGroupId))
			{
				$adminIdsForUser[$userGroup->AdminGroupId] = true;
			}
		}

		foreach ($this->Groups() as $group)
		{
			if ($group->IsGroupAdmin)
			{
				if (array_key_exists($group->GroupId, $adminIdsForUser))
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param IResource $resource
	 * @return bool
	 */
	public function IsResourceAdminFor(IResource $resource)
	{
		if ($this->isApplicationAdmin)
		{
			return true;
		}

		if ($this->isResourceAdmin || $this->isScheduleAdmin)
		{
			foreach ($this->groups as $group)
			{
				if (
						($group->GroupId == $resource->GetAdminGroupId()) ||
						($group->GroupId == $resource->GetScheduleAdminGroupId())
				)
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * @param IResource[] $resources
	 * @return bool
	 */
	public function IsResourceAdminForOneOf($resources)
	{
		foreach ($resources as $resource)
		{
			if ($this->IsResourceAdminFor($resource))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param ISchedule $schedule
	 * @return bool
	 */
	public function IsScheduleAdminFor(ISchedule $schedule)
	{
		if ($this->isApplicationAdmin)
		{
			return true;
		}

		if (!$this->isScheduleAdmin)
		{
			return false;
		}

		foreach ($this->groups as $group)
		{
			if ($group->GroupId == $schedule->GetAdminGroupId())
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param int|RoleLevel $roleLevel
	 * @return bool
	 */
	public function IsInRole($roleLevel)
	{
		if ($roleLevel == RoleLevel::GROUP_ADMIN)
		{
			return $this->isGroupAdmin;
		}
		if ($roleLevel == RoleLevel::APPLICATION_ADMIN)
		{
			return $this->isApplicationAdmin;
		}
		if ($roleLevel == RoleLevel::RESOURCE_ADMIN)
		{
			return $this->isResourceAdmin;
		}
		if ($roleLevel == RoleLevel::SCHEDULE_ADMIN)
		{
			return $this->isScheduleAdmin;
		}

		return false;
	}

	/**
	 * @static
	 * @return User
	 */
	public static function Null()
	{
		return new NullUser();
	}

	/**
	 * @return array|UserGroup[]
	 */
	public function GetAdminGroups()
	{
		return $this->groupsICanAdminister;
	}

	/**
	 * @param $attribute AttributeValue
	 */
	public function WithAttribute(AttributeValue $attribute)
	{
		$this->_attributeValues[$attribute->AttributeId] = $attribute;
	}

	/**
	 * @var array|AttributeValue[]
	 */
	private $_attributeValues = array();

	/**
	 * @var array|AttributeValue[]
	 */
	private $_addedAttributeValues = array();

	/**
	 * @var array|AttributeValue[]
	 */
	private $_removedAttributeValues = array();

	/**
	 * @var int
	 */
	private $credits;

	/**
	 * @param $attributes AttributeValue[]|array
	 */
	public function ChangeCustomAttributes($attributes)
	{
		$diff = new ArrayDiff($this->_attributeValues, $attributes);

		$added = $diff->GetAddedToArray1();
		$removed = $diff->GetRemovedFromArray1();

		/** @var $attribute AttributeValue */
		foreach ($added as $attribute)
		{
			$this->_addedAttributeValues[] = $attribute;
		}

		/** @var $attribute AttributeValue */
		foreach ($removed as $attribute)
		{
			$this->_removedAttributeValues[] = $attribute;
		}

		foreach ($attributes as $attribute)
		{
			$this->AddAttributeValue($attribute);
		}
	}

	/**
	 * @param $attributeValue AttributeValue
	 */
	public function AddAttributeValue($attributeValue)
	{
		$this->_attributeValues[$attributeValue->AttributeId] = $attributeValue;
	}

	/**
	 * @return array|AttributeValue[]
	 */
	public function GetAddedAttributes()
	{
		return $this->_addedAttributeValues;
	}

	/**
	 * @return array|AttributeValue[]
	 */
	public function GetRemovedAttributes()
	{
		return $this->_removedAttributeValues;
	}

	/**
	 * @param $customAttributeId
	 * @return mixed
	 */
	public function GetAttributeValue($customAttributeId)
	{
		if (array_key_exists($customAttributeId, $this->_attributeValues))
		{
			return $this->_attributeValues[$customAttributeId]->Value;
		}

		return null;
	}

	/**
	 * @var int|null
	 */
	protected $defaultScheduleId;

	/**
	 * @return int|null
	 */
	public function GetDefaultScheduleId()
	{
		return $this->defaultScheduleId;
	}

	/**
	 * @param int $scheduleId
	 */
	public function ChangeDefaultSchedule($scheduleId)
	{
		$this->defaultScheduleId = $scheduleId;
	}

	/**
	 * @param int $scheduleId
	 */
	public function WithDefaultSchedule($scheduleId)
	{
		$this->defaultScheduleId = $scheduleId;
	}

	public function IsGroupAdminFor($groupId)
	{
		foreach ($this->groupsICanAdminister as $group)
		{
			if ($group->GroupId == $groupId)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * @param $preferenceName string
	 * @return null|string
	 */
	public function GetPreference($preferenceName)
	{
		return $this->preferences->Get($preferenceName);
	}

	public function ChangeGroups($groups)
	{
		$diff = new ArrayDiff($this->groups, $groups);

		$added = $diff->GetAddedToArray1();
		$removed = $diff->GetRemovedFromArray1();

		/** @var $group UserGroup */
		foreach ($added as $group)
		{
			$this->_addedGroups[] = $group;
		}

		/** @var $group UserGroup */
		foreach ($removed as $group)
		{
			$this->_removedGroups[] = $group;
		}

		$this->WithGroups($groups);
	}

	/**
	 * @param $attribute AttributeValue
	 */
	public function ChangeCustomAttribute($attribute)
	{
		$this->_removedAttributeValues[] = $attribute;
		$this->_addedAttributeValues[] = $attribute;
		$this->AddAttributeValue($attribute);
	}

	public function GetCurrentCredits()
	{
		return empty($this->credits) ? 0 : $this->credits;
	}

	public function WithCredits($credits)
	{
		$this->credits = $credits;
	}

	public function ChangeCurrentCredits($credits)
	{
		$this->credits = $credits;
	}
}

class NullUser extends User
{
    public function Id()
    {
        return null;
    }
}

class GuestUser extends User
{
	public function __construct($email)
	{
		parent::__construct();
		$this->emailAddress = $email;
		$this->language = Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);
		$this->timezone = Configuration::Instance()->GetDefaultTimezone();
	}
}

class UserAttribute
{
	const Phone = 'phone';
	const Organization = 'organization';
	const Position = 'position';

	/**
	 * @var array|string[]
	 */
	private $attributeValues = array();

	public function __construct($attributeValues = array())
	{
		$this->attributeValues = $attributeValues;
	}

	/**
	 * @param string|UserAttribute $attributeName
	 * @return null|string
	 */
	public function Get($attributeName)
	{
		if (array_key_exists($attributeName, $this->attributeValues))
		{
			return $this->attributeValues[$attributeName];
		}

		return null;
	}
}

class UserGroup
{
	/**
	 * @var int
	 */
	public $GroupId;

	/**
	 * @var string
	 */
	public $GroupName;

	/**
	 * @var int|null
	 */
	public $AdminGroupId;

	/**
	 * @var bool
	 */
	public $IsGroupAdmin = false;

	/**
	 * @var bool
	 */
	public $IsApplicationAdmin = false;

	/**
	 * @var bool
	 */
	public $IsResourceAdmin = false;

	/**
	 * @var bool
	 */
	public $IsScheduleAdmin = false;

	/**
	 * @param int $groupId
	 * @param string $groupName
	 * @param int|null $adminGroupId
	 * @param int|RoleLevel $roleLevel defaults to none
	 */
	public function __construct($groupId, $groupName, $adminGroupId = null, $roleLevel = RoleLevel::NONE)
	{
		$this->GroupId = $groupId;
		$this->GroupName = $groupName;
		$this->AdminGroupId = $adminGroupId;
		$this->AddRole($roleLevel);
	}

	/**
	 * @param int|null|RoleLevel $roleLevel
	 */
	public function AddRole($roleLevel = null)
	{
		if ($roleLevel == RoleLevel::GROUP_ADMIN)
		{
			$this->IsGroupAdmin = true;
		}
		if ($roleLevel == RoleLevel::APPLICATION_ADMIN)
		{
			$this->IsApplicationAdmin = true;
		}
		if ($roleLevel == RoleLevel::RESOURCE_ADMIN)
		{
			$this->IsResourceAdmin = true;
		}
		if ($roleLevel == RoleLevel::SCHEDULE_ADMIN)
		{
			$this->IsScheduleAdmin = true;
		}
	}

	public function __toString()
	{
		return $this->GroupId . '';
	}
}