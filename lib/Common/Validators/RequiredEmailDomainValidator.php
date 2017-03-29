<?php

/**
 * Copyright 2016 Nick Korbel
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

class RequiredEmailDomainValidator extends ValidatorBase implements IValidator
{
	private $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function Validate()
	{
		$this->isValid = true;

		$domains = Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_REQUIRED_EMAIL_DOMAINS);

		if (empty($domains))
		{
			return;
		}

		$allDomains = explode(',', $domains);

		$trimmed = trim($this->value);

		foreach ($allDomains as $d)
		{
			$d = str_replace('@', '', $d);
			if (BookedStringHelper::EndsWith($trimmed, '@' . $d))
			{
				return;
			}

			$this->isValid = false;
			break;
		}
	}
}