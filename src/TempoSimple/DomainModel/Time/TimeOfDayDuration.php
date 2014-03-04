<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DomainModel\Time;

class TimeOfDayDuration
{
    const NB_SECOND_PER_MINUTE = 60.0;

    /** @var TimeOfDay */
    private $start;

    /** @var TimeOfDay */
    private $end;

    /**
     * @param TimeOfDay $start
     * @param TimeOfDay $end
     */
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /** @return float */
    public function inWorkingHours()
    {
        list($startHour, $startMinutes) = explode(TimeOfDay::SEPARATOR, $this->start->getHour());
        list($endHour, $endMinutes) = explode(TimeOfDay::SEPARATOR, $this->end->getHour());

        $hourDiff = floatval($endHour) - floatval($startHour);
        $minutesDiff = floatval($endMinutes) - floatval($startMinutes);

        return $hourDiff + $minutesDiff / self::NB_SECOND_PER_MINUTE;
    }
}
