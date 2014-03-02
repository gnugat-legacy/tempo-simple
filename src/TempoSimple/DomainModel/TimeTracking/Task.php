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

class Task
{
    /** @var string **/
    private $title;

    /** @var array of TimeCard **/
    private $timeCards;

    /** @param string $title */
    public function __construct($title)
    {
        $this->title = $title;
        $this->timeCards = array();
    }

    /** @return string **/
    public function getTitle()
    {
        return $this->title;
    }

    /** @param TimeCard $timeCard */
    public function addTimeCard(TimeCard $timeCard)
    {
        $this->timeCards[] = $timeCard;
    }

    /** @return float **/
    public function getTotalWorkingDays()
    {
        $totalWorkingHours = 0.0;
        foreach ($this->timeCards as $timeCard) {
            $totalWorkingHours += $timeCard->getWorkingHours();
        }
        $totalWorkingDays = $totalWorkingHours / 8.0;

        return $totalWorkingDays;
    }
}
