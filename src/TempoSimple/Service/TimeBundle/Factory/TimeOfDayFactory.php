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
use TempoSimple\DomainModel\Time\TimeOfDay;

class TimeOfDayFactory
{
    const HOUR_INDEX = 0;
    const MINUTES_INDEX = 1;

    /** @var TimeOfDay */
    private $now;

    /** @return TimeOfDay */
    public function now()
    {
        if (!($this->now instanceof TimeOfDay)) {
            $now = new DateTime();
            $this->now = new TimeOfDay(
                $now->format('H'),
                $now->format('i')
            );
        }

        return $this->now;
    }

    /**
     * @param string $stringTimeOfDay
     *
     * @return TimeOfDay
     */
    public function fromString($stringTimeOfDay)
    {
        $timeOfDayBits = explode(TimeOfDay::SEPARATOR, $stringTimeOfDay);

        return new TimeOfDay(
            $timeOfDayBits[self::HOUR_INDEX],
            $timeOfDayBits[self::MINUTES_INDEX]
        );
    }
}
