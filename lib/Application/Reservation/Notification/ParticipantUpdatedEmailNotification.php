<?php
/**
Copyright 2016 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ParticipantAddedEmailNotification.php');

class ParticipantUpdatedEmailNotification extends ParticipantAddedEmailNotification
{
	/**
		 * @var IUserRepository
		 */
		private $userRepository;

		/**
		 * @var IAttributeRepository
		 */
		private $attributeRepository;

		public function __construct(IUserRepository $userRepository, IAttributeRepository $attributeRepository)
		{
			$this->userRepository = $userRepository;
			$this->attributeRepository = $attributeRepository;
		}

		/**
		 * @param ReservationSeries $reservationSeries
		 */
		function Notify($reservationSeries)
		{
			$instance = $reservationSeries->CurrentInstance();
	        $owner = $this->userRepository->LoadById($reservationSeries->UserId());

			foreach ($instance->UnchangedParticipants() as $userId)
			{
				$participant = $this->userRepository->LoadById($userId);

				$message = new ParticipantUpdatedEmail($owner, $participant, $reservationSeries, $this->attributeRepository);
				ServiceLocator::GetEmailService()->Send($message);
			}

			foreach ($instance->RemovedParticipants() as $userId)
			{
				$participant = $this->userRepository->LoadById($userId);

				$message = new ParticipantDeletedEmail($owner, $participant, $reservationSeries, $this->attributeRepository);
				ServiceLocator::GetEmailService()->Send($message);
			}
		}
}