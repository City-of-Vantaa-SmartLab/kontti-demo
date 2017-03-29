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

class ReservationAttachmentView
{
    /**
     * @param int $fileId
     * @param int $seriesId
     * @param string $fileName
     */
    public function __construct($fileId, $seriesId, $fileName)
    {
        $this->fileId = $fileId;
        $this->seriesId = $seriesId;
        $this->fileName = $fileName;
    }

    /**
     * @return int
     */
    public function FileId()
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    public function FileName()
    {
        return $this->fileName;
    }

    /**
     * @return int
     */
    public function SeriesId()
    {
        return $this->seriesId;
    }
}