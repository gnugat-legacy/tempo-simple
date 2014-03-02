<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\DomainModel\TimeTracking;

class TimeCard
{
    const TIME_SEPARATOR = ':';

    /** @var float **/
    private $startHour;

    /** @var float **/
    private $startQuarter;

    /** @var float **/
    private $endHour;

    /** @var float **/
    private $endQuarter;

    /**
     * @param string $startTime Format: 'H:i' (e.g. 09:00)
     * @param string $endTime   Format: 'H:i' (e.g. 13:15)
     */
    public function __construct($startTime, $endTime)
    {
        list($startHour, $startQuarter) = explode(self::TIME_SEPARATOR, $startTime);
        list($endHour, $endQuarter) = explode(self::TIME_SEPARATOR, $endTime);

        $quarters = array(
            '00' => 0.0,
            '15' => 0.25,
            '30' => 0.5,
            '45' => 0.75,
        );

        $this->startHour = floatval($startHour);
        $this->endHour = floatval($endHour);

        $this->startQuarter = $quarters[$startQuarter];
        $this->endQuarter = $quarters[$endQuarter];
    }

    /** @return float */
    public function getWorkingHours()
    {
        if ($this->startHour === $this->endHour) {
            return $this->endQuarter - $this->startQuarter;
        }

        $timeToOne = 1.0 - $this->startQuarter;
        $hourDiff = $this->endHour - $this->startHour - 1.0;

        return $hourDiff + $timeToOne + $this->endQuarter;
    }
}
