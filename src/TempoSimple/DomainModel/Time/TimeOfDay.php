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

class TimeOfDay
{
    const NB_SECOND_PER_MINUTE = 60.0;

    const SEPARATOR = ':';

    /** @var integer */
    private $hour;

    /** @var integer */
    private $minutes;

    /**
     * @param integer $hour
     * @param integer $minutes
     */
    public function __construct($hour, $minutes)
    {
        $this->hour = intval($hour);
        $this->minutes = intval($minutes);
    }

    /** @return string */
    public function getHour()
    {
        $literalHour = ($this->hour > 10) ? $this->hour : '0'.$this->hour;
        $literalMinutes = ($this->minutes > 10) ? $this->minutes : '0'.$this->minutes;

        $time = array(
            $literalHour,
            $literalMinutes,
        );

        return implode(self::SEPARATOR, $time);
    }

    /**
     * @param TimeOfDay $begin
     *
     * @return float
     */
    public function getTimeSpentSince(TimeOfDay $begin)
    {
        $hourDiff = floatval($this->hour) - floatval($begin->hour);
        $minutesDiff = floatval($this->minutes) - floatval($begin->minutes);

        return $hourDiff + $minutesDiff / self::NB_SECOND_PER_MINUTE;
    }
}
