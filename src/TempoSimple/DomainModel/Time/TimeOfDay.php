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
        $this->hour = $hour;
        $this->minutes = $minutes;
    }

    /** @return string */
    public function getHour()
    {
        $times = array(
            $this->hour,
            $this->minutes,
        );

        return implode(self::SEPARATOR, $times);
    }
}
