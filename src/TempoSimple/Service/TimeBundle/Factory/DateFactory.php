<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Service\TimeBundle\Factory;

use DateTime;
use TempoSimple\DomainModel\Time\Date;

class DateFactory
{
    const YEAR_INDEX = 0;
    const MONTH_INDEX = 1;
    const DAY_INDEX = 2;

    const DEFAULT_DAY = '01';

    /** @var Date */
    private $today;

    /** @return Date */
    public function today()
    {
        if (!($this->today instanceof Date)) {
            $today = new DateTime();
            $this->today = new Date(
                $today->format('Y'),
                $today->format('m'),
                $today->format('d')
            );
        }

        return $this->today;
    }

    /**
     * @param string $stringDate
     *
     * @return Date
     */
    public function fromString($stringDate)
    {
        $dateBits = explode(Date::SEPARATOR, $stringDate);
        if (2 === count($dateBits)) {
            $dateBits[self::DAY_INDEX] = self::DEFAULT_DAY;
        }

        return new Date(
            $dateBits[self::YEAR_INDEX],
            $dateBits[self::MONTH_INDEX],
            $dateBits[self::DAY_INDEX]
        );
    }

    /** @return  array of Date */
    public function lastWorkingWeek()
    {
        $workingDays = array(
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
        );

        $dates = array();
        foreach ($workingDays as $workingDay) {
            $timestamp = strtotime($workingDay.' last week');
            $dates[] = new Date(
                date('Y', $timestamp),
                date('m', $timestamp),
                date('d', $timestamp)
            );
        }

        return $dates;
    }
}
