<?php
/**
 * Copyright 2012-2016 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface ICalendarSubscriptionService
{
    /**
     * @param string $publicResourceId
     * @return BookableResource
     */
    public function GetResource($publicResourceId);

    /**
     * @param string $publicScheduleId
     * @return Schedule
     */
    public function GetSchedule($publicScheduleId);

    /**
     * @param string $publicUserId
     * @return User
     */
    public function GetUser($publicUserId);

    /**
     * @param int $userId
     * @param null|int $resourceId
     * @param null|int $scheduleId
     * @return CalendarSubscriptionDetails
     */
    public function ForUser($userId, $resourceId = null, $scheduleId = null);

    /**
     * @param int $resourceId
     * @return CalendarSubscriptionDetails
     */
    public function ForResource($resourceId);

    /**
     * @param int $scheduleId
     * @return CalendarSubscriptionDetails
     */
    public function ForSchedule($scheduleId);

    /**
     * @param string $publicResourceGroupId
     * @return int[]
     */
    public function GetResourcesInGroup($publicResourceGroupId);
}

class CalendarSubscriptionDetails
{
    /**
     * @var bool
     */
    private $isAllowed;

    /**
     * @var CalendarSubscriptionUrl
     */
    private $url;

    /**
     * @param bool $isAllowed
     * @param null|CalendarSubscriptionUrl $url
     */
    public function __construct($isAllowed, $url = null)
    {
        $this->isAllowed = $isAllowed;
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function IsAllowed()
    {
        return $this->isAllowed;
    }

    /**
     * @return bool
     */
    public function IsEnabled()
    {
        $key = Configuration::Instance()->GetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY);
        return !empty($key);
    }

    /**
     * @return string
     */
    public function Url()
    {
        if (is_null($this->url)) {
            return null;
        }
        return $this->url->__toString();
    }
}

class CalendarSubscriptionService implements ICalendarSubscriptionService
{
    private $cache = array();

    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @var IResourceRepository
     */
    private $resourceRepository;

    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(IUserRepository $userRepository,
                                IResourceRepository $resourceRepository,
                                IScheduleRepository $scheduleRepository)
    {
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @param string $publicResourceId
     * @return BookableResource
     */
    public function GetResource($publicResourceId)
    {
        if (!array_key_exists($publicResourceId, $this->cache)) {
            $resource = $this->resourceRepository->LoadByPublicId($publicResourceId);
            $this->cache[$publicResourceId] = $resource;
        }

        return $this->cache[$publicResourceId];
    }

    /**
     * @param string $publicScheduleId
     * @return Schedule
     */
    public function GetSchedule($publicScheduleId)
    {
        if (!array_key_exists($publicScheduleId, $this->cache)) {
            $schedule = $this->scheduleRepository->LoadByPublicId($publicScheduleId);
            $this->cache[$publicScheduleId] = $schedule;
        }

        return $this->cache[$publicScheduleId];
    }

    /**
     * @param string $publicUserId
     * @return User
     */
    public function GetUser($publicUserId)
    {
        if (!array_key_exists($publicUserId, $this->cache)) {
            $user = $this->userRepository->LoadByPublicId($publicUserId);
            $this->cache[$publicUserId] = $user;
        }

        return $this->cache[$publicUserId];
    }

    public function GetResourcesInGroup($publicResourceGroupId)
    {
        if (!array_key_exists($publicResourceGroupId, $this->cache)) {
            $group = $this->resourceRepository->LoadResourceGroupByPublicId($publicResourceGroupId);

            if ($group == null) {
                return array();
            }

            $groups = $this->resourceRepository->GetResourceGroups();
            $this->cache[$publicResourceGroupId] = $groups->GetResourceIds($group->id);
        }

        return $this->cache[$publicResourceGroupId];
    }

    public function ForUser($userId, $resourceId = null, $scheduleId = null)
    {
        $user = $this->userRepository->LoadById($userId);

        $resourcePublicId = null;
        $schedulePublicId = null;

        if (!empty($scheduleId)) {
            $schedule = $this->scheduleRepository->LoadById($scheduleId);
            $schedulePublicId = $schedule->GetPublicId();
        }
        if (!empty($resourceId)) {
            $resource = $this->resourceRepository->LoadById($resourceId);
            $resourcePublicId = $resource->GetPublicId();
        }

        return new CalendarSubscriptionDetails(
            $user->GetIsCalendarSubscriptionAllowed(),
            new CalendarSubscriptionUrl($user->GetPublicId(), $schedulePublicId, $resourcePublicId));
    }

    /**
     * @param int $resourceId
     * @return CalendarSubscriptionDetails
     */
    public function ForResource($resourceId)
    {
        $resource = $this->resourceRepository->LoadById($resourceId);

        return new CalendarSubscriptionDetails(
            $resource->GetIsCalendarSubscriptionAllowed(),
            new CalendarSubscriptionUrl(null, null, $resource->GetPublicId()));
    }

    /**
     * @param int $scheduleId
     * @return CalendarSubscriptionDetails
     */
    public function ForSchedule($scheduleId)
    {
        $schedule = $this->scheduleRepository->LoadById($scheduleId);

        return new CalendarSubscriptionDetails(
            $schedule->GetIsCalendarSubscriptionAllowed(),
            new CalendarSubscriptionUrl(null, $schedule->GetPublicId(), null));
    }
}