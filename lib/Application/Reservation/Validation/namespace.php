<?php
/**
Copyright 2011-2016 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/PreReservationFactory.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IUpdateReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationService.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationRuleProcessor.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AdminExcludedRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationBasicInfoRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ExistingResourceAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationDateTimeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationStartTimeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/PermissionValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationRuleResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMinimumNoticeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMaximumNoticeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMinimumDurationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMaximumDurationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/QuotaRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AccessoryAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/CustomAttributeValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationAttachmentRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/RequiresApprovalRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/SchedulePeriodRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceParticipationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReminderValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceCrossDayRule.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AddReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/UpdateReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/DeleteReservationValidationService.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IBlackoutValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/BlackoutValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/BlackoutDateTimeValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/CurrentUserIsReservationUserRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AccessoryResourceRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationCanBeCheckedInRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationCanBeCheckedOutRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/CreditsRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AnonymousResourceExcludedRule.php');