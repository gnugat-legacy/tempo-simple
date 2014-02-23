<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Domain\TimeTracking;

class Timesheet
{
    /** @var array of TimeCard */
    private $timeCards;

    /** @param array $timeCards A collection of TimeCard */
    public function __construct(array $timeCards = array())
    {
        $this->timeCards = $timeCards;
    }

    /** @param TimeCard $timeCard */
    public function addTimeCard(TimeCard $timeCard)
    {
        $this->timeCards[] = $timeCard;
    }

    /** @return float */
    public function getTotalWorkingDays()
    {
        $total = 0.0;
        foreach ($this->timeCards as $timeCard) {
            $total += $timeCard->getWorkingHours();
        }

        return $total / 8.0;
    }
}
